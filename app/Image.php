<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'Image';

    public $timestamps = false;

    public function getImage(){
        return $this->lien_image;
    }
}
