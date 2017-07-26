<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use \stdClass;
use Illuminate\Support\Facades\DB;
use App\Helpers\Crypto;

function parseFloat($value) {
    return floatval(preg_replace("/[^0-9\.\-]/", "", $value));
}

class LaporanController extends Controller {

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param Request $request
     * @return Response
     */  
     
      public function jumlahpetani() {

        $user = Auth::user(); 

        $data = DB::table('user_detail')
        ->join('ref_district', 'ref_district.id', '=', 'user_detail.district')
        ->select(DB::raw('ref_district.name as kecamatan, count(user_detail.district) as jumlah'))
        ->where('user_detail.user_type','user')
        ->groupBy('user_detail.district')
        ->get();

        return view('laporan.index', compact('data'));

      }

     public function jumlahproduk()
    {
        $user = Auth::user(); 
        $data = DB::table('view_pie_commodity')->select('*')->OrderBy('count','desc')->get();
        return view('laporan.index_produk', compact('data'));
    }


}
