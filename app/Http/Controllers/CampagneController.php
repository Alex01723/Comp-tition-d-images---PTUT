<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use Request;
use App\Campagne;

use App\Image;
use App\Http\Requests\CampagneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

use App\Schulze;
use App\Schulze\Calcul;

class CampagneController extends Controller
{
    const nbSemainesVote = 2;

    public function getIndex() {
        return View::make('admin.campagne', array('campagnes' => $this->retrieveEnCours()));
    }

    public function getForm()
    {
        return view('admin.campagne_creation');
    }

    public function postForm(CampagneRequest $request) {
        $Campagne = new Campagne();
        $Campagne->nom_campagne = $request->input('nom_campagne');
        $Campagne->description_campagne = $request->input('description_campagne');
        $Campagne->date_debut = $request->input('date_debut');
        $Campagne->date_fin = $request->input('date_fin');
        $Campagne->date_fin_vote = Carbon::parse($request->input('date_fin'))->addWeek(self::nbSemainesVote);
        $Campagne->choix_binaire = ($request->input('choix_binaire') == null) ? false : true;
        $Campagne->choix_validation = ($request->input('choix_validation') == null) ? false : true;
        $Campagne->save();

        return Redirect::to('admin');
    }

    // Retrouver toutes les campagnes
    public function retrieveAll() {
        $calcul = new Calcul(8);
        $calcul->gagnants();

        $campagnes = Campagne::all();
        return view('campagnes', ['campagnes' => $campagnes]);
    }

    // Retrouver toutes les campagnes en cours
    public function retrieveEnCours() {
        return Campagne::orderBy('date_fin_vote', 'desc')->paginate(5);
    }

    // Retrouver une campagne par son numéro de campagne
    public function retrieveId($id_campagne) {
        $campagne = Campagne::find($id_campagne);
        if ($campagne != null)
            return view('campagne', ['campagne' => $campagne,
                                     'images' => Image::where('id_campagne', $id_campagne, false)
                                                       ->where('validation_image', 1, false)
                                                       ->orderByRaw('RAND()')->get()]);
        else
            return Response("Campagne non trouvée");
    }

    // Retrouver une campagne avec des arguments de recherche
    public function rechercher($id_campagne, Request $request) {
        $campagne = Campagne::find($id_campagne);
        $contenu = $request::get('recherche');

        if ($campagne != null)
            return view('campagne', ['campagne' => $campagne,
                                     'images' => Image::where('id_campagne', $id_campagne, false)
                                                        ->where(function($query) use ($contenu) {
                                                            $query->where('titre_image', 'LIKE', '%' . $contenu . '%')
                                                                  ->orWhere('description_image', 'LIKE', '%' . $contenu . '%'); })
                                                        ->where('validation_image', 1, false)
                                                        ->orderByRaw('RAND()')->get(),
                                     'elementRecherche' => $contenu]);
        else
            return Response("Campagne non trouvée");
    }
}