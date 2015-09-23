<?php

namespace tests;

require_once('/src/exceptions/UserNameEmptyException.php');
require_once('/src/exceptions/PasswordEmptyException.php');
require_once('/src/model/LoginAttemptModel.php');

use model\LoginAttemptModel;


class LoginAttemptModelTest extends \PHPUnit_Framework_TestCase
{
    protected $model;

    protected function setUp() {
        $this->model = new LoginAttemptModel("Username", "Password", true, true);
    }

    public function testGetters() {
        $this->assertEquals("Username", $this->model->getName());

        $this->assertEquals("Password", $this->model->getPassword());

        $this->assertEquals(true, $this->model->getKeep());

        $this->assertEquals(true, $this->model->isRemembered());
    }

    /**
     * @expectedException \exceptions\UserNameEmptyException
     */
    public function testUserNameEmptyException()
    {
        $newAttempt = new LoginAttemptModel("", "Password", true, false);
    }

    /**
     * @expectedException \exceptions\PasswordEmptyException
     */
    public function testPasswordEmptyException()
    {
        $newAttempt = new LoginAttemptModel("Username", "", true, false);
    }

    /**
     * @expectedException \exceptions\UserNameEmptyException
     */
    public function testUserNameAndPasswordEmptyException()
    {
        $newAttempt = new LoginAttemptModel("", "", true, false);
    }

}
