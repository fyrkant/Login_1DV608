<?php

namespace model;


class LoginAttemptModel
{

    private $name;
    private $password;
    private $keep;

    /**
     * @param string $name
     * @param string $password
     * @param bool|false $keep
     *
     */
    public function __construct($name, $password, $keep)
    {
        $this->name = $name;
        $this->password = $password;
        $this->keep = $keep;
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