@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Absensi - Edit Pengaturan') }}</div>

                <div class="card-body">
                    @if(session()->get('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}  
                        </div><br />
                    @endif

                    <form method="POST" action="{{ route('setting.update', ['setting' => $data->id]) }}">
                        @csrf

                        {{ method_field('PUT') }}

                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <input type="hidden" name="id_jabatan" value="{{ $data->id_jabatan }}">

                        <div class="row mb-3">
                            <label for="jabatan" class="col-md-4 col-form-label text-md-end">{{ __('Jabatan') }}</label>

                            <div class="col-md-6">
                                <select name="jabatan" id="id_jabatan" class="form-control @error('id_jabatan') is-invalid @enderror" disabled="disabled">
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
                            <label for="jam_masuk" class="col-md-4 col-form-label text-md-end">{{ __('Jam Masuk') }}</label>

                            <div class="col-md-6">
                                {{Form::time('jam_masuk', $data['jam_masuk'],['class' => 'form-control'])}}

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
                                {{Form::time('jam_pulang', $data['jam_pulang'],['class' => 'form-control'])}}

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
                                <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ $data['latitude'] }}" required autocomplete="latitude">

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
                                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ $data['longitude'] }}" required>

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
                                <input id="jarak_toleransi" type="text" class="form-control @error('jarak_toleransi') is-invalid @enderror" name="jarak_toleransi" value="{{ $data['jarak_toleransi'] }}" required>

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