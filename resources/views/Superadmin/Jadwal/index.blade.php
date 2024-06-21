@extends('Superadmin.layouts.main')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp
    <div class="container-fluid px-4">
        <h1 class="mt-4">Jadwal</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Jadwal</li>
        </ol>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
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
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    </div>
                </div>
                <div class="row">
                    {{-- Tampilan untuk Jadwal Orasi --}}
                    @forelse ($jadwalOrasi as $jo)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <span class="badge bg-success">Jadwal Orasi</span>
                                    <p class="card-text">Tanggal Orasi Vote:
                                        {{ Carbon::parse($jo->tanggal_orasi_vote)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    <p class="card-text">Jam Orasi Mulai:
                                        {{ Carbon::parse($jo->jam_orasi_mulai)->format('H:i') }} WIB</p>
                                    <p class="card-text">Tempat Orasi: {{ $jo->tempat_orasi }}</p>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('jadwal-orasi.edit', $jo) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ url('dashboardSuperadmin/Jadwal/destroy/orasi/' . $jo->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text text-center">Data tidak ditemukan</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    {{-- Tampilan untuk Jadwal Votes --}}
                    @forelse ($jadwalVotes as $jv)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <span class="badge bg-info">Jadwal Voting</span>
                                    <p class="card-text">Tanggal Awal Voting:
                                        {{ Carbon::parse($jv->tanggal_awal_vote)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    <p class="card-text">Tanggal Akhir Voting:
                                        {{ Carbon::parse($jv->tanggal_akhir_vote)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    <p class="card-text">Tempat Voting: {{ $jv->tempat_vote }}</p>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('jadwal-votes.edit', $jv) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ url('dashboardSuperadmin/Jadwal/destroy/votes/' . $jv->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text text-center">Data tidak ditemukan</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    {{-- Tampilan untuk Jadwal Result Vote --}}
                    @forelse ($jadwalResultVote as $jrv)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <span class="badge bg-danger">Jadwal Pembacaan Hasil</span>
                                    <p class="card-text">Tanggal Pembacaan Hasil:
                                        {{ Carbon::parse($jrv->tanggal_result_vote)->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    <p class="card-text">Jam Pembacaan Hasil:
                                        {{ Carbon::parse($jrv->jam_result_vote)->format('H:i') }} WIB</p>
                                    <p class="card-text">Tempat Pembacaan Hasil: {{ $jrv->tempat_result_vote }}</p>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('jadwal-result.edit', $jrv) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ url('dashboardSuperadmin/Jadwal/destroy/result/' . $jrv->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text text-center">Data tidak ditemukan</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2024</div>
            </div>
        </div>
    </footer>
@endsection
