<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Image;
use App\Libelle;
use App\Http\Controllers\Controller;

class LibelleController extends Controller
{
    public function getLibelles($id_image){
        $libelles = Libelle::find($id_image) ;
        //TODO; Faire la route qui pointera vers la vue image
        return view('image', ['libelles' => $libelles]);
    }
    public function addLibelle(Requests\ImageRequest $request, $id_image){
        Libelle::find($id_image)->text_libelle+=$request->input('libelle');
    }
    public function editLibelle(Requests\ImageRequest $request, $id_image){
        Libelle::find($id_image)->text_libelle=$request->input('libelle');
    }
    public function deleteLibelle(Requests\ImageRequest $request, $id_image){
        $text = Libelle::find($id_image)->text_libelle;
        Libelle::find($id_image)->text_libelle = str_replace($request->input('libelle'),'',$text);
    }

}
