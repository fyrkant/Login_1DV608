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

    /**
     * @var \model\MessageModel
     */
    private $model;

    /**
     * MessageController constructor.
     *
     * @param \model\MessageModel $model
     */
    public function __construct(\model\MessageModel $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->model->setSessionMessage($message);
    }

}