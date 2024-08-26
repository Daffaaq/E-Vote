@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Candidate.index') }}">Daftar Kandidat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Kandidat</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Kandidat</h6>
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
                <div class="col-md-3 font-weight-bold">Nama Ketua:</div>
                <div class="col-md-9">{{ $candidate->nama_ketua }}</div>
            </div>
            @if ($candidate->status !== 'perseorangan')
                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">Nama Wakil Ketua:</div>
                    <div class="col-md-9">{{ $candidate->nama_wakil_ketua }}</div>
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Nomor Urut:</div>
                <div class="col-md-9">{{ $candidate->no_urut_kandidat }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Visi:</div>
                <div class="col-md-9">{!! $candidate->visi !!}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Misi:</div>
                <div class="col-md-9">{!! $candidate->misi !!}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Slogan:</div>
                <div class="col-md-9">{{ $candidate->slogan }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Periode:</div>
                <div class="col-md-9">{{ $periode->periode_nama }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Status:</div>
                <div class="col-md-9">{{ $candidate->status }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 font-weight-bold">Foto Ketua:</div>
                <div class="col-md-9">
                    <img src="{{ asset('storage/' . $candidate->foto) }}" alt="Foto Ketua"
                        class="img-fluid rounded shadow img-thumbnail"style="width: 200px; height: 200px">
                </div>
            </div>
            @if ($candidate->status !== 'perseorangan')
                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">Foto Wakil Ketua:</div>
                    <div class="col-md-9">
                        <img src="{{ asset('storage/' . $candidate->foto_wakil) }}" alt="Foto Wakil Ketua"
                            class="img-fluid rounded shadow img-thumbnail" style="width: 200px; height: 200px">
                    </div>
                </div>
            @endif
            <div class="d-flex justify-content-end">
                <a href="{{ route('Candidate.index') }}" class="btn btn-secondary"
                    style="margin-right: 5px;">Kembali</a>
                <a href="{{ route('Candidate.edit', $candidate->uuid) }}" class="btn btn-primary"
                    style="margin-right: 5px;">Edit</a>
                <form action="{{ route('Candidate.destroy', $candidate->uuid) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kandidat ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
