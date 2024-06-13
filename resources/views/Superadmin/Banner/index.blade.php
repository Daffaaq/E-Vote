@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Banner</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Banner</li>
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
                        <a href="{{ Route('banner.create') }}" class="btn btn-primary">Tambah Banner</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('banner.index') }}" method="GET" class="d-flex align-items-center">
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
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $periode)
                                <tr>
                                    <td>{{ $periode->tittle }}</td>
                                    <td>{{ $periode->desc }}</td>
                                    <td>
                                        <a href="{{ route('banner.edit', $periode) }}" class="btn btn-warning">Edit</a>
                                        <button type="button" class="btn btn-danger delete-button"
                                            data-id="{{ $periode->id }}" data-tittle="{{ $periode->tittle }}"
                                            data-desc="{{ $periode->desc }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start">
                    Jumlah Data: {{ $banners->count() }} <br>
                    Jumlah Data Asli: {{ $banners->total() }}
                </div>
                <div class="d-flex justify-content-end">
                    {{ $banners->links('pagination::bootstrap-4') }}
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
                    const judul = this.getAttribute('data-tittle');
                    const deskripsi = this.getAttribute('data-desc');

                    document.getElementById('modalDeskripsi').textContent = deskripsi;
                    document.getElementById('modalJudul').textContent = judul;
                    document.getElementById('deleteForm').setAttribute('action',
                        '{{ url('dashboardSuperadmin/Banner/destroy') }}/' + id);

                    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                    deleteModal.show();
                });
            });
        });
    </script>
@endsection
