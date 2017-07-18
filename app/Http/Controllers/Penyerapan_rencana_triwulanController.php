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

class Penyerapan_rencana_triwulanController extends Controller {

    public function parseFloat($value) {
        return floatval(preg_replace("/[^0-9\.\-]/","",$value));
    }

    public function updatesetahunpjb(Request $request, $id) {
        $this->validate($request, [
            'target_paket_pjb' => 'required|numeric',
            'nilai_paket_pjb' => 'required'
        ]);
        $user = Auth::user();

        $penyerapan_setahun = Penyerapan_anggaran_setahun_pjb::findOrFail($id);

        $data_plaintext = new stdClass();

        $data_plaintext->target_paket_pjb = $request->input("target_paket_pjb");
        $data_plaintext->nilai_paket_pjb = $this->parseFloat($request->input("nilai_paket_pjb"));

        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = hex2bin($penyerapan_setahun->iv);  // IV gak diubah

        $penyerapan_setahun->plaintext_data = $data_plaintext;
        $penyerapan_setahun->user_id = $user->id;
        $penyerapan_setahun->encrypt($encryption_key, $iv_bin);
        $penyerapan_setahun->save();

        return Redirect::back()->with('message2', 'Sukses memperbaharui Perekaman Target PBJ setahun.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function updatebarang(Request $request, $id) {
        $this->validate($request, [
            'barang_triwulan_1' => 'required',
            'barang_triwulan_2' => 'required',
            'barang_triwulan_3' => 'required',
            'barang_triwulan_4' => 'required'
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $data_plaintext = new stdClass();
        $penyerapan_anggaran_triwulan_barang_m = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
        $penyerapan_anggaran_triwulan_barang->decrypt($decryption_key);

        $total = $penyerapan_anggaran_triwulan_barang->jumlah;

        $belanja = $this->parseFloat($request->input("barang_triwulan_1")) + $this->parseFloat($request->input("barang_triwulan_2")) + $this->parseFloat($request->input("barang_triwulan_4")) + $this->parseFloat($request->input("barang_triwulan_3"));

        if ($total != $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Rencana Serap Belanja Barang gagal. Jumlah rincian anggaran (' . number_format($belanja, 2) . ') dan pagu tidak sama (' . number_format($total, 2) . ')');
        } else {

            $data_plaintext->jumlah = $total;
            $data_plaintext->triwulan_1 = $this->parseFloat($request->input("barang_triwulan_1"));
            $data_plaintext->triwulan_2 = $this->parseFloat($request->input("barang_triwulan_2"));
            $data_plaintext->triwulan_3 = $this->parseFloat($request->input("barang_triwulan_3"));
            $data_plaintext->triwulan_4 = $this->parseFloat($request->input("barang_triwulan_4"));

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_anggaran_triwulan_barang_m->iv);  // IV gak diubah

            $penyerapan_anggaran_triwulan_barang_m->plaintext_data = $data_plaintext;
            $penyerapan_anggaran_triwulan_barang_m->user_id = $user->id;
            $penyerapan_anggaran_triwulan_barang_m->encrypt($encryption_key, $iv_bin);
            $penyerapan_anggaran_triwulan_barang_m->save();


            return Redirect::back()->with('message2', 'Sukses memperbaharui penyerapan rencana triwulan barang.');
        }
    }

    public function updatemodal(Request $request, $id) {
        $this->validate($request, [
            'modal_triwulan_1' => 'required',
            'modal_triwulan_2' => 'required',
            'modal_triwulan_3' => 'required',
            'modal_triwulan_4' => 'required',
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $data_plaintext = new stdClass();
        $penyerapan_anggaran_triwulan_modal_m = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
        $penyerapan_anggaran_triwulan_modal->decrypt($decryption_key);

        $total = $penyerapan_anggaran_triwulan_modal->jumlah;

        $belanja = $this->parseFloat($request->input("modal_triwulan_1")) + $this->parseFloat($request->input("modal_triwulan_2")) + $this->parseFloat($request->input("modal_triwulan_4")) + $this->parseFloat($request->input("modal_triwulan_3"));

        if ($total != $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Rencana Serap Belanja Modal gagal. Jumlah rincian anggaran (' . number_format($belanja, 2) . ') dan pagu tidak sama (' . number_format($total, 2) . ')');
        } else {

            $data_plaintext->jumlah = $total;
            $data_plaintext->triwulan_1 = $this->parseFloat($request->input("modal_triwulan_1"));
            $data_plaintext->triwulan_2 = $this->parseFloat($request->input("modal_triwulan_2"));
            $data_plaintext->triwulan_3 = $this->parseFloat($request->input("modal_triwulan_3"));
            $data_plaintext->triwulan_4 = $this->parseFloat($request->input("modal_triwulan_4"));

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_anggaran_triwulan_modal_m->iv);  // IV gak diubah

            $penyerapan_anggaran_triwulan_modal_m->plaintext_data = $data_plaintext;
            $penyerapan_anggaran_triwulan_modal_m->user_id = $user->id;
            $penyerapan_anggaran_triwulan_modal_m->encrypt($encryption_key, $iv_bin);
            $penyerapan_anggaran_triwulan_modal_m->save();


            return Redirect::back()->with('message2', 'Sukses memperbaharui penyerapan rencana triwulan modal.');
        }
    }

    public function updatelainnya(Request $request, $id) {
        $this->validate($request, [
            'lainnya_triwulan_1' => 'required',
            'lainnya_triwulan_2' => 'required',
            'lainnya_triwulan_3' => 'required',
            'lainnya_triwulan_4' => 'required',
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $data_plaintext = new stdClass();
        $penyerapan_anggaran_triwulan_lainnya_m = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
        $penyerapan_anggaran_triwulan_lainnya->decrypt($decryption_key);

        $total = $penyerapan_anggaran_triwulan_lainnya->jumlah;

        $belanja = $this->parseFloat($request->input("lainnya_triwulan_1")) + $this->parseFloat($request->input("lainnya_triwulan_2")) + $this->parseFloat($request->input("lainnya_triwulan_4")) + $this->parseFloat($request->input("lainnya_triwulan_3"));

        if ($total != $belanja) {
            return Redirect::back()->with('message', 'Memperbaharui Rencana Serap Belanja Lainnya gagal. Jumlah rincian anggaran (' . number_format($belanja, 2) . ') dan pagu tidak sama (' . number_format($total, 2) . ')');
        } else {

            $data_plaintext->jumlah = $total;
            $data_plaintext->triwulan_1 = $this->parseFloat($request->input("lainnya_triwulan_1"));
            $data_plaintext->triwulan_2 = $this->parseFloat($request->input("lainnya_triwulan_2"));
            $data_plaintext->triwulan_3 = $this->parseFloat($request->input("lainnya_triwulan_3"));
            $data_plaintext->triwulan_4 = $this->parseFloat($request->input("lainnya_triwulan_4"));

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($penyerapan_anggaran_triwulan_lainnya_m->iv);  // IV gak diubah

            $penyerapan_anggaran_triwulan_lainnya_m->plaintext_data = $data_plaintext;
            $penyerapan_anggaran_triwulan_lainnya_m->user_id = $user->id;
            $penyerapan_anggaran_triwulan_lainnya_m->encrypt($encryption_key, $iv_bin);
            $penyerapan_anggaran_triwulan_lainnya_m->save();

            return Redirect::back()->with('message2', 'Sukses memperbaharui penyerapan rencana triwulan lainnya.');
        }
    }

}
