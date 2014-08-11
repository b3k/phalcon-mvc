<?php

namespace App\Library\Session;

trait ConfigurableSessionTrait
{

    /**
     * Starts the session
     * @return bool
     */
    public function start()
    {
        // Check that session is not already started
        if ($this->isStarted()) {
            return false;
        }

        // Get current cookie options
        $options = $this->getSessionOptions();

        ini_set('session.hash_function', $options['hash']);

        // Set cookie name
        session_name($options['name']);

        // Set cookie parameters
        session_set_cookie_params(
                $options['lifetime'], $options['path'], $options['domain'], $options['secure'], $options['httponly']
        );

        // Start session
        return parent::start();
    }

    /**
     * Destroys current session and removes session cookie
     * @return bool
     */
    public function destroy($session_id = NULL)
    {
        // Remove session cookie
        $options = $this->getSessionOptions();
        if (!setcookie($options['name'], '', -1)) {
            return false;
        }

        // Clean session data
        return parent::destroy();
    }

    /**
     * Sets cookie lifetime to zero
     * @return bool
     */
    public function setShortLifetime()
    {
        if (!$this->isStarted()) {
            return false;
        }

        // Get cookie options
        $options = $this->getSessionOptions();

        // Short session, will be finished after browser will be closed
        $options['lifetime'] = 0;

        // Session id
        $id = session_id();

        // Set new cookie
        return setcookie(
                $options['name'], $id, $options['lifetime'], $options['path'], $options['domain'], $options['secure'], $options['httponly']
        );
    }

    /**
     * Returns current session cookie configuration
     * @return array
     */
    public function getSessionOptions()
    {
        // Get default cookie options
        $options = array_merge(session_get_cookie_params(), array('hash' => ini_get('session.hash_function')));

        // Cookie name
        $options['name'] = session_name();
        if (!empty($this->_options['name'])) {
            $options['name'] = (string) $this->_options['name'];
        }

        // Cookie lifetime
        if (!empty($this->_options['cookie']['lifetime'])) {
            $options['lifetime'] = (int) $this->_options['cookie']['lifetime'];
        }

        // Path
        if (!empty($this->_options['cookie']['path'])) {
            $options['path'] = (string) $this->_options['cookie']['path'];
        }

        // Domain
        if (!empty($this->_options['cookie']['domain'])) {
            $options['domain'] = (string) $this->_options['cookie']['domain'];
        }

        // Secure
        if (!empty($this->_options['cookie']['secure'])) {
            $options['secure'] = (bool) $this->_options['cookie']['secure'];
        }

        // Http only
        if (!empty($this->_options['cookie']['httponly'])) {
            $options['httponly'] = (bool) $this->_options['cookie']['httponly'];
        }

        // Hash function
        if (!empty($this->_options['hash'])) {
            $options['hash'] = (string) $this->_options['hash'];
        }

        return $options;
    }

}
