<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-06
 * Time: 15:32
 */

namespace controller;

class DateTimeString
{
    private $now;

    /**
     * DateTimeString constructor.
     * Sets $now.
     */
    public function __construct()
    {
        $this->now = new \DateTime("Europe/Stockholm");
    }

    /**
     * @return string
     */
    public function getFormatted() {

        $day = date_format($this->now, "l");
        $date = date_format($this->now, "jS");
        $month = date_format($this->now, "F");
        $year = date_format($this->now, "Y");
        $time = date_format($this->now, "H:i:s");
        $formattedString = "$day, the $date of $month $year, The time is $time";

        return $formattedString;
    }
}