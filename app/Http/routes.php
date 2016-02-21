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

// Route d'accès pour gérer les campagnes
Route::get('campagnes', 'CampagneController@retrieveAll');                                                                  // Toutes les campagnes
Route::get('campagne/{id_campagne}', ['uses' => 'CampagneController@retrieveId'])->where('id_campagne', '[1-9][0-9]*');     // Campagne précise

Route::get('campagne/{id_campagne}/submit', ['before' => 'auth', 'after' => 'auth', 'uses' => 'ImageController@getForm'])->where('id_campagne', '[1-9][0-9]*');    // A FINIR
Route::post('campagne/{id_campagne}/submit', ['before' => 'auth', 'uses' => 'ImageController@postForm'])->where('id_campagne', '[1-9][0-9]*');

// RÉSERVÉ AUX UTILISATEURS AUTHENTIFIÉS SEULEMENT
Route::filter('auth', function() {
    // Si l'utilisateur n'est pas authentifié
    if (Auth::guest()) {
        Session::put('redirect', URL::full());           // Sauvegarder le lien de redirection avant l'authentification
        return Redirect::to('/auth/login');
    }

    if (Session::has('redirect')) {
        Session::forget('redirect');
    }
});

// RÉSERVÉ À L'ADMINISTRATEUR SEULEMENT
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
    // Routes relatives à la page d'accueil de l'administration
    Route::get('/admin', function() { return view('admin/admin'); });                       // Accueil de l'administration
    Route::post('/admin', 'Admin\AdminController@validation');                              // Choix des éléments à modérer

    // Contrôleur de création d'une campagne (méthodes GET et POST à l'intérieur)
    Route::controller('admin/campagne', 'CampagneController');

    // Affectation et visualisation des jurés des campagnes
    Route::get('/admin/jures', function() { return view('admin/jures'); });
    Route::get('/admin/jures/{id}', function($id) { return view('admin/jures')->with('id',$id); })->where('id', '[1-9]\d*');
    Route::post('/admin/jures/{id}', 'Admin\AdminController@affectation');

    Menu::make('adminMenu', function($menu) {
        $menu->add('Créer une campagne', 'admin/campagne/form');
        $menu->add('Suivre les campagnes', 'admin/campagne');
        $menu->add('Affecter des jurés', 'admin/jures');
        $menu->add('Statistiques', 'admin/stats');
    });
});

// MENU DU SITE DE COMPÉTITIONS D'IMAGES
Menu::make('MyNavBar', function($menu){
    $menu->add('Accueil', '');
    $menu->add('Campagnes en cours','campagnes');
    $menu->add('Résultats des campagnes', 'resultats');
    $menu->add('Jugement',  'jugement');
});