@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Users</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Users</h6>
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
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary" style="margin-right: 5px;">Tambah User</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" id="closeModalHeader" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus siswa ini?
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeModalFooter" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var dataMaster = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('users-list-superadmin') }}',
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        render: function(data, type, row) {
                            if (data == 'superadmin') {
                                return '<span class="badge bg-success">Superadmin</span>';
                            } else {
                                return '<span class="badge bg-info">Admin</span>';
                            }
                        }
                    },
                    {
                        data: 'uuid',
                        name: 'uuid',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                                <a href="/dashboardSuperadmin/Users/edit/${data}" class="btn icon btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn icon btn-sm btn-danger" onclick="confirmDelete('${data}')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            `;
                        }
                    }
                ],
                autoWidth: false,
                drawCallback: function(settings) {
                    $('a').tooltip();
                }
            });
            $('#closeModalHeader, #closeModalFooter').on('click', function() {
                $('#deleteConfirmationModal').modal('hide');
            });
        });

        function confirmDelete(uuid) {
            $('#deleteForm').attr('action', `/dashboardSuperadmin/Users/destroy/${uuid}`);
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endsection
