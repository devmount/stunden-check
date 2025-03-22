<?php

use Illuminate\Support\Carbon;

test('human readable date helper', function () {
	$date = Carbon::create(1970, 1, 1, 11, 30);
	expect(hdate($date))->toBe('1. January 1970');
});

test('human readable datetime helper', function () {
	$date = Carbon::create(1970, 1, 1, 11, 30);
	expect(hdatetime($date))->toBe('1. January 1970, 11.30 Uhr');
});

test('human readable short date helper', function () {
	$date = Carbon::create(1970, 1, 1, 11, 30);
	expect(shortdate($date))->toBe('01.01.70');
});
