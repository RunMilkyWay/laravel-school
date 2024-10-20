<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
