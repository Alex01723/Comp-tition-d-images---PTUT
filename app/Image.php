<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function est_recente() {
        return (strtotime($this->date_envoi) > \Carbon\Carbon::now()->subHours(8)->getTimestamp())
            && (strtotime($this->date_envoi) < \Carbon\Carbon::now()->getTimestamp());
    }

    public function est_geolocalisee() {
        return $this->geo_image != null;
    }

    public function getAppreciations() {
        return DB::table('apprecie')->where('id_image', '=', $this->id_image, false)->count();
    }

    // Relations BELONGS TO pour accéder aux données
    public function campagne() { return $this->belongsTo('App\Campagne', 'id_campagne', 'id_campagne'); }
    public function posteur()  { return $this->belongsTo('App\User', 'id_utilisateur', 'id'); }
    public function libelles() { return $this->hasMany('App\Libelle', 'id_image', 'id_image'); }


    public function getCampagne() {
        return Image::find($this->id_image)->campagne;
    }

    public function getPosteur() {
        return Image::find($this->id_image)->posteur;
    }

    public function getLibelles() {
        return Image::find($this->id_image)->libelles;
    }
}
