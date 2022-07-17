<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Kehadiran;
use DB;

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
            $laporan = $this->getDataLaporan($_GET['date1'], $_GET['date2']);
        }

        return view('laporan.laporan', ['laporan' => $laporan]);
    }

    /**
     * Display laporan print only
     */
    public function printLaporan($date1, $date2) {
        $laporan = $this->getDataLaporan($date1, $date2);

        return view(
            'laporan.print_laporan', 
            [
                'laporan' => $laporan,
                'date1' => $date1,
                'date2' => $date2,
            ]
        );
    }

    function getDataLaporan($date1, $date2) {
        $laporan = Kehadiran::leftJoin('users as b', 'kehadirans.id_user', '=', 'b.id')
            ->leftJoin('jabatans as c', 'c.id', '=', 'b.id_jabatan')
            ->whereBetween('kehadirans.created_at', [$date1, $date2])
            ->get([
                'kehadirans.created_at',
                'b.name',
                'c.nama_jabatan',
                'kehadirans.jam_masuk',
                'kehadirans.status_masuk',
                'kehadirans.jam_pulang',
                'kehadirans.status_pulang',
                DB::raw('(TIME_TO_SEC(kehadirans.setting_jam_masuk) - TIME_TO_SEC(kehadirans.jam_masuk)) as menit_masuk'),
                DB::raw('(TIME_TO_SEC(kehadirans.setting_jam_pulang) - TIME_TO_SEC(kehadirans.jam_pulang)) as menit_pulang'),
            ]);

        return $laporan;
    }
}