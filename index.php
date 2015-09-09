<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('model/DateTimeModel.php');
require_once('model/LoginModel.php');

require_once('view/DateTimeView.php');
require_once('view/LoginView.php');
require_once('view/LayoutViewView.php');

require_once('controller/DateTimeController.php');
require_once('controller/LoginController.php');
require_once('controller/MainController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$dateTimeView = new view\DateTimeView(new \model\DateTimeModel());

$loginModel = new model\LoginModel();
$loginView = new view\LoginView($loginModel);

$loginController = new controller\LoginController($loginModel, $loginView);

$layoutView = new view\LayoutView();

$mainController = new controller\MainController($loginModel, $loginView, $layoutView, $dateTimeView);

$mainController->doControl();


// $layoutView->render(false, $loginView, $dateTimeView);

