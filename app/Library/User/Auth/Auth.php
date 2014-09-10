<?php

namespace App\Library\User\Auth;

use Phalcon\Mvc\User\Component;
use Phalcon\Session\Bag;
use App\Library\User\Auth\Exception\UnknownUserException;
use App\Library\User\Auth\Exception\InactiveUserException;
use App\Library\User\Auth\Exception\InvalidCredentialsException;
use App\Library\User\Auth\Exception\UserExpiredException;
use App\Library\User\Auth\UserInterface;
use App\Model\UserLog;
use App\Model\UserLogQuery;
use App\Library\User\Manager\ManagerInterface as UserManagerInterface;

/**
 * Vokuro\Auth\Auth
 * Manages Authentication/Identity Management in Vokuro
 */
class Auth extends Component
{

    /**
     * Auth token
     */
    const AUTH_IDENT_SESSION_KEY = 'auth_ident';

    /**
     * Auth remember ident
     */
    const AUTH_REMEMBER_IDENT_COOKIE_KEY = 'auth_rmb_id';

    /**
     * Auth remember token
     */
    const AUTH_REMEMBER_TOKEN_COOKIE_KEY = 'auth_rmb_token';

    /**
     * Default Auth options
     *
     * @var array
     */
    protected $config_defaults = array(
        'manager' => '\App\Library\PropelConnector\User\Manager\Manager',
        'login_column' => 'email',
        'throttling' => TRUE,
        'throttling_check_duration' => 3600,
        'remember_token_validity' => 604800
    );

    /**
     * User mnager
     * 
     * @var type 
     */
    protected $_UsersManager;

    /**
     * Configuration node
     *
     * @var array 
     */
    protected $_config;
    
    
    protected $SaveUser = FALSE;

    /**
     * COntrscts this instance
     * 
     * @throws \RuntimeException
     */
    public function __construct()
    {
        $this->_config = array_merge($this->config_defaults, $this->config->application->users->toArray());
        $managerClass = $this->ConfigNode['mnager'];
        if (!class_exists($managerClass)) {
            throw new \RuntimeException(sprintf('Given repository class %s does not exists.', $managerClass));
        }
        $this->UsersRepository = new $managerClass();
    }

    /**
     * Get config value
     * 
     * @param   string|null $value
     * @return  mixed
     * @throws  \Exception
     */
    public function getConfig($value = null)
    {
        if ($value && !isset($this->_config[$value])) {
            throw new \Exception(sprintf('There is no config value %s', $value));
        }
        return $value ? $this->_config[$value] : $this->_config;
    }

    /**
     * Get users manager
     * 
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->_UserManager;
    }

    /**
     * Set usermanager object
     * 
     * @param   UserManagerInterface $UserManagerClass
     * @return  UserManagerInterface
     */
    public function setUserManager(UserManagerInterface $UserManager)
    {
        return $this->_UsersManager = $UserManager;
    }

    public function getSession()
    {
        return $this->getDI()->getShared('session');
    }

    public function getRequest()
    {
        return $this->getShared('request');
    }
    
    public function getSecurity()
    {
        return $this->getShared('security');
    }
    
    public function getEventsManager()
    {
        return $this->getShared('eventsManager');
    }

    /**
     * Returns the current identity
     *
     * @return UserInterface
     */
    public function getIdentity()
    {
        $id = $this->getSession()->get(self::AUTH_IDENT_SESSION_KEY, FALSE);
        return $id !== FALSE && is_numeric($id) ? $this->getUserManager()->find($id) : FALSE;
    }

    /**
     * Returns the current identity
     *
     * @params UserInterface
     */
    public function setIdentity(UserInterface $User)
    {
        $this->getSession()->set(self::AUTH_IDENT_SESSION_KEY, $User->getId());
    }

    /**
     * Check credentials
     * 
     * @param array $credentials
     * @return bool
     */
    public function checkCredentials(Array $credentials)
    {
        $User = $this->getUserManager()->findOneBy($this->ConfigNode['login_column'], $credentials['ident']);
        if (!$User) {
            return FALSE;
        }
        if (!$this->getSecurity()->checkHash($credentials['password'], $User->getPassword())) {
            return FALSE;
        }
    }

