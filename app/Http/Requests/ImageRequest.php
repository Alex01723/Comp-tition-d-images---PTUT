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
            'image'             =>'required|mimes:jpeg,bmp,png|between:50,24800',
            'titre_image'       =>'required|string|max:254',
            'description_image' =>'required|string',
        ];
    }
}
