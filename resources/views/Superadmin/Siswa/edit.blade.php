<!-- View: edit.blade.php -->

@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Daftar Pemilih</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Daftar Pemilih</li>
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
                        <form method="POST" action="{{ url('/dashboardSuperadmin/Siswa/update/' . $student->uuid) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="nama">Nama Lengkap</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="nama" class="form-control" name="nama"
                                                value="{{ $student->nama }}" placeholder="Muhammad Cahyo Zulfikar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="name">Nama Panggilan</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                value="{{ $student->user->name }}" placeholder="Cahyo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="nis">NIS/NIM</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="nis" class="form-control" name="nis"
                                                value="{{ $student->nis }}" placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="kelas">Kelas</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="kelas" class="form-control" name="kelas"
                                                value="{{ $student->kelas }}" placeholder="XII RPL 1">
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
                                                    {{ $student->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                                </option>
                                                <option value="Perempuan"
                                                    {{ $student->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
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
                                                    {{ $student->status_students == '1' ? 'selected' : '' }}>
                                                    Aktif</option>
                                                <option value="2"
                                                    {{ $student->status_students == '2' ? 'selected' : '' }}>
                                                    Non-Aktif</option>
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
    {{-- <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update Data Mahasiswa') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/dashboardSuperadmin/Siswa/update/' . $student->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Isi formulir dengan data mahasiswa yang ada -->
                            <div class="mb-3 row">
                                <label for="nama"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama"
                                        value="{{ $student->nama }}" required autofocus>

                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama Panggilan') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $student->user->name }}" required autofocus>

                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="nis"
                                    class="col-md-4 col-form-label text-md-right">{{ __('NIS') }}</label>

                                <div class="col-md-6">
                                    <input id="nis" type="text"
                                        class="form-control @error('nis') is-invalid @enderror" name="nis"
                                        value="{{ $student->nis }}" required>

                                    @error('nis')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="kelas"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kelas') }}</label>

                                <div class="col-md-6">
                                    <input id="kelas" type="text"
                                        class="form-control @error('kelas') is-invalid @enderror" name="kelas"
                                        value="{{ $student->kelas }}" required>

                                    @error('kelas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="jenis_kelamin"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Jenis Kelamin') }}</label>

                                <div class="col-md-6">
                                    <select id="jenis_kelamin"
                                        class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki"
                                            {{ $student->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ $student->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>

                                    </select>

                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="status_students"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Status Mahasiswa') }}</label>

                                <div class="col-md-6">
                                    <select id="status_students"
                                        class="form-select @error('status_students') is-invalid @enderror"
                                        name="status_students" required>
                                        <option value="">Pilih Status Mahasiswa</option>
                                        <option value="1" {{ $student->status_students == '1' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="2" {{ $student->status_students == '2' ? 'selected' : '' }}>
                                            Non-Aktif</option>

                                    </select>

                                    @error('status_students')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Tambahkan elemen formulir lainnya seperti di halaman create -->

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                    <a href="{{ route('students.index') }}" class="btn btn-secondary">
                                        {{ __('Batal') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
