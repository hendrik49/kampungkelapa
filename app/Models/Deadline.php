<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model 
{
    public $table = 'deadlines';
    public $fillable = ['id', 'tahun_anggaran','triwulan_1','triwulan_2','triwulan_3','triwulan_4'];
    public $primaryKey = 'id';
    public $incrementing = true;
    
}