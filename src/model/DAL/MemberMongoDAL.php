<?php

namespace model\DAL;


class MemberMongoDAL implements MemberDALInterface
{

    /*
     * Using MongoDB driver
     * URL: http://php.net/mongo
     */

    private $db;


    public function __construct()
    {
        try {
            $serverString = "mongodb://"
                . \AppSettings::MONGO_USERNAME . ":"
                . \AppSettings::MONGO_PASSWORD . "@"
                . \AppSettings::MONGO_IP;
            $m = new \MongoClient($serverString);
            $this->db = $m->selectDB("users")->selectCollection("creds");
        } catch (\MongoConnectionException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param \model\RegisterAttemptModel $attempt
     *
     * @throws \exceptions\UserAlreadyExistsException
     */
    public function tryRegisterNew(\model\RegisterAttemptModel $attempt)
    {
        if ($this->usernameExistsCheck($attempt->getName())) {
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
        $query = array("Name" => $username);
        $cursor = $this->db->findOne($query);

        if ($cursor != null) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param \model\RegisterAttemptModel $attempt
     */
    private function save(\model\RegisterAttemptModel $attempt)
    {
        $memberToSave = new \model\RegisterModel($attempt);

        $toAdd = array("Name"     => $memberToSave->getName(),
                       "Password" => $memberToSave->getPassword());

        $this->db->insert($toAdd);
    }

    /**
     * @param $username
     *
     * @return string password
     */
    public function getMemberPassword($username)
    {
        $query = array("Name" => $username);
        $user = $this->db->findOne($query);

        return $user["Password"];
    }


}