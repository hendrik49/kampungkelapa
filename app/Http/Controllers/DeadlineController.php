<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Deadline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class DeadlineController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
//            $notifs = Auth::user()->getNotifikasiPengisian('2017-10-06');
//            dd($notifs);            
            
		$deadlines = Deadline::orderBy('id', 'desc')->paginate(10);

		return view('deadlines.index', compact('deadlines'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            
            $tahun = DB::table('deadlines')->max('tahun_anggaran');
            
            if (!$tahun) $tahun = date('Y');
            else $tahun = $tahun + 1;
            
            return view('deadlines.create', compact('tahun'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
            Validator::extend('after_equal', function($attribute, $value, $parameters, $validator) {
                return strtotime($validator->getData()[$parameters[0]]) <= strtotime($value);
            }, "tanggal harus lebih dari tenggat triwulan sebelumnya");            
            
            $this->validate($request, [
                'triwulan_1' => 'required|date',
                'triwulan_2' => 'required|date|after_equal:triwulan_1',
                'triwulan_3' => 'required|date|after_equal:triwulan_2',
                'triwulan_4' => 'required|date|after_equal:triwulan_3',
            ]);            
            
            $deadline = new Deadline();

            $deadline->tahun_anggaran = $request->input("tahun_anggaran");
            $deadline->triwulan_1 = Carbon::parse($request->input("triwulan_1"))->format('Y-m-d');
            $deadline->triwulan_2 = Carbon::parse($request->input("triwulan_2"))->format('Y-m-d');
            $deadline->triwulan_3 = Carbon::parse($request->input("triwulan_3"))->format('Y-m-d');
            $deadline->triwulan_4 = Carbon::parse($request->input("triwulan_4"))->format('Y-m-d');

            $deadline->save();

            return redirect()->route('deadlines.index')->with('message', 'Data telah ditambahkan.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$deadline = Deadline::findOrFail($id);

		return view('deadlines.show', compact('deadline'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$deadline = Deadline::findOrFail($id);
                
                $deadline->triwulan_1 = Carbon::parse($deadline->triwulan_1)->format('d-m-Y');
                $deadline->triwulan_2 = Carbon::parse($deadline->triwulan_2)->format('d-m-Y');
                $deadline->triwulan_3 = Carbon::parse($deadline->triwulan_3)->format('d-m-Y');
                $deadline->triwulan_4 = Carbon::parse($deadline->triwulan_4)->format('d-m-Y');

		return view('deadlines.edit', compact('deadline'));
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
            Validator::extend('after_equal', function($attribute, $value, $parameters, $validator) {
                return strtotime($validator->getData()[$parameters[0]]) <= strtotime($value);
            }, "tanggal harus lebih dari tenggat triwulan sebelumnya");            
            
            $this->validate($request, [
                'triwulan_1' => 'required|date',
                'triwulan_2' => 'required|date|after_equal:triwulan_1',
                'triwulan_3' => 'required|date|after_equal:triwulan_2',
                'triwulan_4' => 'required|date|after_equal:triwulan_3',
            ]);                 
            
            $deadline = Deadline::findOrFail($id);

            // tahun gak diubah
            $deadline->triwulan_1 = Carbon::parse($request->input("triwulan_1"))->format('Y-m-d');
            $deadline->triwulan_2 = Carbon::parse($request->input("triwulan_2"))->format('Y-m-d');
            $deadline->triwulan_3 = Carbon::parse($request->input("triwulan_3"))->format('Y-m-d');
            $deadline->triwulan_4 = Carbon::parse($request->input("triwulan_4"))->format('Y-m-d');

            $deadline->save();

            return redirect()->route('deadlines.index')->with('message', 'Data telah disimpan.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$deadline = Deadline::findOrFail($id);
		$deadline->delete();

		return redirect()->route('deadlines.index')->with('message', 'Data telah dihapus.');
	}

}
