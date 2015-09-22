<?php

namespace controller;


class LoginController
{

    private $loginModel;
    private $loginView;
    private $messageModel;

    /**
     * MainController constructor.
     *
     * @param \model\LoginModel $loginModel
     * @param \view\LoginView $loginView
     * @param \model\MessageModel $messageModel
     */
    public function __construct(\model\LoginModel $loginModel,
                                \view\LoginView $loginView,
                                \model\MessageModel $messageModel)
    {
        $this->loginModel = $loginModel;
        $this->loginView = $loginView;
        $this->messageModel = $messageModel;
    }

    /**
     * @return mixed
     */
    public function getIsLoggedIn()
    {
        $currentUser = $this->loginView->getUserClient();

        return $this->loginModel->isLoggedIn($currentUser);
    }

    /**
     * Main login control, checks what the user wants to do and does it.
     */
    public function doControl()
    {
        $currentUser = $this->loginView->getUserClient();

        $isLoggedIn = $this->loginModel->isLoggedIn($currentUser);

        if ($isLoggedIn && $this->loginView->userWantsToLogOut()) {

            $this->messageModel->setMessageKey("ByeBye");
            $this->logOut();

        } else if (!$isLoggedIn && $this->loginView->userTriedToLogin()) {

            $this->tryLogin($currentUser);

        }
    }

    /**
     * Removes logged in Session, clears cookies,
     * sets a message and redirects with header("Location: ").
     */
    private function logOut()
    {
        $this->loginModel->logOut();
        $this->loginView->forgetUser();
        $this->loginView->redirect();
    }


    private function tryLogin(\model\UserClient $currentUser)
    {
        try {

            if ($this->loginView->userIsRemembered()) {
                $this->loginModel->logIn($currentUser);
                $this->messageModel->setMessageKey("CookieWelcome");
            } else {

                $attempt = $this->loginView->getUserInput();

                $this->loginModel->tryLogin($attempt, $currentUser);

                if ($attempt->getKeep()) {
                    $this->messageModel->setMessageKey("WelcomeRemember");
                    $this->loginView->remember($attempt->getName());
                } else {
                    $this->messageModel->setMessageKey("Welcome");
                }
                $this->loginView->redirect();
            }
        } catch (\exceptions\UserNameEmptyException $e) {
            $this->messageModel->setMessageKey("Username");
        } catch (\exceptions\PasswordEmptyException $e) {
            $this->messageModel->setMessageKey("Password");
        } catch (\exceptions\IncorrectCredentialsException $e) {
            $this->messageModel->setMessageKey("Credentials");
        } catch (\exceptions\IncorrectCookieException $e) {
            $this->messageModel->setMessageKey("CookieError");
            $this->logOut();
        }
    }
}