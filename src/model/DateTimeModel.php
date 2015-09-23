<?php

namespace model;

class DateTimeModel
{

    private $now;

    public function __construct()
    {
        $this->now = new \DateTime("Europe/Stockholm");
    }

    /**
     * @return string
     */
    public function getFormatted()
    {

        $day = date_format($this->now, "l");
        $date = date_format($this->now, "jS");
        $month = date_format($this->now, "F");
        $year = date_format($this->now, "Y");
        $time = date_format($this->now, "H:i:s");
        $formattedString = "$day, the $date of $month $year, The time is $time";

        return $formattedString;
    }

}