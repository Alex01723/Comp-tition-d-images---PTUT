<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    // Vérifier qu'une image appartient bien à cette campagne
    public function possedeImage($id_image) {
        $conditions = ['id_image' => $id_image, 'id_campagne' => $this->id_campagne];
        return Image::where($conditions, false)->get();
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
    public function getCouleur($fond = false) {
        if (!$fond) {
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
        } else {
            switch ($this->getEtat()) {
                case "Campagne terminée":
                    return '#FFC1C1';
                case "Campagne en cours de jugement":
                    return '#FFDAB9';
                case "Campagne en cours":
                    return '#C1FFC1';
                case "Campagne non commencée":
                    return '#F4F4F4';
            }
        }
    }

    // Obtenir le nombre d'images associées à une campagne
    public function getNombreImages() {
        return DB::table('image')->where('id_campagne', '=', $this->id_campagne)->count();
    }

    // Obtenir le nombre de participants associés à la campagne
    public function getNombreParticipants() {
        return count(DB::select('SELECT DISTINCT id_utilisateur FROM image i WHERE id_campagne LIKE :idc', ['idc' => $this->id_campagne]));
    }

    // Obtenir le nombre de jurés associés à la campagne
    public function getNombreJures() {
        return count(DB::select('SELECT DISTINCT id_utilisateur FROM jugement j WHERE id_campagne LIKE :idc', ['idc' => $this->id_campagne]));
    }
}
