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
     * @param \model\DAL\MemberDALInterface $memberDAL
     */
    public function __construct(\view\RegisterView $registerView, \model\DAL\MemberDALInterface $memberDAL)
    {
        $this->registerView = $registerView;
        $this->DAL = $memberDAL;
    }

    /**
     * @return mixed
     */
    public function doControl()
    {

        if ($this->registerView->userTriedToRegister()) {
            $attempt = $this->registerView->getUserInput();

            if ($attempt) {

                try {
                    $this->DAL->tryRegisterNew($attempt);

                    return $attempt->getName();
                } catch (\exceptions\UserAlreadyExistsException $e) {
                    $this->registerView->setMessageKey("UserExists");
                }
            }
        }

        return false;
    }

}