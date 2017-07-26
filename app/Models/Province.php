<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model 
{
    public $table = 'ref_province';
    public $fillable = ['id', 'name'];
    public $primaryKey = 'id';
    public $incrementing = true;
    
}