<?php

namespace controller;


class RegisterController
{

    /**
     * @var \view\RegisterView
     */
    private $registerView;

    public function __construct(\view\RegisterView $registerView)
    {
        $this->registerView = $registerView;
    }


    public function doControl() {

        if ($this->registerView->userTriedToRegister()) {
            $attempt = $this->registerView->getUserInput();
        }

    }

}