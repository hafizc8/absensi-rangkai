@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Master Jabatan') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}  
                        </div><br />
                    @endif
                    <a href="{{ route('jabatan.create') }}" class="btn btn-primary mb-3"><span class="fa fa-plus"></span> &nbsp;Tambah Jabatan</a>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Nama Jabatan</td>
                                <td>Dibuat Tgl</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jabatan as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->nama_jabatan}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <a href="{{ route('jabatan.edit', ['jabatan' => $v->id]) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit Jabatan"><span class="fa fa-edit"></span></a>
                                            </div>
                                            <div class="col-md-3">
                                                <form method="POST" action="{{ route('jabatan.destroy', ['jabatan' => $v->id]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus Jabatan"><span class="fa fa-trash"></span></button>
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