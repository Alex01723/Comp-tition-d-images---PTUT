<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ImageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_utilisateur'=>'required|integer|unique:Image,id_utilisateur',
            'id_campagne'=>'required|integer|unique:Image,id_campagne',
            'id_image'=>'required|integer|unique:Image,id_image',
            'lien_image'=>'required|string',
            'titre_image'=>'required|strin|max:254',
            'description_image'=>'required|string',
            'geo_image'=>'string',
            'date_envoi'=>'date|before:tomorrow',
        ];
    }
}
