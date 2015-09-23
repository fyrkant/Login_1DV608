<?php

session_start();

// Settings
require_once("AppSettings.php");

// Models
require_once('model/DateTimeModel.php');
require_once('model/LoginModel.php');
require_once('model/LoginAttemptModel.php');
require_once('model/UserClient.php');

// Views
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');
require_once('view/CookieJar.php');
require_once('view/MessageView.php');

// Controllers
require_once('controller/LoginController.php');

// Exceptions
require_once('exceptions/UserNameEmptyException.php');
require_once('exceptions/PasswordEmptyException.php');
require_once('exceptions/IncorrectCredentialsException.php');
require_once('exceptions/IncorrectCookieException.php');

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Initiate models

$settings = new AppSettings();

$dateTimeModel = new model\DateTimeModel();
$dateTimeView = new view\DateTimeView($dateTimeModel);

$cookieJar = new view\CookieJar($settings::DATA_PATH);

$messageView = new \view\MessageView($cookieJar);

$loginModel = new model\LoginModel($settings::USERNAME, $settings::PASSWORD);
$loginView = new view\LoginView($loginModel, $messageView, $cookieJar);

$loginController = new controller\LoginController($loginModel, $loginView);

$loginController->doControl();
$loggedIn = $loginController->getIsLoggedIn();

$layoutView = new view\LayoutView();

$layoutView->render($loggedIn, $loginView, $dateTimeView);

