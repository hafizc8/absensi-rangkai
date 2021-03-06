@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Absensi - Tambah Pengaturan') }}</div>

                <div class="card-body">
                    @if(session()->get('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}  
                        </div><br />
                    @endif

                    <form method="POST" action="{{ route('setting.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>

                            <div class="col-md-6">
                                <select name="id_jabatan" id="id_jabatan" class="form-control @error('id_jabatan') is-invalid @enderror">
                                    @foreach($jabatan as $v)
                                        <option value="{{ $v->id }}">{{ $v->nama_jabatan }}</option>
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
                            <label for="jam_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Jam Masuk') }}</label>

                            <div class="col-md-6">
                                {{Form::time('jam_masuk', \Carbon\Carbon::now()->timezone('Asia/Jakarta'),['class' => 'form-control'])}}

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jam_pulang" class="col-md-4 col-form-label text-md-end">{{ __('Jam Pulang') }}</label>

                            <div class="col-md-6">
                                {{Form::time('jam_pulang', \Carbon\Carbon::now()->timezone('Asia/Jakarta'),['class' => 'form-control'])}}

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="latitude" class="col-md-4 col-form-label text-md-end">{{ __('Latitude') }}</label>

                            <div class="col-md-6">
                                <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required autocomplete="latitude" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="longitude" class="col-md-4 col-form-label text-md-end">{{ __('Longitude') }}</label>

                            <div class="col-md-6">
                                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required autocomplete="longitude" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jarak_toleransi" class="col-md-4 col-form-label text-md-end">{{ __('Jarak Toleransi (meter)') }}</label>

                            <div class="col-md-6">
                                <input id="jarak_toleransi" type="text" class="form-control @error('jarak_toleransi') is-invalid @enderror" name="jarak_toleransi" value="{{ old('jarak_toleransi') }}" required autocomplete="jarak_toleransi" autofocus>

                                @error('name')
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