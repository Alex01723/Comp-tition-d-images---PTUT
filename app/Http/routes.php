<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Routes principales
Route::get('/', function () {
    return view('welcome');
});

Route::get('home', '\Bestmomo\Scafold\Http\Controllers\HomeController@index');

//Route::get('Campagne', function () {return view('Campagne');});
Route::controller('campagne', 'CampagneController');                                // Création d'une campagne (amené à bouger)

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Menu de navigation
Menu::make('MyNavBar', function($menu){
    $menu->add('Accueil', '/:8888');
    $menu->add('Campagnes en cours','campagne');
    $menu->add('Résultats des campagnes', 'resultats');
    $menu->add('Jugements',  'jugements');
});

// Route d'accès à la liste des campagnes
Route::get('campagnes', 'CampagneController@listCampagnes');