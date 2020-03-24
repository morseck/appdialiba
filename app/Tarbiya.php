<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarbiya extends Model
{
    use SoftDeletes;

    protected $fillable=['prenom','nom','genre','pere','mere','datenaissance','lieunaissance','adresse','region',
        'tuteur','phone1','phone2','arrivee','depart','deces','commentaire','avatar','daara_id'
    ];

    public function daara()
    {
        return $this->belongsTo('App\Daara');
    }

    public function fullname()
    {
        return ucfirst(strtolower($this->prenom)).' '.strtoupper($this->nom) ;
    }
}
