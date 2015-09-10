<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 06:50
 */

namespace model;


class LoginModel
{

    private static $loginSessionLocation = "LoginModel::LoggedIn";
    private $name = "Admin";
    private $password = "Password";

    public function isLoggedIn()
    {
        if (!isset($_SESSION[self::$loginSessionLocation])) {
            $_SESSION[self::$loginSessionLocation] = false;

            return false;
        } else {

            $isLoggedIn = $_SESSION[self::$loginSessionLocation];

            return $isLoggedIn;
        }
    }

    public function logOut()
    {
        $_SESSION[self::$loginSessionLocation] = false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function logIn()
    {
        $_SESSION[self::$loginSessionLocation] = true;
    }
}