<?php

session_start();

// Settings
require_once("AppSettings.php");

// Models
require_once('model/DateTimeModel.php');
require_once('model/LoginModel.php');
require_once('model/LoginAttemptModel.php');
require_once('model/MessageModel.php');

// Views
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');
require_once('view/CookieJar.php');

// Controllers
require_once('controller/LoginController.php');
require_once('controller/MessageController.php');

// Exceptions
require_once('exceptions/UserNameEmptyException.php');
require_once('exceptions/PasswordEmptyException.php');
require_once('exceptions/IncorrectCredentialsException.php');

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Initiate models

$settings = new AppSettings();

$dateTimeModel = new model\DateTimeModel();
$dateTimeView = new view\DateTimeView($dateTimeModel);

$messageModel = new model\MessageModel();
$messageController = new controller\MessageController($messageModel);

$loginModel = new model\LoginModel($settings::USERNAME, $settings::PASSWORD);
$loginView = new view\LoginView($loginModel, $messageModel);

$cookieJar = new view\CookieJar($settings::DATA_PATH);
$loginController = new controller\LoginController($loginModel, $loginView, $messageController, $cookieJar);

$loginController->doControl();
$loggedIn = $loginController->userLoggedInCheck();

$layoutView = new view\LayoutView();

$layoutView->render($loggedIn, $loginView, $dateTimeView);

