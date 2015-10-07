<?php

namespace model\DAL;

interface MemberDALInterface
{

    public function tryRegisterNew(\model\RegisterAttemptModel $attempt);

    public function usernameExistsCheck($username);

    public function getMemberPassword($username);
}