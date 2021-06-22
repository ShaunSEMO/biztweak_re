<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::put('/{id}/add-profile-picture', [App\Http\Controllers\HomeController::class, 'addProfilePic'])->name('addProfilePic');
Route::get('/{id}/add-company', [App\Http\Controllers\HomeController::class, 'addCompany'])->name('addCompany');
Route::post('/{id}/save-company', [App\Http\Controllers\HomeController::class, 'saveCompany'])->name('saveCompany');
Route::get('/{id}/manage-company', [App\Http\Controllers\HomeController::class, 'manageCompany'])->name('manageCompany');
Route::put('/{id}/edit-company', [App\Http\Controllers\HomeController::class, 'editCompany'])->name('editCompany');
Route::post('/{user_id}/{company_id}/save-assessment', [App\Http\Controllers\HomeController::class, 'saveAssessment'])->name('saveAssessment');
Route::get('/{company_id}/report-summary', [App\Http\Controllers\HomeController::class, 'reportSumm'])->name('reportSumm');
Route::get('/{company_id}/full-report', [App\Http\Controllers\HomeController::class, 'fullReport'])->name('fullReport');
Route::get('/foo-bar', [App\Http\Controllers\HomeController::class, 'foo_bar'])->name('foo_bar');
Route::get('/recommendations', [App\Http\Controllers\HomeController::class, 'recom'])->name('recom');
