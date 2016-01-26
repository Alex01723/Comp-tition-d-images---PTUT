<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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
            'date_debut'=>'required|date|date_format:d/m/Y|after:today',
            'date_fin'=>'required|date|date_format:d/m/Y|after:tomorrow|after:date_debut',
            'choix_binaire'=>'boolean',
            'choix_validation'=>'boolean',
            'choix_popularite'=>'required|integer|between:0,50'
        ];
    }
}
