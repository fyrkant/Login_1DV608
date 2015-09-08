<?php

//INCLUDE THE FILES NEEDED...
require_once('view/DateTimeView.php');
require_once('controller/DateTimeController.php');
require_once('model/DateTimeModel.php');
require_once('view/LoginView.php');
require_once('view/LayoutView.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$dateTimeController = new controller\DateTimeController();

//CREATE OBJECTS OF THE VIEWS
$dateTimeView = new view\DateTimeView($dateTimeController);
$loginView = new view\LoginView();
$layoutView = new view\Layout();


$layoutView->render(false, $loginView, $dateTimeView);

