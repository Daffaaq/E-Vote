@extends('Superadmin.layouts.main')
@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update Data Mahasiswa') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url('/dashboardSuperadmin/Periode/update/' . $periode->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Isi formulir dengan data mahasiswa yang ada -->
                            <div class="mb-3 row">
                                <label for="nama"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                                <div class="col-md-6">
                                    <input id="nama" type="text"
                                        class="form-control @error('periode_nama') is-invalid @enderror" name="periode_nama"
                                        value="{{ $periode->periode_nama }}" required autofocus>

                                    @error('nama')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="periode_kepala_sekolah"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Kepala Sekolah') }}</label>

                                <div class="col-md-6">
                                    <input id="periode_kepala_sekolah" type="text"
                                        class="form-control @error('periode_kepala_sekolah') is-invalid @enderror"
                                        name="periode_kepala_sekolah" value="{{ $periode->periode_kepala_sekolah }}"
                                        required autofocus>

                                    @error('periode_kepala_sekolah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="periode_no_kepala_sekolah"
                                    class="col-md-4 col-form-label text-md-right">{{ __('No. Kepala Sekolah') }}</label>

                                <div class="col-md-6">
                                    <input id="periode_no_kepala_sekolah" type="text"
                                        class="form-control @error('periode_no_kepala_sekolah') is-invalid @enderror"
                                        name="periode_no_kepala_sekolah" value="{{ $periode->periode_no_kepala_sekolah }}"
                                        required autofocus>

                                    @error('periode_no_kepala_sekolah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Tambahkan elemen formulir lainnya seperti di halaman create -->

                            <div class="mb-3 row">
                                <label for="actif"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Status Aktif') }}</label>

                                <div class="col-md-6">
                                    <select id="actif" class="form-select @error('actif') is-invalid @enderror"
                                        name="actif" required>
                                        <option value="">Pilih Status Aktif</option>
                                        <option value="1" {{ $periode->actif == '1' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="2" {{ $periode->actif == '2' ? 'selected' : '' }}>
                                            Non-Aktif</option>
                                    </select>

                                    @error('actif')
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
                                    <a href="{{ route('periode.index') }}" class="btn btn-secondary">
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
