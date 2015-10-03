<?php

namespace model;


class RegisterAttemptModel
{


    private $name;
    private $password;
    private $passwordRepeat;

    public function __construct($name, $password, $passwordRepeat)
    {

        if (filter_var($name, FILTER_SANITIZE_STRING) !== $name) {
            throw new \exceptions\InvalidCharactersException();
        }

        if (mb_strlen($name) < 3 && mb_strlen($password) <6) {
            throw new \exceptions\PassAndNameLengthException();
        }
        if (mb_strlen($name) < 3) {
            throw new \exceptions\UsernameLengthException();
        }
        if (mb_strlen($password) < 6) {
            throw new \exceptions\PasswordLengthException();
        }
        if ($password !== $passwordRepeat) {
            throw new \exceptions\PasswordNotMatchingException();
        }


        $this->name = $name;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
    }


}