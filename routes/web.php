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

Auth::routes();

Route::get('/page/{namepage}', function ($namepage)
{
    return view('pages.'.$namepage);
});

// Les actions de sauvegardes et de modifications
Route::post('/projet', 'ProjetController@save');
Route::post('/user', 'UserController@save');
Route::post('/plan', 'PlanController@save');
Route::post('/remarque', 'RemarqueController@save');
Route::post('/resave', 'UserController@resave');
Route::post('/statut', 'UserController@statut');
Route::post('/active_plan', 'ProjetController@active_plan');
Route::post('/connexion', 'ClientController@connexion');
Route::post('/link_plan_to_projet', 'ProjetController@linkPlanToProjet');

// les actions de suppressions
Route::delete('/projet/{id}', 'ProjetController@delete');
Route::delete('/user/{id}', 'UserController@delete');
Route::delete('/plan/{id}', 'PlanController@delete');
Route::delete('/remarque/{id}', 'RemarqueController@delete');

// les action de recuperations de modification
Route::get('/plan-pdf/{id}', 'PlanController@getpdf');
Route::get('/projet-pdf/{id}', 'ProjetController@getpdf');
Route::get('/plan-pdfs/{id}', 'PlanController@getAllFiles');
Route::get('/status/{id}/{model}', 'ValidationController@status');


// les routes de teste

Route::get('/test/{id}', 'PlanController@test');
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
