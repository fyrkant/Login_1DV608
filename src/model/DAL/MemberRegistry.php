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

        $this->save($attempt);
    }

    public function usernameExistsCheck($username)
    {
        return file_exists(\AppSettings::DATA_PATH . $username);
    }


    public function getMemberPassword($username)
    {
        $fileContents = file_get_contents(\AppSettings::DATA_PATH . $username);
        $member = unserialize($fileContents);

        return $member->getPassword();
    }

    private function save(\model\RegisterAttemptModel $attempt)
    {
        $member = new \model\RegisterModel($attempt);
        $toSave = serialize($member);

        file_put_contents(\AppSettings::DATA_PATH . $attempt->getName(), $toSave);
    }
}