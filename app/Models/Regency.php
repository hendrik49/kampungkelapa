<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model 
{
    public $table = 'ref_regency';
    public $fillable = ['id', 'province_id','name'];
    public $primaryKey = 'id';
    public $incrementing = true;
    
}