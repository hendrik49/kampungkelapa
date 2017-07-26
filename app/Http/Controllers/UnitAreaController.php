<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AreaAuthorize;
use App\Models\UserDetail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitAreaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $users = AreaAuthorize::orderBy('id', 'asc')->get();

        return view('unit_area.index', compact('users'));
    }
    
    public function store(Request $request) {

        $this->validate($request, [
            'user_id' => 'required',
            'zone' => 'required',
            'zone_ids' => 'required'
        ]);

        $user = new AreaAuthorize();
        $user->id = $request->input("id");
        $user->zone = $request->input("zone");
        $user->zone_ids = $request->input("zone_ids");
        $user->user_id = $request->input("user_id");
        $user->save();

        return redirect()->route('unit_area.index')->with('message', 'Menyimpan berhasil.');
    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'user_id' => 'required',
            'zone' => 'required',
            'zone_ids' => 'required'
        ]);

        $user = AreaAuthorize::findOrFail($id);
        $user->zone = $request->input("zone");
        $user->zone_ids = $request->input("zone_ids");
        $user->user_id = $request->input("user_id");
        $user->save();

        return redirect()->route('unit_area.index')->with('message', 'Memperbaharui berhasil.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
        $province = Province::orderBy('id', 'asc')->get();
        $regency = Regency::orderBy('id', 'asc')->get();
        $district = District::orderBy('id', 'asc')->get();
        $users = UserDetail::get();

        return view('unit_area.create',compact('regency','province','district','users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $user = AreaAuthorize::findOrFail($id);

        return view('unit_area.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $area = AreaAuthorize::findOrFail($id);
        $user = UserDetail::Where('user_id',$area->user_id)->first();
        $regency = Regency::orderBy('id', 'asc')->get();
        $province = Province::orderBy('id', 'asc')->get();
        $district = District::orderBy('id', 'asc')->get();

        return view('unit_area.edit',compact('regency','province','district','user','area'));
    }

    public function destroy($id) {
        $user = AreaAuthorize::findOrFail($id);
        $user->delete();

        return redirect()->route('unit_area.index')->with('message', 'Item deleted successfully.');
    }

}
