<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingAbsensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_jabatan',
        'jam_masuk',
        'jam_pulang',
        'latitude',
        'longitude',
        'jarak_toleransi',
    ];
}
