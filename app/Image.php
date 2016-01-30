<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'Image';
    protected $primaryKey = 'id_image';
    public $timestamps = false;

    public function getImage() {
        return $this->lien_image;
    }

    public function est_gardee($choix) {
        switch ($choix) {
            case true:
                $this->validation_image = true;
                $this->save();
                break;
            case false:
                $this->delete();
                break;
        }
    }

    // Relations BELONGS TO pour accéder aux données
    public function campagne() { return $this->belongsTo('App\Campagne', 'id_campagne', 'id_campagne'); }
    public function posteur()  { return $this->belongsTo('App\User', 'id_utilisateur', 'id');}

    public function getCampagne() {
        return Image::find($this->id_image)->campagne;
    }

    public function getPosteur() {
        return Image::find($this->id_image)->posteur;
    }
}
