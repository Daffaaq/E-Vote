@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('log.superadmin.index') }}">Daftar Log</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Log</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Log</h6>
        </div>

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Action:</div>
                <div class="col-md-9">{{ $data->action }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">URL:</div>
                <div class="col-md-9">{{ $data->url }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Tanggal:</div>
                <div class="col-md-9">{{ $data->tanggal }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Waktu:</div>
                <div class="col-md-9">{{ \Carbon\Carbon::createFromFormat('H:i:s', $data->waktu)->format('H:i') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Data:</div>
                <div class="col-md-9">{{ $data->data }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">User ID:</div>
                <div class="col-md-9">{{ $data->user->name }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Periode ID:</div>
                <div class="col-md-9">{{ $data->periode->periode_nama }}</div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('log.superadmin.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <form action="{{ route('log.superadmin.destroy', $data->uuid) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
