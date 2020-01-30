<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daara extends Model
{
    protected $fillable = ['nom','lat','lon','creation','dieuw','image','phone'] ;

    public function talibes()
    {
    	return $this->hasMany('App\Talibe');
    }

    public function dieuws()
    {
    	return $this->hasMany('App\Dieuw');
    }

    public function location()
    {
    	return $this->lat.'   '.$this->lon;
    }
}

