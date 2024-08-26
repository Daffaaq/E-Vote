@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Daftar Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Daftar Jadwal Orasi</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Jadwal Orasi') }}</div>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('jadwal-orasi.admin.update', $jadwal_orasi->uuid) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row d-none">
                                <label for="periode_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Periode ID') }}</label>
                                <div class="col-md-6">
                                    <input id="periode_id" type="hidden" name="periode_id"
                                        value="{{ old('periode_id', $jadwal_orasi->periode_id) }}">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tanggal_orasi_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Orasi Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tanggal_orasi_vote" type="date"
                                        class="form-control @error('tanggal_orasi_vote') is-invalid @enderror"
                                        name="tanggal_orasi_vote"
                                        value="{{ old('tanggal_orasi_vote', $jadwal_orasi->tanggal_orasi_vote) }}">
                                    @error('tanggal_orasi_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="jam_orasi_mulai"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Jam Orasi Mulai') }}</label>
                                <div class="col-md-6">
                                    <input id="jam_orasi_mulai" type="time"
                                        class="form-control @error('jam_orasi_mulai') is-invalid @enderror"
                                        name="jam_orasi_mulai"
                                        value="{{ old('jam_orasi_mulai', $jadwal_orasi->jam_orasi_mulai) }}">
                                    @error('jam_orasi_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tempat_orasi"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tempat Orasi') }}</label>
                                <div class="col-md-6">
                                    <input id="tempat_orasi" type="text"
                                        class="form-control @error('tempat_orasi') is-invalid @enderror" name="tempat_orasi"
                                        value="{{ old('tempat_orasi', $jadwal_orasi->tempat_orasi) }}">
                                    @error('tempat_orasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
