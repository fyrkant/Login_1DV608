<?php

require_once("/model/LoginModel.php");

class LoginModelTest extends PHPUnit_Framework_TestCase {

    protected $model;

    protected function setUp()
    {
        $this->model = new model\LoginModel("Name", "Password");
    }

    public function testModelNameGet() {
        $this->assertEquals(false, $this->model->getKeep());
    }


}