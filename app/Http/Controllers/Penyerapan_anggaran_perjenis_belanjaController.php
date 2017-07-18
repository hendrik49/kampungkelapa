<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Penyerapan_anggaran_target_pjb;
use App\Models\Penyerapan_anggaran_pradipa;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use \stdClass;
use App\Helpers\Crypto;

function parseFloat($value) {
    return floatval(preg_replace("/[^0-9\.\-]/", "", $value));
}

class Penyerapan_anggaran_perjenis_belanjaController extends Controller {

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());

        $pjb = Penyerapan_anggaran_target_pjb::find($id);
        if (!$pjb) {
            $pjb = Penyerapan_anggaran_pradipa::find($id);
        }

        $pjb->decrypt($decryption_key);
        if ($pjb->jenis == "p") {
            $this->validate($request, [
                'belanja_lainnya' => 'required',
                'belanja_barang' => 'required',
                'belanja_modal' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'belanja_lainnya' => 'required',
                'belanja_barang' => 'required'
            ]);
        }

        $penyerapan_anggaran_perjenis_m = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);
        $penyerapan_anggaran_perjenis = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);
        $penyerapan_anggaran_perjenis->decrypt($decryption_key);

        $data_plaintext = new stdClass();

        $belanja = parseFloat($request->input("belanja_modal")) + parseFloat($request->input("belanja_barang")) + parseFloat($request->input("belanja_lainnya"));
        $total = $penyerapan_anggaran_perjenis->total_anggaran;
        $triwulan = $belanja;

        if ($penyerapan_anggaran_perjenis->total_anggaran < $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Penyerapan Anggaran Perjenis Belanja gagal. Jumlah rincian anggaran (' . $belanja . ') lebih besar dari totalnya (' . $total . ')');
        } elseif ($penyerapan_anggaran_perjenis->total_anggaran != $triwulan && $penyerapan_anggaran_perjenis->total_anggaran != $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Penyerapan Anggaran Perjenis Belanja gagal. Jumlah triwulan anggaran (' . $triwulan . '),  Jumlah rincian anggaran (' . $belanja . ') dan totalnya (' . $total . ') tidak sama ');
        } elseif ($penyerapan_anggaran_perjenis->total_anggaran != $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Penyerapan Anggaran Perjenis Belanja gagal. Jumlah rincian anggaran (' . $belanja . ') dan totalnya (' . $total . ') tidak sama ');
        } elseif ($penyerapan_anggaran_perjenis->total_anggaran != $triwulan) {
            return Redirect::back()->with('message', 'Memperbaharui Penyerapan Anggaran Perjenis Belanja gagal. Jumlah triwulan anggaran (' . $triwulan . ') dan totalnya (' . $total . ') tidak sama ');
        } else {

            $data_plaintext->total_anggaran = $penyerapan_anggaran_perjenis->total_anggaran;
            $data_plaintext->belanja_barang = parseFloat($request->input("belanja_barang"));
            $data_plaintext->belanja_modal = parseFloat($request->input("belanja_modal"));
            $data_plaintext->belanja_lainnya = parseFloat($request->input("belanja_lainnya"));


            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_anggaran_perjenis_m->iv);  // IV gak diubah

            $penyerapan_anggaran_perjenis_m->plaintext_data = $data_plaintext;
            $penyerapan_anggaran_perjenis_m->user_id = $user->id;
            $penyerapan_anggaran_perjenis_m->encrypt($encryption_key, $iv_bin);
            $penyerapan_anggaran_perjenis_m->save();


            $penyerapan_rencana_triwulan_modal = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
            $data_plaintext_modal = new stdClass();

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_rencana_triwulan_modal->iv);  // IV gak diubah

            $data_plaintext_modal->jumlah = parseFloat($request->input("belanja_modal"));
            $data_plaintext_modal->triwulan_1 = 0;
            $data_plaintext_modal->triwulan_2 = 0;
            $data_plaintext_modal->triwulan_3 = 0;
            $data_plaintext_modal->triwulan_4 = 0;
            
            $penyerapan_rencana_triwulan_modal->plaintext_data = $data_plaintext_modal;
            $penyerapan_rencana_triwulan_modal->user_id = $user->id;
            $penyerapan_rencana_triwulan_modal->encrypt($encryption_key, $iv_bin);
            $penyerapan_rencana_triwulan_modal->save();

            $penyerapan_rencana_triwulan_barang = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
            $data_plaintext_barang = new stdClass();

            $data_plaintext_barang->jumlah = parseFloat($request->input("belanja_barang"));
            $data_plaintext_barang->triwulan_1 = 0;
            $data_plaintext_barang->triwulan_2 = 0;
            $data_plaintext_barang->triwulan_3 = 0;
            $data_plaintext_barang->triwulan_4 = 0;
            
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_rencana_triwulan_barang->iv);  // IV gak diubah

            $penyerapan_rencana_triwulan_barang->plaintext_data = $data_plaintext_barang;
            $penyerapan_rencana_triwulan_barang->user_id = $user->id;
            $penyerapan_rencana_triwulan_barang->encrypt($encryption_key, $iv_bin);
            $penyerapan_rencana_triwulan_barang->save();

            $penyerapan_rencana_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
            $data_plaintext_lainnya = new stdClass();
            
            $data_plaintext_lainnya->jumlah = parseFloat($request->input("belanja_lainnya"));
            $data_plaintext_lainnya->triwulan_1 = 0;
            $data_plaintext_lainnya->triwulan_2 = 0;
            $data_plaintext_lainnya->triwulan_3 = 0;
            $data_plaintext_lainnya->triwulan_4 = 0;            
            
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_rencana_triwulan_lainnya->iv);  // IV gak diubah

            $penyerapan_rencana_triwulan_lainnya->plaintext_data = $data_plaintext_lainnya;
            $penyerapan_rencana_triwulan_lainnya->user_id = $user->id;
            $penyerapan_rencana_triwulan_lainnya->encrypt($encryption_key, $iv_bin);
            $penyerapan_rencana_triwulan_lainnya->save();

            return Redirect::back()->with('message2', 'Sukses memperbaharui Penyerapan Anggaran Perjenis Belanja.');
        }
    }

}
