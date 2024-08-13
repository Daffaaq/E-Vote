@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Jadwal</li>
        </ol>
    </nav>
@endsection
@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp
    <style>
        .timeline {
            position: relative;
            margin: 0 auto;
            padding: 0;
            max-width: 600px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 50px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 20px;
            width: 2px;
            height: 100%;
            background-color: #dee2e6;
        }

        .timeline-badge {
            position: absolute;
            left: -30px;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
        }

        .timeline-content {
            padding: 10px 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="container-fluid px-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal</h6>
        </div>
        @if (session('error'))
            <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-light-success alert-dismissible fade show" style="height: 50px" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary">Tambah Jadwal</a>
                    </div>
                </div>
                @if ($jadwalOrasi->isNotEmpty() || $jadwalVotes->isNotEmpty() || $jadwalResultVote->isNotEmpty())
                    <div class="row mb-3">
                        <div class="col-md-12 text-end">
                            <div class="row mb-3">
                                @if ($jadwalOrasi->isNotEmpty() && $jadwalVotes->isNotEmpty() && $jadwalResultVote->isNotEmpty())
                                    <div class="col-md-12 text-end">
                                        <form action="{{ $routeUrl }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus semua jadwal ini?');">Hapus
                                                Semua Jadwal</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="timeline">
                            {{-- Timeline Item untuk Jadwal Orasi --}}
                            @forelse ($jadwalOrasi as $jo)
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-success">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h5 class="text-success">Jadwal Orasi</h5>
                                        <p><strong>Tanggal:</strong>
                                            {{ Carbon::parse($jo->tanggal_orasi_vote)->isoFormat('D MMMM YYYY') }}</p>
                                        <p><strong>Jam:</strong> {{ Carbon::parse($jo->jam_orasi_mulai)->format('H:i') }}
                                            WIB
                                        </p>
                                        <p><strong>Tempat:</strong> {{ $jo->tempat_orasi }}</p>
                                        <div class="d-flex justify-content-start mt-2">
                                            <a href="{{ route('jadwal-orasi.edit', $jo->uuid) }}"
                                                class="btn btn-warning btn-sm me-2">Edit</a>
                                            <form
                                                action="{{ url('dashboardSuperadmin/Jadwal/destroy/orasi/' . $jo->uuid) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah anda yakin ingin mengahapus?');">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-secondary">
                                        <i class="bi bi-exclamation-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p>Data tidak ditemukan</p>
                                    </div>
                                </div>
                            @endforelse

                            {{-- Timeline Item untuk Jadwal Votes --}}
                            @forelse ($jadwalVotes as $jv)
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-info">
                                        <i class="bi bi-bar-chart"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h5 class="text-info">Jadwal Voting</h5>
                                        <p><strong>Tanggal Awal:</strong>
                                            {{ Carbon::parse($jv->tanggal_awal_vote)->isoFormat('D MMMM YYYY') }}</p>
                                        <p><strong>Tanggal Akhir:</strong>
                                            {{ Carbon::parse($jv->tanggal_akhir_vote)->isoFormat('D MMMM YYYY') }}</p>
                                        <p><strong>Tempat:</strong> {{ $jv->tempat_vote }}</p>
                                        <div class="d-flex justify-content-start mt-2">
                                            <a href="{{ route('jadwal-votes.edit', $jv->uuid) }}"
                                                class="btn btn-warning btn-sm me-2">Edit</a>
                                            <form
                                                action="{{ url('dashboardSuperadmin/Jadwal/destroy/votes/' . $jv->uuid) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah anda yakin ingin mengahapus?');">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-secondary">
                                        <i class="bi bi-exclamation-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p>Data tidak ditemukan</p>
                                    </div>
                                </div>
                            @endforelse

                            {{-- Timeline Item untuk Jadwal Pembacaan Hasil --}}
                            @forelse ($jadwalResultVote as $jrv)
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-danger">
                                        <i class="bi bi-clipboard-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h5 class="text-danger">Jadwal Pembacaan Hasil</h5>
                                        <p><strong>Tanggal:</strong>
                                            {{ Carbon::parse($jrv->tanggal_result_vote)->isoFormat('D MMMM YYYY') }}</p>
                                        <p><strong>Jam:</strong> {{ Carbon::parse($jrv->jam_result_vote)->format('H:i') }}
                                            WIB
                                        </p>
                                        <p><strong>Tempat:</strong> {{ $jrv->tempat_result_vote }}</p>
                                        <div class="d-flex justify-content-start mt-2">
                                            <a href="{{ route('jadwal-result.edit', $jrv->uuid) }}"
                                                class="btn btn-warning btn-sm me-2">Edit</a>
                                            <form
                                                action="{{ url('dashboardSuperadmin/Jadwal/destroy/result/' . $jrv->uuid) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah anda yakin ingin mengahapus?');">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="timeline-item">
                                    <div class="timeline-badge bg-secondary">
                                        <i class="bi bi-exclamation-circle"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <p>Data tidak ditemukan</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @else
                    <div class="empty-state d-flex flex-column align-items-center">
                        <img src="{{ asset('Image-Assets/No-Data.png') }}" alt="No Data" class="img-fluid"
                            style="max-width: 300px;">
                        <h5 class="text-muted mt-3">Belum ada data jadwal yang tersedia</h5>
                        <a href="{{ route('jadwal.create') }}" class="btn btn-success mt-2">Tambah Jadwal Sekarang</a>
                    </div>
                @endif

            </div>
        </div>
    </div>


@endsection
