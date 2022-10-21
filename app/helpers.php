<?php

// converts given date string to human readable date format
if (! function_exists('hdate')) {
	function hdate($str) {
		return date('j. F Y', strtotime($str)); 
	}
}
