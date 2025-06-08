<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Daara extends Model
{
    use  Loggable;
    protected $fillable = ['nom','lat','lon','creation','dieuw','image','phone'] ;

    public function talibes()
    {
    	return $this->hasMany('App\Talibe');
    }

    public function dieuws()
    {
    	return $this->hasMany('App\Dieuw');
    }

    public function tarbiyas()
    {
        return $this->hasMany('App\Tarbiya');
    }

    public function location()
    {
    	return $this->lat.'   '.$this->lon;
    }
}

