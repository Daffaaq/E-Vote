@extends('Superadmin.layouts.index')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Kandidat</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kandidat</h6>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ url('/dashboardSuperadmin/Candidate/create') }}" class="btn btn-primary"
                    style="margin-right: 5px;">Tambah Kandidat</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="CandidateTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>nama_ketua</th>
                            @if ($candidates && $candidates->status == 'ganda')
                                <th>nama_wakil_ketua</th>
                            @endif
                            <th>Jargon</th>
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
            var columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_ketua',
                    name: 'nama_ketua'
                },
                {
                    data: 'slogan',
                    name: 'slogan'
                },
                {
                    data: 'uuid',
                    name: 'uuid',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `
                            <a href="/dashboardSuperadmin/Candidate/edit/${data}" class="btn icon btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button class="btn icon btn-sm btn-danger" onclick="confirmDelete('${data}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        `;
                    }
                }
            ];

            @if ($candidates && $candidates->status == 'ganda')
                columns.splice(2, 0, {
                    data: 'nama_wakil_ketua',
                    name: 'nama_wakil_ketua'
                });
            @endif

            var dataMaster = $('#CandidateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('candidate-list-superadmin') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                columns: columns,
                autoWidth: false,
                drawCallback: function(settings) {
                    $('a').tooltip();
                }
            });
            $('#closeModalHeader, #closeModalFooter').on('click', function() {
                console.log('close');
                $('#deleteConfirmationModal').modal('hide');
            });
        });

        function confirmDelete(uuid) {
            $('#deleteForm').attr('action', `/dashboardSuperadmin/Candidate/destroy/${uuid}`);
            $('#deleteConfirmationModal').modal('show');
        }
    </script>
@endsection
