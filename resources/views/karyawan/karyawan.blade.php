@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Karyawan') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}  
                        </div><br />
                    @endif
                    <a href="{{ route('pegawai.create') }}" class="btn btn-primary mb-3">Tambah Karyawan</a>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nama Pegawai</td>
                                <td>Jabatan</td>
                                <td>Email</td>
                                <td>Dibuat Tgl</td>
                                <td>Akses</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->jabatan}}</td>
                                    <td>{{$v->email}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{ ($v->akses == 0) ? "User Biasa" : "User HRD" }}</td>
                                    <td>
                                        <a href="{{ route('pegawai.edit', ['pegawai' => $v->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form method="POST" action="{{ route('pegawai.destroy', ['pegawai' => $v->id]) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
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