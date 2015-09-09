<?php

session_start();

// Models
require_once('model/DateTimeModel.php');
require_once('model/LoginModel.php');
require_once('model/MessageModel.php');

// Views
require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');

// Controllers
require_once('controller/LoginController.php');
require_once('controller/MessageController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');


$dateTimeView = new view\DateTimeView(new \model\DateTimeModel());

$messageModel = new model\MessageModel();
$messageController = new controller\MessageController($messageModel);

$loginModel = new model\LoginModel();
$loginView = new view\LoginView($loginModel, $messageModel);

$loginController = new controller\LoginController($loginModel, $loginView, $messageController);

$loginController->doControl();
$loggedIn = $loginController->userLoggedInCheck();

$layoutView = new view\LayoutView();

$layoutView->render($loggedIn, $loginView, $dateTimeView);

