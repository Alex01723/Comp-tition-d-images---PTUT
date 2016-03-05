<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    // Savoir si un jugement a déjà connu une sauvegarde ou non
    // Valeurs de retour :
    //      - count(.) renvoie 1 : l'utilisateur n'est pas dans ceux qui ont déjà voté ; c'est un nouveau jugement
    //      - count(.) renvoie 0 : l'utilisateur est dans la liste de ceux qui ont voté ; c'est une sauvegarde
    public function estNouveau() {
        return count(DB::select("SELECT *
                        FROM users u
                        WHERE u.id NOT IN (SELECT DISTINCT v.id_utilisateur
                                           FROM Vote v
                                           WHERE v.id_campagne LIKE '" . $this->id_campagne . "')
                          AND u.id LIKE '" . $this->id_utilisateur . "'")) == 1;
    }

    // Renvoyer les votes liés à un jugement à un utilisateur
    public function getVotes() {
        $conditions = ["id_utilisateur" => $this->jure->id, "id_campagne" => $this->campagne->id_campagne];
        return Vote::where($conditions, false)->orderBy('position', 'asc')->get();
    }

    // Ajouter ou modifier un vote d'utilisateur
    public function ajouterVote($idc, $idu, $idi, $position) {
        if (DB::table('vote')->where(['id_campagne' => $idc, 'id_utilisateur' => $idu, 'id_image' => $idi], false)->count() < 1)
            DB::table('vote')->insert(['id_campagne' => $idc, 'id_utilisateur' => $idu, 'id_image' => $idi, 'position' => $position]);
        else
            DB::table('vote')->where(['id_campagne' => $idc, 'id_utilisateur' => $idu, 'id_image' => $idi], false)->update(['position' => $position]);
    }

    // Relations d'appartenance Jugement — Campagne et Jugement — Utilisateur
    public function campagne() { return $this->belongsTo('App\Campagne', 'id_campagne', 'id_campagne'); }
    public function jure()  { return $this->belongsTo('App\User', 'id_utilisateur', 'id');}

    public function getCampagne() {
        return $this->campagne;
    }

    public function getJure() {
        return $this->jure;
    }
}

