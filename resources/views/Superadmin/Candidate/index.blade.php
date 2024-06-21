@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Caketos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Caketos</li>
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
                }, 5000);
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
                }, 5000);
            </script>
        @endif
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('Candidate.create') }}" class="btn btn-primary">Tambah Calon Ketua Osis</a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('Candidate.index') }}" method="GET" class="d-flex align-items-center">
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
                                <th>Foto</th>
                                <th>Nama Ketua</th>
                                <th>Nama Wakil Ketua</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($candidates as $cd)
                                <tr>
                                    <td>
                                        @if ($cd->foto)
                                            <img src="{{ Storage::url($cd->foto) }}" alt="{{ $cd->nama }}"
                                                width="50">
                                        @else
                                            Belum ada foto
                                        @endif
                                    </td>
                                    <td>{{ $cd->nama_ketua }}</td>
                                    <td>{{ $cd->nama_wakil_ketua }}</td>
                                    <td>
                                        <a href="{{ route('Candidate.edit', $cd->slug) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ url('dashboardSuperadmin/Candidate/destroy/' . $cd->slug) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-start">
                    Jumlah Data: {{ $candidates->count() }} <br>
                    Jumlah Data Asli: {{ $candidates->total() }}
                </div>
                <div class="d-flex justify-content-end">
                    {{ $candidates->links('pagination::bootstrap-4') }}
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
