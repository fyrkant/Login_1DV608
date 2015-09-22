<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-22
 * Time: 13:10
 */

namespace view;


class MessageView
{

    private static $errorMessages = [
        "Username"        => "Username is missing",
        "Password"        => "Password is missing",
        "Credentials"     => "Wrong name or password",
        "Welcome"         => "Welcome",
        "WelcomeRemember" => "Welcome and you will be remembered",
        "CookieWelcome"   => "Welcome back with cookie",
        "CookieError"     => "Wrong information in cookie",
        "ByeBye"          => "Bye bye!"
    ];
    /**
     * @var \model\MessageModel
     */
    private $model;

    public function __construct(\model\MessageModel $model)
    {

        $this->model = $model;
    }


    public function getMessage()
    {
        $messageKey = $this->model->getMessageKey();

        $message = isset(self::$errorMessages[ $messageKey ]) ? self::$errorMessages[ $messageKey ] : "";

        return $message;
    }

}