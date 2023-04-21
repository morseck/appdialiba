<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordonnances';

    protected $fillable = ['medecin_id','talibe_id','nom_hopital','date_ordonnance','commentaire', 'file_ordonnance'] ;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function talibe()
    {
    	return $this->belongsTo('App\Talibe');
    }

    public function medecin()
    {
    	return $this->belongsTo('App\Medecin');
    }
}
