
<?php

use Illuminate\Support\Facades\Route;
use OhMyCod3\PeopleManager\Http\Controllers\PeopleController;

/** PEOPLE MANAGEMENT */
Route::resource('people', PeopleController::class)->only('index', 'show');