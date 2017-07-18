<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyerapan_anggaran_triwulan_lainnya extends EncryptedModel
{
    public $table = 'penyerapan_anggaran_triwulan_lainnya';
    public $fillable = ['id','id_anggaran','user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey = 'id_anggaran';
    public $incrementing = true; 

}
