<?php

namespace view;

class LoginView
{

    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    private $loginModel;
    private $messageModel;

    /**
     * LoginView constructor.
     *
     * @param \model\LoginModel $login
     * @param \model\MessageModel $message
     *
     * @internal param $model
     */
    public function __construct(\model\LoginModel $login, \model\MessageModel $message)
    {
        $this->loginModel = $login;
        $this->messageModel = $message;
    }


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  string html BUT writes to standard output and cookies!
     */
    public function response()
    {

        $message = $this->messageModel->getSessionMessage();

        $response = null;

        if ($this->loginModel->isLoggedIn()) {
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
        if (isset($_POST[ self::$login ])) {
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
     * @return \model\LoginModel
     */
    public function getLoginAttempt()
    {
        $name = $this->getInput(self::$name);
        $password = $this->getInput(self::$password);
        $keep = $this->getInput(self::$keep);
        $login = new \model\LoginModel($name, $password, $keep);

        return $login;
    }

    public function userIsRemembered()
    {
        if (isset($_COOKIE[ self::$cookieName ])) {
            return true;
        } else {
            return false;
        }
    }

    public function getCookiePassword()
    {
        $password = $_COOKIE[ self::$cookiePassword ];

        return $password;
    }

    public function setLoginCookies()
    {
        $randomString = str_shuffle("1234567890abcdefghijklmnopqrstuvxyzABCDEFGHIJKLMNOPQRSTUVXYZ");
        $cookieLife = (time() + 60 * 60 * 30);

        file_put_contents("secretfile.txt", $randomString);

        setcookie(self::$cookieName, "Admin", $cookieLife, "/");
        setcookie(self::$cookiePassword, $randomString, $cookieLife, "/");

    }

    public function clearCookies()
    {
        unset($_COOKIE[ self::$cookieName ]);
        setcookie(self::$cookieName, null, -1, "/");
        unset($_COOKIE[ self::$cookiePassword ]);
        setcookie(self::$cookiePassword, null, -1, "/");
    }
}