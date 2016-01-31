<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugement extends Model {
    protected $table = 'Jugement';
    // NOTE : Clé composite absente
    public $timestamps = false;

    // Savoir si le jugement est définitif ou non
    public function estDefinitif() {
        return $this->jugement_definitif;
    }

    public function getCouleur() {
        return ($this->estDefinitif()) ? '#00CD66' : '#EE4000';
    }

    // Relations d'appartenance Jugement — Campagne et Jugement — Utilisateur
    public function campagne() { return $this->belongsTo('App\Campagne', 'id_campagne', 'id_campagne'); }
    public function jure()  { return $this->belongsTo('App\User', 'id_utilisateur', 'id');}

    public function getCampagne() {
        return Image::find($this->id_image)->campagne;
    }

    public function getJure() {
        return Image::find($this->id_image)->jure;
    }
}

