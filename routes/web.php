<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SearchUserController;
use App\Http\Controllers\Backend\UserController;
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
})->name('home');
Route::get('/test', [HomeController::class,'test']);

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('quiz', 'QuizController@index')->name('quiz');
Route::get('quiz/accept/{slug}/{token}', 'QuizController@accept')->name('quiz.accept');
Route::post('quiz/accept/{slug}/{token}', 'QuizController@answer');

Route::group([  'prefix' => 'i',
                'middleware' => ['auth']], function()
{
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('search/user', [SearchUserController::class,'search'])->name('search-user');
    Route::post('user-permission-update/{id}', [UserController::class,'updatePermission'])->name('user-permission-update');
    
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    Route::get('quiz', [QuizController::class,'index'])->name('quiz.index');
    Route::post('quiz', [QuizController::class,'store']);
    Route::get('quiz/edit/{slug}', [QuizController::class,'edit'])->name('quiz.edit');
    Route::post('quiz/edit/{slug}', [QuizController::class,'update']);
    Route::delete('quiz/delete', [QuizController::class,'destroy'])->name('quiz.destroy');
    Route::post('quiz/invite/{slug}', [QuizController::class,'invite'])->name('quiz.invite');
    
});