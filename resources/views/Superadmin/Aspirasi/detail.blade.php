@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboardSuperadmin/aspirasi') }}">Daftar Aspirasi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Aspirasi</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Aspirasi</h6>
        </div>
        @if (session('error'))
            <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-light-success alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Nama Siswa:</div>
                <div class="col-md-9">{{ $aspirasi->nama }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">NIS Siswa:</div>
                <div class="col-md-9">{{ $aspirasi->nis }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Kelas Siswa:</div>
                <div class="col-md-9">{{ $aspirasi->kelas }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Deskripsi Aspirasi:</div>
                <div class="col-md-9">{{ $aspirasi->description_profiles }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Tanggal Diajukan:</div>
                <div class="col-md-9">{{ \Carbon\Carbon::parse($aspirasi->created_at)->format('d-m-Y H:i') }}</div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('aspiration.index') }}" class="btn btn-secondary mr-2">Kembali</a>
            </div>
        </div>
    </div>
@endsection
