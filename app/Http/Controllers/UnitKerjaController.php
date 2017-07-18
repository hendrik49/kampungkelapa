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
            'password' => 'required',
            'copassword' => 'required',
        ]);

        $user = new User();
        $user->id = $request->input("id");
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = bcrypt($request->input("password"));
        $user->role = "K";

        $salt = bin2hex(openssl_random_pseudo_bytes(16));
        $randomkey = bin2hex(openssl_random_pseudo_bytes(32));

        $master_hash = session()->get('pass_sha256');
        $user_hash = hash("sha256", $request->input("password"));

        $user->salt = $salt;
        $user->key_m = openssl_encrypt($randomkey, config('crypto.cipher_method'), hex2bin($master_hash), 0, hex2bin($salt));
        $user->key_u = openssl_encrypt($randomkey, config('crypto.cipher_method'), hex2bin($user_hash), 0, hex2bin($salt));

        $user->save();

        return redirect()->route('unit_kerja.index')->with('message', 'Simpan Berhasil.');
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'copassword' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = bcrypt($request->input("password"));
        $user->role = "K";

        // calculate original key via key_m
        $orig_key = openssl_decrypt($user->key_m, config('crypto.cipher_method'), hex2bin(session()->get('pass_sha256')), 0, hex2bin($user->salt));
        // reencrypt key_u using new password
        $user_hash = hash("sha256", $request->input("password"));
        $user->key_u = openssl_encrypt($orig_key, config('crypto.cipher_method'), hex2bin($user_hash), 0, hex2bin($user->salt));
        // salt unchanged

        $user->save();

        return redirect()->route('unit_kerja.index')->with('message', 'Memperbaharui berhasil.');
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
