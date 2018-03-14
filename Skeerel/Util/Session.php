<?php
/**
 * Created by Florian Pradines
 */

namespace Skeerel\Util;


use Skeerel\Exception\IllegalArgumentException;
use Skeerel\Exception\SessionNotStartedException;

class Session
{
    public static function isValidName($sessionName) {
        return is_string($sessionName) && preg_match("/^[a-zA-Z_][a-zA-Z0-9_-]*$/", $sessionName) === 1;
    }

    public static function isSessionStarted() {
        if (function_exists('session_status')) {
            return PHP_SESSION_ACTIVE === session_status();
        }

        // arbitrary expressions are only allowed since php 5.5
        $sessionId = session_id();
        return !empty($sessionId);
    }

    public static function get($name) {
        if (!self::isSessionStarted()) {
            throw new SessionNotStartedException();
        }

        if (!self::isValidName($name)) {
            throw new IllegalArgumentException("the name of the session parameter must be a valid string name");
        }

        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return null;
    }

    public static function set($name, $value) {
        if (!self::isSessionStarted()) {
            throw new SessionNotStartedException();
        }

        if (!self::isValidName($name)) {
            throw new IllegalArgumentException("the name of the session parameter must be a valid string name");
        }

        if (!is_string($value)) {
            throw new IllegalArgumentException("the value of the session parameter must be a string");
        }

        $_SESSION[$name] = $value;
    }

    public static function remove($name) {
        if (!self::isSessionStarted()) {
            throw new SessionNotStartedException();
        }

        if (!self::isValidName($name)) {
            throw new IllegalArgumentException("the name of the session parameter must be a valid string name");
        }

        if (isset($_SESSION[$name])) {
            unset($_SESSION[$name]);
        }
    }
}