<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kehadiran;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = [];

        if (isset($_GET['date1'])) {
            $laporan = Kehadiran::leftJoin('users as b', 'kehadirans.id_user', '=', 'b.id')
                ->leftJoin('jabatans as c', 'c.id', '=', 'b.id_jabatan')
                ->whereBetween('kehadirans.created_at', [$_GET['date1'], $_GET['date2']])
                ->get([
                    'kehadirans.created_at',
                    'b.name',
                    'c.nama_jabatan',
                    'kehadirans.jam_masuk',
                    'kehadirans.status_masuk',
                    'kehadirans.jam_pulang',
                    'kehadirans.status_pulang',
                ]);
        }


        return view('laporan.laporan', ['laporan' => $laporan]);
    }
}