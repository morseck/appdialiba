<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talibe extends Model
{
    use SoftDeletes;

    protected $fillable=['prenom','nom','genre','pere','mere','datenaissance','lieunaissance','adresse','region','dieuw_id',
                         'tuteur','phone1','phone2','arrivee','depart','deces','commentaire','avatar','niveau','daara_id'
        ];


	public function daara()
    {
    	return $this->belongsTo('App\Daara');
    }

    public function dieuw()
    {
    	return $this->belongsTo('App\Dieuw');
    }

    public function consultations()
    {
        return $this->hasMany('App\Consultation');

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ordonnances()
    {
        return $this->hasMany('App\Ordonnance');
    }

    public function fullname()
    {
    	return ucfirst($this->prenom).' '.ucfirst($this->nom) ;
    }

    public function age()
    {
        $age = null;
        if ($this->datenaissance !=null){
            $date_naissance = app_date_reverse($this->datenaissance,'-','-');
            $age = new \DateTime(''.$date_naissance.'');
            $age = intval($age->diff(new \DateTime())->format('%Y'));

        }
        return $age;
    }



}


