<!-- View: edit.blade.php -->

@extends('Superadmin.layouts.main')
@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
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
    </div>
@endsection
