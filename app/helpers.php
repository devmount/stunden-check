<?php

// converts given date string to human readable date format
if (! function_exists('hdate')) {
	function hdate($str) {
		return date('j. F Y', strtotime($str)); 
	}
}

// converts given date string to human readable date format
if (! function_exists('hdatetime')) {
	function hdatetime($str) {
		return date('j. F Y, H.i \U\h\r', strtotime($str)); 
	}
}

// converts given date string to short date format
if (! function_exists('shortdate')) {
	function shortdate($str) {
		return date('d.m.y', strtotime($str)); 
	}
}
