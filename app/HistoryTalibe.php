<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryTalibe extends Model
{

    protected $fillable=[
        'talibe_id','hizib_id','daara_id','dieuw_id',
        'new_talibe_id','new_hizib_id','new_daara_id','new_dieuw_id',
        'is_change_talibe', 'is_change_hizib', 'is_change_daara', 'is_change_dieuw',
        'date_change_talibe', 'date_change_hizib', 'date_change_daara', 'date_change_dieuw',
        'user_id_change_talibe', 'user_name_change_talibe', 'user_email_change_talibe',
        'user_id_change_hizib', 'user_name_change_hizib', 'user_email_change_hizib',
        'user_id_change_daara', 'user_name_change_daara', 'user_email_change_daara',
        'user_id_change_dieuw', 'user_name_change_dieuw', 'user_email_change_dieuw',
        'commentaire'
    ] ;


    public function history()
    {
        /**
         * @var Talibe $talibe
         */
       $talibe =  Talibe::find('talibe_id');
       $histories = [];
        if ($this->is_change_hizib){
           $histories [] = $this->user_name_change_hizib.'a changé le hizib '.$this->hizib. ' à la date du ' .$this->date_change_hizib;
        }
        return $histories;

    }

    public function talibe()
    {
        return $this->belongsTo('App\Talibe', 'talibe_id', 'id');
    }

    public function daara()
    {
        return $this->belongsTo('App\Daara');
    }
}
