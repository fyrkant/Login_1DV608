<?php

namespace model;


class LoginModel
{

    private static $loginSessionLocation = "LoginModel::LoggedIn";
    private $name;
    private $password;

    /**
     * @param string $name
     * @param string $password
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
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
     * @param UserClient $currentUser
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
    }

    /**
     * @param UserClient $currentUser
     */
    public function login(\model\UserClient $currentUser)
    {
        $_SESSION[ self::$loginSessionLocation ] = serialize($currentUser);
    }

}