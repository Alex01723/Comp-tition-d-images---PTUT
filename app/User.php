<?php

namespace App;

use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;


    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function getId(){
        return $this->id;
    }

    // Déterminer si l'utilisateur est un administrateur ou non pour l'accès au panneau /admin
    public function est_adm() {
        return $this->est_adm;
    }

    // Renvoyer les campagnes dans lesquelles l'utilisateur est impliqué
    // On passe par la classe de milieu Jugement
    public function getCampagnesJugement($deja_jugees = false) {
        $campagnes = array();

        foreach (Jugement::where('id_utilisateur', '=', $this->id, false)->get() as $jugement)
            if ($jugement->jugement_definitif == $deja_jugees)
                array_push($campagnes, $jugement->getCampagne());

        return $campagnes;
    }

    public function getCampagne($id_campagne) {
        return Campagne::find($id_campagne);
    }

    // Renvoyer les jugements dans lesquels l'utilisateur est impliqué
    public function getJugements($id_campagne = -1) {
        if ($id_campagne == -1)
            return Jugement::where('id_utilisateur', '=', $this->id, false)->get();
        else
            $conditions = ['id_utilisateur' => $this->id, 'id_campagne' => $id_campagne];
            return Jugement::where($conditions, false)->get();
    }

    /*
     *   On référence ici les méthodes spécifiques à l'administrateur : obtenir toutes les campagnes, le nombre d'images à valider, etc.
     */

    // Fonctions de CAMPAGNE
    /* Renvoie la liste des campagnes */
    public function adminCampagnes() {
        if ($this->est_adm())
            return Campagne::all();
        else return null;
    }

    /* Renvoie une campagne selon son identifiant */
    public function adminCampagne($id) {
        if ($this->est_adm())
            return Campagne::find($id);
        else return null;
    }

    /* Renvoie la liste des campagnes en cours */
    public function adminCampagnesEnCours() {
        if ($this->est_adm())
            return Campagne::where('date_fin_vote', '>=', DB::raw('NOW()'))->get();
    }

    // Fonctions d'IMAGE
    /* Renvoie les images qui ne sont pas validées */
    public function adminImagesAValider() {
        if ($this->est_adm())
            return Image::all()->where('validation_image', 0, false)
                               ->sortBy('id_campagne');
        else return null;
    }

    // Fonctions de JUGEMENT
    /* Renvoie tous les liens Image <-> Juré */
    public function adminJugements() {
        if ($this->est_adm())
            return Jugement::all();
        else return array();
    }

    // Fonctions d'UTILISATEUR
    /* Renvoie tous les utilisateurs lambdas, qui ne sont pas administrateurs */
    public function adminLambdas() {
        if ($this->est_adm())
            return User::all()->where('est_adm', 0, false);
        else return null;
    }

    /* Renvoie tous les utilisateurs qui sont JURÉS dans une campagne */
    public function adminInscrits($id_campagne) {
        if ($this->est_adm())
            return DB::table('jugement')->join('users', 'jugement.id_utilisateur', '=', 'users.id')
                                        ->where('id_campagne', '=', $id_campagne)->get();
        else return null;
    }

    /* Renvoie tous les utilisateurs qui sont POSTEURS dans une campagne */
    public function adminParticipants($id_campagne) {
        if ($this->est_adm())
            return DB::table('image')->join('users', 'image.id_utilisateur', '=', 'users.id')
                                     ->where('id_campagne', '=', $id_campagne)->get();
        else return null;
    }

    /* Renvoie TRUE si l'utilisateur est affectable à une campagne, FALSE sinon */
    public function adminAffectable($id_membre, $id_campagne) {
        if ($this->est_adm())
            return DB::select("SELECT *
                               FROM users
                               WHERE users.id NOT IN (SELECT DISTINCT i.id_utilisateur
                                                      FROM image i
                                                      WHERE i.id_campagne LIKE :idc)
                                  AND (users.est_adm = 0)
                                  AND (users.id = :idu)", ["idu" => $id_membre, "idc" => $id_campagne]);
        else return false;
    }

    /* Supprime les liens entre une campagne et des utilisateurs jurés : à utiliser pour l'affectation */
    public function adminExclusionJures($id_campagne) {
        if ($this->est_adm())
            return DB::delete("DELETE FROM jugement WHERE (id_campagne LIKE :idc)", ["idc" => $id_campagne]);
        else return false;
    }

    /* Ajoute l'utilisateur à la campagne en créant un tuple dans Jugement */
    public function adminInscriptionJures($id_jure, $id_campagne) {
        if ($this->est_adm())
            DB::insert("INSERT INTO jugement(id_utilisateur, id_campagne, jugement_definitif) VALUES (?, ?, ?)", [$id_jure, $id_campagne, 0]);
    }

    /*
     *   Fonctions tierces d'affichage
     */
    public function getGrade() {
        $nb_images = count(Image::all()->where('id_utilisateur', $this->id, false));
        if ($nb_images < 10) {
            return "Nouveau participant";
        } else if ($nb_images < 100) {
            return "Participant confirmé";
        } else if ($nb_images < 500) {
            return "Participant avancé";
        } else {
            return "Participant professionnel";
        }
    }
}
