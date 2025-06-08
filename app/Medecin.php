<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medecin extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable=['prenom','nom','phone','email','hopital','spec', 'image'] ;


    public function consultations()
    {
    	return $this->hasMany('App\Consultation');
    }

    public function fullname()
    {
        return ucfirst(strtolower($this->prenom)).' '.strtoupper($this->nom) ;
    }

    public function ordonnances()
    {
        return $this->hasMany('App\Ordonnance');
    }
}
