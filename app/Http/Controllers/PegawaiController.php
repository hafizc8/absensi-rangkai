<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::leftJoin('jabatans', 'jabatans.id', '=', 'users.id_jabatan')->get(['users.*', 'jabatans.nama_jabatan']);
        return view('karyawan.karyawan', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan = Jabatan::get();
        return view('karyawan.create', ['jabatan' => $jabatan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make("rangkai123"),
            'akses' => $request->akses,
            'id_jabatan' => $request->id_jabatan
        ]);
        
        if ($user) {
            return redirect()->route('pegawai.index')->with('success', 'Berhasil menambahkan karyawan baru!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::leftJoin('jabatans', 'jabatans.id', '=', 'users.id_jabatan')
            ->where('users.id', $id)
            ->first(['users.*', 'jabatans.nama_jabatan']);

        $jabatan = Jabatan::get();

        return view('karyawan.edit', ['data' => $data, 'jabatan' => $jabatan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'akses' => $request->akses,
            'id_jabatan' => $request->id_jabatan
        ]);

        if ($user) {
            return redirect()->route('pegawai.index')->with('success', 'Berhasil memperbaharui data karyawan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('pegawai.index')->with('success', 'Berhasil menghapus karyawan!');
    }
}
