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
                                        <button type="button" class="btn btn-danger btn-sm delete-button"
                                            data-id="{{ $jo->id }}" data-title=" {{ Carbon::parse($jo->tanggal_orasi_vote)->isoFormat('dddd, D MMMM YYYY') }}"
                                            data-desc="{{ Carbon::parse($jo->jam_orasi_mulai)->format('H:i') }} "data-parent-route="jadwalorasi">Delete</button>
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
                                        <button type="button" class="btn btn-danger btn-sm delete-button"
                                            data-id="{{ $jv->id }}" data-title="{{ Carbon::parse($jv->tanggal_awal_vote)->isoFormat('dddd, D MMMM YYYY') }}"
                                            data-desc="{{ Carbon::parse($jv->tanggal_akhir_vote)->isoFormat('dddd, D MMMM YYYY') }}"
                                            data-parent-route="jadwalvotes">Delete</button>
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
                                        <button type="button" class="btn btn-danger btn-sm delete-button"
                                            data-id="{{ $jrv->id }}" data-title="{{ Carbon::parse($jrv->tanggal_result_vote)->isoFormat('dddd, D MMMM YYYY') }}"
                                            data-desc="{{ Carbon::parse($jrv->jam_result_vote)->format('H:i') }}"data-parent-route="jadwalresult">Delete</button>
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

    <!-- Modal Konfirmasi Penghapusan -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data berikut?</p>
                    <p><strong>Judul :</strong> <span id="modalJudul"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const desc = this.getAttribute('data-desc');
                    const parentRoute = this.getAttribute('data-parent-route');

                    document.getElementById('modalJudul').textContent = title;
                    document.getElementById('modalDeskripsi').textContent = desc;

                    let url;
                    if (parentRoute === 'jadwalorasi') {
                        url = '{{ route('jadwal-orasi.destroy', ':id') }}';
                    } else if (parentRoute === 'jadwalvotes') {
                        url = '{{ route('jadwal-votes.destroy', ':id') }}';
                    } else if (parentRoute === 'jadwalresult') {
                        url = '{{ route('jadwal-result.destroy', ':id') }}';
                    }

                    url = url.replace(':id', id);

                    document.getElementById('deleteForm').setAttribute('action', url);

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        });
    </script>
@endsection
