@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Laporan Kehadiran') }}</div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}  
                        </div><br />
                    @endif

                    <form method="GET" action="{{ route('laporan.index') }}">
                        <div class="row">
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
                                        <a href="{{ URL::to('/print-laporan/'.$_GET['date1'].'/'.$_GET['date2']) }}" target="_blank" class="btn btn-success"><span class="fa fa-print"></span> Cetak</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>Nama Pegawai</td>
                                    <td>Jabatan</td>
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
                                        <td>{{ $v->name }}</td>
                                        <td>{{ $v->nama_jabatan }}</td>
                                        <td>{{ $v->jam_masuk }}</td>
                                        <td>{{ $v->status_masuk == 'LATE' ? 'Terlambat' : 'Tepat Waktu' }}</td>
                                        <td>{{ $v->jam_pulang }}</td>
                                        <td>{{ $v->status_pulang == 'LATE' ? 'Terlambat' : 'Tepat Waktu' }}</td>
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