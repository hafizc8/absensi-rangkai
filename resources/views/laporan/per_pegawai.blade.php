@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Laporan Kehadiran Per Pegawai') }}</div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}  
                        </div><br />
                    @endif

                    <form method="GET" action="{{ route('laporan-per-pegawai') }}">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="row">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Filter Karyawan') }}</label>
                                    <div class="col-md">
                                        <select class="form-control" name="karyawan" id="karyawan">
                                            <option value="">-- Pilih Karyawan --</option>
                                            @foreach($pegawai as $p)
                                                <option value="{{ $p->id }}" {{ isset($_GET['karyawan']) ? (($_GET['karyawan'] == $p->id) ? 'selected' : '') : '' }}>{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <div class="row">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Filter Tanggal') }}</label>
                                    <div class="col-md">
                                        <input id="date" type="date" class="form-control" name="date1" value="{{ $_GET['date1'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="row">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Sampai Dengan') }}</label>
                                    <div class="col-md">
                                        <input id="date" type="date" class="form-control" name="date2" value="{{ $_GET['date2'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-10">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" style="margin-right: 5px"><span class="fa fa-search"></span> Tampilkan</button>
                                    @if (isset($_GET['date1']))
                                        <a href="{{ URL::to('/print-laporan-per-pegawai/'.$_GET['date1'].'/'.$_GET['date2'].'/'.$_GET['karyawan']) }}" target="_blank" class="btn btn-success"><span class="fa fa-print"></span> Cetak</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <b class="col-md-4 text-md-end">{{ 'Nama Pegawai :' }}</b>
                                <b class="col-md-8">{{ count($laporan) > 0 ? $laporan[0]->name : ''}}</b>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <b class="col-md-4 text-md-end">{{ 'Jabatan :' }}</b>
                                <b class="col-md-8">{{ count($laporan) > 0 ? $laporan[0]->nama_jabatan : ''}}</b>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>Jam Masuk</td>
                                    <td>Ket.</td>
                                    <td>Jam Pulang</td>
                                    <td>Ket.</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan as $v)
                                    <tr>
                                        <td>{{ date('d F Y, H:i', strtotime($v->created_at)) }}</td>
                                        <td>{{ $v->jam_masuk }}</td>
                                        <td>{{ $v->status_masuk == 'NOT_YET' ? 'Belum Absen' : ($v->status_masuk == 'ONTIME' ? 'Tepat Waktu' : 'Terlambat') }} <small>{{ ($v->status_masuk == 'LATE' ? '('.($v->menit_masuk < 0 ? $v->menit_masuk * -1 : $v->menit_masuk).' menit)' : '') }}</small></td>
                                        <td>{{ $v->jam_pulang }}</td>
                                        <td>{{ $v->status_pulang == 'NOT_YET' ? 'Belum Absen' : ($v->status_pulang == 'EARLYTIME' ? 'Terlalu Cepat' : ($v->status_pulang == 'ONTIME' ? 'Tepat Waktu' : 'Lembur')) }} <small>{{ ($v->status_pulang == 'LATE' ? '('.($v->menit_pulang < 0 ? $v->menit_pulang * -1 : $v->menit_pulang).' menit)' : '') }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection