@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Selamat Datang di Aplikasi Absensi Menggunakan Metode Haversine Pada PT Rangkai Utama Berjaya
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Absensi hari ini') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>DATANG</h6>
                            <h2>{{ $countHadir }}/{{ $countUser }}</h2>
                        </div>
                        <div class="col-md-6">
                            <h6>PULANG</h6>
                            <h2>{{ $countPulang }}/{{ $countUser }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Terlambat absen hari ini') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>DATANG</h6>
                            <h2>{{ $countHadirLate }}</h2>
                        </div>
                        <div class="col-md-6">
                            <h6>PULANG</h6>
                            <h2>{{ $countPulangLate }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Tepat waktu absen hari ini') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>DATANG</h6>
                            <h2>{{ $countHadirOnTime }}</h2>
                        </div>
                        <div class="col-md-6">
                            <h6>PULANG</h6>
                            <h2>{{ $countPulangOnTime }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 mt-4">
            <div class="card">
                <div class="card-header">{{ __('Riwayat kehadiran terakhir') }}</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Waktu</th>
                                <th>Ket.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kehadiran as $k)
                                <tr>
                                    <td>{{ $k->name }}</td>
                                    <td>{{ $k->status_pulang != 'NOT_YET' ? 'Pulang' : 'Masuk' }}</td>
                                    <td>{{ $k->status_pulang != 'NOT_YET' ? $k->jam_pulang : $k->jam_masuk }}</td>
                                    <td>{{ $k->status_pulang != 'NOT_YET' ? $k->status_pulang : $k->status_masuk }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <a href="{{ route('laporan.index') }}">
                                        Lihat selengkapnya
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-4">
            <div class="card">
                <div class="card-header" data-toggle="tooltip" data-placement="top" title="Dihitung berdasarkan absensi jam masuk">{{ __('Persentase Disiplin') }} <span class="fa-solid fa-circle-question"></span></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <h6>HARI INI</h6>
                            @if ($percen == 0)
                                <h2 class="text-secondary"><span class="fa fa-arrows-up-down"></span> &nbsp;{{ round($percen, 1) }}%</h2>
                            @else
                                @if ($isIncrease)
                                    <h2 class="text-success"><span class="fa fa-arrow-up"></span> &nbsp;{{ round($percen, 1) }}%</h2>
                                @else
                                    <h2 class="text-danger"><span class="fa fa-arrow-down"></span> &nbsp;{{ round($percen, 1) }}%</h2>
                                @endif
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md">
                            <h6 data-toggle="tooltip" data-placement="top" title="Dari tanggal {{ date('d/m/Y', strtotime($weekStartDate)) }} sd. {{ date('d/m/Y', strtotime($weekEndDate)) }}">MINGGU INI <span class="fa-solid fa-circle-question"></span></h6>
                            @if ($percenWeek == 0)
                                <h2 class="text-secondary"><span class="fa fa-arrows-up-down"></span> &nbsp;{{ round($percenWeek, 1) }}%</h2>
                            @else
                                @if ($isIncreaseWeek)
                                    <h2 class="text-success"><span class="fa fa-arrow-up"></span> &nbsp;{{ round($percenWeek, 1) }}%</h2>
                                @else
                                    <h2 class="text-danger"><span class="fa fa-arrow-down"></span> &nbsp;{{ round($percenWeek, 1) }}%</h2>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection