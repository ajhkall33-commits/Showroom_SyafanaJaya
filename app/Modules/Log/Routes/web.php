<?php

use Illuminate\Support\Facades\Route;

Route::get('log', 'logController@log')->name('log');
