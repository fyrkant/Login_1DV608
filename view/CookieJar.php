<?php

namespace view;

class CookieJar
{

    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    private static $directory = "secret";
    private static $filename = "secret/file.txt";

    public function userIsRemembered()
    {
        if (isset($_COOKIE[ self::$cookieName ])) {
            return true;
        } else {
            return false;
        }
    }

    public function setLoginCookies()
    {
        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = (time() + 60 * 60 * 30);

        if (!file_exists(self::$directory)) {
            mkdir(self::$directory, 0744);
        }

        $ip = $_SERVER['REMOTE_ADDR'];

        $stringToSave = $ip . "_" . $randomString . "_" . $cookieLife . "\n";

        file_put_contents(self::$filename, $stringToSave, FILE_APPEND);

        setcookie(self::$cookieName, "Admin", $cookieLife, "/");
        setcookie(self::$cookiePassword, $randomString, $cookieLife, "/");

    }

    public function cookieIsOK()
    {
        $cookiePassword = $this->getCookiePassword();

        $fileArray = file(self::$filename);

        $ip = $_SERVER['REMOTE_ADDR'];
        $correctCookie = null;
        $now = time();

        foreach ($fileArray as $line) {
            $exploded = explode("_", $line);

            if ($ip === $exploded[0] && $cookiePassword === $exploded[1] && $now < $exploded[2]) {
                return true;
            }
        }

        return false;

    }

    public function getCookiePassword()
    {
        $password = $_COOKIE[ self::$cookiePassword ];

        return $password;
    }

    public function clearCookies()
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $fileArray = file(self::$filename);

        foreach ($fileArray as $key => $line) {
            $exploded = explode("_", $line);

            if ($exploded[0] === $ip) {
                unset($fileArray[ $key ]);
            }
        }

        $fileArray = array_values($fileArray);
        file_put_contents(self::$filename, implode($fileArray));

        unset($_COOKIE[ self::$cookieName ]);
        setcookie(self::$cookieName, null, -1, "/");
        unset($_COOKIE[ self::$cookiePassword ]);
        setcookie(self::$cookiePassword, null, -1, "/");


    }

}