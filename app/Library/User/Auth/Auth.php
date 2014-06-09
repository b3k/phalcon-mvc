<?php

namespace App\Library\User\Auth;

use Phalcon\Mvc\User\Component;
use App\Library\User\Auth\Exception\UnknownUserException;
use App\Library\User\Auth\Exception\InactiveUserException;
use App\Library\User\Auth\Exception\InvalidCredentialsException;
use App\Library\User\Auth\Exception\UserExpiredException;
use App\Model\UserLog;

/**
 * Vokuro\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class Auth
        extends Component
{

    const AUTH_IDENT_SESSION_KEY = 'auth_ident';

    protected $UsersRepository;

    public function __construct()
    {
        if (!class_exists($this->config->application->users->repository_class)) {
            throw new \RuntimeException(sprintf('Given repository class %s does not exists.', $this->config->application->users->repository_class));
        }
        $RepositoryClass = $this->config->application->users->repository_class;
        $this->UsersRepository = new $RepositoryClass();
    }

    public function getUsersRepository()
    {
        return $this->UsersRepository;
    }

    public function setUsersRepository($UsersRepository)
    {
        return $this->UsersRepository = $UsersRepository;
    }

    /**
     * Checks the user credentials
     *
     * @param  array  $credentials
     * @return boolan
     */
    public function login($credentials)
    {
        $User = $this->getUsersRepository()->findByEmail($credentials['email']);
        if (!$User) {
            $this->addLog('auth:login:fail', 0, $credentials, $this->request->getClientAddress(), $this->request->getUserAgent());
            $this->checkUserThrottling(0);
            throw new UnknownUserException('Wrong email/password combination');
        }

        if (!$this->security->checkHash($credentials['password'], $User->getPassword())) {
            $this->registerUserThrottling($User->getId());
            throw new InvalidCredentialsException('Wrong email/password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($User);

        // Register the successful login
        $this->saveSuccessLogin($User);

        $credentials['password'] = str_repeat('*', strlen($credentials['password']));
        $this->addLog('auth:login:success', $User->getId(), array_map($credentials, array($this, 'prepareDataToLog')), $this->request->getClientAddress(), $this->request->getUserAgent());

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->createRememberEnviroment($User);
        }

        $this->session->set(self::AUTH_IDENT_SESSION_KEY, array(
            'id' => $user->id,
            'name' => $user->name,
            'profile' => $user->profile->name
        ));
    }

    public function prepareDataToLog($data)
    {
        foreach ($data as $key => $value) {
            switch (strtolower(trim($key))) {
                case 'password': $data[$key] = str_repeat("*", strlen($value));
            }
        }
        return $data;
    }

    public function addLog($action, $userId = 0, $params = array(), $ip = '', $ua = '')
    {
        $UserLog = new UserLog();
        $UserLog->setAction($action);
        $UserLog->setParams(json_encode($params));
        $UserLog->setUserId($userId);
        $UserLog->setIp($this->request->getClientAddress());
        $UserLog->setUserAgent($this->request->getUserAgent());
        $UserLog->save();
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param Vokuro\Models\Users $user
     */
    public function saveSuccessLogin($User)
    {
        $UserLog = $User->createLog();
        $UserLog->setIp() = $this->request->getClientAddress();
        $UserLog->setUserAgent() = $this->request->getUserAgent();
        if (!$UserLog->save()) {
            throw new \RuntimeException('Can not save user log');
        }
    }

    /**
     * Implements login throttling
     * Reduces the efectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function registerUserThrottling($userId)
    {
        $attempts = FailedLogins::count(array(
                    'ipAddress = ?0 AND attempted >= ?1',
                    'bind' => array(
                        $this->request->getClientAddress(),
                        time() - 3600 * 6
                    )
        ));

        switch ($attempts) {
            case 1:
            case 2:
                // no delay
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * Creates the remember me environment settings the related cookies and generating tokens
     *
     * @param Vokuro\Models\Users $user
     */
    public function createRememberEnviroment($User)
    {
        $userAgent = $this->request->getUserAgent();
        $token = sha1($User->email . $User->password . $userAgent);

        $remember = new RememberTokens();
        $remember->usersId = $user->id;
        $remember->token = $token;
        $remember->userAgent = $userAgent;

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->id, $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = Users::findFirstById($userId);
        if ($user) {

            $userAgent = $this->request->getUserAgent();
            $token = md5($user->email . $user->password . $userAgent);

            if ($cookieToken == $token) {

                $remember = RememberTokens::findFirst(array(
                            'usersId = ?0 AND token = ?1',
                            'bind' => array(
                                $user->id,
                                $token
                            )
                ));
                if ($remember) {

                    // Check if the cookie has not expired
                    if ((time() - (86400 * 8)) < $remember->createdAt) {

                        // Check if the user was flagged
                        $this->checkUserFlags($user);

                        // Register identity
                        $this->session->set(self::AUTH_IDENT_SESSION_KEY, array(
                            'id' => $user->id,
                            'name' => $user->name,
                            'profile' => $user->profile->name
                        ));

                        // Register the successful login
                        $this->saveSuccessLogin($user);

                        return $this->response->redirect('users');
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

        return $this->response->redirect('session/login');
    }

    /**
     * Checks if the user is banned/inactive/suspended
     *
     * @param Vokuro\Models\Users $user
     */
    public function checkUserFlags($User)
    {
        if (!$User->getActive()) {
            throw new InactiveUserException('The user is inactive');
        }

        if ($User->getExpired()) {
            throw new UserExpiredException('The user account is expired');
        }
    }

    /**
     * Returns the current identity
     *
     * @return array
     */
    public function getIdentity()
    {
        return $this->session->get(self::AUTH_IDENT_SESSION_KEY);
    }

    /**
     * Returns the current identity
     *
     * @return string
     */
    public function getName()
    {
        $identity = $this->session->get(self::AUTH_IDENT_SESSION_KEY);

        return $identity['name'];
    }

    /**
     * Removes the user identity information from session
     */
    public function remove()
    {
        if ($this->cookies->has('RMU')) {
            $this->cookies->get('RMU')->delete();
        }
        if ($this->cookies->has('RMT')) {
            $this->cookies->get('RMT')->delete();
        }

        $this->session->remove(self::AUTH_IDENT_SESSION_KEY);
    }

    /**
     * Auths the user by his/her id
     *
     * @param int $id
     */
    public function authUserById($id)
    {
        $user = Users::findFirstById($id);
        if ($user == false) {
            throw new Exception('The user does not exist');
        }

        $this->checkUserFlags($user);

        $this->session->set(self::AUTH_IDENT_SESSION_KEY, array(
            'id' => $user->id,
            'name' => $user->name,
            'profile' => $user->profile->name
        ));
    }

    public function getUser()
    {
        $identity = $this->session->get(self::AUTH_IDENT_SESSION_KEY);
        if (isset($identity['id'])) {
            $user = Users::findFirstById($identity['id']);
            if ($user == false) {
                throw new Exception('The user does not exist');
            }

            return $user;
        }

        return false;
    }

}
