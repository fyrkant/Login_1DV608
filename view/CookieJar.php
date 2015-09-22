<?php

namespace view;

class CookieJar
{

    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    private static $filename = "file.txt";

    private $dataPath;

    public function __construct($dataPath)
    {
        $this->dataPath = $dataPath;
    }

    /**
     * @return bool
     */
    public function cookieExists()
    {
        if (isset($_COOKIE[ self::$cookieName ])) {

            return true;

        } else {

            return false;

        }
    }


    /**
     * @param $userName
     */
    public function setLoginCookies($userName)
    {
        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = time() + (30 * 24 * 60 * 60);

        $stringToSave = $randomString . "_" . $cookieLife . "\n";

        file_put_contents($this->dataPath . self::$filename, $stringToSave, FILE_APPEND);

        setcookie(self::$cookieName, $userName, $cookieLife, "/");
        setcookie(self::$cookiePassword, $randomString, $cookieLife, "/");

    }

    /**
     * @return bool
     */
    public function cookieIsOK()
    {
        $cookiePassword = $this->getCookiePassword();

        $now = time();

        $fileArray = file($this->dataPath . self::$filename);

        foreach ($fileArray as $key => $line) {
            $exploded = explode("_", $line);

            $correctPassword = $exploded[0];
            $timeToDie = trim($exploded[1]);

            if ($cookiePassword === $correctPassword && $now < $timeToDie) {
                return true;
            }
        }

        throw new \exceptions\IncorrectCookieException();

    }

    /**
     * @return string Randomized password string from cookie
     */
    public function getCookiePassword()
    {
        $password = $_COOKIE[ self::$cookiePassword ];

        return $password;
    }

    public function getCookieUsername()
    {
        $username = $_COOKIE[ self::$cookieName ];

        return $username;
    }

    public function clearCookies()
    {
        $cookieString = $_COOKIE[ self::$cookiePassword ];

        $fileArray = file($this->dataPath . self::$filename);

        foreach ($fileArray as $key => $line) {
            $exploded = explode("_", $line);

            $passwordString = $exploded[0];
            $timeToDie = trim($exploded[1]);

            if ($passwordString === $cookieString || $timeToDie < time()) {
                unset($fileArray[ $key ]);
            }
        }

        $fileArray = array_values($fileArray);
        file_put_contents($this->dataPath . self::$filename, implode($fileArray));

        unset($_COOKIE[ self::$cookieName ]);
        setcookie(self::$cookieName, null, -1, "/");
        unset($_COOKIE[ self::$cookiePassword ]);
        setcookie(self::$cookiePassword, null, -1, "/");

    }

}