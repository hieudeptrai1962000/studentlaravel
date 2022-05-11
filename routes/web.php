<?php

use App\Http\Controllers\FacultyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('faculty', FacultyController::class);
Route::resource('student', StudentController::class);
Route::resource('subject', SubjectController::class);
Route::get('/addsubject/{id}', [StudentController::class, 'addsubject'])->name('student.subject');
Route::get('/addmark/{id}', [StudentController::class, 'addmark'])->name('student.mark');
Route::post('/update', [StudentController::class, 'updatesubject'])->name('student.updatesubject');
Route::post('/mark', [StudentController::class, 'updatemark'])->name('student.updatemark');
