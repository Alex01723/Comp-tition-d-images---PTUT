<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Carbon\Carbon;

class CampagneRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom_campagne'=>'required|string|between:5,254',
            'description_campagne'=>'required|string|min:10',
            'date_debut'=>'required|date|after:' . Carbon::now()->format('d/m/Y'),
            'date_fin'=>'required|date|after:' . Carbon::tomorrow()->format('d/m/Y') .'|after:date_debut',
            'choix_binaire'=>'boolean',
            'choix_validation'=>'boolean',
            'choix_popularite'=>'required|integer|between:0,50'
        ];
    }
}
