@extends('Superadmin.layouts.index')
<style>
    .alert {
        position: relative;
    }

    .btn-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
</style>
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('periode.index') }}">Daftar Periode</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Daftar Periode</li>
        </ol>
    </nav>
@endsection
@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Pemilih</h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px"
                            role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ url('/dashboardSuperadmin/Periode/update/' . $periode->uuid) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="periode_nama">Nama Periode</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="periode_nama" class="form-control" name="periode_nama"
                                                value="{{ $periode->periode_nama }}" placeholder="2021-2022">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="periode_kepala_sekolah">Nama Kepala
                                            Institusi / Sekolah</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="periode_kepala_sekolah" class="form-control"
                                                value="{{ $periode->periode_kepala_sekolah }}" name="periode_kepala_sekolah"
                                                placeholder="David Oroza">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="periode_no_kepala_sekolah">No Kepala
                                            Institusi / Sekolah</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="periode_no_kepala_sekolah" class="form-control"
                                                value="{{ $periode->periode_no_kepala_sekolah }}"
                                                name="periode_no_kepala_sekolah" placeholder="70003331">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="actif">Status Periode</label>
                                            <select class="form-select" id="actif" name="actif">
                                                <option selected>Pilih Status Periode</option>
                                                <option value="1" {{ $periode->actif == '1' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="2" {{ $periode->actif == '2' ? 'selected' : '' }}>
                                                    Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ url('/dashboardSuperadmin/Periode') }}"
                                        class="btn btn-primary rounded-pill me-1 mb-1">
                                        {{ __('Batal') }}
                                    </a>
                                    <button type="submit" class="btn btn-success rounded-pill me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-warning rounded-pill me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </section>
@endsection