    /**
     * Checks the user credentials
     *
     * @param  array  $credentials
     * @return boolan
     */
    public function login($credentials)
    {
        // run events
        $this->getEventsManager()->fire('auth:login:before');
        // check that given user exists
        $User = $this->getUserManager()->findOneBy($this->ConfigNode['login_column'], $credentials['ident']);
        if (!$User) {
            // run events
            $this->getEventsManager()->fire('auth:login:fail', $this, $credentials);
            //$this->addLog('auth:login:fail', 0, $credentials, $this->request->getClientAddress(), $this->request->getUserAgent());
            //$this->checkUserThrottling(0);
            throw new UnknownUserException('User with given identifier does not exist');
        }

        // check password
        if (!$this->getSecurity()->checkHash($credentials['password'], $User->getPassword())) {
            //$this->registerUserThrottling($User->getId());
            $this->getEventsManager()->fire('auth:login:fail', $this, $credentials);
            throw new InvalidCredentialsException('Wrong email/password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($User);

        // Obfuscate password before log
        //$credentials['password'] = str_repeat('*', strlen($credentials['password']));
        //$this->addLog('auth:login:success', $User->getId(), $credentials, $this->request->getClientAddress(), $this->request->getUserAgent());

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->setRememberEnviroment($User);
        }

        $this->setIdentity($User);

        // regenerate session id
        session_regenerate_id();
        
        // run events
        $this->getEventsManager()->fire('auth:login:after', $User);
    }

    protected function addLog($action, $userId = 0, $params = array(), $ip = FALSE, $ua = FALSE)
    {
        $UserLog = new UserLog();
        $UserLog->setAction($action);
        $UserLog->setParams(json_encode($params));
        $UserLog->setUserId($userId);
        $UserLog->setIp($ip ? $ip : $this->getRequest()->getClientAddress());
        $UserLog->setUserAgent($ua ? $ua : $this->getRequest()->getUserAgent());
        $UserLog->save();
    }

    /**
     * Implements login throttling
     * Reduces the efectiveness of brute force attacks
     *
     * @param int $userId
     */
    public function checkUserThrottling()
    {
        if (!$this->ConfigNode['throttling']) {
            return;
        }
        $count = UserLogQuery::countActions('auth:login:fail', array(
                    'ip' => $this->getRequest()->getClientAddress(),
                    'date_from' => new \DateTime(time() - $this->ConfigNode['throttling_check_duration'])
                        )
        );

        switch ($count) {
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
    public function setRememberEnviroment($User)
    {
        $User->setRememberToken(sha1($User->getId() . $this->config->security->getRandomBytes()));
        $expire = time() + (int) $this->ConfigNode['remember_token_validity'];
        $this->cookies->set(self::AUTH_REMEMBER_IDENT_COOKIE_KEY, $User->getValue($this->ConfigNode['login_column']), $expire);
        $this->cookies->set(self::AUTH_REMEMBER_TOKEN_COOKIE_KEY, $User->getRememberToken(), $expire);
    }

    /**
     * Check if the session has a remember me cookie
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has(self::AUTH_REMEMBER_TOKEN_COOKIE_KEY) && $this->cookies->has(self::AUTH_REMEMBER_IDENT_COOKIE_KEY);
    }

    /**
     * Logs on using the information in the coookies
     *
     * @return Phalcon\Http\Response
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get(self::AUTH_REMEMBER_IDENT_COOKIE_KEY)->getValue();
        $cookieToken = $this->cookies->get(self::AUTH_REMEMBER_TOKEN_COOKIE_KEY)->getValue();

        $user = UserQuery::findOneBy($this->ConfigNode['login_column'], $userId);
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

                        session_regenerate_id();

                        return $this->response->redirect('users');
                    }
                }
            }
        }

        $this->cookies->get(self::AUTH_REMEMBER_IDENT_COOKIE_KEY)->delete();
        $this->cookies->get(self::AUTH_REMEMBER_TOKEN_COOKIE_KEY)->delete();

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
