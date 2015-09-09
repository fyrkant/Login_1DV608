<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-06
 * Time: 15:32
 */

namespace controller;

class DateTimeController
{

    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new \model\DateTimeModel("Europe/Stockholm");
        $this->view = new \view\DateTimeView($this->model);

    }

    public function doControll() {
        return $this->view->getHTML();
    }

}