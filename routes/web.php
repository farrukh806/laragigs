<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Get all job listings
Route::get('/', [ListingController::class, 'index']);

// Get job listing form
Route::get('/listings/create', [ListingController::class, 'create']);

// Store job listing data
Route::post('/listings', [ListingController::class, 'store']);

//Get Job listing editing form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

//Update Job listing 
Route::put('/listings/{listing}/edit', [ListingController::class, 'update']);

//Delete Job listing 
Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);


//Get user register form
Route::get('/users/register', [UserController::class, 'create']);

// Store user registration form
Route::post('/users/register', [UserController::class, 'store']);

// Logout user
Route::post('/users/logout', [UserController::class, 'logout']);

//Get user login form
Route::get('/users/login', [UserController::class, 'login']);

// Login user
Route::post('/users/authenticate', [UserController::class, 'authenticate']);


// Get a single job listing
Route::get('/listings/{listing}',[ListingController::class, 'show']);