<?php

// converts given date string to human readable date format
if (! function_exists('hdate')) {
	function hdate($str) {
		return date('j. F Y', strtotime($str)); 
	}
}

// calculates the time progress of current cycle with given start
if (! function_exists('cycleprogress')) {
	function cycleprogress($date) {
		$today = date_create();
		if ($today > $date) {
			$start = date_create($date);
			$end = date_create(strtotime($start . ' + 1 year'));
		} else {
			$end = date_create($date);
			$start = date_create(strtotime($start . ' - 1 year'));
		}
		$days_passed = date_diff($start, $today)->format('%a');
		return round($days_passed/365, 1);
	}
}
