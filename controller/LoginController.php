<?php

namespace controller;


class LoginController
{

    private $loginModel;
    private $loginView;
    private $messageController;
    private $cookieJar;

    /**
     * MainController constructor.
     *
     * @param $loginModel
     * @param $loginView
     */
    public function __construct(\model\LoginModel $loginModel,
                                \view\LoginView $loginView,
                                \controller\MessageController $messageController,
                                \view\CookieJar $cookieJar)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
        $this->messageController = $messageController;
        $this->cookieJar = $cookieJar;
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


    /**
     * Main login control, checks what the user wants to do and does it.
     */
    public function doControl()
    {

        $userIsLoggedIn = $this->userLoggedInCheck();

        if ($userIsLoggedIn && $this->loginView->userWantsToLogOut()) {

            $this->loginModel->logOut();
            $this->cookieJar->clearCookies();
            $this->messageController->setMessage("Bye bye!");
            $this->loginView->redirect();

        } else if (!$userIsLoggedIn) {

            if ($this->cookieJar->userIsRemembered()) {

                if ($this->cookieJar->cookieIsOK()) {
                    $this->loginModel->logIn(new \model\LoginModel("Admin", "Password"));
                    $this->messageController->setMessage("Welcome back with cookie");
                } else {
                    $this->cookieJar->clearCookies();
                    $this->loginModel->logOut();
                    $this->messageController->setMessage("Wrong information in cookies");
                }
            }

            if ($this->loginView->userTriedToLogin()) {

                $loginAttempt = $this->loginView->getLoginAttempt();

                try {
                    $this->loginModel->logIn($loginAttempt);

                    if ($loginAttempt->getKeep()) {
                        $this->messageController->setMessage("Welcome and you will be remembered");
                        $this->cookieJar->setLoginCookies();
                    } else {
                        $this->messageController->setMessage("Welcome");
                    }
                    $this->loginView->redirect();
                } catch (\Exception $e) {
                    $this->messageController->setMessage($e->getMessage());
                }
            }
        }
    }

    public function userLoggedInCheck()
    {
        return $this->loginModel->isLoggedIn();
    }


}