<?php

namespace model;


class LoginModel
{

    private static $loginSessionLocation = "LoginModel::LoggedIn";
    private $name;
    private $password;

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
    private $keep;

    /**
     * @param string $name
     * @param string $password
     * @param bool|false $keep
     */
    public function __construct($name, $password, $keep = false)
    {
        $this->name = $name;
        $this->password = $password;
        $this->keep = $keep;
    }


    /**
     * @return bool
     */
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

    /**
     * @param LoginModel $attempt
     *
     * @throws \Exception
     */
    public function logIn(LoginAttemptModel $attempt)
    {
        if ($attempt->getName() === $this->name && $this->verifyPassword($attempt->getPassword())) {
            $_SESSION[ self::$loginSessionLocation ] = true;
        } else if ($attempt->getName() == "" && $attempt->getPassword() == "") {
            throw new \exceptions\UserNameEmptyException("Username is missing");
        } else if ($attempt->getPassword() == "") {
            throw new \exceptions\PasswordEmptyException("Password is missing");
        } else if ($attempt->getName() == "") {
            throw new \exceptions\UserNameEmptyException("Username is missing");
        } else {
            throw new \exceptions\IncorrectCredentialsException("Wrong name or password");
        }
    }

    public function verifyPassword($passwordToVerify)
    {

       if ($passwordToVerify === $this->password) {
            return true;
       } else {
            return false;
       }
//        $fileArray = file("secret/supersecret.txt");
//
//        foreach ($fileArray as $line) {
//            $exploded = explode("__", $line);
//            $hashedUser = $exploded[0];
//            $hashedPassword = trim($exploded[1]);
//
//            if ($username === $hashedUser) {
//                return password_verify($passwordToVerify, $hashedPassword);
//            }
//        }
//
//        return false;
    }

    public function cookieLogin()
    {
        $_SESSION[ self::$loginSessionLocation ] = true;
    }

    /**
     * @return mixed
     */
    public function getKeep()
    {
        return $this->keep;
    }

    public function hashedSetter()
    {

        $username = "Admin";
        $password = "Password";

        $hashed = password_hash($password, PASSWORD_BCRYPT);

        $toBeSaved = $username . "__" . $hashed . PHP_EOL;

        file_put_contents("secret/supersecret.txt", $toBeSaved, FILE_APPEND);
    }

}