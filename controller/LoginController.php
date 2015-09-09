<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 06:53
 */

namespace controller;


class LoginController
{
    private $loginModel;
    private $loginView;

    /**
     * LoginController constructor.
     * @param $loginModel
     * @param $loginView
     */
    public function __construct(\model\LoginModel $loginModel, \view\LoginView $loginView)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
    }


    public function doControl() {

        if ($this->loginModel->isLoggedIn()) {



        } else {



        }
    }

}