<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	$timezone = config('app.timezone');

	$info = new stdClass();
	$info->name = config('app.name');
	$info->version = env('APP_VERSION', '1.0.0');
	$info->timezone = $timezone;
	$info->dateTime = Carbon::now($timezone);

    return response()->json($info);
});