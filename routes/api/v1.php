<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$timezone = config('app.timezone');

	$info = new stdClass();
	$info->name = config('app.name');
	$info->version = env('APP_VERSION', '1.0.0');
	$info->timezone = $timezone;
	$info->datetime = Carbon::now($timezone);

    return response()->json($info);
});

/*
The including of nested routes need be done with require because require_once fails
on the tests when we call the same route twice or more times
*/

require 'auth.php';
