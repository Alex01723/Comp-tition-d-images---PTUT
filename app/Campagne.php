<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    protected $table = 'Campagne';
    protected $primaryKey = 'id_campagne';
    public $timestamps = false;
}
