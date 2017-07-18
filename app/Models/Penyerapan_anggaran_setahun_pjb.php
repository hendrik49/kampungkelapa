<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypto;

class Penyerapan_anggaran_setahun_pjb extends EncryptedModel
{
    public $table = 'penyerapan_anggaran_setahun_pjb';
    public $fillable = ['id', 'user_id','hmac','encrypted_data','iv','jenis'];
    public $primaryKey ='id';
    public $incrementing = true; 
    
    public function getDipa()
    {
        $decryption_key = Crypto::getDecryptionKey(Auth::user(), $this->user);

        /*
        $dipa = Penyerapan_anggaran_target_pjb::where('id', $this->id_anggaran)->first();
        if ($dipa) {
            $dipa->decrypt($decryption_key);
            $this->dipa = $dipa;
        }
        */
    }
}
//