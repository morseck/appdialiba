<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{

    use Loggable;
    protected $fillable = ['medecin_id','talibe_id','lieu','date','avis', 'maladie'] ;

    public function talibe()
    {
    	return $this->belongsTo('App\Talibe');
    }

    public function medecin()
    {
    	return $this->belongsTo('App\Medecin');
    }
}
