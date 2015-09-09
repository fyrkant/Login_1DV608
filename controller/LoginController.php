<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-09-09
 * Time: 10:51
 */

namespace controller;


class LoginController
{
    private $loginModel;
    private $loginView;
    private $messageController;

    /**
     * MainController constructor.
     * @param $loginModel
     * @param $loginView
     */
    public function __construct(\model\LoginModel $loginModel, \view\LoginView $loginView, \controller\MessageController $messageController)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
        $this->messageController = $messageController;
    }

    /**
     * @return \model\LoginModel
     */
    public function getLoginModel()
    {
        return $this->loginModel;
    }

    /**
     * @return \view\LoginView
     */
    public function getLoginView()
    {
        return $this->loginView;
    }


    public function doControl() {

        if($this->loginView->userWantsToLogOut()) {
            $this->loginModel->logOut();
            $this->messageController->setMessage("Bye bye!");
        } else if ($this->loginView->userTriedToLogin()) {

            $username = $this->loginView->getNameInput();
            $password = $this->loginView->getPasswordInput();

            try {
                $this->loginModel->logIn($username, $password);
                $this->messageController->setMessage("Welcome");
            } catch (\Exception $e) {
                $this->messageController->setMessage($e->getMessage());
            }
        }
    }

    public function userLoginCheck() {
        return $this->loginModel->isLoggedIn();
    }
}