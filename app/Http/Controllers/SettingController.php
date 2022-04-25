<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\SettingAbsensi;
use App\Models\Kehadiran;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // join ke jabatan
        $setting = SettingAbsensi::join('jabatans', 'jabatans.id', '=', 'setting_absensis.id_jabatan')
            ->get(['setting_absensis.*', 'jabatans.nama_jabatan']);

        return view('setting.setting', ['setting' => $setting]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jabatan = Jabatan::get();
        return view('setting.create', ['jabatan' => $jabatan]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi jika jam masuk lebih dari jam pulang
        $masuk = Carbon::parse(date('Y-m-d')." ".$request->jam_masuk);
        $pulang = Carbon::parse(date('Y-m-d')." ".$request->jam_pulang);
        if ($masuk->gt($pulang)) {
            return redirect()->route('setting.create')->with('error', 'Jam masuk tidak boleh lebih dari jam pulang.');
        }
        
        // validasi jika setting absensi utk jabatan tsb sudah ada
        $exists = SettingAbsensi::where('id_jabatan', $request->id_jabatan)->first();
        if ($exists) {
            return redirect()->route('setting.create')->with('error', 'Jabatan yang dipilih sudah pernah diatur absensinya, silahkan pilih jabatan lain');
        }

        $setting = SettingAbsensi::create([
            'id_jabatan' => $request->id_jabatan,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jarak_toleransi' => $request->jarak_toleransi,
        ]);

        if ($setting) {
            return redirect()->route('setting.index')->with('success', 'Berhasil menambahkan pengaturan absensi baru!');
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
        $data = SettingAbsensi::where('id', $id)->first();

        $jabatan = Jabatan::get();

        return view('setting.edit', ['data' => $data, 'jabatan' => $jabatan]);
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
        // validasi jika setting absensi utk jabatan tsb sudah ada
        $exists = SettingAbsensi::where('id_jabatan', $request->id_jabatan)->first();
        if ($exists) {
            return redirect()->route('setting.edit')->with('error', 'Jabatan yang dipilih sudah pernah diatur absensinya, silahkan pilih jabatan lain');
        }

        // validasi jika jam masuk lebih dari jam pulang
        $masuk = Carbon::parse(date('Y-m-d')." ".$request->jam_masuk);
        $pulang = Carbon::parse(date('Y-m-d')." ".$request->jam_pulang);
        if ($masuk->gt($pulang)) {
            return redirect()->route('setting.create')->with('error', 'Jam masuk tidak boleh lebih dari jam pulang.');
        }

        $setting = SettingAbsensi::where('id', $id)->update([
            'id_jabatan' => $request->id_jabatan,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jarak_toleransi' => $request->jarak_toleransi,
        ]);

        if ($setting) {
            return redirect()->route('setting.index')->with('success', 'Berhasil memperbaharui data pengaturan absensi!');
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
        $setting = SettingAbsensi::findOrFail($id);

        $setting->delete();

        return redirect()->route('jabatan.index')->with('success', 'Berhasil menghapus jabatan!');
    }
}
