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

    private $name = "Admin";
    private $password = "Password";

    private static $loginSessionLocation = "LoginModel::LoggedIn";

    public function __construct()
    {
        //$_SESSION[self::$loginSessionLocation] = true;
    }


    public function isLoggedIn() {
        if ( ! isset($_SESSION[self::$loginSessionLocation])) {
            $_SESSION[self::$loginSessionLocation] = false;

            return false;
        } else {

            $isLoggedIn = $_SESSION[self::$loginSessionLocation];

            return $isLoggedIn;
        }
    }

    public function logOut() {
        $_SESSION[self::$loginSessionLocation] = false;
    }

    public function logIn($username, $password) {

        if ($username === $this->name && $password === $this->password) {
            $_SESSION[self::$loginSessionLocation] = true;
        } else if ($username == "" && $password == "") {
            throw new \Exception("Username is missing");
        } else if ($password == "") {
            throw new \Exception("Password is missing");
        } else if ($username == "") {
            throw new \Exception("Username is missing");
        } else {
            throw new \Exception("Wrong name or password");
        }



    }


//    /**
//     * LoginModel constructor.
//     * @param $name
//     * @param $password
//     */
//    public function __construct($name, $password)
//    {
//        if ($name == "") {
//            throw new \Exception("Username is missing");
//        } else {
//            $this->name = $name;
//        }
//        if ($password == "") {
//            throw new \Exception("Password is missing");
//        } else {
//            $this->password = $password;
//        }
//    }


}