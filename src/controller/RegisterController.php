<?php

namespace controller;


class RegisterController
{

    /**
     * @var \view\RegisterView
     */
    private $registerView;
    /**
     * @var \model\DAL\MemberFileDAL
     */
    private $DAL;

    /**
     * @param \view\RegisterView $registerView
     * @param \model\DAL\MemberDALInterface $memberRegistry
     */
    public function __construct(\view\RegisterView $registerView, \model\DAL\MemberDALInterface $memberRegistry)
    {
        $this->registerView = $registerView;
        $this->DAL = $memberRegistry;
    }


    /**
     * @return mixed
     */
    public function doControl()
    {

        if ($this->registerView->userTriedToRegister()) {
            $attempt = $this->registerView->getUserInput();

            if ($attempt != null) {

                try {
                    $this->DAL->tryRegisterNew($attempt);

                    return $attempt->getName();
                } catch (\exceptions\UserAlreadyExistsException $e) {
                    $this->registerView->setMessageKey("UserExists");
                }
            }
        }
    }

}