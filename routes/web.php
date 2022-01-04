<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\QuizController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SearchUserController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\ScoreboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\QuizController as UserQuizController;
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
]);

Route::get('quiz', [QuizController::class,'index'])->name('quiz');
Route::get('quiz/accept/{slug}/{token}', [QuizController::class,'accept'])->name('quiz.accept');
Route::post('quiz/accept/{slug}/{token}', [QuizController::class,'answer']);
Route::group([  'prefix' => 'user','as'=>'user.',
                'middleware' => ['auth']], function()
{
    Route::get('/', [UserDashboardController::class,'index'])->name('dashboard');
    Route::get('/quiz', [UserQuizController::class,'index'])->name('quiz');
    Route::get('/quiz/{slug}', [UserQuizController::class,'view'])->name('quiz.view');
    Route::post('quiz/answer/{slug}', [UserQuizController::class,'answer'])->name('quiz.answers');
    Route::get('/filtered_data/{from_date?}/{to_date?}', [UserDashboardController::class,'filterData'])->name('filtered_data');
});

Route::group([  'prefix' => 'i',
                'middleware' => ['admin_auth']], function()
{
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('search/user', [SearchUserController::class,'search'])->name('search-user');
    Route::post('user-permission-update/{id}', [UserController::class,'updatePermission'])->name('user-permission-update');
    Route::resource('department', DepartmentController::class);
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);

    Route::get('quiz', [QuizController::class,'index'])->name('quiz.index');
    Route::post('quiz', [QuizController::class,'store']);
    Route::get('quiz/edit/{slug}', [QuizController::class,'edit'])->name('quiz.edit');
    Route::post('quiz/edit/{slug}', [QuizController::class,'update']);
    Route::delete('quiz/delete', [QuizController::class,'destroy'])->name('quiz.destroy');
    Route::post('quiz/invite/{slug}', [QuizController::class,'invite'])->name('quiz.invite');
    Route::get('quiz/report/{slug}', [QuizController::class,'report'])->name('quiz.report');
    Route::get('quiz/report/user/{slug}/{id}', [QuizController::class,'reportUser'])->name('quiz.report.user');
    Route::get('/filtered_data/{from_date?}/{to_date?}', [DashboardController::class,'filterData'])->name('filtered_data');
    Route::get('/scoreboard', [ScoreboardController::class,'index'])->name('scoreboard');
    Route::get('/scoreboard/user/{id}', [ScoreboardController::class,'viewDetails'])->name('scoreboard.user');
});