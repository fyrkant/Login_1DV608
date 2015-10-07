<?php

namespace model;


class UserClient
{
    private $ip;
    private $agent;

    /**
     * @param $ip
     * @param $agent
     */
    public function __construct($ip, $agent)
    {
        $this->ip = $ip;
        $this->agent = $agent;
    }

    /**
     * @param UserClient $uc
     *
     * @return bool
     */
    public function isSame(UserClient $uc) {

        if ($uc->agent === $this->agent && $uc->ip === $this->ip) {
            return true;
        } else {
            return false;
        }
    }

}