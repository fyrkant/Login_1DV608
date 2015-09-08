<?php

namespace model;

class DateTimeModel {

    private $now;

    public function __construct($timeZone)
    {
        $this->now = new \DateTime($timeZone);
    }

    public function getNow() {
        return $this->now;
    }

}