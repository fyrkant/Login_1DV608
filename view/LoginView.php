<?php

namespace view;

class LoginView
{

    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    private $loginModel;
    private $messageView;
    private $cookieJar;

    /**
     * LoginView constructor.
     *
     * @param \model\LoginModel $login
     * @param \model\MessageModel|MessageView $message
     *
     * @internal param $model
     */
    public function __construct(\model\LoginModel $login, \view\MessageView $message, \view\CookieJar $cookieJar)
    {
        $this->loginModel = $login;
        $this->messageView = $message;
        $this->cookieJar = $cookieJar;
    }


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @param $isLoggedIn
     *
     * @return string html BUT writes to standard output and cookies!
     */
    public function response($isLoggedIn)
    {

        $message = $this->messageView->getMessage();

        $response = null;

        if ($isLoggedIn) {
            $response = $this->generateLogoutButtonHTML($message);
        } else {
            $response = $this->generateLoginFormHTML($message);
        }

        return $response;
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     *
     * @param $message , String output message
     *
     * @return  string html, BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message)
    {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     *
     * @param $message , String output message
     *
     * @return  string html, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message)
    {

        $name = $this->getInput(self::$name);

        return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $name . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    /**
     * @param $name
     *
     * @return mixed|string
     */
    private function getInput($name)
    {
        if (!isset($_POST[ $name ])) {
            return "";
        } else {
            return filter_var(trim($_POST[ $name ]), FILTER_SANITIZE_STRING);
        }
    }

    /**
     * @return bool
     */
    public function userTriedToLogin()
    {
        if (isset($_POST[ self::$login ]) || $this->cookieJar->cookieExists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function userWantsToLogOut()
    {
        if (isset($_POST[ self::$logout ])) {
            return true;
        } else {
            return false;
        }
    }

    public function redirect()
    {
        header("Location: " . $_SERVER['REQUEST_URI']);
        die();
    }

    /**
     * @return \model\LoginAttemptModel
     */
    public function getUserInput()
    {
        $name = $this->getInput(self::$name);
        $password = $this->getInput(self::$password);
        $keep = $this->getInput(self::$keep);

        try {
            $isRemembered = $this->cookieJar->cookieExists() ? $this->cookieJar->cookieIsOK() : false;

            if ($isRemembered) {
                $attempt = new \model\LoginAttemptModel("Cookie", "VIP", true, true);
            } else {
                $attempt = new \model\LoginAttemptModel($name, $password, $keep, $isRemembered);
            }

            return $attempt;
        } catch (\exceptions\UserNameEmptyException $e) {
            $this->messageView->setMessageKey("Username");
        } catch (\exceptions\PasswordEmptyException $e) {
            $this->messageView->setMessageKey("Password");
        } catch (\exceptions\IncorrectCredentialsException $e) {
            $this->messageView->setMessageKey("Credentials");
        } catch (\exceptions\IncorrectCookieException $e) {
            $this->messageView->setMessageKey("CookieError");
        }

        return false;
    }

    public function setMessageKey($key)
    {
        $this->messageView->setMessageKey($key);
    }

    public function userIsRemembered()
    {
        if ($this->cookieJar->cookieExists() && $this->cookieJar->cookieIsOK()) {
            return true;
        } else {
            return false;
        }
    }

    public function forgetUser()
    {
        $this->cookieJar->clearCookies();
    }

    public function rememberUser($username)
    {
        $this->cookieJar->setLoginCookies($username);
    }

    public function getUserClient()
    {
        $userClient = new \model\UserClient($_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);

        return $userClient;
    }
}