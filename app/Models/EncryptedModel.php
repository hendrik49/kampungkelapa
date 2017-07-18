<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncryptedModel extends Model {

    public $plaintext_data;

    public function encrypt($key, $iv) {
        $data_plaintext = json_encode($this->plaintext_data);
        $hmac = hash_hmac(config('crypto.hmac_method'), bin2hex($iv) . $data_plaintext, config('crypto.hmac_key')); // HMAC(IV || plaintext)

        $data_ciphertext = openssl_encrypt($data_plaintext, config('crypto.cipher_method'), $key, 0, $iv);

        $this->encrypted_data = $data_ciphertext;
        $this->iv = bin2hex($iv);
        $this->hmac = $hmac;
    }

    public function decrypt($key, $iv = NULL, $extractAttr = true) {
        if ($iv === NULL) $iv = hex2bin($this->iv);

        $plaintext = openssl_decrypt($this->encrypted_data, config('crypto.cipher_method'), $key, 0, $iv);
        $hmac = hash_hmac(config('crypto.hmac_method'), bin2hex($iv) . $plaintext, config('crypto.hmac_key'));

        if ($hmac == $this->hmac) {
            $this->plaintext_data = json_decode($plaintext);
        } else {
            $this->plaintext_data = json_decode('{"error": "DECRYPTION_ERROR"}');
        }        

        if ($extractAttr)
            $this->extractAttributes();
    }

    public function extractAttributes() {
        foreach ($this->plaintext_data as $k => $v) {
            $this->$k = $v;
        }        
        unset($this->encrypted_data);
        unset($this->plaintext_data);
        unset($this->hmac);
        //unset($this->iv);
    } 

    public function user() {
        return $this->belongsTo('App\User');
    }

}