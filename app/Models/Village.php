<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model 
{
    public $table = 'ref_village';
    public $fillable = ['id', 'district_id','name'];
    public $primaryKey = 'id';
    public $incrementing = true;
    
}