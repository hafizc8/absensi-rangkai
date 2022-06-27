<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kehadiran;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countUser = User::count();
        $countHadir = Kehadiran::whereNotNull('jam_masuk')->whereDate('created_at', Carbon::today())->count();
        $countPulang = Kehadiran::whereNotNull('jam_pulang')->whereDate('created_at', Carbon::today())->count();

        // count tepat waktu
        $countHadirOnTime = Kehadiran::whereNotNull('jam_masuk')->whereDate('created_at', Carbon::today())->where('status_masuk', 'ONTIME')->count();
        $countPulangOnTime = Kehadiran::whereNotNull('jam_pulang')->whereDate('created_at', Carbon::today())->where('status_pulang', 'ONTIME')->count();
        
        // count terlambat
        $countHadirLate = Kehadiran::whereNotNull('jam_masuk')->whereDate('created_at', Carbon::today())->where('status_masuk', 'LATE')->count();
        $countPulangLate = Kehadiran::whereNotNull('jam_pulang')->whereDate('created_at', Carbon::today())->where('status_pulang', 'LATE')->count();

        // 5 riwayat absensi
        $kehadiran = Kehadiran::leftJoin('users as b', 'kehadirans.id_user', '=', 'b.id')
            ->orderBy('updated_at', 'DESC')
            ->limit(5)
            ->get([
                'kehadirans.updated_at',
                'b.name',
                'kehadirans.jam_masuk',
                'kehadirans.status_masuk',
                'kehadirans.jam_pulang',
                'kehadirans.status_pulang',
            ]);

        // get sum diff time today
        $sumToday = Kehadiran::whereNotNull('jam_masuk')
            ->whereDate('created_at', Carbon::today())
            ->sum(DB::raw('(TIME_TO_SEC(setting_jam_masuk) - TIME_TO_SEC(jam_masuk))'));
            
        // get sum diff time yesterday
        $sumYesterday = Kehadiran::whereNotNull('jam_masuk')
            ->whereDate('created_at', Carbon::yesterday())
            ->sum(DB::raw('(TIME_TO_SEC(setting_jam_masuk) - TIME_TO_SEC(jam_masuk))'));

        // count percentage
        $percen = 0;
        $isIncrease = false;
        // yesterday = awal
        // today = akhir
        // penurunan (awal - akhir)/awal*100
        if ($sumToday < $sumYesterday) {
            $percen = ($sumYesterday - $sumToday);
            $percen = ($sumYesterday > 0) ? $percen / $sumYesterday : 0;

            $isIncrease = false;
        } 
        // kenaikan (akhir - awal)/akhir*100
        else {
            $percen = ($sumToday - $sumYesterday);
            $percen = ($sumToday > 0) ? $percen / $sumToday : 0;

            $isIncrease = true;
        }

        // count percentage for one week
        $now = Carbon::now();
        $weekStartDate = $now->startOfWeek()->format('Y-m-d')." 00:00:00";
        $weekEndDate = $now->endOfWeek()->format('Y-m-d')." 23:59:59";

        $lastWeekStartDate = $now->startOfWeek()->subDays(7)->format('Y-m-d')." 00:00:00";
        $lastWeekEndDate = $now->endOfWeek()->format('Y-m-d')." 23:59:59";

        // get sum diff time current week
        $sumCurrentWeek = Kehadiran::whereNotNull('jam_masuk')
            ->whereBetween('created_at', [$weekStartDate, $weekEndDate])
            ->sum(DB::raw('(TIME_TO_SEC(setting_jam_masuk) - TIME_TO_SEC(jam_masuk))'));
            
        // get sum diff time last week
        $sumLastWeek = Kehadiran::whereNotNull('jam_masuk')
            ->whereBetween('created_at', [$lastWeekStartDate, $lastWeekEndDate])
            ->sum(DB::raw('(TIME_TO_SEC(setting_jam_masuk) - TIME_TO_SEC(jam_masuk))'));

        // count percentage per week
        $percenWeek = 0;
        $isIncreaseWeek = false;
        // last week = awal
        // current week = akhir
        // penurunan (awal - akhir)/awal*100
        if ($sumCurrentWeek < $sumLastWeek) {
            $percenWeek = ($sumLastWeek - $sumCurrentWeek);
            $percenWeek = ($sumLastWeek > 0) ? $percenWeek / $sumLastWeek : 0;

            $isIncreaseWeek = false;
        } 
        // kenaikan (akhir - awal)/akhir*100
        else {
            $percenWeek = ($sumCurrentWeek - $sumLastWeek);
            $percenWeek = ($sumCurrentWeek > 0) ? $percenWeek / $sumCurrentWeek : 0;

            $isIncreaseWeek = true;
        }

        return view('dashboard', [
            'countUser' => $countUser,
            'countHadir' => $countHadir,
            'countPulang' => $countPulang,

            'countHadirOnTime' => $countHadirOnTime,
            'countPulangOnTime' => $countPulangOnTime,

            'countHadirLate' => $countHadirLate,
            'countPulangLate' => $countPulangLate,

            'kehadiran' => $kehadiran,

            'percen' => $percen,
            'isIncrease' => $isIncrease,

            'percenWeek' => $percenWeek,
            'isIncreaseWeek' => $isIncreaseWeek,

            'weekStartDate' => $weekStartDate,
            'weekEndDate' => $weekEndDate,
            'lastWeekStartDate' => $lastWeekStartDate,
            'lastWeekEndDate' => $lastWeekEndDate,
        ]);
    }
}
