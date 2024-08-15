@extends('Superadmin.layouts.index')
@section('content')
    <div class="page-heading">
        <div class="page-title" style="display: flex; align-items: center; justify-content: space-between;">
            <h3>Profile Statistics</h3>
            <div class="form-check mr-1 form-switch" style="display: flex; align-items: center;">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="set_vote" value="1"
                    {{ $statusvote->first()->set_vote == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="flexSwitchCheckDefault" style="margin-left: 10px;">
                    @if ($statusvote->first()->set_vote == 1)
                        <span class="badge bg-success">Open Vote</span>
                    @else
                        <span class="badge bg-danger">Closed Vote</span>
                    @endif
                </label>
            </div>
        </div>

    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Profile Views
                                        </h6>
                                        <h6 class="font-extrabold mb-0">112.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Followers</h6>
                                        <h6 class="font-extrabold mb-0">183.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Following</h6>
                                        <h6 class="font-extrabold mb-0">80.000</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Saved Post</h6>
                                        <h6 class="font-extrabold mb-0">112</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Saved Post</h6>
                                        <h6 class="font-extrabold mb-0">112</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="width: 625px">
                            <div class="card-header" style="text-align: center;">
                                <h4>Perbandingan Pemilih dan Jumlah Siswa</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-visitors-profile"></div>
                            </div>
                            {{-- <div class="card-header">
            <h4>Profile Visit</h4>
        </div>
        <div class="card-body">
            <div id="chart-profile-visit"></div>
        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                {{-- <div class="card">
                    <div class="card-header">
                        <h4>Perbandingan Pemilih dan jumlah Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Yakin</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var totalstudent = {!! json_encode($datastudent) !!};
        var totalvoter = {!! json_encode($datavoter) !!};
        // console.log(totalstudent);
    </script>
    <script>
        $(document).ready(function() {
            let switchElement = $('#flexSwitchCheckDefault');
            let modal = $('#confirmationModal');
            let modalMessage = $('#modalMessage');
            let confirmButton = $('#confirmButton');

            switchElement.on('change', function() {
                let isChecked = $(this).is(':checked');
                let setVote = isChecked ? 1 : 0;

                // Set the modal message based on the checkbox state
                if (isChecked) {
                    modalMessage.text('Apakah Anda yakin untuk membuka votenya?');
                } else {
                    modalMessage.text('Apakah Anda yakin untuk menutup votenya?');
                }

                // Show the modal
                modal.modal('show');

                // If confirmed, send the AJAX request
                confirmButton.off('click').on('click', function() {
                    $.ajax({
                        url: '{{ route('dashboard.superadmin.setting-vote') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            set_vote: setVote
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.reload();
                            } else {
                                alert('Setting gagal.');
                            }
                        },
                        error: function(response) {
                            alert('Setting gagal.');
                        }
                    });

                    // Hide the modal after confirmation
                    modal.modal('hide');
                });

                // Revert the checkbox state if the user cancels the action
                modal.on('hidden.bs.modal', function() {
                    switchElement.prop('checked', !isChecked);
                });
            });
        });
    </script>
@endsection
