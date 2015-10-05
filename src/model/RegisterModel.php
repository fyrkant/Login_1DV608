<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-05
 * Time: 10:01
 */

namespace model;


class RegisterModel
{

    private $name;
    private $hashedPassword;

    public function __construct(\model\RegisterAttemptModel $attempt)
    {
        $this->name = $attempt->getName();
        $this->hashedPassword = password_hash($attempt->getPassword(), PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool|string
     */
    public function getPassword()
    {
        return $this->hashedPassword;
    }

}