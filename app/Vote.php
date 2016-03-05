<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
    protected $table = 'Vote';
    public $timestamps = false;
    protected $fillable = array('position', 'id_utilisateur', 'id_image', 'id_campagne');

}
