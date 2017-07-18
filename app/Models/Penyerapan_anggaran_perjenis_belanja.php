<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyerapan_anggaran_perjenis_belanja extends EncryptedModel
{
    public $table = 'penyerapan_anggaran_perjenis_belanja';
    public $fillable = ['id', 'id_anggaran','user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey = 'id_anggaran';
    public $incrementing = true; 
    
}
/*
$data_plaintext = new stdClass();
$data_plaintext->total_anggaran = $request->input("total_anggaran");
$data_plaintext->belanja_barang=0;
$data_plaintext->belanja_modal=0;
$data_plaintext->belanja_lainnya=0;
*/
