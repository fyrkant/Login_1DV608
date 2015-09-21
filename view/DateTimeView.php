<?php

namespace view;

class DateTimeView
{

    private $model;

    /**
     * @param \model\DateTimeModel $model
     */
    public function __construct(\model\DateTimeModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return string HTML
     */
    public function getHTML()
    {

        return '<p>' . $this->model->getFormatted() . '</p>';

    }
}