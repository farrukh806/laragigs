<?php

use App\Http\Controllers\ListingController;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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


// Get a single job listing
Route::get('/listings/{listing}',[ListingController::class, 'show']);