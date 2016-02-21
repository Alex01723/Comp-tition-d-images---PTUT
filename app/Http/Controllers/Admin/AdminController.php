<?php

namespace App\Http\Controllers\Admin;

use Redirect;
use Request;
use Input;
use Auth;

use App\Image;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;

class AdminController extends Controller {

    // Validation de la modération des images par l'administrateur
    public function validation(AdminRequest $request) {
        foreach ($request->all() as $element => $coche) {

            // On vérifie si l'image souhaite être envoyée ou non
            // En cas d'autre réponse, on ignore et l'image reste soumise à validation ;-)
            if (starts_with($element, 'radio')) {
                switch ($coche) {
                    case 'envoi_oui':
                        Image::find(substr($element, 5))->est_gardee(true);
                        break;
                    case 'envoi_non':
                        Image::find(substr($element, 5))->est_gardee(false);
                        break;
                }
            }
        }

        return Redirect::to('admin');
    }

    // Affectation des jurés à la campagne et redirection vers elle
    public function affectation(AdminRequest $request) {
        if (is_numeric(Request::segment(3))) {
            // On récupère l'identifiant de la campagne
            $id_campagne = Request::segment(3);

            // PHASE 1. Intégrité des données reçues
            // L'utilisateur ne doit pas être un administrateur et ne doit pas avoir proposé une image
            $affectation_possible = true;
            foreach(Input::get('jures') as $id_jure) {
                if (!is_numeric($id_jure) || !Auth::user()->adminAffectable($id_jure, $id_campagne)) {
                    $affectation_possible = false;
                }
            }

            // PHASE 2. Modification de la base de données
            // On supprime tous les tuples précédents et on ajoute les nouveaux.
            if ($affectation_possible) {
                Auth::user()->adminExclusionJures($id_campagne);

                foreach(Input::get('jures') as $id_jure)
                    Auth::user()->adminInscriptionJures($id_jure, $id_campagne);
            }
        }

        return Redirect::back();
    }
}