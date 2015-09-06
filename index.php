<?php

//INCLUDE THE FILES NEEDED...
require_once('view/Login.php');
require_once('view/DateTimeView.php');
require_once('view/Layout.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$v = new view\Login();
$dtv = new view\DateTime();
$lv = new view\Layout();


$lv->render(false, $v, $dtv);

