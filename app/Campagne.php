<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    protected $table = 'Campagne';
    protected $primaryKey = 'id_campagne';
    public $timestamps = false;

    public function aValider() {
        return $this->choix_validation;
    }

    // Retrouver les images d'une campagne avec son numéro
    public function retrieveImages() {
        return Image::all()->where('id_campagne', $this->id_campagne, false);
    }
}
