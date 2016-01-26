<?php

namespace App\Http\Controllers;

use App\Campagne;
use App\Http\Requests\CampagneRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ImageController extends Controller
{
    public function getForm()
    {
        return view('Image');
    }

    public function postForm(CampagneRequest $request)
    {
        while (true);
        $Image = new Image();
        $Image->titre_image = $request->input('titre_image');
        $Image->description_image = $request->input('description_image');
            $image = Input::file('image');
            $filename  = time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('profilepics/' . $filename);
            Image::make($image->getRealPath())->save($path);
        $Image->lien_image = $filename;
        $Image->save();

        return View::make('adminAccueil', array('message' => 'tkt'));
    }

}