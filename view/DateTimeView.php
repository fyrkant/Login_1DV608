<?php

namespace view;

require_once("controller/DateTimeString.php");

class DateTime {


	public function show() {

		$dtc = new \controller\DateTimeString();

		$timeString = $dtc->getFormatted();

		return '<p>' . $timeString . '</p>';
	}
}