@extends('Superadmin.layouts.main')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pemilih</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Pemilih</li>
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
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ url('dashboardSuperadmin/Siswa') }}" method="GET">
                            <div class="input-group">
                                <select name="status" class="form-select ms-2">
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                <button type="submit" class="btn btn-primary">Set</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ url('/dashboardSuperadmin/Siswa/create') }}" class="btn btn-primary">Tambah
                            Mahasiswa</a>
                        <a href="#" class="btn btn-success ms-2">Import</a> <!-- Tambah tombol Import di sini -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <form action="{{ url('dashboardSuperadmin/Siswa') }}" method="GET">
                            <div class="input-group">
                                <select name="perPage" class="form-select">
                                    <option value="" {{ request('perPage') == '' ? 'selected' : '' }}>All</option>
                                    @for ($i = 1; $i <= 100; $i++)
                                        <option value="{{ $i }}"
                                            {{ request('perPage') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="submit" class="btn btn-primary">Set</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 mb-4 d-flex justify-content-end">
                        <form action="{{ url('dashboardSuperadmin/Siswa') }}" method="GET">
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
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS Siswa</th>
                                <th>Kelas</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->kelas }}</td>
                                    <td>
                                        <a href="{{ url('dashboardSuperadmin/Siswa/edit/' . $item->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <button type="button" class="btn btn-danger btn-sm delete-button"
                                            data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                            data-nis="{{ $item->nis }}" data-kelas="{{ $item->kelas }}">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start">
                    Jumlah Data: {{ $data->count() }} </br>
                    Jumlah Data Asli: {{ $data->total() }}
                </div>
                <div class="d-flex justify-content-end">
                    {{ $data->links('pagination::bootstrap-4') }}
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
                    <p><strong>Nama:</strong> <span id="modalNama"></span></p>
                    <p><strong>Nis:</strong> <span id="modalNis"></span></p>
                    <p><strong>Kelas:</strong> <span id="modalKelas"></span></p>
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
                    const nama = this.getAttribute('data-nama');
                    const nis = this.getAttribute('data-nis');
                    const kelas = this.getAttribute('data-kelas');

                    document.getElementById('modalNis').textContent = nis;
                    document.getElementById('modalNama').textContent = nama;
                    document.getElementById('modalKelas').textContent = kelas;
                    document.getElementById('deleteForm').setAttribute('action',
                        '{{ url('dashboardSuperadmin/Siswa/destroy') }}/' + id);

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        });
    </script>
@endsection
