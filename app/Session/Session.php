<?php

namespace App\Session;

class Session{

    private $cookieTime = 3600;

    public function __construct() {
        session_cache_limiter(false);
    }

    public function start()
    {
        session_start();
    }

    public function has($name)
    {
        return isset($_SESSION[$name]);
    }

    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function setArray(array $vars)
    {
        foreach($vars as $name => $value) {
            $this->set($name, $value);
        }
    }

    public function get($name) {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return $_SESSION[$name];
    }

    public function destroy($name) {
        unset($_SESSION[$name]);
    }

    public function destroyAll() {
        session_destroy();
    }

    public function setCookie($name, $value) {
        setcookie($name, $value, time() + $this->cookieTime, '/'); 
    }

    public function getCookie($name) {
        if (isset($_COOKIE[$name])) 
            return $_COOKIE[$name];
        return false;
    }

    public function removeCookie($name) {
        setcookie($name, '', time() - 3600, '/'); 
    }
}