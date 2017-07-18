<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypto;

class Realisasi_anggaran_target_pjb extends EncryptedModel
{
    public $table = 'realisasi_anggaran_target_pjb';
    public $fillable = ['id','id_anggaran','user_id','hmac','encrypted_data','iv','id_pjb','jenis'];
    public $primaryKey = 'id';
    public $incrementing = true; 
    
    public function getDetails()
    {
        $decryption_key = Crypto::getDecryptionKey(Auth::user(), $this->user);
        
        $details = Realisasi_anggaran_triwulan_berjalan::where('id_realisasi', $this->id)->first();
        if ($details) {
            $details->decrypt($decryption_key);
            $this->belanja_barang = $details->belanja_barang;
            $this->belanja_modal  = $details->belanja_modal;
            $this->belanja_lainnya = $details->belanja_lainnya;
        } else {
            $this->belanja_barang = 0;
            $this->belanja_modal  = 0;
            $this->belanja_lainnya = 0;            
        }
        
    }
}
