@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Daftar Pemilih</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Daftar Pemilih</li>
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

                    <div class="card-body">
                        <form method="POST" action="{{ url('/dashboardSuperadmin/Siswa/store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="nama">Nama Lengkap</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="nama" class="form-control" name="nama"
                                                placeholder="Muhammad Cahyo Zulfikar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="name">Nama Panggilan</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Cahyo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="nis">NIS/NIM</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="nis" class="form-control" name="nis"
                                                placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="kelas">Kelas</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="kelas" class="form-control" name="kelas"
                                                placeholder="XII RPL 1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                                                <option selected>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki"
                                                    {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="status_students">Status Siswa</label>
                                            <select class="form-select" id="status_students" name="status_students">
                                                <option selected>Pilih Status Siswa</option>
                                                <option value="1"
                                                    {{ old('status_students') == '1' ? 'selected' : '' }}>Aktif</option>
                                                <option value="2"
                                                    {{ old('status_students') == '2' ? 'selected' : '' }}>Non-Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ url('/dashboardSuperadmin/Siswa') }}"
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
    </section>
@endsection
