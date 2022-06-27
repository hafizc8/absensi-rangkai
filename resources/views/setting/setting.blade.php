@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Absensi') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}  
                        </div><br />
                    @endif
                    <a href="{{ route('setting.create') }}" class="btn btn-primary mb-3"><span class="fa fa-plus"></span> &nbsp;Tambah Pengaturan</a>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nama Jabatan</td>
                                <td>Jam Masuk</td>
                                <td>Jam Pulang</td>
                                <td>Koordinat</td>
                                <td>Jarak Toleransi</td>
                                <td>Dibuat Tgl</td>
                                <td>Diubah Tgl</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($setting as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->nama_jabatan}}</td>
                                    <td>{{$v->jam_masuk}}</td>
                                    <td>{{$v->jam_pulang}}</td>
                                    <td><a href="https://maps.google.com/?q=<?= $v->latitude .",". $v->longitude ?>" target="_blank">({{$v->latitude}}, {{$v->longitude}})</a></td>
                                    <td>{{$v->jarak_toleransi}} m</td>
                                    <td>{{ date('d/m/Y, H:i', strtotime($v->created_at)) }}</td>
                                    <td>{{ date('d/m/Y, H:i', strtotime($v->updated_at)) }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <a href="{{ route('setting.edit', ['setting' => $v->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Pengaturan"><span class="fa fa-edit"></span></a>
                                            </div>
                                            <div class="col-md-5">
                                                <form method="POST" action="{{ route('setting.destroy', ['setting' => $v->id]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Pengaturan"><span class="fa fa-trash"></span></button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection