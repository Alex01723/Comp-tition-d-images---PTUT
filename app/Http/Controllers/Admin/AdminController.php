<?php

namespace App\Http\Controllers\Admin;

use App\Campagne;
use Redirect;
use App\Image;
use App\Http\Requests\AdminRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class AdminController extends Controller {
    public function validation(AdminRequest $request) {
        foreach ($request->all() as $element => $coche) {

            // On vérifie si l'image souhaite être envoyée ou non
            // En cas d'autre réponse, on ignore et l'image reste soumise à validation ;-)
            if (starts_with($element, 'radio')) {
                switch ($coche) {
                    case 'envoi_oui':
                        Image::find(substr($element, 5))->est_gardee(true);
                        break;
                    case 'envoi_non':
                        Image::find(substr($element, 5))->est_gardee(false);
                        break;
                }
            }
        }

        return Redirect::to('admin');
    }
}