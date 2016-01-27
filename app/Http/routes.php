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
/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/', '\Bestmomo\Scafold\Http\Controllers\HomeController@index');

Route::controller('Image', 'ImageController');

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

// En cours d'écriture
//Route::post('image/envoi', 'ImageController@postForm');

Menu::make('MyNavBar', function($menu){
    $menu->add('Accueil', '/:8888');
    $menu->add('Campagnes en cours','campagnes');
    $menu->add('Résultats des campagnes', 'resultats');
    $menu->add('Jugements',  'jugements');
});

// Route d'accès à la liste des campagnes
Route::get('campagnes', 'CampagneController@retrieveAll');

// RÉSERVÉ À L'ADMINISTRATEUR SEULEMENT
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
    Route::get('/admin', function() {
       return Response("Vous êtes administrateur !");
    });

    //Route::get('Campagne', function () {return view('Campagne');});
    Route::controller('/admin/campagne', 'CampagneController');
});
