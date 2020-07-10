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
//Route::get('/test', 'ContratController@test');
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
Route::post('/password-create', 'UserController@resetpassword');
Route::post('/contact-send', 'UserController@getMessage');
Route::post('/contrat', 'ContratController@save');
Route::post('/link_plan_to_projet', 'ProjetController@linkPlanToProjet');
Route::post('/inscription', 'UserController@save');
Route::post('/joined', 'PlanController@joined');
Route::get('/payment', 'ProjetController@payment');
Route::post('/activer-projet', 'ProjetController@activeProjet');
Route::get('/payeprojet/{id}', 'ProjetController@payeProjet');
Route::get('/projet/gerResultat', 'ProjetController@getResult');

// les actions de suppressions
Route::delete('/projet/{id}', 'ProjetController@delete');
Route::delete('/user/{id}', 'UserController@delete');
Route::delete('/plan/{id}', 'PlanController@delete');
Route::delete('/remarque/{id}', 'RemarqueController@delete');

// les action de recuperations de modification
Route::get('/active_fichier/{id}', 'ProjetController@activeFichier');
Route::get('/plan-pdf/{id}', 'PlanController@getpdf');
Route::get('/projet-pdf/{id}', 'ProjetController@getpdf');
Route::get('/plan-pdfs/{id}', 'PlanController@getAllFiles');
Route::get('/status/{id}/{model}', 'ValidationController@status');

Route::get('/plan/pdf/{id}', 'PdfController@pdf_plan');
Route::get('/contrat/{id}', 'ProjetController@makeContrat');
Route::get('/a_valider', 'ProjetController@avalider');
Route::get('/paypal/{id}', 'ProjetController@payment');
Route::post('/make-montant', 'ProjetController@makeMontant');

Route::get('/success', 'ProjetController@paypalSuccess')->name('payment-execute');



// les routes de teste

Route::get('/test', 'PlanController@test');
Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
