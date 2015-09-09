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

    private $model;
    private $message;

    /**
     * LoginView constructor.
     * @param $model
     */
    public function __construct(\model\LoginModel $model)
    {
        $this->model = $model;
    }


    /**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  string html BUT writes to standard output and cookies!
	 */
	public function response() {

        $response = "";

        if ($this->model->isLoggedIn()) {
            $response .= $this->generateLogoutButtonHTML($this->message);
        } else {
            $response = $this->generateLoginFormHTML($this->message);
        }

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {

		$name = $this->getInput(self::$name);

//        if ($this->userTriedToLogin()) {
//            echo "You tried to log in.";
//        }

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
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}

	private function getInput($name) {
		if ( ! isset($_POST[$name])) {
			return "";
		} else {
			return filter_var(trim($_POST[$name]), FILTER_SANITIZE_STRING);
		}
	}

    public function userTriedToLogin() {
        if (isset($_POST[self::$login])) {
            return true;
        } else {
            return false;
        }
    }

    public function tryLogin() {

        $name = $this->getInput(self::$name);
        $password = $this->getInput(self::$password);
        $keepLogged = $this->getInput(self::$keep);

        try {
            $this->model->logIn($name, $password);
            $this->message = "Welcome";
        } catch (\Exception $e) {
            $this->message = $e->getMessage();
        }

    }

    public function userWantsToLogOut() {
        if (isset($_POST[self::$logout])) {
            return true;
        } else {
            return false;
        }
    }

	
}