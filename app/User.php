<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\ReportController;

use App\Models\Deadline;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // decrypt key_u using pass_sha256
    public function getCryptoKey() {

        $pass_sha256 = session()->get("pass_sha256");
        $key = openssl_decrypt($this->key_u, config('crypto.cipher_method'), hex2bin($pass_sha256), 0, hex2bin($this->salt));

        // the real key is in hex string
        // 31837202e80c007fdef09e95271c115631837202e80c007fdef09e95271c1156
        return $key;

    }

    // decrypt this user's key (key_m) using master's pass_sha256
    public function getCryptoKeyByMaster() {

        $pass_sha256 = session()->get("pass_sha256");
        $key = openssl_decrypt($this->key_m, config('crypto.cipher_method'), hex2bin($pass_sha256), 0, hex2bin($this->salt));

        // the real key is in hex string
        // 31837202e80c007fdef09e95271c115631837202e80c007fdef09e95271c1156
        return $key;

    }    
    
    // get status pengisian form user
    // apakah untuk TA sekian triwulan sekian sudah mengisi rencana, realisasi, progres
    public function getStatusPengisian($tahun_anggaran) {
        
        $status_pengisian = [
            "rencana"   => "BELUM", 
            "realisasi" => [1 => "BELUM", 2 => "BELUM", 3 => "BELUM", 4 => "BELUM"], 
            "progres"   => [1 => "BELUM", 2 => "BELUM", 3 => "BELUM", 4 => "BELUM"]
        ];
        
        $rencana = ReportController::getRencanaAnggaran($this->id, $tahun_anggaran);
        $realisasi = ReportController::getRealisasiAnggaran($this->id, $tahun_anggaran);
        $progres = ReportController::getProgressAnggaran($this->id, $tahun_anggaran);
        
        if (count($rencana) > 0) {
            $status_pengisian['rencana'] = 'FINAL';
            foreach ($rencana as $d) {
                if ($d->status == 'DRAFT') $status_pengisian['rencana'] = 'DRAFT';
            }
        }

        if (count($realisasi) > 0) {
            $count_final = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            $total       = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            foreach ($realisasi as $d) {
                $total[$d->triwulan]++;
                for ($t = 1; $t <= 4; $t++) {
                    if ($d->status == 'DRAFT' && $d->triwulan == $t) $status_pengisian['realisasi'][$t] = 'DRAFT';
                    if ($d->status == 'FINAL' && $d->triwulan == $t) $count_final[$t]++;
                }
            }
            for ($t = 1; $t <= 4; $t++) {
                if ($count_final[$t] == $total[$t] && $total[$t] > 0) $status_pengisian['realisasi'][$t] = 'FINAL';
            }
        }

        if (count($progres) > 0) {
            $count_final = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            $total       = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
            foreach ($progres as $d) {
                $total[$d->triwulan]++;
                for ($t = 1; $t <= 4; $t++) {
                    if ($d->status == 'DRAFT' && $d->triwulan == $t) $status_pengisian['progres'][$t] = 'DRAFT';
                    if ($d->status == 'FINAL' && $d->triwulan == $t) $count_final[$t]++;
                }
            }
            for ($t = 1; $t <= 4; $t++) {
                if ($count_final[$t] == $total[$t] && $total[$t] > 0) $status_pengisian['progres'][$t] = 'FINAL';
            }
        }
                
        return ($status_pengisian);
        
    }
    
    public $days = 7;
    
    public function getNotifikasiPengisian($now = null) {
        
        // cek tanggal sekarang, adakah deadline terdekat di tiap triwulan
        
        if (!$now) {
            $now = "NOW()";
        } else {
            $now = "DATE('{$now}')";
        }
        
        $deadline_tw = [];
        $deadline_tw[1] = Deadline::whereRaw("$now BETWEEN DATE_SUB(triwulan_1, INTERVAL {$this->days} DAY) AND triwulan_1")->first();
        $deadline_tw[2] = Deadline::whereRaw("$now BETWEEN DATE_SUB(triwulan_2, INTERVAL {$this->days} DAY) AND triwulan_2")->first();
        $deadline_tw[3] = Deadline::whereRaw("$now BETWEEN DATE_SUB(triwulan_3, INTERVAL {$this->days} DAY) AND triwulan_3")->first();
        $deadline_tw[4] = Deadline::whereRaw("$now BETWEEN DATE_SUB(triwulan_4, INTERVAL {$this->days} DAY) AND triwulan_4")->first();

        $messages = [];
        $deadline_terdekat = [];
        
        for ($t = 1; $t <= 4; $t++) {
            if ($deadline_tw[$t]) {
                $tahun = $deadline_tw[$t]->tahun_anggaran;
                $deadline_terdekat[] = $deadline_tw[$t]->{'triwulan_' . $t};
                $status_pengisian = $this->getStatusPengisian($tahun);
                
                if ($status_pengisian["rencana"] != 'FINAL') {
                    $messages[] = sprintf("Anda belum mengisi rencana anggaran tahun %d", $tahun);
                }
                if ($status_pengisian["realisasi"][$t] != 'FINAL') {
                    $messages[] = sprintf("Anda belum mengisi realisasi anggaran triwulan %d tahun %d", $t, $tahun);
                }
                if ($status_pengisian["progres"][$t] != 'FINAL') {
                    $messages[] = sprintf("Anda belum mengisi progres PBJ triwulan %d tahun %d", $t, $tahun);
                }
            }
        }
        
        $notif = ['pesan' => array_unique($messages), 'deadline' => array_unique($deadline_terdekat)];

        return $notif;
        
    }
    
    
}
