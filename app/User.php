<?php

namespace App;

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

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // Déterminer si l'utilisateur est un administrateur ou non pour l'accès au panneau /admin
    public function est_adm() {
        return $this->est_adm;
    }

    public function getId(){
        return $this->id;
    }

    /*
     *   On référence ici les méthodes spécifiques à l'administrateur : obtenir toutes les campagnes, le nombre d'images à valider, etc.
     */

    public function adminCampagnes() {
        if ($this->est_adm())
            return Campagne::all();
        else return null;
    }

    public function adminImagesAValider() {
        if ($this->est_adm())
            return Image::all()->where('validation_image', 0);
        else return null;
    }
}
