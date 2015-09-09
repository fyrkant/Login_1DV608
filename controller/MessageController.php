<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 13:14
 */

namespace controller;


class MessageController
{
    private $model;

    /**
     * MessageController constructor.
     * @param $model
     */
    public function __construct(\model\MessageModel $model)
    {
        $this->model = $model;
    }

    public function setMessage($message) {
        $this->model->setSessionMessage($message);
    }

}