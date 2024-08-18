@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Daftar Siswa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Siswa</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Siswa</h6>
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
                <div class="col-md-3 font-weight-bold">Nama:</div>
                <div class="col-md-9">{{ $student->nama }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">NIS:</div>
                <div class="col-md-9">{{ $student->nis }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Kelas:</div>
                <div class="col-md-9">{{ $student->kelas }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Jenis Kelamin:</div>
                <div class="col-md-9">{{ $student->jenis_kelamin }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Status Siswa:</div>
                <div class="col-md-9">{{ $student->status_students == 1 ? 'Aktif' : 'Tidak Aktif' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Status Voting:</div>
                <div class="col-md-9">
                    @if ($student->StatusVote)
                        <span class="badge bg-success">Sudah Memilih</span>
                    @else
                        <span class="badge bg-danger">Belum Memilih</span>
                    @endif
                    <div>
                        <small>Periode {{ $periode->periode_nama }}</small>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('students.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <a href="{{ route('students.edit', $student->uuid) }}" class="btn btn-primary mr-2">Edit</a>
                <form action="{{ route('students.destroy', $student->uuid) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
