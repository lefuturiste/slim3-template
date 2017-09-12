<?php

namespace App;

class Session
{

    /**
     * Session constructor.
	 *
     * @param int $expire
     */
    public function __construct($expire = -1)
    {
        if ($expire != -1) {
            session_cache_expire($expire);
        }
        session_start();
    }

	/**
	 * Set a session variable
	 *
	 * @param $name
	 * @param $data
	 * @return void
	 */
    public function set($name, $data)
    {
        $_SESSION[$name] = $data;
    }

	/**
	 * Get actual data in session variable
	 *
	 * @param $name
	 * @return mixed
	 */
    public function get($name)
    {
        return $_SESSION[$name];
    }

    /**
     * Verify if a key exist in session
     *
     * @param $name
     * @return bool
     */
    public function exist($name)
    {
        if (isset($_SESSION[$name])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete data in session variable
	 *
     * @param string $name
     */
    public function delete($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * Destroy actual session
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
	 * Get user data
	 *
	 * @return void
	 */
    public function getProfile()
	{
		if ($this->exist('user')){
			return $this->get('user');
		}else{
			return false;
		}
	}
}