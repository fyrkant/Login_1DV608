<?php

namespace model;


class LoginAttemptModel
{

    private $name;
    private $password;
    private $keep;
    private $isRemembered;

    /**
     * @param string $name
     * @param string $password
     * @param UserClient $client
     * @param bool|false $keep
     *
     * @throws \exceptions\PasswordEmptyException
     * @throws \exceptions\UserNameEmptyException
     */
    public function __construct($name, $password, $keep, $isRemembered)
    {
        if ($name == "" && $password == "") {
            throw new \exceptions\UserNameEmptyException();
        }
        if ($password == "") {
            throw new \exceptions\PasswordEmptyException();
        }
        if ($name == "") {
            throw new \exceptions\UserNameEmptyException();
        }

        $this->name = $name;
        $this->password = $password;
        $this->keep = $keep;
        $this->isRemembered = $isRemembered;
    }

    /**
     * @return mixed
     */
    public function isRemembered()
    {
        return $this->isRemembered;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getKeep()
    {
        return $this->keep;
    }

}