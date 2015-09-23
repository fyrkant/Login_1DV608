<?php

require_once('/exceptions/IncorrectCredentialsException.php');
require_once("/model/LoginModel.php");
require_once("/model/UserClient.php");

class LoginModelTest extends PHPUnit_Framework_TestCase {

    protected $model;

    protected function setUp()
    {
        $this->model = new model\LoginModel("Name", "Password");

        $this->correctAttempt = new model\LoginAttemptModel("Name", "Password", true, true);
        $this->incorrectAttempt = new model\LoginAttemptModel("WRONG", "NOPE", true, true);

        $this->client = new model\UserClient(123, 123);
    }

    /**
     * @expectedException \exceptions\IncorrectCredentialsException
     */
    public function testLoginException() {

        $this->model->tryLogin($this->incorrectAttempt, $this->client);

    }


}