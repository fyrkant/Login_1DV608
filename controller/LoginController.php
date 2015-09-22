<?php

namespace controller;


class LoginController
{

    private $loginModel;
    private $loginView;
    private $messageModel;
    private $cookieJar;

    /**
     * MainController constructor.
     *
     * @param \model\LoginModel $loginModel
     * @param \view\LoginView $loginView
     * @param \model\MessageModel $messageModel
     * @param \view\CookieJar $cookieJar
     */
    public function __construct(\model\LoginModel $loginModel,
                                \view\LoginView $loginView,
                                \model\MessageModel $messageModel,
                                \view\CookieJar $cookieJar)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
        $this->messageModel = $messageModel;
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
        $this->messageModel->setMessageKey("ByeBye");
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
            $this->messageModel->setMessageKey("CookieWelcome");
        } else {
            $this->cookieJar->clearCookies();
            $this->loginModel->logOut();
            $this->messageModel->setMessageKey("CookieError");
        }
    }

    /**
     * Gets input from view, tries to log in.
     * If provided username & password is correct
     * user is logged in, message is set and view redirects.
     * If user has checked "remember me" cookies will be saved.
     * Exceptions thrown by model gets caught and messages
     * sent to messageController.
     */
    private function tryLogin()
    {
        try {
            $attempt = $this->loginView->getLoginAttempt();

            $this->loginModel->logIn($attempt);

            if ($attempt->getKeep()) {
                $this->messageModel->setMessageKey("WelcomeRemember");
                $this->cookieJar->setLoginCookies($this->loginModel->getName());
            } else {
                $this->messageModel->setMessageKey("Welcome");
            }
            $this->loginView->redirect();
        } catch (\exceptions\UserNameEmptyException $e) {
            $this->messageModel->setMessageKey("Username");
        } catch (\exceptions\PasswordEmptyException $e) {
            $this->messageModel->setMessageKey("Password");
        } catch (\exceptions\IncorrectCredentialsException $e) {
            $this->messageModel->setMessageKey("Credentials");
        }
    }

    public function userLoggedInCheck()
    {
        return $this->loginModel->isLoggedIn();
    }


}