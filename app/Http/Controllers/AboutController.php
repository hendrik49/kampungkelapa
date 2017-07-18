<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
		$judul = '<i>GA-Coba</i>';
		$tanggal = '<b>10-08-2016</b>';
    	return view('about')->with('data' , compact ('judul', 'tanggal'));
	}
}
