<?php

namespace App\Library\User\Auth;

use Phalcon\Mvc\User\Component;
use Phalcon\Session\Bag;
use App\Library\User\Auth\Exception\UnknownUserException;
use App\Library\User\Auth\Exception\InactiveUserException;
use App\Library\User\Auth\Exception\InvalidCredentialsException;
use App\Library\User\Auth\Exception\UserExpiredException;
use App\Library\User\Auth\UserInterface;
use App\Library\User\Manager\ManagerInterface as UserManagerInterface;

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
    protected $UsersManager;

    /**
     * Configuration node
     *
     * @var array 
     */
    protected $_config;

    /**
     * COntrscts this instance
     * 
     * @throws \RuntimeException
     */
    public function __construct()
    {
        $this->_config = array_merge($this->config_defaults, $this->config->application->users->toArray());
        $managerClass = $this->_config['manager'];
        if (!class_exists($managerClass)) {
            throw new \RuntimeException(sprintf('Given repository class %s does not exists.', $managerClass));
        }
        $this->setUsersManager(new $managerClass());
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
    public function getUsersManager()
    {
        return $this->UsersManager;
    }

    /**
     * Set usermanager object
     * 
     * @param   UserManagerInterface $UserManagerClass
     * @return  UserManagerInterface
     */
    public function setUsersManager(UserManagerInterface $UserManager)
    {
        return $this->UsersManager = $UserManager;
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
        return $id !== FALSE ? $this->getUsersManager()->find($id) : FALSE;
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
        $User = $this->getUsersManager()->findOneBy($this->ConfigNode['login_column'], $credentials['ident']);
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
        $User = $this->getUsersManager()->findOneBy($this->ConfigNode['login_column'], $credentials['ident']);
        if (!$User) {
            // run events
            $this->getEventsManager()->fire('auth:login:fail', $this, $credentials);
            throw new UnknownUserException('User with given identifier does not exist');
        }

        // check password
        if (!$this->getSecurity()->checkHash($credentials['password'], $User->getPassword())) {
            $this->getEventsManager()->fire('auth:login:fail', $this, $credentials);
            throw new InvalidCredentialsException('Wrong email/password combination');
        }

        // Check if the user was flagged
        $this->checkUserFlags($User);

        // Check if the remember me was selected
        if (isset($credentials['remember'])) {
            $this->setRememberEnviroment($User);
        }

        // Set User object
        $this->setIdentity($User);

        // regenerate session id
        session_regenerate_id();

        // run events
        $this->getEventsManager()->fire('auth:login:after', $User);
    }

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
        return NULL;
    }

    public function checkUserFlags($User)
    {
        if (!$User->getActive()) {
            throw new InactiveUserException('The user is inactive');
        }

        if ($User->getExpired()) {
            throw new UserExpiredException('The user account is expired');
        }
    }

}
