<?php

namespace controller;


class RegisterController
{

    /**
     * @var \view\RegisterView
     */
    private $registerView;
    /**
     * @var \model\DAL\MemberRegistry
     */
    private $DAL;

    public function __construct(\view\RegisterView $registerView, \model\DAL\MemberRegistry $memberRegistry)
    {
        $this->registerView = $registerView;
        $this->DAL = $memberRegistry;
    }


    public function doControl() {

        if ($this->registerView->userTriedToRegister()) {
            $attempt = $this->registerView->getUserInput();

            if ($attempt) {

                try {
                    $this->DAL->tryRegisterNew($attempt);
                } catch (\exceptions\UserAlreadyExistsException $e) {
                    $this->registerView->setMessageKey("UserExists");
                }
            }
        }
    }

}