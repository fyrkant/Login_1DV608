<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-05
 * Time: 12:23
 */
namespace model\DAL;

interface MemberDALInterface
{

    public function tryRegisterNew(\model\RegisterAttemptModel $attempt);

    public function usernameExistsCheck($username);

    public function getMemberPassword($username);
}