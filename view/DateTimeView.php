<?php

namespace view;

class DateTimeView {

	private $dateTimeController;

	public function __construct(\controller\DateTimeController $dateTimeController) {
        $this->dateTimeController = $dateTimeController;
	}

	public function getHTML() {

        return '<p>' . $this->dateTimeController->getFormatted() . '</p>';

	}
}