<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-06
 * Time: 15:32
 */

namespace controller;

class DateTimeController {

    private $model;

    public function __construct()
    {
        $this->model = new \model\DateTimeModel("Europe/Stockholm");
    }

    /**
     * @return string
     */
    public function getFormatted() {

        $day = date_format($this->model->getNow(), "l");
        $date = date_format($this->model->getNow(), "jS");
        $month = date_format($this->model->getNow(), "F");
        $year = date_format($this->model->getNow(), "Y");
        $time = date_format($this->model->getNow(), "H:i:s");
        $formattedString = "$day, the $date of $month $year, The time is $time";

        return $formattedString;
    }
}