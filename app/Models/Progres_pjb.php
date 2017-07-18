<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progres_pjb extends EncryptedModel
{
    public $table = 'progres_pjb';
    public $fillable = ['id', 'id_anggaran','user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey ='id';
    public $incrementing = true; 
    
}
//