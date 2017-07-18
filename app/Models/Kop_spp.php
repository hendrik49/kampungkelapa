<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypto;

class Kop_spp extends EncryptedModel
{
    public $table = 'kop_spp';
    public $fillable = ['id', 'id_anggaran','type_belanja','tahun','user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey ='id';
    public $incrementing = true; 
     
     public function getDipa()
    {
        $decryption_key = Crypto::getDecryptionKey(Auth::user(), $this->user);

        $dipa = Penyerapan_anggaran_target_pjb::where('id', $this->id_anggaran)->first();
        if ($dipa) {
            $dipa->decrypt($decryption_key);
            $this->dipa = $dipa;
        }
    }
}
