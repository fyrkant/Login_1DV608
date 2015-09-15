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
    private $name;
    private $password;
    private $keep;

    /**
     * @param string $name
     * @param string $password
     * @param bool|false $keep
     */
    public function __construct($name = "Admin", $password = "Password", $keep = false)
    {
        $this->name = $name;
        $this->password = $password;
        $this->keep = $keep;
    }


    public function isLoggedIn()
    {
        if (!isset($_SESSION[ self::$loginSessionLocation ])) {
            $_SESSION[ self::$loginSessionLocation ] = false;

            return false;
        } else {

            $isLoggedIn = $_SESSION[ self::$loginSessionLocation ];

            return $isLoggedIn;
        }
    }

    public function logOut()
    {
        $_SESSION[ self::$loginSessionLocation ] = false;
    }

    public function logIn(LoginModel $attempt = null)
    {
        if ($attempt === null) {
            $_SESSION[ self::$loginSessionLocation ] = true;
        } else if ($attempt->name === $this->name && $attempt->password === $this->password) {
            $_SESSION[ self::$loginSessionLocation ] = true;
        } else if ($attempt->name == "" && $attempt->password == "") {
            throw new \Exception("Username is missing");
        } else if ($attempt->password == "") {
            throw new \Exception("Password is missing");
        } else if ($attempt->username == "") {
            throw new \Exception("Username is missing");
        } else {
            throw new \Exception("Wrong name or password");
        }
    }

    /**
     * @return mixed
     */
    public function getKeep()
    {
        return $this->keep;
    }

}