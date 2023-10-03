<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TestController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\TakeTestController;
use App\Http\Controllers\UserController;

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

// Route::get('/dashboard', function () {
    // return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::controller(TestController::class)->middleware(['auth'])->group(function () {
    Route::get('/tests/', 'index')->name('testIndex');    
    Route::get('/tests/create', 'create')->name('testCreate');    
    Route::get('/tests/{id}', 'show')->name('testShow');    
    Route::post('/tests/', 'store')->name('testStore');    
    Route::delete('/tests/{id}', 'destroy')->name('testDelete');    

});

Route::controller(TestQuestionController::class)->middleware(['auth'])->group(function () {
    // Route::get('/tests/', 'index')->name('testIndex');    
    Route::get('/test-questions/create/{testId}', 'create')->name('testQuestionCreate');    
    // Route::get('/tests/{id}', 'show')->name('testShow');    
    Route::post('/test-questions/{testId}', 'store')->name('testQuestionStore');    
});

Route::controller(TakeTestController::class)->middleware(['auth'])->group(function () {
    Route::get('/take-test/', 'index')->name('takeTestIndex');    
    Route::get('/take-test/{testId}', 'show')->name('takeTestShow');    
    Route::post('/take-test/advanced/{testId}', 'storeAdvanced')->name('takeTestStoreAdvanced');    
    Route::post('/take-test/{testId}', 'store')->name('takeTestStore');    


    // Route::get('/test-questions/create/{testId}', 'create')->name('testQuestionCreate');    
    // Route::get('/tests/{id}', 'show')->name('testShow');    
    // Route::post('/test-questions/{testId}', 'store')->name('testQuestionStore');    
});

Route::controller(UserController::class)->middleware(['auth'])->group(function () {
    Route::get('/users/', 'index')->name('userIndex');    
    Route::get('/users/create', 'create')->name('userCreate');    
    Route::post('/users/', 'store')->name('userStore');    
    Route::get('/users/{id}', 'show')->name('userShow');    
    Route::get('/users/{id}/assign-test', 'assignTest')->name('userAssignTest');    
    Route::get('/users/{id}/assign-test/{testId}', 'assignTestSubmit')->name('userAssignTestSubmit');    

    Route::get('/users/{id}/edit', 'edit')->name('userEdit');    
    Route::put('/users/{id}', 'update')->name('userUpdate');    
    Route::delete('/users/{id}', 'delete')->name('userDelete');


});


