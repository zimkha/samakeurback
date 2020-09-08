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
// Auth::routes();

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
Route::post('/lier_plan', 'ProjetController@linkPlanToProjet');
Route::post('/inscription', 'UserController@save');
Route::post('/joined', 'PlanController@joined');
Route::post('/pub', 'PostController@save');
Route::post('/user-nci', 'UserController@saveNci');
Route::get('/payment', 'ProjetController@payment');
Route::post('/activer-projet', 'ProjetController@activeProjet');
Route::get('/payeprojet/{id}', 'ProjetController@payeProjet');
Route::get('/getResultat', 'ProjetController@getResult');

// les actions de suppressions
Route::delete('/projet/{id}', 'ProjetController@delete');
Route::delete('/user/{id}', 'UserController@delete');
Route::delete('/plan/{id}', 'PlanController@delete');
Route::delete('/remarque/{id}', 'RemarqueController@delete');
Route::delete('/pub/{id}', 'PostController@delete');
Route::get('/rompre_liaison/{projet_id}/{plan_id}', 'ProjetController@rompre_liaison');

// les action de recuperations de modification
Route::get('/active_fichier/{id}', 'ProjetController@activeFichier');
Route::get('/plan-pdf/{id}', 'PlanController@getpdf');
Route::get('/projet-pdf/{id}', 'ProjetController@getpdf');
Route::get('/plan-pdfs/{id}', 'PlanController@getAllFiles');
Route::get('/status/{id}/{model}', 'ValidationController@status');
Route::get('/signe-contrat/{id}', 'ProjetController@SigneContrat');
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


// Ajout de new Routes


Route::post('/payed', 'PayedController@save');
Route::post('/planningprevisionnel', 'PlanningPrevisionnelConntroller@save');
Route::post('/planningfond', 'PlanningFondConntroller@save');
Route::post('/chantier', 'ChantierController@save');
Route::post('/deviseestime', 'DeviseEstimeController@save');
Route::post('/devisefinance', 'DeviseFinanceController@save');
Route::post('/contratexecution', 'ContratExecutionController@save');
Route::post('/chantier_date', 'ChantierController@makeDate');

Route::delete('/chantier/{id}',  'ChantierController@delete');
Route::delete('/deviseestime/{id}', 'DeviseEstimeController@delete');
Route::delete('/devisefinance/{id}', 'DeviseFinanceController@delete');
Route::delete('/contratexecution/{id}', 'ContratExecutionController@delete');

Route::get('/chantier_enable/{id}', 'ChantierController@enableChantier');
Route::get('/estime_enable/{id}', 'DeviseEstimeController@enable');
Route::get('/finance_enable/{id}', 'DeviseFinanceController@enable');
Route::get('/contrat_execution_enable/{id}', 'ContratExecutionController@enable');

Route::get('/finance_pdf/{id}', 'DeviseFinanceController@getpdf');
Route::get('/estime_pdf/{id}', 'DeviseEstimeController@getpdf');
Route::get('/contratexecution_pdf/{id}', 'ContratExecutionController@getpdf');
