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
            'image'=>'required',
            'titre_image'       =>'required|string|max:254',
            'description_image' =>'required|string',
//            'geo_image'=>'string',
//            'date_envoi'=>'date|before:tomorrow',
        ];
    }
}
