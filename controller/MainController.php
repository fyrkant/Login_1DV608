<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 10:51
 */

namespace controller;


class MainController
{
    private $loginModel;
    private $loginView;
    private $layoutView;
    private $dateTimeView;

    /**
     * MainController constructor.
     * @param $loginModel
     * @param $loginView
     * @param $layoutView
     * @param $dateTimeView
     */
    public function __construct(\model\LoginModel $loginModel, \view\LoginView $loginView, \view\LayoutView $layoutView, \view\DateTimeView $dateTimeView)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
        $this->layoutView = $layoutView;
        $this->dateTimeView = $dateTimeView;
    }


    public function doControl() {
        if($this->loginView->userWantsToLogOut()) {
            $this->loginModel->logOut();
        } else if ($this->loginView->userTriedToLogin()) {
            $this->loginView->tryLogIn();
        }

        if ($this->loginModel->isLoggedIn()) {
            $this->layoutView->render(true, $this->loginView, $this->dateTimeView);
        } else {
            $this->layoutView->render(false, $this->loginView, $this->dateTimeView);
        }

    }

}