<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Penyerapan_anggaran_setahun_pjb;
use Illuminate\Http\Request;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\User;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;
use PHPExcel_IOFactory;
function I($str) // currency to int
{
    return floatval(preg_replace("/[^0-9\.\-]/","",$str));
}
class PJBSetahunController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $user = Auth::user();
        $Penyerapan_anggaran_setahun_pjbs = Penyerapan_anggaran_setahun_pjb::orderBy('id', 'asc')->get();
          foreach ($Penyerapan_anggaran_setahun_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }
        return view('pjb_setahun.index', compact('Penyerapan_anggaran_setahun_pjbs'));
    }
    

    public function store(Request $request) {
        $this->validate($request, [
            'tahun' => 'required',
            'jumlah_paket' => 'required',
            'nilai_paket' => 'required'
        ]);
        $user = Auth::user();
        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));
        $status=false;
        
        $tahun=$request->input("tahun");
        $Penyerapan_anggaran_setahun_pjbs = Penyerapan_anggaran_setahun_pjb::get();
         foreach ($Penyerapan_anggaran_setahun_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if( $row->tahun==  $tahun)
                $status=true;
        }
        $data_plaintext = new stdClass();
        $Penyerapan_anggaran_setahun_pjb = new Penyerapan_anggaran_setahun_pjb();
        if($status){
            return redirect()->route('pjb_setahun.create')->with('message', 'Membuat PJB Setahun gagal. Sudah ada PJB di tahun '.$tahun.''); 
        }
        else{
            $data_plaintext->tahun = $request->input("tahun");
            $data_plaintext->target_paket_pjb = $request->input("jumlah_paket");
            $data_plaintext->nilai_paket_pjb =  I($request->input("nilai_paket"));


            $Penyerapan_anggaran_setahun_pjb->plaintext_data = $data_plaintext;
            $Penyerapan_anggaran_setahun_pjb->user_id = $user->id;
            $Penyerapan_anggaran_setahun_pjb->encrypt($encryption_key, $iv_bin);
            $Penyerapan_anggaran_setahun_pjb->save();

            return redirect()->route('pjb_setahun.index')->with('message', 'Simpan Berhasil.');
        }
    }

    public function update(Request $request, $id) {
       $this->validate($request, [
            'tahun' => 'required',
            'jumlah_paket' => 'required',
            'nilai_paket' => 'required'
        ]);
        $user = Auth::user();
        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));
    
        $data_plaintext = new stdClass();
        $Penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::where('id',$id)->first();

        $data_plaintext->tahun = $request->input("tahun");
        $data_plaintext->target_paket_pjb = $request->input("jumlah_paket");
        $data_plaintext->nilai_paket_pjb =  I($request->input("nilai_paket"));


        $Penyerapan_anggaran_setahun_pjb->plaintext_data = $data_plaintext;
        $Penyerapan_anggaran_setahun_pjb->user_id = $user->id;
        $Penyerapan_anggaran_setahun_pjb->encrypt($encryption_key, $iv_bin);
        $Penyerapan_anggaran_setahun_pjb->save();


        return redirect()->route('pjb_setahun.index')->with('message', 'Memperbaharui berhasil.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('pjb_setahun.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $Penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::findOrFail($id);

        return view('pjb_setahun.show', compact('Penyerapan_anggaran_setahun_pjb'));
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
        $Penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::where('id',$id)->first();
        $Penyerapan_anggaran_setahun_pjb->decrypt($decryption_key);
        return view('pjb_setahun.edit', compact('Penyerapan_anggaran_setahun_pjb'));
    }

    public function destroy($id) {
        $Penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::find($id);
        $Penyerapan_anggaran_setahun_pjb->delete();
        return redirect()->route('pjb_setahun.index')->with('message', 'Data berhasil dihapus.');
    }

}
