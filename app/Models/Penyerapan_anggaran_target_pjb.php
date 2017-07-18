<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyerapan_anggaran_target_pjb extends EncryptedModel
{
    public $table = 'penyerapan_anggaran_target_pjb';
    public $fillable = ['id','user_id','hmac','encrypted_data','iv','jenis','pradipa'];
    public $primaryKey = 'id';
    public $incrementing = true; 

    // default pas insert & retrieve
    
    protected $attributes = ['pradipa' => 0];    
    
    public function newQuery() {
        return parent::newQuery()->where('pradipa', 0);
    }

}

/*
$data_plaintext->tahun_anggaran = $request->input("tahun_anggaran");
$data_plaintext->satuan_kerja = $request->input("satuan_kerja");
$data_plaintext->nama_dipa = $request->input("nama_dipa");
$data_plaintext->tanggal_dipa = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');        
$data_plaintext->total_anggaran = $request->input("total_anggaran");
$data_plaintext->status = $request->input("status");
*/