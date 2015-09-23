<?php

namespace model;


class UserClient
{
    private $ip;
    private $agent;

    public function __construct($ip, $agent)
    {
        $this->ip = $ip;
        $this->agent = $agent;
    }

    public function isSame(UserClient $uc) {

        if ($uc->agent === $this->agent && $uc->ip === $this->ip) {
            return true;
        } else {
            return false;
        }
    }

}