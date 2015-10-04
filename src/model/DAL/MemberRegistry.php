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
        $decodedArray = $this->getArrayFromJSONFile();

        if (isset($decodedArray[ $username ])) {
            return true;
        } else {
            return false;
        }

    }

    public function registerNewMember(\model\RegisterAttemptModel $attempt)
    {

        $decodedArray = $this->getArrayFromJSONFile();

        $decodedArray[ $attempt->getName() ] = password_hash($attempt->getPassword(), PASSWORD_BCRYPT);

        $this->saveArrayToJSON($decodedArray);
    }

    public function getMemberPassword($username)
    {
        $decodedArray = $this->getArrayFromJSONFile();

        return $decodedArray[ $username ];
    }

    private function getArrayFromJSONFile()
    {

        $fileContent = file_get_contents(self::$filename);
        $decodedArray = json_decode($fileContent, true);

        return $decodedArray;
    }

    private function saveArrayToJSON($array)
    {
        $json = json_encode($array);

        file_put_contents(self::$filename, $json);
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