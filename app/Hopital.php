<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Hopital extends Model
{
    use Loggable;
    protected $fillable = ['nom','region_id'] ;
}
