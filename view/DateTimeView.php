<?php

namespace view;

class DateTimeView
{

    private $model;

    public function __construct(\model\DateTimeModel $model)
    {
        $this->model = $model;
    }

    public function getHTML()
    {

        return '<p>' . $this->model->getFormatted() . '</p>';

    }
}