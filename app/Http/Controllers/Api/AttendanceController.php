<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Kehadiran;
use App\Models\SettingAbsensi;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AttendanceController {
    /**
     * Endpoint check attendance today
     * @param String $userId
     */
    public function getAttendanceToday($userId) {
        $kehadiran = Kehadiran::where('id_user', $userId)->whereDate('created_at', Carbon::today())->first();
        $user = User::where('id', $userId)->first();
        $setting = SettingAbsensi::where('id_jabatan', $user->id_jabatan)->first();

        if ($kehadiran == null) {
            return response()->json([
                'setting' => $setting,
                'check_in' => [
                    'status' => 'NOT_YET',
                    'time' => null
                ],
                'check_out' => [
                    'status' => 'NOT_YET',
                    'time' => null
                ],
            ], 200);
        }

        return response()->json([
            'setting' => $setting,
            'check_in' => [
                'status' => $kehadiran->status_masuk,
                'time' => $kehadiran->jam_masuk ?? null
            ],
            'check_out' => [
                'status' => $kehadiran->status_pulang,
                'time' => $kehadiran->jam_pulang ?? null
            ],
        ], 200);
    }

    /**
     * Endpoint save attendance
     * @param String $userId
     * @param int $mode (1: checkin, 2: checkout)
     */
    public function saveAttendance(Request $request) {
        // check if data has exist, update data
        $kehadiran = Kehadiran::where('id_user', $request->userId)->whereDate('created_at', Carbon::today())->first();
        $user = User::where('id', $request->userId)->first();
        $setting = SettingAbsensi::where('id_jabatan', $user->id_jabatan)->first();

        // if setting jabatan not exist
        if ($setting == null) {
            return response()->json([
                'message' => 'NOT_CONFIGURED',
            ], 200);
        }
        
        if ($kehadiran != null) {
            // validation if mode 1 && already checkin
            if ($request->mode == 1 && $kehadiran->jam_masuk != null) {
                return response()->json([
                    'message' => 'ALREADY_CHECKIN',
                ], 200);
            }

            // validation if mode 2 && already checkout
            if ($request->mode == 2 && $kehadiran->jam_pulang != null) {
                return response()->json([
                    'message' => 'ALREADY_CHECKOUT',
                ], 200);
            }

            // update data
            $update = [];
            if ($request->mode == 1) {
                $update = [
                    'jam_masuk' => Carbon::now()->format('H:i:s'),
                    'status_masuk' => $this->getStatusAttendance(Carbon::now()->format('H:i'), $setting->jam_masuk)
                ];
            } else if ($request->mode == 2) {
                $update = [
                    'jam_pulang' => Carbon::now()->format('H:i:s'),
                    'status_pulang' => $this->getStatusAttendance(Carbon::now()->format('H:i'), $setting->jam_pulang)
                ];
            }

            $kehadiran = Kehadiran::where('id_user', $request->userId)
                ->whereDate('created_at', Carbon::today())
                ->update($update);
            
            return response()->json([
                'message' => 'SUCCESS',
            ], 200);
        }

        // if data not exist, create new data
        $create = Kehadiran::create([
            'id_user' => $request->userId,
            'id_setting' => $setting->id,
            'jam_masuk' => $request->mode == 1 ? Carbon::now()->format('H:i:s') : null,
            'jam_pulang' => $request->mode == 2 ? Carbon::now()->format('H:i:s') : null,
            'setting_jam_masuk' => $setting->jam_masuk,
            'setting_jam_pulang' => $setting->jam_pulang,
            'status_masuk' => $request->mode == 1 ? $this->getStatusAttendance(Carbon::now()->format('H:i'), $setting->jam_masuk) : 'NOT_YET',
            'status_pulang' => $request->mode == 2 ? $this->getStatusAttendance(Carbon::now()->format('H:i'), $setting->jam_pulang) : 'NOT_YET',
        ]);

        return response()->json([
            'message' => 'SUCCESS',
        ], 200);
    }

    /**
     * Endpoint get attendace history
     * @param String $userId
     */
    public function getAttendanceHistory($userId) {
        $data = Kehadiran::where('id_user', $userId)->get();

        return response()->json([
            'message' => 'SUCCESS',
            'data' => $data
        ], 200);
    }

    function getStatusAttendance($time, $banding) {
        $time = Carbon::parse(date('Y-m-d')." ".$time);
        $banding = Carbon::parse(date('Y-m-d')." ".$banding);

        return $time->gt($banding) ? "LATE" : "ONTIME";
    }
}