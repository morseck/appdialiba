<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dieuw extends Model
{
    use SoftDeletes;
    
    protected $fillable=['prenom','nom','genre','pere','mere','datenaissance','lieunaissance','adresse',
                         'tuteur','phone1','phone2','arrivee','depart','deces','commentaire','avatar','daara_id'
        ];

    public function daara()
    {
        return $this->belongsTo('App\Daara');
    }
    public function talibes()
    {
    	$this->hasMany('App\Talibe');
    }

    public function fullname()
    {
    	return ucfirst($this->prenom).' '.ucfirst($this->nom) ;
    }
}