<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisasi_anggaran_triwulan_berjalan extends EncryptedModel
{
    public $table = 'realisasi_anggaran_triwulan_berjalan';
    public $fillable = ['id','id_realisasi','user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey = 'id';
    public $incrementing = true; 
}
