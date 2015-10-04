<?php

namespace model\DAL;


class MemberRegistry
{

    private static $filename = "passwords.json";

    public function __construct($dataPath)
    {
        self::$filename = $dataPath . self::$filename;
    }

    public function tryRegisterNew(\model\RegisterAttemptModel $attempt)
    {
        if($this->usernameExistsCheck($attempt->getName())) {
            throw new \exceptions\UserAlreadyExistsException();
        }

        $this->registerNewMember($attempt);
    }

    public function usernameExistsCheck($username)
    {
        $fileContent = file_get_contents(self::$filename);
        $decodedArray = json_decode($fileContent, true);

        if (isset($decodedArray[ $username ])) {
            return true;
        } else {
            return false;
        }

    }

    public function registerNewMember(\model\RegisterAttemptModel $attempt)
    {
        $fileContent = file_get_contents(self::$filename);
        $decodedArray = json_decode($fileContent, true);

        $decodedArray[ $attempt->getName() ] = password_hash($attempt->getPassword(), PASSWORD_BCRYPT);

        $json = json_encode($decodedArray);

        file_put_contents(self::$filename, $json);
    }

    public function getMemberPassword($username)
    {
        $fileContent = file_get_contents(self::$filename);
        $decodedArray = json_decode($fileContent, true);

        return $decodedArray[ $username ];
    }


    public function saveLoginCredentials($userName)
    {
        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = time() + (30 * 24 * 60 * 60);

        $stringToSave = $randomString . "_" . $cookieLife . "\n";

        file_put_contents(self::$filename, $stringToSave, FILE_APPEND);

        setcookie(self::$cookieName, $userName, $cookieLife, "/");
        setcookie(self::$cookiePassword, $randomString, $cookieLife, "/");

    }

    public function keep()
    {
        $fileContentString = file_get_contents(self::$filename);

        $decodedArray = json_decode($fileContentString);

        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = time() + (30 * 24 * 60 * 60);

        $decodedArray[ $randomString ] = $cookieLife;

        $json = json_encode($decodedArray);

        file_put_contents(self::$filename, $json);
    }

}