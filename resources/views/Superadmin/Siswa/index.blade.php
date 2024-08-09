@extends('Superadmin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Pemilih</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemilih</h6>
        </div>
        <div class="card-body">
            <a href="{{ url('/dashboardSuperadmin/Siswa/create') }}" class="btn btn-primary">Tambah
                Siswa</a>
            {{-- <button id="createUserBtn" class="btn btn-success float-right mb-3">
                <i class="fas fa-plus"></i> Create Users
            </button> --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS Siswa</th>
                            <th>Kelas</th>
                            <th>Status Pemilihan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var dataMaster = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('siswa-list-superadmin') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'nis',
                        name: 'nis'
                    },
                    {
                        data: 'kelas',
                        name: 'kelas'
                    },
                    {
                        data: 'status_vote',
                        name: 'status_vote'
                    },
                    {
                        data: 'uuid',
                        name: 'uuid',
                        orderable: false,
                        searchable: false
                    }
                ],
                autoWidth: false,
                drawCallback: function(settings) {
                    $('a').tooltip();
                }
            });
        });
    </script>
    {{-- <div class="container-fluid px-4">
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
                                    <option value="">All</option>
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
                            Siswa</a>
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
                                <th>Status Pemilihan</th>
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
                                        @if ($item->StatusVote)
                                            <span class="badge badge-success">Sudah Memilih</span>
                                        @else
                                            <span class="badge badge-danger">Belum Memilih</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('dashboardSuperadmin/Siswa/edit/' . $item->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ url('dashboardSuperadmin/Siswa/destroy/' . $item->id) }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this item?');">Hapus</button>
                                        </form>
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
    </footer> --}}
@endsection
