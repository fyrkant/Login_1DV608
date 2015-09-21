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
     * @param \model\LoginModel $loginModel
     * @param \view\LoginView $loginView
     * @param MessageController $messageController
     * @param \view\CookieJar $cookieJar
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
     * Main login control, checks what the user wants to do and does it.
     */
    public function doControl()
    {

        $userIsLoggedIn = $this->loginModel->isLoggedIn();

        if ($userIsLoggedIn && $this->loginView->userWantsToLogOut()) {

            $this->logOut();

        } else if (!$userIsLoggedIn) {

            if ($this->cookieJar->cookieExists()) {

                $this->tryCookieLogin();
            }

            if ($this->loginView->userTriedToLogin()) {

                $this->tryLogin();
            }
        }
    }

    /**
     * Removes logged in Session, clears cookies,
     * sets a message and redirects with header("Location: ").
     */
    private function logOut()
    {
        $this->loginModel->logOut();
        $this->cookieJar->clearCookies();
        $this->messageController->setMessage("Bye bye!");
        $this->loginView->redirect();
    }

    /**
     * Checks if cookie is OK, if it is - logs in user.
     * If cookie has been tampered with the user is logged
     * out, cookie is cleared and message is set.
     */
    private function tryCookieLogin()
    {
        if ($this->cookieJar->cookieIsOK()) {
            $this->loginModel->cookieLogIn();
            $this->messageController->setMessage("Welcome back with cookie");
        } else {
            $this->cookieJar->clearCookies();
            $this->loginModel->logOut();
            $this->messageController->setMessage("Wrong information in cookies");
        }
    }

    /**
     * Gets input from view, tries to log in.
     * If provided username & password is correct
     * user is logged in, message is set and view redirects.
     * If user has checked "remember me" cookies will be saved.
     * Exceptions thrown by model gets catched and messages
     * sent to messageController.
     */
    private function tryLogin()
    {
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

    public function userLoggedInCheck()
    {
        return $this->loginModel->isLoggedIn();
    }


}