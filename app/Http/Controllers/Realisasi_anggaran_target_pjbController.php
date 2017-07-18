<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Realisasi_anggaran_target_pjb;
use App\Models\Realisasi_anggaran_triwulan_berjalan;
use App\Models\Realisasi_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\Models\Penyerapan_anggaran_target_pjb;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;

class Realisasi_anggaran_target_pjbController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();

        if ($user->role == "M")
            $realisasi_anggaran_target_pjbs = Realisasi_anggaran_target_pjb::orderBy('id', 'desc')->get();
        else
            $realisasi_anggaran_target_pjbs = Realisasi_anggaran_target_pjb::Where('user_id', $user->id)->orderBy('id', 'desc')->get();

        $realisasi_daerah = [];
        
        foreach ($realisasi_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            $row->getDetails();
            
            if ($row->jenis == 'd')
                $realisasi_daerah[] = $row;
        }
        
        $realisasi_anggaran_target_pjbs = $realisasi_daerah;

        return view('realisasi_anggaran_target_pjbs.index', compact('realisasi_anggaran_target_pjbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $user = Auth::user();
        
        if ($user->role == "M")
            $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('jenis', "d")->orderBy('id', 'desc')->get();        
        else
            $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('user_id', $user->id)->Where('jenis', "d")->orderBy('id', 'desc')->get();

        foreach ($penyerapan_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }

        return view('realisasi_anggaran_target_pjbs.create', compact('penyerapan_anggaran_target_pjbs', 'user'));
    }

    public function getRencanaTriwulan($id, $idtriwulan) {
        $total_anggaran = 0;
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
        $penyerapan_anggaran_triwulan_modal->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
        $penyerapan_anggaran_triwulan_barang->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
        $penyerapan_anggaran_triwulan_lainnya->decrypt($decryption_key);

        if($idtriwulan=="1"){
             $total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_1 +  $penyerapan_anggaran_triwulan_barang->triwulan_1  + $penyerapan_anggaran_triwulan_lainnya->triwulan_1 ;
        }
        else if($idtriwulan=="2"){
             $total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_2 +  $penyerapan_anggaran_triwulan_barang->triwulan_2  + $penyerapan_anggaran_triwulan_lainnya->triwulan_2 ;
        }
        else if($idtriwulan=="3"){
             $total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_3 +  $penyerapan_anggaran_triwulan_barang->triwulan_3  + $penyerapan_anggaran_triwulan_lainnya->triwulan_3 ;
        }
        else if($idtriwulan=="4"){
             $total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_4 +  $penyerapan_anggaran_triwulan_barang->triwulan_4  + $penyerapan_anggaran_triwulan_lainnya->triwulan_4 ;
        }

        return $total_anggaran;
    }

    public function getModelRencanaTriwulan($id, $idtriwulan) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::findOrFail($id);
        $penyerapan_anggaran_triwulan_modal->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::findOrFail($id);
        $penyerapan_anggaran_triwulan_barang->decrypt($decryption_key);

        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::findOrFail($id);
        $penyerapan_anggaran_triwulan_lainnya->decrypt($decryption_key);
        $data = new stdClass();
        $data->total_anggaran=0;
        $data->belanja_modal=0;
        $data->belanja_barang=0;
        $data->belanja_lainnya=0;

        if($idtriwulan=="1"){
                $data->total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_1 +  $penyerapan_anggaran_triwulan_barang->triwulan_1  + $penyerapan_anggaran_triwulan_lainnya->triwulan_1 ;
                $data->belanja_modal=$penyerapan_anggaran_triwulan_modal->triwulan_1;
                $data->belanja_barang= $penyerapan_anggaran_triwulan_barang->triwulan_1 ;
                $data->belanja_lainnya=$penyerapan_anggaran_triwulan_lainnya->triwulan_1 ;
        }
        else if($idtriwulan=="2"){
                $data->total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_2 +  $penyerapan_anggaran_triwulan_barang->triwulan_2  + $penyerapan_anggaran_triwulan_lainnya->triwulan_2 ;
                $data->belanja_modal=$penyerapan_anggaran_triwulan_modal->triwulan_2;
                $data->belanja_barang= $penyerapan_anggaran_triwulan_barang->triwulan_2 ;
                $data->belanja_lainnya=$penyerapan_anggaran_triwulan_lainnya->triwulan_2 ;
        }
        else if($idtriwulan=="3"){
                $data->total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_3 +  $penyerapan_anggaran_triwulan_barang->triwulan_3  + $penyerapan_anggaran_triwulan_lainnya->triwulan_3 ;
                $data->belanja_modal=$penyerapan_anggaran_triwulan_modal->triwulan_3;
                $data->belanja_barang= $penyerapan_anggaran_triwulan_barang->triwulan_3 ;
                $data->belanja_lainnya=$penyerapan_anggaran_triwulan_lainnya->triwulan_3 ;
        }
        else if($idtriwulan=="4"){
                $data->total_anggaran  = $penyerapan_anggaran_triwulan_modal->triwulan_4 +  $penyerapan_anggaran_triwulan_barang->triwulan_4  + $penyerapan_anggaran_triwulan_lainnya->triwulan_4 ;
                $data->belanja_modal=$penyerapan_anggaran_triwulan_modal->triwulan_4;
                $data->belanja_barang= $penyerapan_anggaran_triwulan_barang->triwulan_4 ;
                $data->belanja_lainnya=$penyerapan_anggaran_triwulan_lainnya->triwulan_4 ;
        }

        return $data;
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
            'triwulan' => 'required',
            'satuan_kerja' => 'required',
            'nama_dipa' => 'required',
            'tanggal_dipa' => 'required|Date',
            'total_anggaran' => 'required',
        ]);
        $user = Auth::user();
        $id_pjb = $request->input("nama_dipa");
        $tri = $request->input("triwulan");
        $rencanatriwulan = $this->getRencanaTriwulan($id_pjb, $tri);
        $belanja = $this->parseFloat($request->input("total_anggaran"));
        $data_plaintext = new stdClass();

        $pjb = Penyerapan_anggaran_target_pjb::find($id_pjb);
        $decryption_key = hex2bin($user->getCryptoKey());
        $pjb->decrypt($decryption_key);

        $triwulan = Realisasi_anggaran_target_pjb::Where('id_pjb', $pjb->id)->first();
        if ($triwulan != null)
            $triwulan->decrypt($decryption_key);

        if ($triwulan != null && $triwulan->triwulan == $tri) {
            return redirect()->route('realisasi_anggaran_target_pjbs.create')->with('message', 'Membuat Realisasi Anggaran ' . $pjb->nama_dipa . ' gagal.  Sudah ada realisasi untuk triwulan ' . $tri . '');
        } else if ( $rencanatriwulan < $belanja) {
            return redirect()->route('realisasi_anggaran_target_pjbs.create')->with('message', 'Membuat Realisasi Anggaran gagal. Jumlah realisasi anggaran (' . number_format($belanja, 2) . ') lebih besar dari total rencana triwulan '.$tri.' anggaran (' . number_format($rencanatriwulan, 2) . ')');
        } else {
            $Realisasi_anggaran_target_pjb = new Realisasi_anggaran_target_pjb();
            $data_plaintext->tahun_anggaran = $pjb->tahun_anggaran;
            $data_plaintext->triwulan = $request->input("triwulan");
            if ($pjb != null)
                $data_plaintext->nama_dipa = $pjb->nama_dipa;
            else
                $data_plaintext->nama_dipa = "Istimewa";

            $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
            $data_plaintext->tanggal_dipa = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');
            $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintext->status = "DRAFT";
            $data_plaintext->permasalahan = [];

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $Realisasi_anggaran_target_pjb->jenis = $pjb->jenis;
            $Realisasi_anggaran_target_pjb->id_pjb = $request->input("nama_dipa");
            $Realisasi_anggaran_target_pjb->plaintext_data = $data_plaintext;
            $Realisasi_anggaran_target_pjb->user_id = $user->id;
            $Realisasi_anggaran_target_pjb->encrypt($encryption_key, $iv_bin);
            $Realisasi_anggaran_target_pjb->save();

            $Realisasi_id = $Realisasi_anggaran_target_pjb->id;

            $jenis = new Realisasi_anggaran_triwulan_berjalan();
            $jenis->id_realisasi = $Realisasi_id;
            $jenis->id_pjb = $request->input("nama_dipa");

            $data_plaintextRealisasi = new stdClass();
            $data_plaintextRealisasi->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintextRealisasi->belanja_barang = 0;
            $data_plaintextRealisasi->belanja_modal = 0;
            $data_plaintextRealisasi->belanja_lainnya = 0;
            $data_plaintextRealisasi->triwulan = $request->input("triwulan");

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $jenis->plaintext_data =  $data_plaintextRealisasi;
            $jenis->user_id = $user->id;
            $jenis->encrypt($encryption_key, $iv_bin);
            $jenis->save();

            return redirect()->route('realisasi_anggaran_target_pjbs.index')->with('message', 'Sukses membuat penyerapan anggaran dan target PBJ.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getTriwulan($month) {

        if ($month >= 1 && $month <= 3)
            $month = 1;
        else if ($month >= 4 && $month <= 6)
            $month = 2;
        else if ($month >= 7 && $month <= 9)
            $month = 3;
        else if ($month >= 10 && $month <= 12)
            $month = 4;
        return $month;
    }

    public function show($id) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $month = date('m');
        $month = $this->getTriwulan($month);
        $realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $realisasi_anggaran_target_pjb->user);
        $realisasi_anggaran_target_pjb->decrypt($decryption_key);

        $realisasi_triwulan = new stdClass();
        $realisasi_triwulan->total_anggaran = 0;
        $realisasi_triwulan->belanja_modal = 0;
        $realisasi_triwulan->belanja_barang = 0;
        $realisasi_triwulan->belanja_lainnya = 0;

        $realisasi_triwulan->p_total_anggaran = 0;
        $realisasi_triwulan->p_belanja_modal = 0;
        $realisasi_triwulan->p_belanja_barang = 0;
        $realisasi_triwulan->p_belanja_lainnya = 0;

        $realisasirekap = Realisasi_anggaran_triwulan_berjalan::where('id_pjb', $realisasi_anggaran_target_pjb->id_pjb)->get();
        foreach ($realisasirekap as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if ($row->triwulan <= $month) {
                $realisasi_triwulan->total_anggaran += $row->total_anggaran;
                $realisasi_triwulan->belanja_modal += $row->belanja_modal;
                $realisasi_triwulan->belanja_barang += $row->belanja_barang;
                $realisasi_triwulan->belanja_lainnya += $row->belanja_lainnya;
            }
        }

        $realisasi_anggaran_triwulan_berjalan = Realisasi_anggaran_triwulan_berjalan::Where('id_realisasi', $id)->first();
        $decryption_key = Crypto::getDecryptionKey($user, $realisasi_anggaran_triwulan_berjalan->user);
        $realisasi_anggaran_triwulan_berjalan->decrypt($decryption_key);

        // assuming usernya sama semua
        $penyerapan_anggaran = Penyerapan_anggaran_perjenis_belanja::Where('id_anggaran', $realisasi_anggaran_target_pjb->id_pjb)->first();
        $penyerapan_anggaran->decrypt($decryption_key);
        $penyerapan_anggaran_barang = Penyerapan_anggaran_triwulan_barang::Where('id_anggaran', $realisasi_anggaran_target_pjb->id_pjb)->first();
        $penyerapan_anggaran_barang->decrypt($decryption_key);
        $penyerapan_anggaran_modal = Penyerapan_anggaran_triwulan_modal::Where('id_anggaran', $realisasi_anggaran_target_pjb->id_pjb)->first();
        $penyerapan_anggaran_modal->decrypt($decryption_key);
        $penyerapan_anggaran_lainnya = Penyerapan_anggaran_triwulan_lainnya::Where('id_anggaran', $realisasi_anggaran_target_pjb->id_pjb)->first();
        $penyerapan_anggaran_lainnya->decrypt($decryption_key);

        $rencana_triwulan = new stdClass();
        $rencana_triwulan->p_total_anggaran = 0;
        $rencana_triwulan->p_belanja_modal = 0;
        $rencana_triwulan->p_belanja_barang = 0;
        $rencana_triwulan->p_belanja_lainnya = 0;


        if ($month == 4) {
            $rencana_triwulan->p_total_anggaran = $penyerapan_anggaran->total_anggaran;
            $rencana_triwulan->p_belanja_modal = $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_modal->triwulan_2 + $penyerapan_anggaran_modal->triwulan_3 + $penyerapan_anggaran_modal->triwulan_4;
            $rencana_triwulan->p_belanja_barang = $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_barang->triwulan_2 + $penyerapan_anggaran_barang->triwulan_3 + $penyerapan_anggaran_barang->triwulan_4;
            $rencana_triwulan->p_belanja_lainnya = $penyerapan_anggaran_lainnya->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_2 + $penyerapan_anggaran_lainnya->triwulan_3 + $penyerapan_anggaran_lainnya->triwulan_4;
        } else if ($month == 3) {
            $rencana_triwulan->p_total_anggaran = $penyerapan_anggaran_lainnya->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_2 + $penyerapan_anggaran_lainnya->triwulan_3 +
                    + $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_modal->triwulan_2 + $penyerapan_anggaran_modal->triwulan_3 + $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_barang->triwulan_2 + $penyerapan_anggaran_barang->triwulan_3;
            $rencana_triwulan->p_belanja_modal = $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_modal->triwulan_2 + $penyerapan_anggaran_modal->triwulan_3;
            $rencana_triwulan->p_belanja_barang = $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_barang->triwulan_2 + $penyerapan_anggaran_barang->triwulan_3;
            $rencana_triwulan->p_belanja_lainnya = $penyerapan_anggaran_lainnya->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_2 + $penyerapan_anggaran_lainnya->triwulan_3;
        } else if ($month == 2) {
            $rencana_triwulan->p_total_anggaran = $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_modal->triwulan_2 + $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_barang->triwulan_2 + $penyerapan_anggaran_lainnya->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_2;
            $rencana_triwulan->p_belanja_modal = $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_modal->triwulan_2;
            $rencana_triwulan->p_belanja_barang = $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_barang->triwulan_2;
            $rencana_triwulan->p_belanja_lainnya = $penyerapan_anggaran_lainnya->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_2;
        } else if ($month == 1) {
            $rencana_triwulan->p_total_anggaran = $penyerapan_anggaran_modal->triwulan_1 + $penyerapan_anggaran_barang->triwulan_1 + $penyerapan_anggaran_lainnya->triwulan_1;
            $rencana_triwulan->p_belanja_modal = $penyerapan_anggaran_modal->triwulan_1;
            $rencana_triwulan->p_belanja_barang = $penyerapan_anggaran_barang->triwulan_1;
            $rencana_triwulan->p_belanja_lainnya = $penyerapan_anggaran_lainnya->triwulan_1;
        }

        if($rencana_triwulan->p_total_anggaran!=0)
        $realisasi_triwulan->p_total_anggaran = $realisasi_triwulan->total_anggaran/$rencana_triwulan->p_total_anggaran;
        if($rencana_triwulan->p_belanja_modal!=0)
        $realisasi_triwulan->p_belanja_modal =  $realisasi_triwulan->belanja_modal/$rencana_triwulan->p_belanja_modal ;
        if($rencana_triwulan->p_belanja_barang!=0)
        $realisasi_triwulan->p_belanja_barang =  $realisasi_triwulan->belanja_barang/$rencana_triwulan->p_belanja_barang ;
        if($rencana_triwulan->p_belanja_lainnya!=0)
        $realisasi_triwulan->p_belanja_lainnya =   $realisasi_triwulan->belanja_lainnya/$rencana_triwulan->p_belanja_lainnya ;

        $penyerapan_anggaran_target_pjb = Penyerapan_anggaran_target_pjb::Where('id', $realisasi_anggaran_target_pjb->id_pjb)->first();
        $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_target_pjb->user);
        $penyerapan_anggaran_target_pjb->decrypt($decryption_key);

        if (!isset($realisasi_anggaran_target_pjb->permasalahan))
            $realisasi_anggaran_target_pjb->permasalahan = [];
        
        return view('realisasi_anggaran_target_pjbs.show', compact('rencana_triwulan', 'penyerapan_anggaran_target_pjb', 'realisasi_anggaran_target_pjb', 'month', 'penyerapan_anggaran', 'realisasi_anggaran_triwulan_berjalan', 'realisasi_triwulan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function jenis($id) {
        $Realisasi_anggaran_perjenis_belanja = Realisasi_anggaran_perjenis_belanja::findOrFail($id);

        return compact('Realisasi_anggaran_perjenis_belanja');
    }

    public function edit($id) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::find($id);
        $realisasi_anggaran_target_pjb->decrypt($decryption_key);

        if ($user->role == "M")
            $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('jenis', "d")->orderBy('id', 'desc')->get();        
        else
            $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('user_id', $user->id)->Where('jenis', "d")->orderBy('id', 'desc')->get();

        foreach ($penyerapan_anggaran_target_pjbs as $row) {
            $row->decrypt($decryption_key);
        }
        return view('realisasi_anggaran_target_pjbs.edit', compact('realisasi_anggaran_target_pjb', 'user', 'penyerapan_anggaran_target_pjbs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function edittriwulanberjalan($id) {
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $realisasi = Realisasi_anggaran_target_pjb::findOrFail($id);
        $realisasi->decrypt($decryption_key);

        $realisasi_triwulan_berjalan = Realisasi_anggaran_triwulan_berjalan::Where('id_realisasi', $id)->first();
        $realisasi_triwulan_berjalan->decrypt($decryption_key);

        $pjb = Penyerapan_anggaran_target_pjb::Where('id', $realisasi->id_pjb)->first();
        $pjb->decrypt($decryption_key);
        $realisasi_triwulan= $this->getModelRencanaTriwulan($realisasi->id_pjb,  $realisasi->triwulan);
        return view('realisasi_anggaran_target_pjbs.edit_triwulan_berjalan', compact('pjb', 'realisasi_triwulan_berjalan', 'realisasi', 'realisasi_triwulan'));
    }

    public function updatetriwulan(Request $request, $id) {

        $this->validate($request, [
            'realisasi_barang' => 'required',
            'realisasi_modal' => 'required',
            'realisasi_lainnya' => 'required'
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $data_plaintext = new stdClass();
        $data_plaintext->belanja_barang = $this->parseFloat($request->input("realisasi_barang"));
        $data_plaintext->belanja_modal = $this->parseFloat($request->input("realisasi_modal"));
        $data_plaintext->belanja_lainnya = $this->parseFloat($request->input("realisasi_lainnya"));

        $jenism = Realisasi_anggaran_triwulan_berjalan::find($id);
        $jenis = Realisasi_anggaran_triwulan_berjalan::find($id);
        $jenis->decrypt($decryption_key);
        $penyerapan_anggaran = Penyerapan_anggaran_perjenis_belanja::Where('id_anggaran', $jenis->id_pjb)->first();
        $penyerapan_anggaran->decrypt($decryption_key);

        $realisasi_triwulan = new stdClass();
        $realisasi_triwulan->total_anggaran = 0;
        $realisasi_triwulan->belanja_modal = 0;
        $realisasi_triwulan->belanja_barang = 0;
        $realisasi_triwulan->belanja_lainnya = 0;
        $month = date('m');
        $month = $this->getTriwulan($month);

        $realisasirekap = Realisasi_anggaran_triwulan_berjalan::where('id_pjb', $jenis->id_pjb)->get();
        $pjb=Penyerapan_anggaran_target_pjb::find($jenis->id_pjb);
        foreach ($realisasirekap as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if ($row->triwulan <= $month) {
                $realisasi_triwulan->total_anggaran += $row->total_anggaran;
                $realisasi_triwulan->belanja_modal += $row->belanja_modal;
                $realisasi_triwulan->belanja_barang += $row->belanja_barang;
                $realisasi_triwulan->belanja_lainnya += $row->belanja_lainnya;
            }
        }
        $belanja_modal = $penyerapan_anggaran->belanja_modal - $realisasi_triwulan->belanja_modal;
        $belanja_barang = $penyerapan_anggaran->belanja_barang - $realisasi_triwulan->belanja_barang;
        $belanja_lainnya = $penyerapan_anggaran->belanja_lainnya - $realisasi_triwulan->belanja_lainnya;


        $realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::find($jenis->id_realisasi);
        $realisasi_anggaran_target_pjb->decrypt($decryption_key);
        $belanja = $this->parseFloat($request->input("realisasi_barang")) + $this->parseFloat($request->input("realisasi_modal")) + $this->parseFloat($request->input("realisasi_lainnya"));

        if ($jenis == null || $realisasi_anggaran_target_pjb == null) {
            return redirect()->route('realisasi_anggaran_target_pjbs.show', $id)->with('message', 'Memperbaharui realisasi triwulan berjalan gagal. Rincian anggaran (' . $id . ') tidak ditemukan');
        } else if ($jenis->total_anggaran != $belanja) {
            return redirect()->route('realisasi_anggaran_target_pjbs.show', $jenis->id_realisasi)->with('message', 'Memperbaharui gagal. Jumlah rincian anggaran (' . number_format($belanja, 2) . ') tidak sama dengan totalnya (' . number_format($jenis->total_anggaran, 2) . ')');
        } else if ($belanja_modal < $data_plaintext->belanja_modal) {
            return redirect()->route('realisasi_anggaran_target_pjbs.show', $jenis->id_realisasi)->with('message', 'Memperbaharui gagal. Jumlah realisasi modal (' . number_format($data_plaintext->belanja_modal, 2) . ') lebih besar dari sisa (' . number_format($belanja_modal, 2) . ')');
        } else if ($belanja_barang < $data_plaintext->belanja_barang) {
            return redirect()->route('realisasi_anggaran_target_pjbs.show', $jenis->id_realisasi)->with('message', 'Memperbaharui gagal. Jumlah realisasi barang (' . number_format($data_plaintext->belanja_barang, 2) . ') lebih besar dari sisa (' . number_format($belanja_barang, 2) . ')');
        } else if ($belanja_lainnya < $data_plaintext->belanja_lainnya) {
            return redirect()->route('realisasi_anggaran_target_pjbs.show', $jenis->id_realisasi)->with('message', 'Memperbaharui gagal. Jumlah realisasi lainnya (' . number_format($data_plaintext->belanja_lainnya, 2) . ') lebih besar dari sisa (' . number_format($belanja_lainnya, 2) . ')');
        } else {
            $data_plaintext->total_anggaran = $jenis->total_anggaran;

            $data_plaintext->triwulan = $realisasi_anggaran_target_pjb->triwulan;
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($jenism->iv);  // IV gak diubah

            $jenism->plaintext_data = $data_plaintext;
            $jenism->jenis = $pjb->jenis;
            $jenism->user_id = $user->id;
            $jenism->encrypt($encryption_key, $iv_bin);
            $jenism->save();

            return redirect()->route('realisasi_anggaran_target_pjbs.show', $jenis->id_realisasi)->with('message2', 'Sukses memperbaharui triwulan berjalan.');
        }
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'triwulan' => 'required',
            'satuan_kerja' => 'required',
            'nama_dipa' => 'required',
            'tanggal_dipa' => 'required|Date',
            'total_anggaran' => 'required',
            'status' => 'required',
        ]);
        $user = Auth::user();
        $tri=$request->input("triwulan");
        $Realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::findOrFail($id);
        $id_pjb = $request->input("nama_dipa");
        $rencanatriwulan = $this->getRencanaTriwulan($id_pjb, $tri);
        $belanja = $this->parseFloat($request->input("total_anggaran"));
        
        $pjb = Penyerapan_anggaran_target_pjb::find($id_pjb);
        $decryption_key = hex2bin($user->getCryptoKey());
        $pjb->decrypt($decryption_key);
        $Realisasi_anggaran_target_pjb->decrypt($decryption_key, NULL, false);

        if ( $rencanatriwulan < $belanja) {
            return redirect()->route('realisasi_anggaran_target_pjbs.edit', $id)->with('message', 'Memperbaharui Realisasi Anggaran gagal. Jumlah realisasi (' . number_format($belanja, 2) . ') lebih besar dari total rencana triwulan '.$tri.' anggaran (' . number_format($rencanatriwulan, 2) .')');
        } else {
            $data_plaintext = new stdClass();
            $data_plaintext->tahun_anggaran = $pjb->tahun_anggaran;
            $data_plaintext->triwulan = $request->input("triwulan");
            $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
            if ($pjb != null)
                $data_plaintext->nama_dipa = $pjb->nama_dipa;
            else
                $data_plaintext->nama_dipa = "Istimewa";

            $data_plaintext->tanggal_dipa = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');
            $data_plaintext->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintext->status = $request->input("status");
            
            // jangan timpa permasalahan
            if (isset($Realisasi_anggaran_target_pjb->plaintext_data->permasalahan))
                $data_plaintext->permasalahan = $Realisasi_anggaran_target_pjb->plaintext_data->permasalahan;
            else
                $data_plaintext->permasalahan = [];
            
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = hex2bin($Realisasi_anggaran_target_pjb->iv);  // IV gak diubah
            
            $Realisasi_anggaran_target_pjb->jenis = $pjb->jenis;
            $Realisasi_anggaran_target_pjb->id_pjb = $request->input("nama_dipa");
            $Realisasi_anggaran_target_pjb->plaintext_data = $data_plaintext;
            $Realisasi_anggaran_target_pjb->user_id = $user->id;
            $Realisasi_anggaran_target_pjb->encrypt($encryption_key, $iv_bin);
            $Realisasi_anggaran_target_pjb->save();

            $jenis = Realisasi_anggaran_triwulan_berjalan::Where('id_realisasi', $Realisasi_anggaran_target_pjb->id)->first();            
            $jenism = Realisasi_anggaran_triwulan_berjalan::Where('id_realisasi', $Realisasi_anggaran_target_pjb->id)->first();   
            $jenism->decrypt($decryption_key);         
            $jenis->id_realisasi = $Realisasi_anggaran_target_pjb->id;
            $jenis->id_pjb = $Realisasi_anggaran_target_pjb->id_pjb;

            $data_plaintextRealisasi = new stdClass();
            $data_plaintextRealisasi->total_anggaran = $this->parseFloat($request->input("total_anggaran"));
            $data_plaintextRealisasi->belanja_barang = $jenism->belanja_barang;
            $data_plaintextRealisasi->belanja_modal = $jenism->belanja_modal;
            $data_plaintextRealisasi->belanja_lainnya = $jenism->belanja_lainnya;
            $data_plaintextRealisasi->triwulan = $request->input("triwulan");

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $jenis->plaintext_data = $data_plaintextRealisasi;
            $jenis->user_id = $user->id;
            $jenis->encrypt($encryption_key, $iv_bin);
            $jenis->save();

            return redirect()->route('realisasi_anggaran_target_pjbs.index')->with('message', 'Sukses memperbaharui realisasi anggaran pjb.');
        }
    }
    
    public function permasalahan($id) {
        
        $user = Auth::user();
        $realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $realisasi_anggaran_target_pjb->user);
        $realisasi_anggaran_target_pjb->decrypt($decryption_key);        
        
        if (!isset($realisasi_anggaran_target_pjb->permasalahan))
            $realisasi_anggaran_target_pjb->permasalahan = [];        
        
        $permasalahan = $realisasi_anggaran_target_pjb->permasalahan;
        
        $permasalahan = json_encode($permasalahan);
        
        return view('realisasi_anggaran_target_pjbs.permasalahan', compact('permasalahan', 'realisasi_anggaran_target_pjb'));
        
    }
    
    public function permasalahanSave(Request $request, $id) {
        
        $json = json_decode($request->input('POST_BODY'));
        $permasalahan = $json->permasalahan;
        
        $user = Auth::user();
        $realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $realisasi_anggaran_target_pjb->user);
        $realisasi_anggaran_target_pjb->decrypt($decryption_key, NULL, false);
        
        $plaintext_data = $realisasi_anggaran_target_pjb->plaintext_data;
        $plaintext_data->permasalahan = $permasalahan;

        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = hex2bin($realisasi_anggaran_target_pjb->iv);  // IV gak diubah        
        
        $realisasi_anggaran_target_pjb->plaintext_data = $plaintext_data;
        $realisasi_anggaran_target_pjb->encrypt($encryption_key, $iv_bin);
        $realisasi_anggaran_target_pjb->save();
                
        return redirect()->route('realisasi_anggaran_target_pjbs.show', $id)->with('message2', 'Sukses memperbaharui penyebab dan rekomendasi permasalahan.');
        
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $Realisasi_anggaran_target_pjb = Realisasi_anggaran_target_pjb::find($id);
        if ($Realisasi_anggaran_target_pjb != null) {
            $Realisasi_anggaran_target_pjb->delete();

            if ($Realisasi_anggaran_target_pjb != null) {
                $realisasi_anggaran_triwulan_berjalan = Realisasi_anggaran_triwulan_berjalan::Where('id_realisasi', $id)->first();
                if ($realisasi_anggaran_triwulan_berjalan != null) {
                    $realisasi_anggaran_triwulan_berjalan->delete();
                }
            }
        }
        return redirect()->route('realisasi_anggaran_target_pjbs.index')->with('message', 'Data berhasil dihapus.');
    }

}
