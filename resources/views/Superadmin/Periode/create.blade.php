@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tambah Periode Baru') }}</div>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script>
                            setTimeout(function() {
                                const alert = document.querySelector('.alert');
                                if (alert) {
                                    alert.classList.remove('show');
                                    alert.classList.add('fade');
                                    setTimeout(function() {
                                        alert.remove();
                                    }, 500);
                                }
                            }, 5000); // 5000 milliseconds = 5 seconds
                        </script>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('periode.store') }}">
                            @csrf

                            <div class="mb-3 row">
                                <label for="periode_nama"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Nama Periode') }}</label>

                                <div class="col-md-6">
                                    <input id="periode_nama" type="text"
                                        class="form-control @error('periode_nama') is-invalid @enderror" name="periode_nama"
                                        value="{{ old('periode_nama') }}" required autofocus>

                                    @error('periode_nama')
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
                                        name="periode_kepala_sekolah" value="{{ old('periode_kepala_sekolah') }}" required>

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
                                        name="periode_no_kepala_sekolah" value="{{ old('periode_no_kepala_sekolah') }}"
                                        required>

                                    @error('periode_no_kepala_sekolah')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="actif"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Status Aktif') }}</label>

                                <div class="col-md-6">
                                    <select id="actif" class="form-select @error('actif') is-invalid @enderror"
                                        name="actif" required>
                                        <option value="">Pilih Status Aktif</option>
                                        <option value="1" {{ old('actif') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="2" {{ old('actif') == '2' ? 'selected' : '' }}>Non-Aktif
                                        </option>
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
                                        {{ __('Tambah') }}
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
