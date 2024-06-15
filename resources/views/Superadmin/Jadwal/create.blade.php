@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Jadwal</div>

                    <div class="card-body">
                        <form id="mainForm" method="POST" action="{{ route('jadwal.store') }}">
                            @csrf
                            {{-- Langkah 1: Isi Jadwal Orasi --}}
                            <div id="step-orasi">
                                <h5><span class="badge badge-success">Langkah 1: Isi Jadwal Orasi</span></h5>
                                <div class="form-group">
                                    <label for="tanggal_orasi_vote">Tanggal Orasi Vote</label>
                                    <input id="tanggal_orasi_vote" type="date"
                                        class="form-control @error('tanggal_orasi_vote') is-invalid @enderror"
                                        name="tanggal_orasi_vote" value="{{ old('tanggal_orasi_vote') }}" required>
                                    @error('tanggal_orasi_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jam_orasi_mulai">Jam Orasi Mulai</label>
                                    <input id="jam_orasi_mulai" type="time"
                                        class="form-control @error('jam_orasi_mulai') is-invalid @enderror"
                                        name="jam_orasi_mulai" value="{{ old('jam_orasi_mulai') }}" required>
                                    @error('jam_orasi_mulai')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat_orasi">Tempat Orasi</label>
                                    <input id="tempat_orasi" type="text"
                                        class="form-control @error('tempat_orasi') is-invalid @enderror" name="tempat_orasi"
                                        value="{{ old('tempat_orasi') }}" required>
                                    @error('tempat_orasi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="button" onclick="saveAndNext('step-votes')"
                                        class="btn btn-primary">Selanjutnya</button>
                                </div>
                            </div>

                            {{-- Langkah 2: Isi Jadwal Votes --}}
                            <div id="step-votes" style="display: none;">
                                <h5><span class="badge badge-info">Langkah 2: Isi Jadwal Votes</span></h5>
                                <div class="form-group">
                                    <label for="tanggal_awal_vote">Tanggal Awal Vote</label>
                                    <input id="tanggal_awal_vote" type="date"
                                        class="form-control @error('tanggal_awal_vote') is-invalid @enderror"
                                        name="tanggal_awal_vote" value="{{ old('tanggal_awal_vote') }}" required>
                                    @error('tanggal_awal_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_akhir_vote">Tanggal Akhir Vote</label>
                                    <input id="tanggal_akhir_vote" type="date"
                                        class="form-control @error('tanggal_akhir_vote') is-invalid @enderror"
                                        name="tanggal_akhir_vote" value="{{ old('tanggal_akhir_vote') }}" required>
                                    @error('tanggal_akhir_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat_vote">Tempat Vote</label>
                                    <input id="tempat_vote" type="text"
                                        class="form-control @error('tempat_vote') is-invalid @enderror" name="tempat_vote"
                                        value="{{ old('tempat_vote') }}" required>
                                    @error('tempat_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="button" onclick="prevStep('step-orasi')"
                                        class="btn btn-secondary mr-2">Sebelumnya</button>
                                    <button type="button" onclick="saveAndNext('step-result-vote')"
                                        class="btn btn-primary">Selanjutnya</button>
                                </div>
                            </div>

                            {{-- Langkah 3: Isi Jadwal Result Vote --}}
                            <div id="step-result-vote" style="display: none;">
                                <h5><span class="badge badge-warning">Langkah 3: Isi Jadwal Result Vote</span></h5>
                                <div class="form-group">
                                    <label for="tanggal_result_vote">Tanggal Result Vote</label>
                                    <input id="tanggal_result_vote" type="date"
                                        class="form-control @error('tanggal_result_vote') is-invalid @enderror"
                                        name="tanggal_result_vote" value="{{ old('tanggal_result_vote') }}" required>
                                    @error('tanggal_result_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="jam_result_vote">Jam Result Vote</label>
                                    <input id="jam_result_vote" type="time"
                                        class="form-control @error('jam_result_vote') is-invalid @enderror"
                                        name="jam_result_vote" value="{{ old('jam_result_vote') }}" required>
                                    @error('jam_result_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat_result_vote">Tempat Result Vote</label>
                                    <input id="tempat_result_vote" type="text"
                                        class="form-control @error('tempat_result_vote') is-invalid @enderror"
                                        name="tempat_result_vote" value="{{ old('tempat_result_vote') }}" required>
                                    @error('tempat_result_vote')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="button" onclick="prevStep('step-votes')"
                                        class="btn btn-secondary mr-2">Sebelumnya</button>
                                    <button type="button" onclick="saveAndNext('step-akhir')"
                                        class="btn btn-primary">Selanjutnya</button>
                                </div>
                            </div>

                            {{-- Langkah Akhir: Verifikasi Jadwal --}}
                            <div id="step-akhir" style="display: none;">
                                <span class="badge bg-success">Jadwal Orasi</span>
                                <div class="form-group">
                                    <label>Tanggal Orasi Vote</label>
                                    <p id="verif_tanggal_orasi_vote"></p>
                                </div>

                                <div class="form-group">
                                    <label>Jam Orasi Mulai</label>
                                    <p id="verif_jam_orasi_mulai"></p>
                                </div>

                                <div class="form-group">
                                    <label>Tempat Orasi</label>
                                    <p id="verif_tempat_orasi"></p>
                                </div>

                                <span class="badge bg-info">Jadwal Votes</span>
                                <div class="form-group">
                                    <label>Tanggal Awal Vote</label>
                                    <p id="verif_tanggal_awal_vote"></p>
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Akhir Vote</label>
                                    <p id="verif_tanggal_akhir_vote"></p>
                                </div>

                                <div class="form-group">
                                    <label>Tempat Vote</label>
                                    <p id="verif_tempat_vote"></p>
                                </div>
                                <span class="badge bg-danger">Jadwal Result Vote</span>
                                <div class="form-group">
                                    <label>Tanggal Result Vote</label>
                                    <p id="verif_tanggal_result_vote"></p>
                                </div>

                                <div class="form-group">
                                    <label>Jam Result Vote</label>
                                    <p id="verif_jam_result_vote"></p>
                                </div>

                                <div class="form-group">
                                    <label>Tempat Result Vote</label>
                                    <p id="verif_tempat_result_vote"></p>
                                </div>

                                <div class="form-group">
                                    <button type="button" onclick="prevStep('step-result-vote')"
                                        class="btn btn-secondary mr-2">Sebelumnya</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function saveAndNext(nextStep) {
            if (nextStep === 'step-votes') {
                sessionStorage.setItem('tanggal_orasi_vote', document.getElementById('tanggal_orasi_vote').value);
                sessionStorage.setItem('jam_orasi_mulai', document.getElementById('jam_orasi_mulai').value);
                sessionStorage.setItem('tempat_orasi', document.getElementById('tempat_orasi').value);
            } else if (nextStep === 'step-result-vote') {
                sessionStorage.setItem('tanggal_awal_vote', document.getElementById('tanggal_awal_vote').value);
                sessionStorage.setItem('tanggal_akhir_vote', document.getElementById('tanggal_akhir_vote').value);
                sessionStorage.setItem('tempat_vote', document.getElementById('tempat_vote').value);
            } else if (nextStep === 'step-akhir') {
                sessionStorage.setItem('tanggal_result_vote', document.getElementById('tanggal_result_vote').value);
                sessionStorage.setItem('jam_result_vote', document.getElementById('jam_result_vote').value);
                sessionStorage.setItem('tempat_result_vote', document.getElementById('tempat_result_vote').value);

                // Display values in the verification step
                document.getElementById('verif_tanggal_orasi_vote').textContent = sessionStorage.getItem(
                    'tanggal_orasi_vote');
                document.getElementById('verif_jam_orasi_mulai').textContent = sessionStorage.getItem('jam_orasi_mulai');
                document.getElementById('verif_tempat_orasi').textContent = sessionStorage.getItem('tempat_orasi');
                document.getElementById('verif_tanggal_awal_vote').textContent = sessionStorage.getItem(
                    'tanggal_awal_vote');
                document.getElementById('verif_tanggal_akhir_vote').textContent = sessionStorage.getItem(
                    'tanggal_akhir_vote');
                document.getElementById('verif_tempat_vote').textContent = sessionStorage.getItem('tempat_vote');
                document.getElementById('verif_tanggal_result_vote').textContent = sessionStorage.getItem(
                    'tanggal_result_vote');
                document.getElementById('verif_jam_result_vote').textContent = sessionStorage.getItem('jam_result_vote');
                document.getElementById('verif_tempat_result_vote').textContent = sessionStorage.getItem(
                    'tempat_result_vote');
            }

            document.getElementById(nextStep).style.display = 'block';

            // Hide the current step
            if (nextStep !== 'step-orasi') {
                document.getElementById('step-orasi').style.display = 'none';
            }
            if (nextStep !== 'step-votes') {
                document.getElementById('step-votes').style.display = 'none';
            }
            if (nextStep !== 'step-result-vote') {
                document.getElementById('step-result-vote').style.display = 'none';
            }
            if (nextStep !== 'step-akhir') {
                document.getElementById('step-akhir').style.display = 'none';
            }
        }

        function prevStep(prevStep) {
            document.getElementById(prevStep).style.display = 'block';

            // Hide the current step
            if (prevStep !== 'step-orasi') {
                document.getElementById('step-orasi').style.display = 'none';
            }
            if (prevStep !== 'step-votes') {
                document.getElementById('step-votes').style.display = 'none';
            }
            if (prevStep !== 'step-result-vote') {
                document.getElementById('step-result-vote').style.display = 'none';
            }
            if (prevStep !== 'step-akhir') {
                document.getElementById('step-akhir').style.display = 'none';
            }
        }

        // Load saved data on page load
        window.onload = function() {
            if (sessionStorage.getItem('tanggal_orasi_vote')) {
                document.getElementById('tanggal_orasi_vote').value = sessionStorage.getItem('tanggal_orasi_vote');
            }
            if (sessionStorage.getItem('jam_orasi_mulai')) {
                document.getElementById('jam_orasi_mulai').value = sessionStorage.getItem('jam_orasi_mulai');
            }
            if (sessionStorage.getItem('tempat_orasi')) {
                document.getElementById('tempat_orasi').value = sessionStorage.getItem('tempat_orasi');
            }
            if (sessionStorage.getItem('tanggal_awal_vote')) {
                document.getElementById('tanggal_awal_vote').value = sessionStorage.getItem('tanggal_awal_vote');
            }
            if (sessionStorage.getItem('tanggal_akhir_vote')) {
                document.getElementById('tanggal_akhir_vote').value = sessionStorage.getItem('tanggal_akhir_vote');
            }
            if (sessionStorage.getItem('tempat_vote')) {
                document.getElementById('tempat_vote').value = sessionStorage.getItem('tempat_vote');
            }
            if (sessionStorage.getItem('tanggal_result_vote')) {
                document.getElementById('tanggal_result_vote').value = sessionStorage.getItem('tanggal_result_vote');
            }
            if (sessionStorage.getItem('jam_result_vote')) {
                document.getElementById('jam_result_vote').value = sessionStorage.getItem('jam_result_vote');
            }
            if (sessionStorage.getItem('tempat_result_vote')) {
                document.getElementById('tempat_result_vote').value = sessionStorage.getItem('tempat_result_vote');
            }
        }

        document.getElementById('mainForm').addEventListener('submit', () => {
            console.log("Tanggal Orasi Vote:", sessionStorage.getItem('tanggal_orasi_vote'));
            console.log("Jam Orasi Mulai:", sessionStorage.getItem('jam_orasi_mulai'));
            console.log("Tempat Orasi:", sessionStorage.getItem('tempat_orasi'));
            console.log("Tanggal Awal Vote:", sessionStorage.getItem('tanggal_awal_vote'));
            console.log("Tanggal Akhir Vote:", sessionStorage.getItem('tanggal_akhir_vote'));
            console.log("Tempat Vote:", sessionStorage.getItem('tempat_vote'));
            console.log("Tanggal Result Vote:", sessionStorage.getItem('tanggal_result_vote'));
            console.log("Jam Result Vote:", sessionStorage.getItem('jam_result_vote'));
            console.log("Tempat Result Vote:", sessionStorage.getItem('tempat_result_vote'));
            // Ensure data is stored in the form fields before submission
            document.getElementById('tanggal_orasi_vote').value = sessionStorage.getItem('tanggal_orasi_vote');
            document.getElementById('jam_orasi_mulai').value = sessionStorage.getItem('jam_orasi_mulai');
            document.getElementById('tempat_orasi').value = sessionStorage.getItem('tempat_orasi');
            document.getElementById('tanggal_awal_vote').value = sessionStorage.getItem('tanggal_awal_vote');
            document.getElementById('tanggal_akhir_vote').value = sessionStorage.getItem('tanggal_akhir_vote');
            document.getElementById('tempat_vote').value = sessionStorage.getItem('tempat_vote');
            document.getElementById('tanggal_result_vote').value = sessionStorage.getItem('tanggal_result_vote');
            document.getElementById('jam_result_vote').value = sessionStorage.getItem('jam_result_vote');
            document.getElementById('tempat_result_vote').value = sessionStorage.getItem('tempat_result_vote');

            document.getElementById('mainForm').submit();
            sessionStorage.removeItem('tanggal_orasi_vote');
            sessionStorage.removeItem('jam_orasi_mulai');
            sessionStorage.removeItem('tempat_orasi');
            sessionStorage.removeItem('tanggal_awal_vote');
            sessionStorage.removeItem('tanggal_akhir_vote');
            sessionStorage.removeItem('tempat_vote');
            sessionStorage.removeItem('tanggal_result_vote');
            sessionStorage.removeItem('jam_result_vote');
            sessionStorage.removeItem('tempat_result_vote');
        });
    </script>
@endsection
