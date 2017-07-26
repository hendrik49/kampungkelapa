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
    Route::get("/getKinerjaPPL", "DashboardController@getKinerjaPPL");

    Route::resource("/unit_kerja", "UnitKerjaController");
    Route::resource("/unit_area", "UnitAreaController");

    //pusat
    Route::get("/jumlahpetani","LaporanController@jumlahpetani");
    Route::get("/jumlahproduk","LaporanController@jumlahproduk");
    Route::get("/jmlhphnprodannonpro","LaporanController@jmlhphnprodannonpro");
    Route::get("/jumlahperuntukan","LaporanController@jumlahperuntukan");
    Route::get("/nilaikerjappl","LaporanController@nilaikerjappl");
    Route::get("/datamemberdanphnppl","LaporanController@datamemberdanphnppl");
    Route::get("/trackppl","LaporanController@trackppl");

        
    Route::get('/', function () {
        return redirect('/dashboard');
    });

});

Route::auth();

