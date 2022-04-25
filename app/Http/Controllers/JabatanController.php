<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Hash;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = Jabatan::get();
        return view('jabatan.jabatan', ['jabatan' => $jabatan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jabatan = Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);
        
        if ($jabatan) {
            return redirect()->route('jabatan.index')->with('success', 'Berhasil menambahkan jabatan baru!');
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
        $data = Jabatan::where('id', $id)->first();

        return view('jabatan.edit', ['data' => $data]);
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
        $jabatan = Jabatan::where('id', $id)->update([
            'nama_jabatan' => $request->nama_jabatan
        ]);

        if ($jabatan) {
            return redirect()->route('jabatan.index')->with('success', 'Berhasil memperbaharui data jabatan!');
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
        $jabatan = Jabatan::findOrFail($id);

        // validasi jika ada pegawai di jabatan tsb, jabatan tidak boleh dihapus

        // pemberitahuan jika jabatan dihapus, maka data pengaturan juga akan terhapus

        $jabatan->delete();

        return redirect()->route('jabatan.index')->with('success', 'Berhasil menghapus jabatan!');
    }
}
