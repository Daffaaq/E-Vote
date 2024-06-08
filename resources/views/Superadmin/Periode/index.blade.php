@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Periode</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Periode</li>
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
                    <div class="col-md-12 d-flex justify-content-between">
                        <form action="{{ route('periode.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <select name="status" class="form-select ms-2">
                                    <option value="">All</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                <button type="submit" class="btn btn-primary">Set</button>
                            </div>
                        </form>
                        <a href="{{ Route('periode.create') }}" class="btn btn-primary">Tambah
                            Periode</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('periode.index') }}" method="GET" class="d-flex align-items-center">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width" id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Periode Nama</th>
                                <th>Kepala Sekolah</th>
                                <th>No Kepala Sekolah</th>
                                <th>Actif</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($periodes as $periode)
                                <tr>
                                    <td>{{ $periode->periode_nama }}</td>
                                    <td>{{ $periode->periode_kepala_sekolah }}</td>
                                    <td>{{ $periode->periode_no_kepala_sekolah }}</td>
                                    <td>{{ $periode->actif == 1 ? 'Active' : 'Nonactive' }}</td>
                                    <td>
                                        <a href="{{ route('periode.edit', $periode) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" class="btn btn-danger delete-button"
                                            data-id="{{ $periode->id }}" data-periode-nama="{{ $periode->periode_nama }}"
                                            data-kepala-sekolah="{{ $periode->periode_kepala_sekolah }}"
                                            data-no-kepala-sekolah="{{ $periode->periode_no_kepala_sekolah }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start">
                    Jumlah Data: {{ $periodes->count() }} <br>
                    Jumlah Data Asli: {{ $periodes->total() }}
                </div>
                <div class="d-flex justify-content-end">
                    {{ $periodes->links('pagination::bootstrap-4') }}
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
                    <p><strong>Periode Nama:</strong> <span id="modalNama"></span></p>
                    <p><strong>Nama Kepala Sekolah:</strong> <span id="modalNis"></span></p>
                    <p><strong>No Kepala Sekolah:</strong> <span id="modalKelas"></span></p>
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
                    const periode_nama = this.getAttribute('data-periode-nama');
                    const kepala_sekolah = this.getAttribute('data-kepala-sekolah');
                    const no_kepala_sekolah = this.getAttribute('data-no-kepala-sekolah');

                    document.getElementById('modalNis').textContent = kepala_sekolah;
                    document.getElementById('modalNama').textContent = periode_nama;
                    document.getElementById('modalKelas').textContent = no_kepala_sekolah;
                    document.getElementById('deleteForm').setAttribute('action',
                        '{{ url('dashboardSuperadmin/Periode/destroy') }}/' + id);

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        });
    </script>
@endsection
