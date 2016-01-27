<?php

namespace App\Http\Controllers;

use App\Image;
use App\Campagne;
use Auth;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as CLImage;
use Intervention\Image\Facades\Image as CImage;
use Input;

class ImageController extends Controller
{
    public function getForm($id_campagne)
    {
        $campagne = Campagne::find($id_campagne);
        if ($campagne != null)
            return view('image_creation', array('campagne' => $campagne));
        else
            return Response("Stop pirater");
    }

    public function postForm(ImageRequest $request, $id_campagne)
    {
        // Création de l'instance Image (entité Eloquent ORM créée pour le projet)
        $Image = new Image();
        $Image->id_utilisateur = Auth::user()->getId();
        $Image->id_campagne= $id_campagne;

        $Image->titre_image = $request->input('titre_image');
        $Image->description_image = $request->input('description_image');

        // Création de l'objet $photo à partir de ce qu'on récupère de 'image' (Request)
        $photo = Input::file('image');
        $filename  = time().'_' .uniqid() .'.' . $photo->getClientOriginalExtension();
        $path = public_path('uploads/' . $filename);
        $photo=CLImage::make($photo->getRealPath());
        $exif= ($photo->exif() != null && array_key_exists('GPSLongitude', $photo->exif())) ? $photo->exif() : null;
        $photo->save($path);

        // Sauvegarde de l'image et calcul de la géolocalisation si disponible
        $Image->geo_image=$this->get_location($exif);
        $Image->lien_image = $filename;
        $Image->save();

        // Appel de la vue de redirection
        return View::make('campagne', array('campagne'=> Campagne::find($id_campagne), 'images' => Image::all()->where('id_campagne', $id_campagne, false), 'message' => 'L\'image a été mise en ligne !'));
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