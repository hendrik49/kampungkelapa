<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Models\Realisasi_anggaran_target_pjb;
use App\Models\Realisasi_anggaran_triwulan_berjalan;
use App\Models\Realisasi_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\Models\Penyerapan_anggaran_target_pjb;
use App\Models\Progres_pjb;
use Illuminate\Support\Facades\Auth;
use \stdClass;
use App\Helpers\Crypto;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        //$notif = $user->getNotifikasiPengisian();
        
        return view('dashboard', compact('user'));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        $user =  User::get();
        return $user;
    }

    public function getProduktifYesNo()
    {
        $user = Auth::user(); 
        $data = DB::table('view_produktif_noproduktif')->select('*')->get();
        return  compact('data');
    }

     public function getProduktifJenis()
    {
        $user = Auth::user(); 
        $data = DB::table('view_commodity_for')->select('*')->get();
        return  compact('data');
    }

    
     public function getRealisasiPerjenis()
    {
        $user = Auth::user(); 
        $data = DB::table('view_pie_commodity')->select('*')->get();
        return  compact('data');
    }

    public function getDonutCommodity()
    {
        $user = Auth::user(); 
        $data = DB::table('view_pie_commodity')->select('*')->get();
        return  compact('data');
    }

     public function getDonutSetahunPaket()
    {
        $user = Auth::user(); 
        $year = date('Y');
        $month = date('m');
        $month= $this->getTriwulan($month);
        $data = new stdClass();
        $data->year =  $year;
        $data->jumlah_paket_belum_dilelang =  0;
        $data->nilai_pjb_belum_dilelang    =  0;
        $data->jumlah_paket_pemenang       =  0;         
        $data->nilai_pjb_pemenang          =  0;
        $data->jumlah_paket_belum_realisasi=  0;
        $data->nilai_pjb_belum_realisasi   =  0;
        $data->jumlah_paket_level1         =  0;
        $data->nilai_pjb_level1            =  0;
        $data->jumlah_paket_level2         =  0;
        $data->nilai_pjb_level2            =  0;
        $data->jumlah_paket_level3         =  0;
        $data->nilai_pjb_level3            =  0;
        $data->jumlah_paket_level4         =  0;
        $data->nilai_pjb_level4            =  0;
        $data->jumlah_paket_level5         =  0;
        $data->nilai_pjb_level5            =  0;

        $realisasi_anggaran_target_pjbs = Progres_pjb::orderBy('id', 'desc')->get();
        foreach ($realisasi_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
                if($row->tahun_anggaran==$year && $row->triwulan==$month){
                $data->jumlah_paket_belum_dilelang +=  $row->jumlah_paket_belum_dilelang;
                $data->nilai_pjb_belum_dilelang    +=  $row->nilai_pjb_belum_dilelang ; 
                $data->jumlah_paket_pemenang       +=  $row->jumlah_paket_pemenang ;               
                $data->nilai_pjb_pemenang          +=  $row->nilai_pjb_pemenang  ;
                $data->jumlah_paket_belum_realisasi+=  $row->jumlah_paket_belum_realisasi ;
                $data->nilai_pjb_belum_realisasi   +=  $row->nilai_pjb_belum_realisasi ;
                $data->jumlah_paket_level1         +=  $row->jumlah_paket_level1 ;
                $data->nilai_pjb_level1            +=  $row->nilai_pjb_level1 ;
                $data->jumlah_paket_level2         +=  $row->jumlah_paket_level2;
                $data->nilai_pjb_level2            +=  $row->nilai_pjb_level2 ;
                $data->jumlah_paket_level3         +=  $row->jumlah_paket_level3;
                $data->nilai_pjb_level3            +=  $row->nilai_pjb_level3;
                $data->jumlah_paket_level4         +=  $row->jumlah_paket_level4;
                $data->nilai_pjb_level4            +=  $row->nilai_pjb_level4;
                $data->jumlah_paket_level5         +=  $row->jumlah_paket_level5 ;
                $data->nilai_pjb_level5            +=  $row->nilai_pjb_level5 ;            
                }
        }
        return  compact('data');
    }

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

     public function getDonutSetahunNilai()
    {
        $user = Auth::user(); 
        $year = date('Y');
        $month = date('m');
        $month= $this->getTriwulan($month);

        $data = new stdClass();
        $data->year =  $year;
        $data->jumlah_paket_belum_dilelang =  0;
        $data->nilai_pjb_belum_dilelang    =  0;
        $data->jumlah_paket_pemenang       =  0;         
        $data->nilai_pjb_pemenang          =  0;
        $data->jumlah_paket_belum_realisasi=  0;
        $data->nilai_pjb_belum_realisasi   =  0;
        $data->jumlah_paket_level1         =  0;
        $data->nilai_pjb_level1            =  0;
        $data->jumlah_paket_level2         =  0;
        $data->nilai_pjb_level2            =  0;
        $data->jumlah_paket_level3         =  0;
        $data->nilai_pjb_level3            =  0;
        $data->jumlah_paket_level4         =  0;
        $data->nilai_pjb_level4            =  0;
        $data->jumlah_paket_level5         =  0;
        $data->nilai_pjb_level5            =  0;

        $realisasi_anggaran_target_pjbs = Progres_pjb::orderBy('id', 'desc')->get();
        foreach ($realisasi_anggaran_target_pjbs as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            if($row->tahun_anggaran==$year && $row->triwulan==$month){
                $data->jumlah_paket_belum_dilelang +=  $row->jumlah_paket_belum_dilelang;
                $data->nilai_pjb_belum_dilelang    +=  $row->nilai_pjb_belum_dilelang ; 
                $data->jumlah_paket_pemenang       +=  $row->jumlah_paket_pemenang ;               
                $data->nilai_pjb_pemenang          +=  $row->nilai_pjb_pemenang  ;
                $data->jumlah_paket_belum_realisasi+=  $row->jumlah_paket_belum_realisasi ;
                $data->nilai_pjb_belum_realisasi   +=  $row->nilai_pjb_belum_realisasi ;
                $data->jumlah_paket_level1         +=  $row->jumlah_paket_level1 ;
                $data->nilai_pjb_level1            +=  $row->nilai_pjb_level1 ;
                $data->jumlah_paket_level2         +=  $row->jumlah_paket_level2;
                $data->nilai_pjb_level2            +=  $row->nilai_pjb_level2 ;
                $data->jumlah_paket_level3         +=  $row->jumlah_paket_level3;
                $data->nilai_pjb_level3            +=  $row->nilai_pjb_level3;
                $data->jumlah_paket_level4         +=  $row->jumlah_paket_level4;
                $data->nilai_pjb_level4            +=  $row->nilai_pjb_level4;
                $data->jumlah_paket_level5         +=  $row->jumlah_paket_level5 ;
                $data->nilai_pjb_level5            +=  $row->nilai_pjb_level5 ;            
            }
        }
        return  compact('data');
    }


        public function getUserByEmail($email)
    {
        $user =  User::Where('email',$email)->get();
        return $user;
    }    
        public function getDataInstall()
    {
        $install =  DB::table('view_user_count')->get();
        return $install;
    }

    //DataClick
        public function getDataClickDay()
    {
        $clickday =  DB::table('view_by_click_per_day')->get();
        return $clickday;
    }
        public function getDataClickMonth()
    {
        $clickday =  DB::table('view_by_click_per_month')->get();
        return $clickday;
    }
        public function getDataClickYear()
    {
        $clickday =  DB::table('view_by_click_per_year')->get();
        return $clickday;
    } 

    //DataViewPage
        public function getDataViewPageDay()
    {
        $json = Array();
        $viewcategory = DB::table('view_by_view_page_perday')->select('view')->groupBy('view')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_by_view_page_perday')->select('view_day','count_view')->Where('view',$view->view)->get();
            $json[] = [ 'key'=>$view->view,'data'=> $viewpageday]; 
        }
        return $json;
    }
        public function getDataViewPageMonth()
    {
        $json = Array();
        $viewcategory = DB::table('view_by_view_page_permonth')->select('view')->groupBy('view')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_by_view_page_permonth')->select('view_month','count_view')->Where('view',$view->view)->get();
            $json[] = [ 'key'=>$view->view,'data'=> $viewpageday]; 
        }
        return $json;

    }
        public function getDataViewPageYear()
    {
        $json = Array();
        $viewcategory = DB::table('view_by_view_page_peryear')->select('view')->groupBy('view')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_by_view_page_peryear')->select('view_year','count_view')->Where('view',$view->view)->get();
            $json[] = [ 'key'=>$view->view,'data'=> $viewpageday]; 
        }
        return $json;
    }

    //DataActivityDevice
        public function getDataActivityDeviceDay()
    {
        $json = Array();
        $viewcategory = DB::table('view_activity_by_type_device_per_day')->select('type_device')->groupBy('type_device')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_activity_by_type_device_per_day')->select('activity_day','count_activity')->Where('type_device',$view->type_device)->get();
            $json[] = [ 'key'=>$view->type_device,'data'=> $viewpageday]; 
        }
        return $json;
    }
        public function getDataActivityDeviceMonth()
    {
        $json = Array();
        $viewcategory = DB::table('view_activity_by_type_device_per_month')->select('type_device')->groupBy('type_device')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_activity_by_type_device_per_month')->select('activity_day','count_activity')->Where('type_device',$view->type_device)->get();
            $json[] = [ 'key'=>$view->type_device,'data'=> $viewpageday]; 
        }
        return $json;
    }
        public function getDataActivityDeviceYear()
    {
        $json = Array();
        $viewcategory = DB::table('view_activity_by_type_device_per_year')->select('type_device')->groupBy('type_device')->get();
        foreach ($viewcategory  as $view) {
            $viewpageday =  DB::table('view_activity_by_type_device_per_year')->select('activity_day','count_activity')->Where('type_device',$view->type_device)->get();
            $json[] = [ 'key'=>$view->type_device,'data'=> $viewpageday]; 
        }
        return $json;
    }        
}
