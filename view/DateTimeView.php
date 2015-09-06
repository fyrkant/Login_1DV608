<?php

class DateTimeView {


	public function show() {

		$now = new DateTime("GMT+2");

		$day = date_format($now, "l");

		$date = date_format($now, "jS");

		$month = date_format($now, "F");

		$time = date_format($now, "H:i:s");

		$timeString = "$day, the $date of $month, The time is $time";

		return '<p>' . $timeString . '</p>';
	}
}