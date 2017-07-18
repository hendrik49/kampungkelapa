<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => 'auth'], function(){

    Route::get('/dashboard', 'DashboardController@index');

    Route::get('/home', 'HomeController@index');
    Route::get('/admin', function () {
        return view('admin');
    });

    //Dashboard
    Route::get("/getProduktifYesNo", "DashboardController@getProduktifYesNo");
    Route::get("/getProduktifJenis", "DashboardController@getProduktifJenis");
    Route::get("/getDonutCommodity", "DashboardController@getDonutCommodity");
    Route::get("/getDonutSetahunPaket", "DashboardController@getDonutSetahunPaket");
    Route::get("/getDonutSetahunNilai", "DashboardController@getDonutSetahunPaket");
    Route::get("/getRealisasiPerjenis", "DashboardController@getRealisasiPerjenis");

    Route::resource("/unit_kerja", "UnitKerjaController");
    Route::get("/status_pengisian", "UnitKerjaController@statuspengisian");

    //pusat
    Route::resource("/realisasi_anggaran_target_pjbs","Realisasi_anggaran_target_pjbController");
    Route::resource("/penyerapan_anggaran_pradipas","Penyerapan_anggaran_pradipaController");
    Route::resource("/penyerapan_anggaran_target_pjbs","Penyerapan_anggaran_target_pjbController");
    Route::resource("/penyerapan_anggaran_perjenis","Penyerapan_anggaran_perjenis_belanjaController");
    Route::resource("/penyerapan_rencana_triwulans","Penyerapan_rencana_triwulanController");
    Route::resource("/progres_pjbs","Progres_pjbController");
    Route::resource("/kop_spp","Kop_sppController");
    Route::resource("/pjb_setahun","PJBSetahunController");
    Route::resource("/deadlines","DeadlineController");

    
    //report excel
    Route::get("/report/{format}/{user_id}/{tahun}/{triwulan_no}/{encrypt}", "ReportController@download");
    Route::get("/report", "ReportController@index");

    Route::get("/report_kop_spp_excel/{user_id}/{tahun}/{encrypt}", "ReportKopSppController@excelReport");
    Route::get("/report_kop_spp_pdf/{user_id}/{tahun}/{encrypt}", "ReportKopSppController@pdfReport");
    Route::get("/report_kop_spp", "ReportKopSppController@index");
    
    // aux
    Route::get('/penyerapan_rencana_triwulan_modal/{id?}','Penyerapan_rencana_triwulanController@editmodal');
    Route::post('/penyerapan_rencana_triwulan_modal/{id?}','Penyerapan_rencana_triwulanController@updatemodal');

    Route::get('/penyerapan_rencana_triwulan_barang/{id?}','Penyerapan_rencana_triwulanController@editbarang');
    Route::post('/penyerapan_rencana_triwulan_barang/{id?}','Penyerapan_rencana_triwulanController@updatebarang');
    
    Route::get('/penyerapan_rencana_triwulan_lainnya/{id?}','Penyerapan_rencana_triwulanController@editlainnya');
    Route::post('/penyerapan_rencana_triwulan_lainnya/{id?}','Penyerapan_rencana_triwulanController@updatelainnya');
    
    Route::get('/penyerapan_anggaran_setahun_pjb/{id?}','Penyerapan_rencana_triwulanController@editsetahunpjb');
    Route::post('/penyerapan_anggaran_setahun_pjb/{id?}','Penyerapan_rencana_triwulanController@updatesetahunpjb');
    Route::get('/realisasi_triwulan_berjalan/{id?}','Realisasi_anggaran_target_pjbController@edittriwulanberjalan');
    Route::post('/realisasi_triwulan_update/{id?}','Realisasi_anggaran_target_pjbController@updatetriwulan');

    Route::get('/penyerapan_anggaran_pradipas/approve/{id?}','Penyerapan_anggaran_pradipaController@approve');
    Route::get('/penyerapan_anggaran_pradipas/reject/{id?}','Penyerapan_anggaran_pradipaController@reject');

    Route::get("/realisasi_anggaran_target_pjbs/permasalahan/{id?}","Realisasi_anggaran_target_pjbController@permasalahan");
    Route::post("/realisasi_anggaran_target_pjbs/permasalahan/{id?}","Realisasi_anggaran_target_pjbController@permasalahanSave");
        
    Route::get("/progres_pjbs/permasalahan/{id?}","Progres_pjbController@permasalahan");
    Route::post("/progres_pjbs/permasalahan/{id?}","Progres_pjbController@permasalahanSave");
    
    Route::get('/', function () {
        return redirect('/dashboard');
    });

});

Route::auth();

