<?php

namespace model;


class UserClient
{
    private $ip;
    private $browser;

    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->browser = $_SERVER['HTTP_USER_AGENT'];
    }

    public function isSame(UserClient $uc) {

        if ($uc->browser === $this->browser && $uc->getIp() === $this->ip) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser;
    }



}