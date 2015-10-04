<?php

namespace view;

class CookieJar
{

    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $messageKeyCookiePosition = "CookieJar::message";

    private static $filename = "cookies.json";

    /**
     * @param $dataPath
     */
    public function __construct($dataPath)
    {
        self::$filename = $dataPath . self::$filename;
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
        $fileContentString = file_get_contents(self::$filename);

        $decodedArray = json_decode($fileContentString);

        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = time() + (30 * 24 * 60 * 60);

        $decodedArray[$randomString] = $cookieLife;

        $json = json_encode($decodedArray);

        file_put_contents(self::$filename, $json);

        setcookie(self::$cookieName, $userName, $cookieLife, "/");
        setcookie(self::$cookiePassword, $randomString, $cookieLife, "/");

    }

    /**
     * @return bool
     * @throws \exceptions\IncorrectCookieException
     */
    public function cookieIsOK()
    {
        $cookiePassword = $_COOKIE[ self::$cookiePassword ];

        $now = time();

        $fileContentString = file_get_contents(self::$filename);

        $decodedArray = json_decode($fileContentString);

        foreach ($decodedArray as $randomString => $timeToDie) {
            if ($cookiePassword === $randomString && $now < $timeToDie) {
                return true;
            }
        }

        throw new \exceptions\IncorrectCookieException();
    }

    public function clearCookies()
    {
        $cookieString = $_COOKIE[ self::$cookiePassword ];

        $fileContentString = file_get_contents(self::$filename);

        $decodedArray = json_decode($fileContentString, true);

        unset($decodedArray[$cookieString]);

        $json = json_encode($decodedArray);

        file_put_contents(self::$filename, $json);

        unset($_COOKIE[ self::$cookieName ]);
        setcookie(self::$cookieName, null, -1, "/");
        unset($_COOKIE[ self::$cookiePassword ]);
        setcookie(self::$cookiePassword, null, -1, "/");

    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        $messageKey = isset($_COOKIE[ self::$messageKeyCookiePosition ]) ? $_COOKIE[ self::$messageKeyCookiePosition ] : "";

        unset($_COOKIE[ self::$messageKeyCookiePosition ]);
        setcookie(self::$messageKeyCookiePosition, null, -1, "/");

        return $messageKey;
    }

    /**
     * @param $key
     */
    public function setMessageKey($key)
    {
        setcookie(self::$messageKeyCookiePosition, $key, 0, "/");
        $_COOKIE[ self::$messageKeyCookiePosition ] = $key;
    }
}