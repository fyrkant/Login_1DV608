<?php

namespace view;

/**
 * MessageView with keys and messages, for easy changes/translations.
 * */
class MessageView
{

    private static $errorMessages = [
        "Username"        => "Username is missing",
        "Password"        => "Password is missing",
        "Credentials"     => "Wrong name or password",
        "Welcome"         => "Welcome",
        "WelcomeRemember" => "Welcome and you will be remembered",
        "CookieWelcome"   => "Welcome back with cookie",
        "CookieError"     => "Wrong information in cookies",
        "ByeBye"          => "Bye bye!"
    ];
    /**
     * @var CookieJar
     */
    private $cookieJar;

    public function __construct(\view\CookieJar $cookieJar)
    {
        $this->cookieJar = $cookieJar;
    }


    public function getMessage()
    {
        $messageKey = $this->cookieJar->getMessageKey();

        $message = isset(self::$errorMessages[ $messageKey ]) ? self::$errorMessages[ $messageKey ] : "";

        return $message;
    }

    public function setMessageKey($key) {
        $this->cookieJar->setMessageKey($key);
    }

}