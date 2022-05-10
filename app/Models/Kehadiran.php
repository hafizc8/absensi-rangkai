<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_setting',
        'jam_masuk',
        'jam_pulang',
        'setting_jam_masuk',
        'setting_jam_pulang',
        'status_masuk',
        'status_pulang',
    ];
}
