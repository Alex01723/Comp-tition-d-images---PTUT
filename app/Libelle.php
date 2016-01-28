<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Libelle extends Model
{
    protected $table = 'libelle';
    protected $primaryKey = 'id_libelle';
    public $timestamps = false;
}
