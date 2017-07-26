<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model 
{
    public $table = 'user_detail';
    public $fillable = ['id','user_id','full_name','phone_number','email','address','province','regency','district','village','user_type','rating','officer_assigned'];
    public $primaryKey = 'id'; 
    public $incrementing = true;   

}