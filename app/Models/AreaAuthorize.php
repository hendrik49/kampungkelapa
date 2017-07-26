<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaAuthorize extends Model 
{
    public $table = 'user_area_authorize';
    public $fillable = ['id', 'user_id','zone','zone_ids'];
    public $primaryKey = 'id'; 
    public $incrementing = true;   
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\Models\UserDetail','user_id','user_id');
    }

}