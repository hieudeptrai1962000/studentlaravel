<?php


use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Auth;
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

Route::post('', function () {
    return view('welcome');
});

Route::controller(SocialController::class)->group(function () {
    Route::get('/auth/redirect/{social}', 'login');
    Route::get('/callback/{social}', 'callback');
});

Route::post('registerUser', [RegisterController::class, 'RegisterUser'])->name('register-user');
Route::get('home', [HomeController::class, 'index'])->name('home');
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
//    Route::group(['middleware' => ['role:admin role']], function () {  ---> Phân quyền bằng package permission Spatie
//    });
    Route::resources([
        'faculties' => FacultyController::class,
        'students' => StudentController::class,
        'subjects' => SubjectController::class,
    ]);

    Route::controller(StudentController::class)->group(function () {
        Route::get('create/{id}', 'createSubjectAndMark')->name('createSubjectAndMark');
        Route::post('/update/{id}', 'updateSubjectAndMark')->name('updateSubjectAndMark');
        Route::get('search', 'searchStudent')->name('search');
        Route::get('email', 'sendEmail')->name('send-email');
        Route::get('students/seen/{id}/{slug}', 'showstudents')->name('show-student');
        Route::post('students/ajax/{id}', 'updateAjax');
    });

    Route::group(['middleware' => 'locale'], function () {
        Route::get('change-language/{language}', [HomeController::class, 'changeLanguage'])->name('user.change-language');
    });
});

//Route test package permission Spatie
Route::resource('permission', PermissionController::class);
