<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitKerjaController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $users = User::orderBy('id', 'asc')->get();

        return view('unit_kerja.index', compact('users'));
    }
    
    public function statuspengisian(Request $request) {
        
        $user = Auth::user();
        
        if ($user->role == 'M')        
            $users = User::orderBy('id', 'asc')->get();
        else
            $users = User::where('id', $user->id)->get();
        
        $tahun = $request->query('tahun');
        if (!$tahun) $tahun = intval(date("Y"));
        
        $tahun_now = intval(date("Y"));
        
        foreach ($users as $u) {
            $u->status = $u->getStatusPengisian($tahun);
        }
        
        return view('unit_kerja.status', compact('users', 'tahun', 'tahun_now', 'user'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            'copassword' => 'required',
        ]);

        $user = new User();
        $user->id = $request->input("id");
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->role = $request->input("role");
        $user->password = bcrypt($request->input("password"));
        $user->status = $request->input("status");

        $salt = bin2hex(openssl_random_pseudo_bytes(16));
        $randomkey = bin2hex(openssl_random_pseudo_bytes(32));

        $user->save();

        return redirect()->route('unit_kerja.index')->with('message', 'Menyimpan pengguna '.$user->name.' Berhasil.');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
            'copassword' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = bcrypt($request->input("password"));
        $user->role = $request->input("role");
        $user->status = $request->input("status");

        $user->save();

        return redirect()->route('unit_kerja.index')->with('message', 'Memperbaharui pengguna '.$user->name.' berhasil.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('unit_kerja.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $user = User::findOrFail($id);

        return view('unit_kerja.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $user = User::findOrFail($id);

        return view('unit_kerja.edit', compact('user'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('unit_kerja.index')->with('message', 'Item deleted successfully.');
    }

}
