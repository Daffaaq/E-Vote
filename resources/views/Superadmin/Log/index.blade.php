@extends('Superadmin.layouts.index')
<style>
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: .25rem;
    }
</style>
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Log</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Log</h6>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="LogTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Aksi</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationLabel">Konfirmasi Hapus Log</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="alert" id="modalAlert" style="display:none;"></div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus log ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var dataMaster = $('#LogTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('log.superadmin.list') }}',
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
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'uuid',
                        name: 'uuid',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `
                            <a href="/dashboardSuperadmin/log/show/${data}" class="btn icon btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button class="btn icon btn-sm btn-danger" onclick="showDeleteModal('${data}')">
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

            console.log("DataTable loaded");

            var logToDeleteUuid;

            window.showDeleteModal = function(uuid) {
                logToDeleteUuid = uuid;
                $('#deleteConfirmationModal').modal('show');
            };

            $('#confirmDelete').on('click', function() {
                if (logToDeleteUuid) {
                    $.ajax({
                        url: `/dashboardSuperadmin/log/destroy/${logToDeleteUuid}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                            } else {
                                showAlert('error', response.message);
                            }
                        },
                        error: function(xhr) {
                            showAlert('error', 'Terjadi kesalahan saat menghapus data.');
                        }
                    });
                }
            });

            function showAlert(type, message) {
                var alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                var alertHtml = `
                <div class="alert ${alertClass}" role="alert">
                    ${message}
                </div>
            `;
                $('#modalAlert').html(alertHtml).show(); // Tampilkan alert

                setTimeout(function() {
                    $('#modalAlert').fadeOut('slow', function() {
                        $('#deleteConfirmationModal').modal('hide'); // Tutup modal setelah fade out
                    });
                }, 5000); // 5000 ms = 5 detik
            }

            console.log("data masuk");
        });
    </script>
@endsection
