<?php

namespace view;


class RegisterView
{

    private static $messageId = 'RegisterView::Message';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $register = "DoRegistration";
    /**
     * @var MessageView
     */
    private $messageView;
    private $message = "";

    public function __construct(\view\MessageView $message)
    {
        $this->messageView = $message;
    }

    public function response()
    {

        //$message = $this->messageView->getMessage();

        $response = $this->generateRegisterFormHTML($this->message);

        return $response;
    }

    public function generateRegisterFormHTML($message)
    {
        $name = isset($_POST[ self::$name ]) ? $_POST[ self::$name ] : "";

        return '<h2>Register new user</h2>
        <form method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Register a new user - Write username and password</legend>
                <p id="' . self::$messageId . '">' . $message . '</p>
                <label for="' . self::$name . '">Username :</label>
                <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . $name . '" />
                <br />
                <label for="' . self::$password . '">Password :</label>
                <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="" />
                <br />
                <label for="' . self::$passwordRepeat . '">Repeat password :</label>
                <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="" />
                <br />
                <input id="submit" type="submit" name="' . self::$register . '" value="Register" />
                <br />
            </fieldset>
        </form>';
    }

    public function userTriedToRegister()
    {
        if (isset($_POST[ self::$register ])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserInput()
    {
        $name = isset($_POST[ self::$name ]) ? $_POST[ self::$name ] : "";
        $password = isset($_POST[ self::$password ]) ? $_POST[ self::$password ] : "";
        $passwordRepeat = isset($_POST[ self::$passwordRepeat ]) ? $_POST[ self::$passwordRepeat ] : "";

        try {

            $attempt = new \model\RegisterAttemptModel($name, $password, $passwordRepeat);
            return $attempt;

        } catch (\exceptions\UsernameLengthException $e) {

            $this->message = $this->messageView->getMessageWithKey("UserNameLength");
            //$this->messageView->setMessageKey("UsernameLength");
        } catch (\exceptions\PasswordLengthException $e) {
            $this->message = $this->messageView->getMessageWithKey("PasswordLength");
            //$this->messageView->setMessageKey("PasswordLength");
        } catch (\exceptions\PasswordNotMatchingException $e) {
            $this->message = $this->messageView->getMessageWithKey("PasswordMatch");
            //$this->messageView->setMessageKey("PasswordMatch");
        } catch (\exceptions\InvalidCharactersException $e) {
            $this->message = $this->messageView->getMessageWithKey("InvalidCharacters");
            //$this->messageView->setMessageKey("InvalidCharacters");
        } catch (\exceptions\PassAndNameLengthException $e) {
            $this->message = $this->messageView->getMessageWithKey("PassAndNameLength");
            //$this->messageView->setMessageKey("PassAndNameLength");
        }

        return false;

    }

}