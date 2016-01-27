<?php

namespace App\Http\Controllers;


use App\Image;
use Auth;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as CLImage;
use Intervention\Image\Facades\Image as CImage;
use Input;

class ImageController extends Controller
{
    public function getForm()
    {
        return view('Image');
    }

    public function postForm(ImageRequest $request)
    {
        $Image = new Image();
        $Image->id_utilisateur=Auth::user()->getId();
        $Image->id_campagne=1;                                          // À changer urgemment
        $Image->titre_image = $request->input('titre_image');
        $Image->description_image = $request->input('description_image');
            $photo = Input::file('image');
            $filename  = time().'_' .uniqid() .'.' . $photo->getClientOriginalExtension();
            $path = public_path('uploads/' . $filename);
            //$photo->save($path);
            $photo=CLImage::make($photo->getRealPath());
            $exif= ($photo->exif() != null && $photo->exif()['GPSLongitude'] != null) ? $photo->exif() : null;
        $Image->geo_image=$this->get_location($exif);

        $Image->lien_image = $filename;
        $Image->save();



        return View::make('adminAccueil', array('message' => 'tkt'));
    }
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

    function to_decimal($deg, $min, $sec, $hem){
        $d = $deg + ((($min/60) + ($sec/3600))/100);
        return ($hem =='S' || $hem=='W') ?  $d*=-1 : $d;
    }


}