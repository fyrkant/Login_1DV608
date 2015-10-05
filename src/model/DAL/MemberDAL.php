<?php

namespace model\DAL;


class MemberDAL implements  MemberDALInterface
{

    /*
     * Using MongoDB driver
     * URL: http://php.net/mongo
     */

    private $db;

    public function __construct()
    {
        try {
            $m = new \MongoClient();
            $this->db = $m->users->users;
        } catch (\MongoConnectionException $e) {
            echo $e->getMessage();
        }
    }

    public function tryRegisterNew(\model\RegisterAttemptModel $attempt)
    {
        if ($this->usernameExistsCheck($attempt->getName())) {
            throw new \exceptions\UserAlreadyExistsException();
        }

        $this->save($attempt);

    }

    private function save(\model\RegisterAttemptModel $attempt) {
        $memberToSave = new \model\RegisterModel($attempt);

        $toAdd = array("Name" => $memberToSave->getName(),
                       "Password" => $memberToSave->getPassword());

        $this->db->insert($toAdd);
    }

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

    public function getMemberPassword($username)
    {
        $query = array("Name" => $username);
        $user = $this->db->findOne($query);

        return $user["Password"];
    }


}