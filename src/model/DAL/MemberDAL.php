<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-05
 * Time: 10:48
 */

namespace model\DAL;


class MemberDAL implements  MemberDALInterface
{

    private $db;

    public function __construct()
    {
        try {
            $m = new \MongoClient();
        } catch (\MongoConnectionException $e) {
            echo $e->getMessage();
        }

        $this->db = $m->users->users;
    }

    public function listData()
    {
        $toAdd = array("Name" => "Admin", "Password" => "Password");

        //$this->db->insert($toAdd);


        $all = $this->db->find();

        foreach ($all as $user) {
            var_dump($user);
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