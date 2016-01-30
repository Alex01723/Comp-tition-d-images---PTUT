<?php

namespace App\Http\Controllers;

use App\Campagne;
use App\Image;
use App\Http\Requests\CampagneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class CampagneController extends Controller
{
    const nbSemainesVote = 2;

    public function getIndex() {
        return view("admin.campagne");
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
        $campagnes = Campagne::all();
        return view('campagnes', ['campagnes' => $campagnes]);
    }

    // Retrouver une campagne par son numéro de campagne
    public function retrieveId($id_campagne) {
        $campagne = Campagne::find($id_campagne);
        if ($campagne != null)
            return view('campagne', ['campagne' => $campagne,
                        'images' => Image::all()->where('id_campagne', $id_campagne, false)
                                                ->where('validation_image', 1, false)]);
        else
            return Response("Campagne non trouvée");
    }
}