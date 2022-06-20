<?php

use App\Http\Controllers\AgeController;
use App\Http\Controllers\AjaxBOOKCRUDController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InforController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
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


Route::group(['middleware' => 'locale'], function() {
    Route::get('change-language/{language}', [HomeController::class, 'changeLanguage'])->name('user.change-language');
});



Route::group(['middleware' => 'auth'], function () {

//    Route::resource('faculties', FacultyController::class)->middleware('can:superAdmin');;
    Route::resource('students', StudentController::class);
    Route::get('students/seen/{id}/{slug}', [StudentController::class, 'showstudents'])->name('show.students');

    Route::resource('age', AgeController::class);
    Route::resource('editajax', AjaxController::class);
    Route::resource('subject', SubjectController::class);


    Route::group(['middleware' => ['role:admin role']], function () {
        Route::resource('faculties', FacultyController::class);

    });


//    Route::get('/addsubject/{id}', [StudentController::class, 'addsubject'])->name('students.subject');
////    Route::get('/addmark/{id}', [StudentController::class, 'addmark'])->name('students.mark');
//    Route::post('/update', [StudentController::class, 'updatesubject'])->name('students.updatesubject');
    Route::post('/mark/{id}', [StudentController::class, 'updatemark'])->name('students.updatemark');

    Route::get('ajax-students/{student}/show', [StudentController::class, 'showAjax']);

    Route::delete('students/del', function (Request $request) {
        App\Models\Student\Student::destroy($request->id);
        return response()->json();
    });

    Route::resource('information', InforController::class);

});
Route::post('/regis', [RegisterController::class, 'RegisterNewUser'])->name('register.newuser');


Route::resource('permission', PermissionController::class);

Route::get('ajax-book-crud', [AjaxBOOKCRUDController::class, 'index']);
Route::post('add-update-book', [AjaxBOOKCRUDController::class, 'store']);
Route::post('edit-book', [AjaxBOOKCRUDController::class, 'edit']);
Route::post('delete-book', [AjaxBOOKCRUDController::class, 'destroy']);


Route::post('students/ajax/{id}', [StudentController::class, 'updateAjax'])->name('getStudentId');
Route::get('students/ajaxx/{id}', [StudentController::class, 'showAjax']);


//Route::resource('faculties', FacultyController::class);
//Route::resource('students', StudentController::class);
//Route::resource('subject', SubjectController::class);
//Route::resource('age', AgeController::class);
//Route::get('/addsubject/{id}', [StudentController::class, 'addsubject'])->name('students.subject');
//Route::get('/addmark/{id}', [StudentController::class, 'addmark'])->name('students.mark');
//Route::post('/update', [StudentController::class, 'updatesubject'])->name('students.updatesubject');
//Route::post('/mark', [StudentController::class, 'updatemark'])->name('students.updatemark');
//Route::get('save', function(){
//    $user = \App\Models\Student\Student::find(3);
//    $user->stu()->sync([1,2]);
//});
Route::get('/redirect/{social}', [SocialAuthController::class, 'redirect']);
Route::get('/callback/{social}', [SocialAuthController::class, 'callback']);


Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
