<?php

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
    public function __construct($name, $password, $keep = false)
    {
        $this->name = $name;
        $this->password = $password;
        $this->keep = $keep;
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

    /**
     * @param UserClient $currentUser
     *
     * @return bool
     */
    public function isLoggedIn(UserClient $currentUser)
    {
        if (!isset($_SESSION[ self::$loginSessionLocation ])) {
            return false;
        } else {
            $sessionUser = unserialize($_SESSION[ self::$loginSessionLocation ]);
            session_regenerate_id(true);

            if ($currentUser->isSame($sessionUser)) {
                return true;
            }

            return false;
        }
    }

    public function logOut()
    {
        $_SESSION[ self::$loginSessionLocation ] = null;
    }

    /**
     * @param LoginAttemptModel $attempt
     *
     * @throws \exceptions\IncorrectCredentialsException
     */
    public function tryLogin(\model\LoginAttemptModel $attempt, \model\UserClient $currentUser)
    {
        if ($this->verify($attempt->getName(), $attempt->getPassword())) {
            $this->login($currentUser);
        } else {
            throw new \exceptions\IncorrectCredentialsException();
        }
    }

    /**
     *
     * Very much unnecessary method as it is right now, but
     * will take care of verifying pass and username against hashed
     * versions later on.
     *
     * @param $usernameToVerify
     * @param $passwordToVerify
     *
     * @return bool
     */
    public function verify($usernameToVerify, $passwordToVerify)
    {

        if ($usernameToVerify === $this->name && $passwordToVerify === $this->password) {
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

    /**
     * Direct login for VIP cookie peeps.
     *
     * @param UserClient $currentUser
     */
    public function login(\model\UserClient $currentUser)
    {
        $_SESSION[ self::$loginSessionLocation ] = serialize($currentUser);
    }

    /**
     * @return mixed
     */
    public function getKeep()
    {
        return $this->keep;
    }

}