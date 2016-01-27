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

Route::get('/', function() {
    return view('welcome');
});

// Authentication routes...
Route::get('auth/login', ['as' => 'routeLogin', 'uses' => 'Auth\AuthController@getLogin']);
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
    $menu->add('Accueil', '');
    $menu->add('Campagnes en cours','campagnes');
    $menu->add('Résultats des campagnes', 'resultats');
    $menu->add('Jugement',  'jugement');
});

// Route d'accès pour gérer les campagnes
Route::get('campagnes', 'CampagneController@retrieveAll');                                                                  // Toutes les campagnes
Route::get('campagne/{id_campagne}', ['uses' => 'CampagneController@retrieveId'])->where('id_campagne', '[1-9][0-9]*');     // Campagne précise

Route::get('campagne/{id_campagne}/submit', ['before' => 'auth', 'uses' => 'ImageController@getForm'])->where('id_campagne', '[1-9][0-9]*');    // A FINIR
Route::post('campagne/{id_campagne}/submit', ['before' => 'auth', 'uses' => 'ImageController@postForm'])->where('id_campagne', '[1-9][0-9]*');

// RÉSERVÉ AUX UTILISATEURS AUTHENTIFIÉS SEULEMENT
Route::filter('auth', function() {
    // Si l'utilisateur n'est pas authentifié
    if (Auth::guest()) {
        Session::put('redirect', URL::full());           // Sauvegarder le lien de redirection avant l'authentification
        return Redirect::to('/auth/login');
    }

    // Configuration de la redirection après la connexion
    if ($redirect = Session::get('redirect')) {
        Session::forget('redirect');
        return Redirect::to($redirect);
    }
});

// RÉSERVÉ À L'ADMINISTRATEUR SEULEMENT
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
    Route::get('/admin', function() {
       return Response("Vous êtes administrateur !");
    });

    //Route::get('Campagne', function () {return view('Campagne');});
    Route::controller('/admin/campagne', 'CampagneController');
});
