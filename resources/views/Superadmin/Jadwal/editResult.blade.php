@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jadwal.index') }}">Daftar Jadwal</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Daftar Jadwal Pembacaan Hasil</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Jadwal Pembacaan Hasil') }}</div>
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
                        <form method="POST" action="{{ route('jadwal-result.update', $jadwalResultVote->uuid) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row d-none">
                                <label for="periode_id"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Periode ID') }}</label>
                                <div class="col-md-6">
                                    <input id="periode_id" type="hidden" name="periode_id"
                                        value="{{ old('periode_id', $jadwalResultVote->periode_id) }}">
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="tanggal_result_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Result Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tanggal_result_vote" type="date"
                                        class="form-control @error('tanggal_result_vote') is-invalid @enderror"
                                        name="tanggal_result_vote"
                                        value="{{ old('tanggal_result_vote', $jadwalResultVote->tanggal_result_vote) }}">
                                    @error('tanggal_result_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="jam_result_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Jam Result Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="jam_result_vote" type="time"
                                        class="form-control @error('jam_result_vote') is-invalid @enderror"
                                        name="jam_result_vote"
                                        value="{{ old('jam_result_vote', $jadwalResultVote->jam_result_vote) }}">
                                    @error('jam_result_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tempat_result_vote"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Tempat Result Vote') }}</label>
                                <div class="col-md-6">
                                    <input id="tempat_result_vote" type="text"
                                        class="form-control @error('tempat_result_vote') is-invalid @enderror"
                                        name="tempat_result_vote"
                                        value="{{ old('tempat_result_vote', $jadwalResultVote->tempat_result_vote) }}">
                                    @error('tempat_result_vote')
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
