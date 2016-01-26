<?php

namespace App\Http\Controllers;

use App\Campagne;
use App\Http\Requests\CampagneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class CampagneController extends Controller
{
    const nbSemainesVote = 2;

    public function getForm()
    {
        return view('Campagne');
    }

    public function postForm(CampagneRequest $request)
    {
        $Campagne = new Campagne();
        $Campagne->nom_campagne = $request->input('nom_campagne');
        $Campagne->description_campagne = $request->input('description_campagne');
        $Campagne->date_debut = Carbon::parse($request->input('date_debut'))->format("Y/m/d");
        $Campagne->date_fin = Carbon::parse($request->input('date_fin'))->format("Y/m/d");
        $Campagne->date_fin_vote = Carbon::parse($request->input('date_fin'))->addWeek(self::nbSemainesVote)->format("Y/m/d");
        $Campagne->choix_binaire = ($request->input('choix_binaire') == null) ? false : true;
        $Campagne->choix_validation = ($request->input('choix_validation') == null) ? false : true;
        $Campagne->save();

        return View::make('adminAccueil', array('message' => 'tkt'));
    }

}