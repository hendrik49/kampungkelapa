<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Progres_pjb;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_target_pjb;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;
use PHPExcel_IOFactory;

function I($str) // currency to int
{
    return floatval(preg_replace("/[^0-9\.\-]/","",$str));
}

class Progres_pjbController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();

        if($user->role=="M")
            $progres_pjbs = Progres_pjb::orderBy('id', 'desc')->get();
        else
            $progres_pjbs = Progres_pjb::Where('user_id',$user->id)->orderBy('id', 'desc')->get();

        foreach ($progres_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
        }
        //return compact('progres_pjbs');
        return view('progres_pjbs.index', compact('progres_pjbs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {  
        $user = Auth::user();
        if($user->role=="M")
            $pjbs = Penyerapan_anggaran_setahun_pjb::get();        
        else
            $pjbs = Penyerapan_anggaran_setahun_pjb::Where('user_id',$user->id)->get();

        if($pjbs!=null){
            foreach ($pjbs as $row) {
                $decryption_key = Crypto::getDecryptionKey($user, $row->user);
                $row->decrypt($decryption_key);
                //$row->getDipa();
            }
        }

        return view('progres_pjbs.create',compact('user','pjbs'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_dipa' => 'required',
            'satuan_kerja' => 'required',
            'triwulan' => 'required',
            'tanggal_dipa' => 'required|Date',
            'jumlah_paket_belum_dilelang' => 'required',
            'nilai_pjb_belum_dilelang' => 'required',
            'jumlah_paket_pemenang' => 'required', 
            'nilai_pjb_pemenang' => 'required',
            'jumlah_paket_belum_realisasi' => 'required',
            'nilai_pjb_belum_realisasi' => 'required',
            'jumlah_paket_level1' => 'required',
            'nilai_pjb_level1' => 'required',
            'jumlah_paket_level2' => 'required',
            'nilai_pjb_level2' => 'required',
            'jumlah_paket_level2' => 'required',
            'nilai_pjb_level2' => 'required',
            'jumlah_paket_level3' => 'required',
            'nilai_pjb_level3' => 'required',
            'jumlah_paket_level4' => 'required',
            'nilai_pjb_level4' => 'required',
            'jumlah_paket_level5' => 'required',
            'nilai_pjb_level5' => 'required'
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());

        $progres_pjb = new Progres_pjb();
        $data_plaintext = new stdClass();

        $data_plaintext->triwulan = $request->input("triwulan");
        $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
        $id_penyerapan_setahun = $request->input("nama_dipa"); // WTF

        $pjbs = Penyerapan_anggaran_setahun_pjb::Where('id', $id_penyerapan_setahun)->first();
        if ($pjbs!=null){
            $pjbs->decrypt($decryption_key);
            $pjbs->getDipa();
            $data_plaintext->target_pjb=$pjbs->target_paket_pjb;
            $data_plaintext->nilai_pjb=$pjbs->nilai_paket_pjb;
            $data_plaintext->nama_dipa = $pjbs->id;
            $data_plaintext->tahun_anggaran = $pjbs->tahun;
        }        

        $data_plaintext->tanggal_dipa                 = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');        
        $data_plaintext->status                       = "DRAFT";
        $data_plaintext->jumlah_paket_belum_dilelang  = I($request->input("jumlah_paket_belum_dilelang"));
        $data_plaintext->nilai_pjb_belum_dilelang     = I($request->input("nilai_pjb_belum_dilelang")); 
        $data_plaintext->jumlah_paket_pemenang        = I($request->input("jumlah_paket_pemenang"));               
        $data_plaintext->nilai_pjb_pemenang           = I($request->input("nilai_pjb_pemenang"));
        $data_plaintext->jumlah_paket_belum_realisasi = I($request->input("jumlah_paket_belum_realisasi"));
        $data_plaintext->nilai_pjb_belum_realisasi    = I($request->input("nilai_pjb_belum_realisasi"));
        $data_plaintext->jumlah_paket_level1          = I($request->input("jumlah_paket_level1"));
        $data_plaintext->nilai_pjb_level1             = I($request->input("nilai_pjb_level1"));
        $data_plaintext->jumlah_paket_level2          = I($request->input("jumlah_paket_level2"));
        $data_plaintext->nilai_pjb_level2             = I($request->input("nilai_pjb_level2"));
        $data_plaintext->jumlah_paket_level3          = I($request->input("jumlah_paket_level3"));
        $data_plaintext->nilai_pjb_level3             = I($request->input("nilai_pjb_level3"));
        $data_plaintext->jumlah_paket_level4          = I($request->input("jumlah_paket_level4"));
        $data_plaintext->nilai_pjb_level4             = I($request->input("nilai_pjb_level4"));
        $data_plaintext->jumlah_paket_level5          = I($request->input("jumlah_paket_level5"));
        $data_plaintext->nilai_pjb_level5             = I($request->input("nilai_pjb_level5"));

        $data_plaintext->permasalahan = [];
        
        $jumlah= I($request->input("jumlah_paket_belum_dilelang"))+
        I($request->input("jumlah_paket_pemenang"))+               
        I($request->input("jumlah_paket_belum_realisasi"))+
        I($request->input("jumlah_paket_level1"))+
        I($request->input("jumlah_paket_level2"))+
        I($request->input("jumlah_paket_level3"))+
        I($request->input("jumlah_paket_level4"))+
        I($request->input("jumlah_paket_level5"));

        $nilai = I($request->input("nilai_pjb_belum_dilelang"))+
        I($request->input("nilai_pjb_pemenang"))+
        I($request->input("nilai_pjb_belum_realisasi"))+
        I($request->input("nilai_pjb_level1"))+
        I($request->input("nilai_pjb_level2"))+
        I($request->input("nilai_pjb_level3"))+
        I($request->input("nilai_pjb_level4"))+
        I($request->input("nilai_pjb_level5"));

        $status = false;
        $pjb = Progres_pjb::orderBy('id', 'desc')->get();
        
        foreach ($pjb as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if ($row->triwulan == $data_plaintext->triwulan && $row->id_anggaran==$id_penyerapan_setahun)
                $status = true;
        }

        if($status){
            return redirect()->route('progres_pjbs.create')->with('message', 'Membuat Progres Anggaran ' . $pjbs->id . ' gagal. Sudah ada progres anggaran di triwulan '.$data_plaintext->triwulan.'');
        }
        else if($nilai!=$pjbs->nilai_paket_pjb){
            return redirect()->route('progres_pjbs.create')->with('message', 'Membuat Progres Anggaran ' . $pjbs->id . ' gagal.  Nilai paket input ('.number_format($nilai,2).') tidak sama dengan nilai paket pjb ('.number_format($pjbs->nilai_paket_pjb,2).')');
        }else if($jumlah!=$pjbs->target_paket_pjb){
            return redirect()->route('progres_pjbs.create')->with('message', 'Membuat Progres Anggaran ' . $pjbs->id . ' gagal.  Nilai paket input ('.number_format($jumlah).') tidak sama dengan nilai paket pjb ('.number_format($pjbs->target_paket_pjb).')');
        }
        else{
            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $progres_pjb->plaintext_data = $data_plaintext;
            $progres_pjb->id_anggaran = $id_penyerapan_setahun;
            $progres_pjb->user_id = $user->id;
            $progres_pjb->encrypt($encryption_key, $iv_bin);
            $progres_pjb->save();

            return redirect()->route('progres_pjbs.index')->with('message', 'Sukses membuat progres pengadaan PBJ.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();    
        $progres_pjb = Progres_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $progres_pjb->user);
        $progres_pjb->decrypt($decryption_key);
        
        $penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::Where('id',$progres_pjb->id_anggaran)->first();
        $penyerapan_anggaran_setahun_pjb->decrypt($decryption_key);
        
        if (!isset($progres_pjb->permasalahan))
            $progres_pjb->permasalahan = [];  
        
        return view('progres_pjbs.show', compact('progres_pjb','user','penyerapan_anggaran_setahun_pjb'));
        
    }

    
    public function permasalahan($id) {
        
        $user = Auth::user();
        $progres_pjb = Progres_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $progres_pjb->user);
        $progres_pjb->decrypt($decryption_key);        
        
        if (!isset($progres_pjb->permasalahan))
            $progres_pjb->permasalahan = [];        
        
        $permasalahan = $progres_pjb->permasalahan;
        
        $permasalahan = json_encode($permasalahan);
        
        return view('progres_pjbs.permasalahan', compact('permasalahan', 'progres_pjb'));
        
    }    
    
    public function permasalahanSave(Request $request, $id) {
        
        $json = json_decode($request->input('POST_BODY'));
        $permasalahan = $json->permasalahan;
        
        $user = Auth::user();
        $progres_pjb = Progres_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $progres_pjb->user);
        $progres_pjb->decrypt($decryption_key, NULL, false);
        
        $plaintext_data = $progres_pjb->plaintext_data;
        $plaintext_data->permasalahan = $permasalahan;

        $encryption_key = hex2bin($user->getCryptoKey());
        $iv_bin = hex2bin($progres_pjb->iv);  // IV gak diubah        
        
        $progres_pjb->plaintext_data = $plaintext_data;
        $progres_pjb->encrypt($encryption_key, $iv_bin);
        $progres_pjb->save();
                
        return redirect()->route('progres_pjbs.show', $id)->with('message2', 'Sukses memperbaharui penyebab dan rekomendasi permasalahan.');
        
    }    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function jenis($id)
    {
        $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::findOrFail($id);

        return  compact('penyerapan_anggaran_perjenis_belanja');
    }
    
    public function edit($id)
    {
        
        $user = Auth::user();    
        $progres_pjb = Progres_pjb::findOrFail($id);
        $decryption_key = Crypto::getDecryptionKey($user, $progres_pjb->user);
        $progres_pjb->decrypt($decryption_key);
        
        $penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::Where('id',$progres_pjb->id_anggaran)->first();
        $penyerapan_anggaran_setahun_pjb->decrypt($decryption_key);
        $penyerapan_anggaran_setahun_pjb->getDipa();
        
        return view('progres_pjbs.edit', compact('progres_pjb','user','penyerapan_anggaran_setahun_pjb'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_dipa' => 'required',
            'satuan_kerja' => 'required',
            'triwulan' => 'required',
            'tanggal_dipa' => 'required|Date',
            'jumlah_paket_belum_dilelang' => 'required',
            'nilai_pjb_belum_dilelang' => 'required',
            'jumlah_paket_pemenang' => 'required', 
            'nilai_pjb_pemenang' => 'required',
            'jumlah_paket_belum_realisasi' => 'required',
            'nilai_pjb_belum_realisasi' => 'required',
            'jumlah_paket_level1' => 'required',
            'nilai_pjb_level1' => 'required',
            'jumlah_paket_level2' => 'required',
            'nilai_pjb_level2' => 'required',
            'jumlah_paket_level2' => 'required',
            'nilai_pjb_level2' => 'required',
            'jumlah_paket_level3' => 'required',
            'nilai_pjb_level3' => 'required',
            'jumlah_paket_level4' => 'required',
            'nilai_pjb_level4' => 'required',
            'jumlah_paket_level5' => 'required',
            'nilai_pjb_level5' => 'required'
        ]);

        $user = Auth::user();
        $decryption_key = hex2bin($user->getCryptoKey());
        $progres_pjb = Progres_pjb::find($id);
        if($progres_pjb==null)
        {
            return redirect()->route('progres_pjbs.edit')->with('message', 'Progres PJB '.$id.' tidak ditemukan.');            
        }else{
    
        $data_plaintext = new stdClass();

        $data_plaintext->triwulan = $request->input("triwulan");
        $data_plaintext->satuan_kerja = $request->input("satuan_kerja");
        $id_penyerapan_setahun = $request->input("nama_dipa"); // WTF

        $pjbs = Penyerapan_anggaran_setahun_pjb::Where('id', $id_penyerapan_setahun)->first();
        if ($pjbs!=null){
            $pjbs->decrypt($decryption_key);
            $pjbs->getDipa();
            $data_plaintext->target_pjb=$pjbs->target_paket_pjb;
            $data_plaintext->nilai_pjb=$pjbs->nilai_paket_pjb;
            $data_plaintext->nama_dipa = $pjbs->id;
            $data_plaintext->tahun_anggaran = $pjbs->tahun;            
        }
        
        $progres_pjb->decrypt($decryption_key, NULL, false);
        
        $data_plaintext->tanggal_dipa                 = Carbon::parse($request->input("tanggal_dipa"))->format('Y-m-d');        
        $data_plaintext->status                       = $request->input("status");
        $data_plaintext->jumlah_paket_belum_dilelang  = I($request->input("jumlah_paket_belum_dilelang"));
        $data_plaintext->nilai_pjb_belum_dilelang     = I($request->input("nilai_pjb_belum_dilelang")); 
        $data_plaintext->jumlah_paket_pemenang        = I($request->input("jumlah_paket_pemenang"));               
        $data_plaintext->nilai_pjb_pemenang           = I($request->input("nilai_pjb_pemenang"));
        $data_plaintext->jumlah_paket_belum_realisasi = I($request->input("jumlah_paket_belum_realisasi"));
        $data_plaintext->nilai_pjb_belum_realisasi    = I($request->input("nilai_pjb_belum_realisasi"));
        $data_plaintext->jumlah_paket_level1          = I($request->input("jumlah_paket_level1"));
        $data_plaintext->nilai_pjb_level1             = I($request->input("nilai_pjb_level1"));
        $data_plaintext->jumlah_paket_level2          = I($request->input("jumlah_paket_level2"));
        $data_plaintext->nilai_pjb_level2             = I($request->input("nilai_pjb_level2"));
        $data_plaintext->jumlah_paket_level3          = I($request->input("jumlah_paket_level3"));
        $data_plaintext->nilai_pjb_level3             = I($request->input("nilai_pjb_level3"));
        $data_plaintext->jumlah_paket_level4          = I($request->input("jumlah_paket_level4"));
        $data_plaintext->nilai_pjb_level4             = I($request->input("nilai_pjb_level4"));
        $data_plaintext->jumlah_paket_level5          = I($request->input("jumlah_paket_level5"));
        $data_plaintext->nilai_pjb_level5             = I($request->input("nilai_pjb_level5"));

        // jangan timpa permasalahan
        if (isset($progres_pjb->plaintext_data->permasalahan))
            $data_plaintext->permasalahan = $progres_pjb->plaintext_data->permasalahan;
        else
            $data_plaintext->permasalahan = [];
        
        $jumlah= I($request->input("jumlah_paket_belum_dilelang"))+
        I($request->input("jumlah_paket_pemenang"))+               
        I($request->input("jumlah_paket_belum_realisasi"))+
        I($request->input("jumlah_paket_level1"))+
        I($request->input("jumlah_paket_level2"))+
        I($request->input("jumlah_paket_level3"))+
        I($request->input("jumlah_paket_level4"))+
        I($request->input("jumlah_paket_level5"));

        $nilai = I($request->input("nilai_pjb_belum_dilelang"))+
        I($request->input("nilai_pjb_pemenang"))+
        I($request->input("nilai_pjb_belum_realisasi"))+
        I($request->input("nilai_pjb_level1"))+
        I($request->input("nilai_pjb_level2"))+
        I($request->input("nilai_pjb_level3"))+
        I($request->input("nilai_pjb_level4"))+
        I($request->input("nilai_pjb_level5"));

        if($nilai!=$pjbs->nilai_paket_pjb){
            return redirect()->route('progres_pjbs.create')->with('message', 'Membuat Progres Anggaran ' . $pjbs->id . ' gagal.  Nilai paket input ('.number_format($nilai,2).') tidak sama dengan nilai paket pjb ('.number_format($pjbs->nilai_paket_pjb,2).')');
        }else if($jumlah!=$pjbs->target_paket_pjb){
            return redirect()->route('progres_pjbs.create')->with('message', 'Membuat Progres Anggaran ' . $pjbs->id . ' gagal.  Nilai paket input ('.number_format($jumlah).') tidak sama dengan nilai paket pjb ('.number_format($pjbs->target_paket_pjb).')');
        }
        else{

            $encryption_key = hex2bin($user->getCryptoKey());
            $iv_bin = openssl_random_pseudo_bytes(config('crypto.cipher_iv_size'));

            $progres_pjb->plaintext_data = $data_plaintext;
            $progres_pjb->id_anggaran = $id_penyerapan_setahun;
            $progres_pjb->user_id = $user->id;
            $progres_pjb->encrypt($encryption_key, $iv_bin);
            $progres_pjb->save();

            return redirect()->route('progres_pjbs.index')->with('message', 'Sukses memperbaharui progres pengadaan PBJ.');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $progres_pjb = Progres_pjb::find($id);
        if($progres_pjb !=null)
            $progres_pjb->delete();

        $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::find($id);
        if($penyerapan_anggaran_perjenis_belanja!=null)
            $penyerapan_anggaran_perjenis_belanja->delete();

        $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::find($id);
        if($penyerapan_anggaran_triwulan_modal!=null)   
            $penyerapan_anggaran_triwulan_modal->delete();

        $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::find($id);
        if($penyerapan_anggaran_triwulan_barang!=null)   
            $penyerapan_anggaran_triwulan_barang->delete();

        $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::find($id);
        if($penyerapan_anggaran_triwulan_lainnya!=null)
           $penyerapan_anggaran_triwulan_lainnya->delete();

        $Penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_modal::find($id);
       if($Penyerapan_anggaran_triwulan_barang!=null)
           $Penyerapan_anggaran_triwulan_barang ->delete();


        $penyerapan_anggaran_setahun_pjb = Penyerapan_anggaran_setahun_pjb::find($id);
        if($penyerapan_anggaran_setahun_pjb!=null)  
            $penyerapan_anggaran_setahun_pjb->delete();


        return redirect()->route('progres_pjbs.index')->with('message', 'Data berhasil dihapus.');
    }

    
}
