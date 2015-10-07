<?php

namespace model\DAL;


class MemberFileDAL implements MemberDALInterface
{

    private static $dataPath;

    public function __construct($dataPath)
    {
        self::$dataPath = $dataPath;
    }

    /**
     * @param \model\RegisterAttemptModel $attempt
     *
     * @throws \exceptions\UserAlreadyExistsException
     */
    public function tryRegisterNew(\model\RegisterAttemptModel $attempt)
    {
        if($this->usernameExistsCheck($attempt->getName())) {
            throw new \exceptions\UserAlreadyExistsException();
        }

        $this->save($attempt);
    }

    /**
     * @param $username
     *
     * @return bool
     */
    public function usernameExistsCheck($username)
    {
        return file_exists(self::$dataPath . $username);
    }


    /**
     * @param $username
     *
     * @return mixed
     */
    public function getMemberPassword($username)
    {
        $fileContents = file_get_contents(self::$dataPath . $username);
        $member = unserialize($fileContents);

        return $member->getPassword();
    }

    /**
     * @param \model\RegisterAttemptModel $attempt
     */
    private function save(\model\RegisterAttemptModel $attempt)
    {
        $member = new \model\RegisterModel($attempt);
        $toSave = serialize($member);

        file_put_contents(self::$dataPath . $attempt->getName(), $toSave);
    }
}