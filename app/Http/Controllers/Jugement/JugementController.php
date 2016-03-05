<?php

namespace App\Http\Controllers\Jugement;

use Redirect;
use Request;
use Session;
use Input;
use Auth;
use View;
use DB;

use App\Campagne;
use App\Vote;
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
            return Redirect::to('jugement/' . $idc . '/classer')->with('msgClasse', 'Votre vote précédent a été restauré.');

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

        return Redirect::to('jugement/' . $idc . '/classer')->with('liste_images', $images);
    }

    public function classer($idc) {
        // CONTRÔLES DE ROUTINE : intégrité de la campagne
        // La campagne existe
        if (!Campagne::find($idc))
            return Redirect::to('jugement')->with('msgJugement', 'Cette campagne de vote n\'est pas attribuée.');

        // L'utilisateur connecté est bien juge de la campagne
        if (count(Auth::user()->getJugements($idc)) == 0)
            return Redirect::to('jugement')->with('msgJugement', 'Vous n\'êtes pas juge de cette campagne !');

        // La campagne n'est pas terminée quand l'utilisateur arrive
        if (Campagne::find($idc)->estTerminee())
            return Redirect::to('jugement')->with('msgJugement', 'La campagne de vote est terminée.');

        // Préparation de la page en fonction du contenu de la session.
        // On peut accéder à classer($idc) de deux manières :
        //      - Après un premier filtre, on possède donc la liste des images filtrées
        //      - Après une sauvegarde, on doit donc reconstruire les choix du juré

        $liste = array();
        $positionner = false;
        if (Session::has('liste_images')) {
            // Construction des possibilités à partir de la liste initiale
            foreach (Session::get('liste_images') as $image)
                array_push($liste, \App\Image::find($image));

        } else if (!Auth::user()->getJugements($idc)[0]->estNouveau()) {
            // Restauration de la sauvegarde
            foreach (Auth::user()->getJugements($idc)[0]->getVotes() as $vote)
                array_push($liste, \App\Image::find($vote->id_image));
            $positionner = true;

        } else {
            // Pas normal d'arriver ici directement, on repart !
            return Redirect::to('jugement')->with('msgJugement', 'Impossible d\'arriver directement à l\'ÉTAPE 2.');
        }

        return View::make('jugement.classer', ['liste' => $liste, 'positionner' => $positionner]);
    }

    public function finir($idc) {
        // CONTRÔLES DE ROUTINE : intégrité de la campagne
        // La campagne existe
        if (!Campagne::find($idc))
            return Redirect::to('jugement')->with('msgJugement', 'Cette campagne de vote n\'est pas attribuée.');

        // L'utilisateur connecté est bien juge de la campagne
        if (count(Auth::user()->getJugements($idc)) == 0)
            return Redirect::to('jugement')->with('msgJugement', 'Vous n\'êtes pas juge de cette campagne !');

        // La campagne n'est pas terminée quand l'utilisateur arrive
        if (Campagne::find($idc)->estTerminee())
            return Redirect::to('jugement')->with('msgJugement', 'La campagne de vote est terminée : vote annulé.');

        // Prise en compte du vote de l'utilisateur :
        // On peut arriver dans finir($idc) de deux manières :
        //      - En sauvegardant son vote pour y revenir ultérieurement ('sauvegarder')
        //      - En validant son vote définitivement ('valider')
        // Dans tous les cas, on doit d'abord enregistrer le vote
        $positions = Input::except('_token', 'sauvegarder', 'valider');

        // Contrôle des données
        if(count(array_unique($positions)) < count($positions))
            return Redirect::back()->with('msgClasse', 'Les positions doivent être distinctes.');

        if (count($positions) != count(array_intersect($positions, range(1, count($positions)))))
            return Redirect::back()->with('msgClasse', 'Les positions doivent être ordonnées correctement.');

        foreach ($positions as $cle => $position)
            if (!\App\Image::find(intval($cle)) || Campagne::find($idc)->possedeImage(intval($cle))->isEmpty())
                return Redirect::back()->with('msgClasse', 'Impossible de classer une image inexistante.');

        // Enregistrement des données
        foreach ($positions as $cle => $position) {
            if (!is_int($cle) || !ctype_digit($position))
                continue;

            Auth::user()->getJugements($idc)[0]->ajouterVote($idc, Auth::user()->id, $cle, $position);
        }

        if (Input::has('valider')) {
            DB::table('jugement')->where(['id_campagne' => $idc, 'id_utilisateur' => Auth::user()->id], false)->update(['jugement_definitif' => 1]);
            return Redirect::to('jugement')->with('msgJugementOK', 'Votre vote a été définitivement validé.');
        }

        return Redirect::to('jugement')->with('msgJugementOK', 'Votre vote a été sauvegardé.');
    }
}