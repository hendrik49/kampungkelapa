<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Kop_spp;
use Illuminate\Http\Request;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_target_pjb;
use App\User;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;
use PHPExcel_IOFactory;

function I($str) // currency to int
{
    return floatval(preg_replace("/[^0-9\.\-]/","",$str));
}
class Kop_sppController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();
        
        if ($user->role == "M"){
            $kop_spp = Kop_spp::orderBy('id', 'asc')->get();
            foreach ($kop_spp as $row) {
                $decryption_key = Crypto::getDecryptionKey($user, $row->user);
                $row->decrypt($decryption_key);
                $row->no_kontrak .= "/" .$row->tgl_kontrak;
                $row->no_bap .= "/" .$row->tgl_bap;
                $row->no_bast .= "/" .$row->tgl_bast;
                $row->getDipa();
            }
        }else{
            $kop_spp = Kop_spp::Where('user_id',$user->id)->orderBy('id', 'asc')->get();
            foreach ($kop_spp as $row) {
                $decryption_key = Crypto::getDecryptionKey($user, $row->user);
                $row->decrypt($decryption_key);
                $row->no_kontrak .= "/" .$row->tgl_kontrak;
                $row->no_bap .= "/" .$row->tgl_bap;
                $row->no_bast .= "/" .$row->tgl_bast;
                $row->getDipa();
            }
        }
        return view('kop_spp.index', compact('kop_spp'));
    }
    

    public function store(Request $request) {
        $this->validate($request, [
            'jenis' => 'required',
            'kategori_uraian' => 'required',
            'id_anggaran' => 'required',
            'no_kop' => 'required',
            'tgl_kop' => 'required',
            'uraian_kop' => 'required',
            'nilai_kop'=>'required',
            'no_spp' => 'required',
            'tgl_spp' => 'required',
            'uraian_kop' => 'required',
            'nilai_spp'=>'required',            
            'no_bap' => 'required',
            'no_bast' => 'required',
            'no_kontrak' => 'required',
            'no_spp' => 'required',
            'nilai_kontrak' => 'required',
            'tgl_bap' => 'required',
            'tgl_bast' => 'required',
            'tgl_kontrak' => 'required'
        ]);

        $user = Auth::user();
        $encryption_key = hex2bin($user->getCryptoKey());
        $decryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));
        $status=false;
                
        $data_plaintext = new stdClass();
        $Kop_spp = new Kop_spp();
        $nilai_kop = I($request->input("nilai_kop"));
        $nilai_spp = I($request->input("nilai_spp"));
        $id_anggaran = $request->input("id_anggaran");
        $jenis = $request->input("jenis");
        $penyerapan_anggaran_perjenis = Penyerapan_anggaran_perjenis_belanja::find($id_anggaran);
        $penyerapan_anggaran_perjenis->decrypt($decryption_key);
        $Kop_spps = Kop_spp::where('id_anggaran',$id_anggaran)->get();

        $sum_kop_modal=0;
        $sum_kop_barang=0;
        $sum_kop_lainnya=0;
        foreach ($Kop_spps as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if($row->type_belanja=="m")
                $sum_kop_modal +=$row->nilai_kop;
            else if($row->type_belanja=="b")
                $sum_kop_barang +=$row->nilai_kop;
            else if($row->type_belanja=="l")
                $sum_kop_lainnya +=$row->nilai_kop;
        }
        if($jenis=="m")
            $sum_kop_modal += $nilai_kop;
        else if($jenis=="b")
           $sum_kop_barang += $nilai_kop;
        else if($jenis=="l")
            $sum_kop_lainnya += $nilai_kop;

        if($jenis=="m" && $penyerapan_anggaran_perjenis->belanja_modal < $sum_kop_modal){
            return redirect()->route('kop_spp.create')->with('message', 'Membuat KOP dan  SPP gagal. Jumlah Nilai Keseluruhan KOP Modal ('.number_format($sum_kop_modal).') lebih besar dari Rencana Belanja Modal ('.number_format($penyerapan_anggaran_perjenis->belanja_modal).')'); 
        }
        else if($jenis=="l" && $penyerapan_anggaran_perjenis->belanja_lainnya < $sum_kop_lainnya){
            return redirect()->route('kop_spp.create')->with('message', 'Membuat KOP dan  SPP gagal. Jumlah Nilai Keseluruhan KOP Lainnya ('.number_format($sum_kop_lainnya).') lebih besar dari Rencana Belanja Lainnya ('.number_format($penyerapan_anggaran_perjenis->belanja_lainnya).')'); 
        }
        else if($jenis=="b" && $penyerapan_anggaran_perjenis->belanja_barang < $sum_kop_barang){
            return redirect()->route('kop_spp.create')->with('message', 'Membuat KOP dan  SPP gagal. Jumlah Nilai Keseluruhan KOP Barang ('.number_format($sum_kop_barang).') lebih besar dari Rencana Belanja Barang ('.number_format($penyerapan_anggaran_perjenis->belanja_barang).')'); 
        }
        else if($nilai_kop < $nilai_spp){
            return redirect()->route('kop_spp.create')->with('message', 'Membuat KOP dan  SPP gagal. Nilai SPP ('.number_format($nilai_spp).') lebih besar dari nilai KOP ('.number_format($nilai_kop).')'); 
        }
        else{
            $data_plaintext->kategori_uraian = $request->input("kategori_uraian");
            $data_plaintext->no_kop = $request->input("no_kop");
            $data_plaintext->tgl_kop =  $request->input("tgl_kop");
            $data_plaintext->uraian_kop =  $request->input("uraian_kop");
            $data_plaintext->nilai_kop =  I($request->input("nilai_kop"));
            $data_plaintext->no_spp = $request->input("no_spp");
            $data_plaintext->tgl_spp =  $request->input("tgl_spp");
            $data_plaintext->uraian_spp =  $request->input("uraian_spp");
            $data_plaintext->nilai_spp =  I($request->input("nilai_spp"));

            $data_plaintext->no_kontrak = $request->input("no_kontrak");
            $data_plaintext->no_bap = $request->input("no_bap");
            $data_plaintext->no_bast = $request->input("no_bast");
            $data_plaintext->tgl_bap = $request->input("tgl_bap");
            $data_plaintext->tgl_bast = $request->input("tgl_bast");
            $data_plaintext->tgl_kontrak = $request->input("tgl_kontrak");
            
            $data_plaintext->nilai_kontrak =  I($request->input("nilai_kontrak"));


            $Kop_spp->tahun = date('Y');
            $Kop_spp->id_anggaran = $request->input("id_anggaran");
            $Kop_spp->type_belanja = $request->input("jenis");
            $Kop_spp->plaintext_data = $data_plaintext;
            $Kop_spp->user_id = $user->id;
            $Kop_spp->encrypt($encryption_key, $iv_bin);
            $Kop_spp->save();

            return redirect()->route('kop_spp.index')->with('message2', 'Simpan Berhasil.');
        }
    }

    public function update(Request $request, $id) {
       $this->validate($request, [
            'jenis' => 'required',
            'kategori_uraian' => 'required',
            'id_anggaran' => 'required',
            'no_kop' => 'required',
            'tgl_kop' => 'required',
            'uraian_kop' => 'required',
            'nilai_kop'=>'required',
            'no_spp' => 'required',
            'tgl_spp' => 'required',
            'uraian_kop' => 'required',
            'nilai_spp'=>'required',            
            'no_bap' => 'required',
            'no_bast' => 'required',
            'no_kontrak' => 'required',
            'no_spp' => 'required',
            'nilai_kontrak' => 'required',
            'tgl_kontrak' => 'required',
            'tgl_bap' => 'required',
            'tgl_bast' => 'required'
        ]);


        $user = Auth::user();
        $encryption_key = hex2bin($user->getCryptoKey());
        $decryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));
    
        $data_plaintext = new stdClass();
        $Kop_spp = Kop_spp::where('id',$id)->first();

        $nilai_kop = I($request->input("nilai_kop"));
        $nilai_spp = I($request->input("nilai_spp"));

        $id_anggaran = $request->input("id_anggaran");
        $jenis = $request->input("jenis");
        $penyerapan_anggaran_perjenis = Penyerapan_anggaran_perjenis_belanja::find($id_anggaran);
        $penyerapan_anggaran_perjenis->decrypt($decryption_key);
        $Kop_spps = Kop_spp::where('id_anggaran',$id_anggaran)->get();
        
        $sum_kop_modal=0;
        $sum_kop_barang=0;
        $sum_kop_lainnya=0;
        foreach ($Kop_spps as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if($row->type_belanja=="m")
                $sum_kop_modal +=$row->nilai_kop;
            else if($row->type_belanja=="b")
                $sum_kop_barang +=$row->nilai_kop;
            else if($row->type_belanja=="l")
                $sum_kop_lainnya +=$row->nilai_kop;
        }

        if($jenis=="m" && $penyerapan_anggaran_perjenis->belanja_modal < $sum_kop_modal){
            return redirect()->route('kop_spp.edit', $id)->with('message', 'Membuat KOP dan  SPP gagal. Nilai Keseluruhan KOP Modal ('.number_format($sum_kop_modal).') lebih besar dari Rencana Belanja Modal ('.number_format($penyerapan_anggaran_perjenis->belanja_modal).')'); 
        }
        else if($jenis=="l" && $penyerapan_anggaran_perjenis->belanja_lainnya < $sum_kop_lainnya){
            return redirect()->route('kop_spp.edit', $id)->with('message', 'Membuat KOP dan  SPP gagal. Nilai Keseluruhan KOP Lainnya ('.number_format($sum_kop_lainnya).') lebih besar dari Rencana Belanja Lainnya ('.number_format($penyerapan_anggaran_perjenis->belanja_lainnya).')'); 
        }
        else if($jenis=="b" && $penyerapan_anggaran_perjenis->belanja_barang <  $sum_kop_barang){
            return redirect()->route('kop_spp.edit', $id)->with('message', 'Membuat KOP dan  SPP gagal. Nilai Keseluruhan KOP Barang ('.number_format($sum_kop_barang).') lebih besar dari Rencana Belanja Barang ('.number_format($penyerapan_anggaran_perjenis->belanja_barang).')'); 
        }
        else if($nilai_kop < $nilai_spp){
            return redirect()->route('kop_spp.edit', $id)->with('message', 'Membuat KOP dan  SPP gagal. Nilai SPP ('.$nilai_spp.') lebih besar dari nilai KOP ('.$nilai_kop.')'); 
        }
        else{
        $data_plaintext->kategori_uraian = $request->input("kategori_uraian");
        $data_plaintext->no_kop = $request->input("no_kop");
        $data_plaintext->tgl_kop =  $request->input("tgl_kop");
        $data_plaintext->uraian_kop =  $request->input("uraian_kop");
        $data_plaintext->nilai_kop =  I($request->input("nilai_kop"));
        $data_plaintext->no_spp = $request->input("no_spp");
        $data_plaintext->tgl_spp =  $request->input("tgl_spp");
        $data_plaintext->uraian_spp =  $request->input("uraian_spp");
        $data_plaintext->nilai_spp =  I($request->input("nilai_spp"));
    
        $data_plaintext->no_kontrak = $request->input("no_kontrak");
        $data_plaintext->no_bap = $request->input("no_bap");
        $data_plaintext->no_bast = $request->input("no_bast");
        $data_plaintext->tgl_bap = $request->input("tgl_bap");
        $data_plaintext->tgl_bast = $request->input("tgl_bast");
        $data_plaintext->tgl_kontrak = $request->input("tgl_kontrak");

        $data_plaintext->nilai_kontrak =  I($request->input("nilai_kontrak"));

        $Kop_spp->tahun = date('Y');
        $Kop_spp->id_anggaran =  $request->input("id_anggaran");
        $Kop_spp->type_belanja = $request->input("jenis");
        $Kop_spp->plaintext_data = $data_plaintext;
        $Kop_spp->user_id = $user->id;
        $Kop_spp->encrypt($encryption_key, $iv_bin);
        $Kop_spp->save();

        return redirect()->route('kop_spp.index')->with('message2', 'Memperbaharui berhasil.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $user = Auth::user();
        $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('user_id', $user->id)->orderBy('id', 'desc')->get();

        foreach ($penyerapan_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }

        return view('kop_spp.create',compact('user','penyerapan_anggaran_target_pjbs'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $Kop_spp = Kop_spp::findOrFail($id);

        return view('kop_spp.show', compact('Kop_spp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {        
        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $Kop_spp = Kop_spp::where('id',$id)->first();
        $Kop_spp->decrypt($decryption_key);
        $penyerapan_anggaran_target_pjbs = Penyerapan_anggaran_target_pjb::Where('id', $Kop_spp->id_anggaran)->orderBy('id', 'desc')->get();

        foreach ($penyerapan_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }

        return view('kop_spp.edit', compact('Kop_spp','user','penyerapan_anggaran_target_pjbs','Kop_spp'));
    }

    public function destroy($id) {
        $Kop_spp = Kop_spp::find($id);
        $Kop_spp->delete();
        return redirect()->route('kop_spp.index')->with('message', 'Data berhasil dihapus.');
    }

}
