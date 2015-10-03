<?php

namespace view;

/**
 * MessageView with keys and messages, for easy changes/translations.
 * */
class MessageView
{

    private static $errorMessages = [
        "Username"          => "Username is missing",
        "Password"          => "Password is missing",
        "Credentials"       => "Wrong name or password",
        "Welcome"           => "Welcome",
        "WelcomeRemember"   => "Welcome and you will be remembered",
        "CookieWelcome"     => "Welcome back with cookie",
        "CookieError"       => "Wrong information in cookies",
        "ByeBye"            => "Bye bye!",
        "UsernameLength"    => "Username has too few characters, at least 3 characters.",
        "PasswordLength"    => "Password has too few characters, at least 6 characters.",
        "PasswordMatch"     => "Passwords do not match.",
        "UserExists"        => "User exists, pick another username.",
        "InvalidCharacters" => "Username contains invalid characters.",
        "Registered"        => "Registered new user.",
        "PassAndNameLength" => "Username has too few characters, at least 3 characters.<br />Password has too few characters, at least 6 characters."

    ];
    /**
     * @var CookieJar
     */
    private $cookieJar;

    public function __construct(\view\CookieJar $cookieJar)
    {
        $this->cookieJar = $cookieJar;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        $messageKey = $this->cookieJar->getMessageKey();

        $message = isset(self::$errorMessages[ $messageKey ]) ? self::$errorMessages[ $messageKey ] : "";

        return $message;
    }

    public function getMessageWithKey($key) {
        return self::$errorMessages[$key];
    }

    /**
     * @param $key
     */
    public function setMessageKey($key)
    {
        $this->cookieJar->setMessageKey($key);
    }

}