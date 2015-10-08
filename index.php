<?php

session_start();

require_once('AppSettings.php');
require_once("vendor/autoload.php");

// MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dateTimeModel = new model\DateTimeModel();
$dateTimeView = new view\DateTimeView($dateTimeModel);

$cookieJar = new view\CookieJar(AppSettings::DATA_PATH);
$messageView = new \view\MessageView($cookieJar);

$memberDAL = null;

if (AppSettings::USE_DB) {
    $memberDAL = new \model\DAL\MemberMongoDAL();
} else {
    $memberDAL = new \model\DAL\MemberFileDAL(AppSettings::DATA_PATH);
}

$loginModel = new model\LoginModel($memberDAL);
$loginView = new view\LoginView($messageView, $cookieJar);

$registerView = new view\RegisterView($messageView);
$registerController = new controller\RegisterController($registerView, $memberDAL);

$loginController = new controller\LoginController($loginModel, $loginView, $registerController);

$loginController->doControl();
$loggedIn = $loginController->getIsLoggedIn();

$layoutView = new view\LayoutView();

$layoutView->render($loggedIn, $loginView, $registerView, $dateTimeView);

