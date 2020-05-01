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


Route::get('/', 'HomeController@index')->name('home');



Route::get('/page/{namepage}', function ($namepage)
{
    return view('pages.'.$namepage);
});

// Les actions de sauvegardes et de modifications
Route::post('/projet', 'ProjetController@save');
Route::post('/user', 'UserController@save');
Route::post('/plan', 'PlanController@save');
Route::post('/remarque', 'RemarqueController@save');

// les actions de suppressions
Route::delete('/projet/{id}', 'ProjetController@delete');
Route::delete('/user/{id}', 'UserController@delete');
Route::delete('/plan/{id}', 'PlanController@delete');
Route::delete('/remarque/{id}', 'RemarqueController@delete');

// les action de recuperations
Route::get('/plan-pdf/{id}', 'PlanController@getpdf');
Route::get('/projet-pdf/{id}', 'ProjetController@getpdf');
Route::get('/plan-pdfs/{id}', 'PlanController@getAllFiles');


// les routes de teste

Route::get('/test/{id}', 'PlanController@test');
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});