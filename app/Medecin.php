<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medecin extends Model
{
    use SoftDeletes;

    protected $fillable=['prenom','nom','phone','email','hopital','spec'] ;


    public function consultations()
    {
    	return $this->hasMany('App\Consultation');
    }
}
