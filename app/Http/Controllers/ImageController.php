<?php

namespace App\Http\Controllers;

use App\Image;
use App\Campagne;
use Auth;
use DB;
use App\Http\Requests\ImageRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as CLImage;
use Intervention\Image\Facades\Image as CImage;
use Input;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('ajax', ['only' => ['aimer']]);
    }

    // Route vers l'affichage d'une image, redirection sur la vue et vérification de l'existence de l'image
    public function afficher($id_image) {
        if (Image::find($id_image))
            return View::make('image', ['image' => Image::find($id_image),
                                        'precedente' => Image::where('id_image', '<', Image::find($id_image)->id_image)
                                                           ->where('id_campagne', '=', Image::find($id_image)->id_campagne)
                                                           ->max('id_image'),
                                        'suivante' => Image::where('id_image', '>', Image::find($id_image)->id_image)
                                                             ->where('id_campagne', '=', Image::find($id_image)->id_campagne)
                                                             ->min('id_image')]);
        else
            return Response('Image non trouvée');
    }

    // AJAX. Apprécier ou non une image.
    public function apprecier($id_image, Request $request) {
        if (!is_numeric($id_image) || !Image::find($id_image))
            return response()->json(['response' => 'ERREUR.']);

        if (Auth::user()->aime($id_image)) {
            DB::table('apprecie')->where(['id_utilisateur' => Auth::user()->id, 'id_image' => $id_image], false)->delete();
            return response()->json(['response' => 'doitUnlike']);
        } else {
            DB::table('apprecie')->insert(['id_utilisateur' => Auth::user()->id, 'id_image' => $id_image]);
            return response()->json(['response' => 'doitLike']);
        }
    }

    // Formulaire de publication d'une image : accès en GET
    public function getForm($id_campagne)
    {
        $campagne = Campagne::find($id_campagne);
        if ($campagne != null)
            return view('image_creation', array('campagne' => $campagne));
        else
            return Response("Stop pirater");
    }

    // Formulaire de publication d'une image : accès en POST
    public function postForm(ImageRequest $request, $id_campagne)
    {
        // Création de l'instance Image (entité Eloquent ORM créée pour le projet)
        $Image = new Image();
        $Image->id_utilisateur = Auth::user()->getId();
        $Image->id_campagne= $id_campagne;

        $Image->titre_image = $request->input('titre_image');
        $Image->description_image = $request->input('description_image');
        $Image->validation_image = !Campagne::find($id_campagne)->aValider();

        // Création de l'objet $photo à partir de ce qu'on récupère de 'image' (Request)
        $photo = Input::file('image');
        $filename  = time().'_' .uniqid() .'.' . $photo->getClientOriginalExtension();
        $path = public_path('uploads\\' . $filename);
        $photo=CLImage::make($photo->getRealPath());
        $exif= ($photo->exif() != null && array_key_exists('GPSLongitude', $photo->exif())) ? $photo->exif() : null;
        $photo->save($path);

        // Sauvegarde de l'image et calcul de la géolocalisation si disponible
        $Image->geo_image=$this->get_location($exif);

        $Image->lien_image = $filename;
        $Image->save();

        // Appel de la vue de redirection
        return Redirect('/campagne/' . $id_campagne);
        // return View::make('campagne', array('campagne'=> Campagne::find($id_campagne), 'images' => Image::all()->where('id_campagne', $id_campagne, false), 'message' => 'L\'image a été mise en ligne !'));
    }

    // AJOUT. Obtenir la localisation d'une image à partir de ses données intrinsèques
    public function get_location($exif) {
        if ($exif != null) {
            $degLong = $exif['GPSLongitude'][0];
            $minLong = $exif['GPSLongitude'][1];
            $secLong = $exif['GPSLongitude'][2];
            $refLong = $exif['GPSLongitudeRef'];

            $degLat = $exif['GPSLatitude'][0];
            $minLat = $exif['GPSLatitude'][1];
            $secLat = $exif['GPSLatitude'][2];
            $refLat = $exif['GPSLatitudeRef'];

            $long = $this->to_decimal($degLong, $minLong, $secLong, $refLong);
            $lat = $this->to_decimal($degLat, $minLat, $secLat, $refLat);
            return $lat . ',' . $long;
        } else return null;
    }

    // AJOUT. Fonction de conversion pour les coordonnées DD -> DMS
    function to_decimal($deg, $min, $sec, $hem){
        $d = $deg + ((($min/60) + ($sec/3600))/100);
        return ($hem =='S' || $hem=='W') ?  $d*=-1 : $d;
    }
}