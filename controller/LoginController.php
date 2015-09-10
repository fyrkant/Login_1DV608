<?php

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


    public function doControl()
    {

        $isUserLoggedIn = $this->userLoggedInCheck();

        if ($this->loginView->userWantsToLogOut() && $isUserLoggedIn) {

            $this->loginModel->logOut();
            $this->messageController->setMessage("Bye bye!");
            $this->redirect();

        } else if ($this->loginView->userTriedToLogin() && !$isUserLoggedIn) {

            $username = $this->loginView->getNameInput();
            $password = $this->loginView->getPasswordInput();

            try {
                $this->logIn($username, $password);
                $this->messageController->setMessage("Welcome");
                $this->redirect();
            } catch (\Exception $e) {
                $this->messageController->setMessage($e->getMessage());
            }
        }
    }

    public function userLoggedInCheck()
    {
        return $this->loginModel->isLoggedIn();
    }

    public function redirect()
    {
        header("Location: " . $_SERVER['REQUEST_URI']);
        die();
    }

    public function logIn($username, $password)
    {

        if ($username === $this->loginModel->getName() && $password === $this->loginModel->getPassword()) {
            $this->loginModel->logIn();
        } else if ($username == "" && $password == "") {
            throw new \Exception("Username is missing");
        } else if ($password == "") {
            throw new \Exception("Password is missing");
        } else if ($username == "") {
            throw new \Exception("Username is missing");
        } else {
            throw new \Exception("Wrong name or password");
        }

    }
}