<?php

namespace tests;

require_once('/src/model/UserClient.php');

class UserClientTest extends \PHPUnit_Framework_TestCase
{
    protected $model;
    protected $same;
    protected $different;

    protected function setUp() {

        $this->model = new \model\UserClient("123.22.342.21", "Chrome");
        $this->same = new \model\UserClient("123.22.342.21", "Chrome");

        $this->different = new \model\UserClient("256.0.256.45", "Firefox");

    }

    public function testIsSame() {
        $this->assertEquals(true, $this->model->isSame($this->same));

        $this->assertEquals(false, $this->model->isSame($this->different));
    }
}
