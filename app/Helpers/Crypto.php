<?php

namespace App\Helpers;

use App\User;

class Crypto
{
    // memutuskan apakah ambil key decrypt dari current user atau data owner
    public static function getDecryptionKey(User $currentUser, User $dataOwner)
    {
        if ($currentUser->role == 'K') {
            $decryption_key = hex2bin($currentUser->getCryptoKey());
        } else if ($currentUser->role == 'M') {
            $decryption_key = hex2bin($dataOwner->getCryptoKeyByMaster());
        }        
        return $decryption_key;
    }
}