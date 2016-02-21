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

    // Retrouver l'état d'une campagne
    public function getEtat() {
        if (strtotime($this->date_fin_vote) < \Carbon\Carbon::now()->getTimestamp()) {
            return "Campagne terminée";
        } else if (strtotime($this->date_fin_vote) >= \Carbon\Carbon::now()->getTimestamp() && strtotime($this->date_fin) < \Carbon\Carbon::now()->getTimestamp()) {
            return "Campagne en cours de jugement";
        } else if (strtotime($this->date_fin) >= \Carbon\Carbon::now()->getTimestamp() && strtotime($this->date_debut) < \Carbon\Carbon::now()->getTimestamp()) {
            return "Campagne en cours";
        } else {
            return "Campagne non commencée";
        }
    }

    public function estTerminee() {
        return ("Campagne terminée" === $this->getEtat());
    }

    public function estEnCoursDeJugement() {
        return ("Campagne en cours de jugement" === $this->getEtat());
    }

    // Obtenir une couleur en fonction de l'état de la campagne
    public function getCouleur() {
        switch ($this->getEtat()) {
            case "Campagne terminée":
                return '#CD0000';
            case "Campagne en cours de jugement":
                return '#FF8000';
            case "Campagne en cours":
                return '#9ACD32';
            case "Campagne non commencée":
                return '#8B8B83';
        }
    }
}
