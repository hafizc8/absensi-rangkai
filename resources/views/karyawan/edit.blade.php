@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Karyawan - Edit Karyawan') }}</div>

                <div class="card-body">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}  
                        </div><br />
                    @endif

                    <form method="POST" action="{{ route('pegawai.update', ['pegawai' => $data->id]) }}">
                        @csrf

                        {{ method_field('PUT') }}

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Karyawan') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data['name'] }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>

                            <div class="col-md-6">
                                <select name="id_jabatan" id="id_jabatan" class="form-control @error('id_jabatan') is-invalid @enderror">
                                    @foreach($jabatan as $v)
                                        @if($data['id_jabatan'] == $v->id)
                                            <option value="{{ $v->id }}" selected>{{ $v->nama_jabatan }}</option>
                                        @else
                                            <option value="{{ $v->id }}">{{ $v->nama_jabatan }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('jabatan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data['email'] }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="akses" class="col-md-4 col-form-label text-md-end">{{ __('Akses') }}</label>

                            <div class="col-md-6">
                                <select name="akses" id="akses" class="form-control @error('akses') is-invalid @enderror">
                                    <option value="0" {{ $data['akses'] == 0 ? 'selected' : '' }}>User Biasa</option>
                                    <option value="1" {{ $data['akses'] == 1 ? 'selected' : '' }}>User HRD</option>
                                </select>

                                @error('akses')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection