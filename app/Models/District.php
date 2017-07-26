<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model 
{
    public $table = 'ref_district';
    public $fillable = ['id', 'regency_id','name'];
    public $primaryKey = 'id';
    public $incrementing = true;
    
}