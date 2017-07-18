<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Penyerapan_anggaran_pradipa;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\Models\Deadline;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;
use PHPExcel_IOFactory;

function triwulan_roman($no) {
    return ['', 'I', 'II', 'III', 'IV'][$no];
}

class Penyerapan_anggaran_pradipaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();

        if ($user->role == "M")
            $penyerapan_anggaran_pradipas = Penyerapan_anggaran_pradipa::orderBy('id', 'desc')->get();
        else
            $penyerapan_anggaran_pradipas = Penyerapan_anggaran_pradipa::Where('user_id', $user->id)->orderBy('id', 'desc')->get();

        foreach ($penyerapan_anggaran_pradipas as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }

        if ($user->role == "M")
            return view('penyerapan_anggaran_pradipas.indexadmin', compact('penyerapan_anggaran_pradipas'));
        else
            return view('penyerapan_anggaran_pradipas.index', compact('penyerapan_anggaran_pradipas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
        $tahun_sekarang = intval(date("Y"));
        $deadline = Deadline::where('tahun_anggaran', $tahun_sekarang)->first();
        
        if (!$deadline) {
            $message = "Admin belum memasukkan batas tenggat waktu triwulan untuk tahun {$tahun_sekarang}. Harap hubungi admin.";
            return view('penyerapan_anggaran_pradipas.error', compact('message'));
        }

        $tw = [];
        $tw[1] = strtotime($deadline->triwulan_1);
        $tw[2] = strtotime($deadline->triwulan_2);
        $tw[3] = strtotime($deadline->triwulan_3);
        $tw[4] = strtotime($deadline->triwulan_4);
        $now = strtotime('now');
        
        // mencari sekarang itu triwulan berapa
        $tw_sekarang = 0;
        for ($t = 1; $t <= 4; $t++) {
            if ($now <= $tw[$t]) {
                $tw_sekarang = $t;
                break;
            }
        }
        
        if ($tw_sekarang == 1 || $tw_sekarang == 4) {
            $user = Auth::user();
            return view('penyerapan_anggaran_pradipas.create', compact('user'));
        } else {
            
            $message = "Pra-DIPA hanya dapat diisi pada triwulan I dan IV";
            $message .= ", sedangkan sekarang adalah triwulan " . triwulan_roman($tw_sekarang) . ".<br/>";
            $message .= "Keterangan batas akhir triwulan: <ul>";
            for ($t = 1; $t <= 4; $t++) {
                $message .= "<li>Triwulan " . triwulan_roman($t) . ": " . Carbon::parse($deadline->{"triwulan_" . $t})->format('d-m-Y') . "</li>";
            }            
            $message .= "</ul>";
            
            return view('penyerapan_anggaran_pradipas.error', compact('message'));
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */

    public function parseFloat($value) {
        return floatval(preg_replace("/[^0-9\.\-]/","",$value));
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'tahun_anggaran' => 'required|numeric',
            'satuan_kerja' => 'required',
            'nama_dipa' => 'required:unique:Penyerapan_anggaran_pradipas',
            'tanggal_dipa' => 'required|Date',
            'total_anggaran' => 'required',
            'jenis' => 'required',
        ]);

        $user = Auth::user();

        $penyerapan_anggaran_pradipa = new Penyerapan_anggaran_pradipa();
        $status = false;
        $nama_dipa = $request->input("nama_dipa");
        $pjb = Penyerapan_anggaran_pradipa::orderBy('id', 'desc')->get();
        
        foreach ($pjb as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if ($row->nama_dipa == $nama_dipa)
                $status = true;
        }

        if ($status) {
            return redirect()->route('penyerapan_anggaran_pradipas.create')->with('message', 'Membuat Pra-DIPA gagal. No DIPA (' . $nama_dipa . ') sudah ada');
        } else {

            $data_plaintext = new stdClass();

            $data_plaintext->tahun_anggaran = $request->input("tahun_anggaran");
            $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
            $data_plaintext->nama_dipa = $request->input("nama_dipa");
            $data_plaintext->tanggal_dipa = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');
            $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintext->status = "DRAFT";            
            if ($data_plaintext->total_anggaran <= 200000000) {
                $data_plaintext->jenis_surat = "SPK";
            } else {
                $data_plaintext->jenis_surat = "Kontrak";
            }

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $penyerapan_anggaran_pradipa->jenis = $request->input("jenis");
            $penyerapan_anggaran_pradipa->plaintext_data = $data_plaintext;
            $penyerapan_anggaran_pradipa->user_id = $user->id;
            $penyerapan_anggaran_pradipa->encrypt($encryption_key, $iv_bin);
            $penyerapan_anggaran_pradipa->save();

            $penyerapan_id = $penyerapan_anggaran_pradipa->id;

            #Penyerapan_anggaran_perjenis_belanja    
            $jenis = new Penyerapan_anggaran_perjenis_belanja();
            $data_plaintext = new stdClass();

            $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintext->belanja_barang = 0;
            $data_plaintext->belanja_modal = 0;
            $data_plaintext->belanja_lainnya = 0;
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $jenis->id_anggaran = $penyerapan_id;
            $jenis->plaintext_data = $data_plaintext;
            $jenis->user_id = $user->id;
            $jenis->encrypt($encryption_key, $iv_bin);
            $jenis->save();

            #Penyerapan_anggaran_triwulan_modal
            $triwulan_modal = new Penyerapan_anggaran_triwulan_modal();
            $data_plaintext_modal = new stdClass();

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $data_plaintext_modal->jumlah = 0;
            $data_plaintext_modal->triwulan_1 = 0;
            $data_plaintext_modal->triwulan_2 = 0;
            $data_plaintext_modal->triwulan_3 = 0;
            $data_plaintext_modal->triwulan_4 = 0;

            $triwulan_modal->id_anggaran = $penyerapan_id;
            $triwulan_modal->plaintext_data = $data_plaintext_modal;
            $triwulan_modal->user_id = $user->id;
            $triwulan_modal->encrypt($encryption_key, $iv_bin);
            $triwulan_modal->save();

            # $data_plaintextPenyerapan_anggaran_barang
            $triwulan_barang = new Penyerapan_anggaran_triwulan_barang();
            $data_plaintext_barang = new stdClass();
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $data_plaintext_barang->jumlah = 0;
            $data_plaintext_barang->triwulan_1 = 0;
            $data_plaintext_barang->triwulan_2 = 0;
            $data_plaintext_barang->triwulan_3 = 0;
            $data_plaintext_barang->triwulan_4 = 0;

            $triwulan_barang->id_anggaran = $penyerapan_id;
            $triwulan_barang->plaintext_data = $data_plaintext_barang;
            $triwulan_barang->user_id = $user->id;
            $triwulan_barang->encrypt($encryption_key, $iv_bin);
            $triwulan_barang->save();

            # $data_plaintextPenyerapan_anggaran_lainnya
            $triwulan_lainnya = new Penyerapan_anggaran_triwulan_lainnya();
            $data_plaintext_lainnya = new stdClass();
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $data_plaintext_lainnya->jumlah = 0;
            $data_plaintext_lainnya->triwulan_1 = 0;
            $data_plaintext_lainnya->triwulan_2 = 0;
            $data_plaintext_lainnya->triwulan_3 = 0;
            $data_plaintext_lainnya->triwulan_4 = 0;

            $triwulan_lainnya->id_anggaran = $penyerapan_id;
            $triwulan_lainnya->plaintext_data = $data_plaintext_lainnya;
            $triwulan_lainnya->user_id = $user->id;
            $triwulan_lainnya->encrypt($encryption_key, $iv_bin);
            $triwulan_lainnya->save();

            return redirect()->route('penyerapan_anggaran_pradipas.index')->with('message', 'Sukses membuat Pra-DIPA.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $user = Auth::user();

        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::findOrFail($id);

        // WARNING: asumsi semua tabel dengan $id yang sama user_id nya juga sama
        $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_pradipa->user);

        $penyerapan_anggaran_pradipa->decrypt($decryption_key);

        $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);
        $penyerapan_anggaran_perjenis_belanja->decrypt($decryption_key);

        /*
        $penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::findOrFail($id);
        $penyerapan_anggaran_setahun_pjb->decrypt($decryption_key);
        */
        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
        $penyerapan_anggaran_triwulan_modal->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
        $penyerapan_anggaran_triwulan_barang->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
        $penyerapan_anggaran_triwulan_lainnya->decrypt($decryption_key);

        return view('penyerapan_anggaran_pradipas.show', compact('penyerapan_anggaran_pradipa', 'penyerapan_anggaran_perjenis_belanja', 'penyerapan_anggaran_triwulan_modal', 'penyerapan_anggaran_triwulan_barang', 'penyerapan_anggaran_triwulan_lainnya'));
        //return compact('penyerapan_anggaran_pradipa','penyerapan_anggaran_perjenis_belanja','penyerapan_anggaran_setahun_pjb','Penyerapan_anggaran_triwulan_modal','Penyerapan_anggaran_triwulan_barang','Penyerapan_anggaran_triwulan_lainnya');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function jenis($id) {
        $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);

        return compact('penyerapan_anggaran_perjenis_belanja');
    }

    public function edit($id) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());

        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::findOrFail($id);
        $penyerapan_anggaran_pradipa->decrypt($decryption_key);

        //return compact('penyerapan_anggaran_pradipa');
        return view('penyerapan_anggaran_pradipas.edit', compact('penyerapan_anggaran_pradipa'));
    }

    // set pradipa = 0 
    // set status = DRAFT
    public function approve($id) {
        $user = Auth::user();
        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::findOrFail($id);
        
        $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_pradipa->user);
        $penyerapan_anggaran_pradipa->decrypt($decryption_key, NULL, false);        
        
        $data_plaintext = $penyerapan_anggaran_pradipa->plaintext_data;
        $data_plaintext->status = 'DRAFT';
        
        $encryption_key = hex2bin($penyerapan_anggaran_pradipa->user->getCryptoKeyByMaster());
        $iv_bin = hex2bin($penyerapan_anggaran_pradipa->iv);  // IV gak diubah        
        
        $penyerapan_anggaran_pradipa->plaintext_data = $data_plaintext;
        $penyerapan_anggaran_pradipa->encrypt($encryption_key, $iv_bin);        
        $penyerapan_anggaran_pradipa->pradipa = 0;        
        $penyerapan_anggaran_pradipa->save();        
        
        return redirect()->route('penyerapan_anggaran_target_pjbs.index')->with('message', 'Pra-DIPA: ' . $data_plaintext->nama_dipa . ' telah diterima.');
    }

    // set status = REJECT
    public function reject($id) {
        $user = Auth::user();
        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::findOrFail($id);
        
        $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_pradipa->user);
        $penyerapan_anggaran_pradipa->decrypt($decryption_key, NULL, false);
        
        $data_plaintext = $penyerapan_anggaran_pradipa->plaintext_data;
        $data_plaintext->status = 'REJECT';
        
        $encryption_key = hex2bin($penyerapan_anggaran_pradipa->user->getCryptoKeyByMaster());
        $iv_bin = hex2bin($penyerapan_anggaran_pradipa->iv);  // IV gak diubah        
        
        $penyerapan_anggaran_pradipa->plaintext_data = $data_plaintext;
        $penyerapan_anggaran_pradipa->encrypt($encryption_key, $iv_bin);
        $penyerapan_anggaran_pradipa->save();        
        
        return redirect()->route('penyerapan_anggaran_pradipas.index')->with('message', 'Pra-DIPA: ' . $data_plaintext->nama_dipa . ' telah ditolak.');
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'tahun_anggaran' => 'required|numeric',
            'satuan_kerja' => 'required',
            'nama_dipa' => 'required',
            'tanggal_dipa' => 'required|Date',
            'total_anggaran' => 'required',
            'status' => 'required',
        ]);
        $user = Auth::user();
        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::findOrFail($id);
        $data_plaintext = new stdClass();

        $data_plaintext->tahun_anggaran = $request->input("tahun_anggaran");
        $data_plaintext->triwulan = $request->input("triwulan");
        $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
        $data_plaintext->alamat_lembaga = "";
        $data_plaintext->nama_dipa = $request->input("nama_dipa");
        $data_plaintext->tanggal_dipa = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');
        $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
        $data_plaintext->status = $request->input("status");
        if ($data_plaintext->total_anggaran <= 200000000) {
            $data_plaintext->jenis_surat = "SPK";
        } else {
            $data_plaintext->jenis_surat = "Kontrak";
        }
        
        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = hex2bin($penyerapan_anggaran_pradipa->iv);  // IV gak diubah

        $penyerapan_anggaran_pradipa->jenis = $request->input("jenis");
        $penyerapan_anggaran_pradipa->plaintext_data = $data_plaintext;
        $penyerapan_anggaran_pradipa->user_id = $user->id;
        $penyerapan_anggaran_pradipa->encrypt($encryption_key, $iv_bin);
        $penyerapan_anggaran_pradipa->save();

        #Penyerapan_anggaran_perjenis_belanja    
        $jenis = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);
        $data_plaintext = new stdClass();

        $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = hex2bin($jenis->iv);  // IV gak diubah

        $jenis->id_anggaran = $penyerapan_anggaran_pradipa->id;
        $jenis->plaintext_data = $data_plaintext;
        $jenis->user_id = $user->id;
        $jenis->encrypt($encryption_key, $iv_bin);
        $jenis->save();

        return redirect()->route('penyerapan_anggaran_pradipas.index')->with('message', 'Data tersimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $penyerapan_anggaran_pradipa = Penyerapan_anggaran_pradipa::find($id);
        if ($penyerapan_anggaran_pradipa != null)
            $penyerapan_anggaran_pradipa->delete();

        $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::find($id);
        if ($penyerapan_anggaran_perjenis_belanja != null)
            $penyerapan_anggaran_perjenis_belanja->delete();

        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::find($id);
        if ($penyerapan_anggaran_triwulan_modal != null)
            $penyerapan_anggaran_triwulan_modal->delete();

        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::find($id);
        if ($penyerapan_anggaran_triwulan_barang != null)
            $penyerapan_anggaran_triwulan_barang->delete();

        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::find($id);
        if ($penyerapan_anggaran_triwulan_lainnya != null)
            $penyerapan_anggaran_triwulan_lainnya->delete();

        $penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::find($id);
        if ($penyerapan_anggaran_setahun_pjb != null)
            $penyerapan_anggaran_setahun_pjb->delete();


        return redirect()->route('penyerapan_anggaran_pradipas.index')->with('message', 'Data berhasil dihapus.');
    }

}
