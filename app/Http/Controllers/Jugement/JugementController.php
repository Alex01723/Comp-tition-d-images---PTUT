<?php

namespace App\Http\Controllers\Jugement;

use Redirect;
use Request;
use Input;
use Auth;
use View;

use App\Campagne;
use App\Http\Controllers\Controller;

class JugementController extends Controller {

    public function getAccueil() {
        // Page d'accueil
        return View::make('jugement.jugement');
    }

    public function filtrer($idc) {
        // Page de filtres

        /*
         *  Liste des vérifications à effectuer dans l'ordre :
         *      - La campagne existe
         *      - L'utilisateur connecté est bien juge de la campagne
         *      - La campagne n'est pas terminée lorsqu'il accède à la page de filtre
         *      - Il n'a pas déjà voté (sinon, il est redirigé à l'étape d'après)
         */

        // La campagne existe
        if (!Campagne::find($idc))
            return Redirect::to('jugement')->with('msgJugement', 'Cette campagne de vote n\'est pas attribuée.');

        // L'utilisateur connecté est bien juge de la campagne
        if (count(Auth::user()->getJugements($idc)) == 0)
            return Redirect::to('jugement')->with('msgJugement', 'Vous n\'êtes pas juge de cette campagne !');

        // La campagne n'est pas terminée quand l'utilisateur arrive
        if (Campagne::find($idc)->estTerminee())
            return Redirect::to('jugement')->with('msgJugement', 'La campagne de vote est terminée.');

        // L'utilisateur n'a pas déjà voté avant d'accéder à la page
        if (!Auth::user()->getJugements($idc)[0]->estNouveau())
            return Redirect::to('jugement/' . $idc . '/classer')->with('msgJugement', 'Votre vote précédent a été restauré.');

        return View::make('jugement.filtrer', ['idc' => $idc]);
    }

    public function continuer($idc) {
        // Passer du filtre au classement : vérifications
        // 0. Les conditions sont toujours réunies sur la campagne
        if (!Campagne::find($idc)) return Redirect::to('jugement')->with('msgJugement', 'Cette campagne de vote n\'est pas attribuée.');
        if (count(Auth::user()->getJugements($idc)) == 0) return Redirect::to('jugement')->with('msgJugement', 'Vous n\'êtes pas juge de cette campagne !');
        if (Campagne::find($idc)->estTerminee()) return Redirect::to('jugement')->with('msgJugement', 'La campagne de vote est terminée.');

        // 1. Il y a au minimum deux images à classer
        $nb_choix = 0;
        $images = array();
        foreach (Input::get('images') as $image) {
            if (strlen($image) > 0) {
                $nb_choix++;
                array_push($images, $image);
            }
        }

        if ($nb_choix < 2)
            return Redirect::back()->with('msgFiltre', 'Vous devez sélectionner au moins deux images.');

        // 2. Les images sont différentes
        if(count(array_unique($images)) < count($images))
            return Redirect::back()->with('msgFiltre', 'Impossible d\'avoir deux fois la même image.');

        // 3. Les images existent et appartiennent bien à la campagne
        foreach ($images as $image) {
            if (!\App\Image::find($image) || Campagne::find($idc)->possedeImage($image)->isEmpty())
                return Redirect::back()->with('msgFiltre', 'Impossible de sélectionner une image inexistante.');
        }

        return Redirect::to('jugement/' . $idc . '/classer')->with('images', $images);
    }

    public function classer($idc) {

    }
}