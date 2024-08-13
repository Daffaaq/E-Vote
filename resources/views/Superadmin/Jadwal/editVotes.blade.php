@extends('Superadmin.layouts.index')

@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Jadwal Vote') }}</div>
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
                        <form method="POST" action="{{ route('jadwal-votes.update', $jadwalVotes->uuid) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row d-none">
                                <label for="periode_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Periode ID') }}</label>
                                <div class="col-md-6">
                                    <input id="periode_id" type="hidden" name="periode_id"
                                        value="{{ old('periode_id', $jadwalVotes->periode_id) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_awal_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Awal Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tanggal_awal_vote" type="date"
                                        class="form-control @error('tanggal_awal_vote') is-invalid @enderror"
                                        name="tanggal_awal_vote"
                                        value="{{ old('tanggal_awal_vote', $jadwalVotes->tanggal_awal_vote) }}">
                                    @error('tanggal_awal_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tanggal_akhir_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Akhir Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tanggal_akhir_vote" type="date"
                                        class="form-control @error('tanggal_akhir_vote') is-invalid @enderror"
                                        name="tanggal_akhir_vote"
                                        value="{{ old('tanggal_akhir_vote', $jadwalVotes->tanggal_akhir_vote) }}">
                                    @error('tanggal_akhir_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tempat_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tempat Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tempat_vote" type="text"
                                        class="form-control @error('tempat_vote') is-invalid @enderror" name="tempat_vote"
                                        value="{{ old('tempat_vote', $jadwalVotes->tempat_vote) }}">
                                    @error('tempat_vote')
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
                                    <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">
                                        {{ __('Cancel') }}
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
