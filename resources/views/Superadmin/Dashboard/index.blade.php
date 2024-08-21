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
        <div class="page-title" style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
            {{-- <a href="{{ route('dashboard.superadmin.export-vote') }}" target="_blank"
                style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: white; background-color: #007bff; border-radius: 0.25rem; text-decoration: none; transition: background-color 0.2s;">
                Export Persentase
            </a> --}}
            <a href="#" id="export-button"
                style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: white; background-color: #007bff; border-radius: 0.25rem; text-decoration: none; transition: background-color 0.2s;">
                Export Persentase
            </a>

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
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">
                                            Pemilih
                                        </h6>
                                        <h6 class="font-extrabold mb-0">{{ $datastudent }}</h6>
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
                                            <i class="iconly-boldUser"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Candidate</h6>
                                        <h6 class="font-extrabold mb-0">{{ $countCandidate }}</h6>
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
                                            <i class="iconly-boldTick-Square"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Sudah Milih</h6>
                                        <h6 class="font-extrabold mb-0">{{ $datavoter }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-6 col-lg-3 col-md-6">
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
                    </div> --}}
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
                        </div>
                    </div>
                </div>
                @if ($isAboveThreshold)
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="width: 625px">
                                <div class="card-header" style="text-align: center;">
                                    <h4>Perbandingan Kandidat</h4>
                                    <button id="download-chart" class="btn btn-primary">Download Chart</button>
                                </div>
                                <div class="card-body">
                                    <div id="chart-candidate"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="width: 625px">
                                <div class="card-header" style="text-align: center;">
                                    <h4>Perbandingan Kandidat</h4>
                                    <button id="download-chart1" class="btn btn-primary">Download Chart</button>
                                </div>
                                <div class="card-body">
                                    <div id="candidateChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="card" style="width: 625px">
                            <div class="card-header" style="text-align: center;">
                                <h4>Perbandingan Kandidat</h4>
                            </div>
                            <div class="card-body">
                                <div id="candidateChart"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
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

    <style>
        .apexcharts-legend-marker {
            border-radius: 50% !important;
            width: 12px !important;
            height: 12px !important;
            margin-right: 8px !important;
        }

        .apexcharts-legend-marker[rel="0"] {
            border-radius: 0px !important;
        }

        /* Mengatur ulang legend untuk memastikan tidak ada kotak yang terlihat */
        .apexcharts-legend {
            display: flex !important;
            justify-content: center !important;
            /* Legend di tengah */
            align-items: center !important;
            flex-wrap: wrap !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Menghilangkan kotak yang mungkin muncul akibat elemen lainnya */
        .apexcharts-legend-series {
            padding: 0 !important;
            margin: 0 !important;
            background: none !important;
            box-shadow: none !important;
        }

        /* Jika ada padding atau margin yang menambah kotak, hilangkan */
        .apexcharts-legend-marker {
            padding: 0 !important;
            margin: 0 !important;
            box-shadow: none !important;
        }

        .apexcharts-legend-text {
            margin: 0 !important;
            padding: 0 !important;
        }

        .apexcharts-legend-text {
            padding-left: 15px;
            margin-left: -15px;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('export-button').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah aksi default dari anchor

            html2canvas(document.querySelector("#candidateChart")).then(canvas => {
                canvas.toBlob(function(blob) {
                    var formData = new FormData();
                    formData.append('chart', blob, 'chart.png');

                    fetch('/dashboardSuperadmin/save-chart', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => response.json())
                        .then(data => {
                            if (data.path) {
                                // Setelah gambar tersimpan, mulai proses download Excel
                                window.location.href =
                                    "{{ route('dashboard.superadmin.export-vote') }}";
                            } else {
                                alert('Failed to save chart image.');
                            }
                        });
                });
            });
        });
    </script>
    <script>
        var totalstudent = {!! json_encode($datastudent) !!};
        var totalvoter = {!! json_encode($datavoter) !!};
        var datanamacandidate = {!! json_encode($candidateNames) !!};
        var datanjumlahvote = {!! json_encode($candidateVotes) !!};
        // console.log(totalstudent);
    </script>
    <script>
        // Warna untuk setiap bagian chart
        let colors = ["#435ebe", "#55c6e8", "#ff6384"];

        // Membuat donut chart menggunakan ApexCharts
        var options = {
            series: datanjumlahvote,
            labels: datanamacandidate,
            colors: colors,
            chart: {
                type: 'donut',
                width: '100%',
                height: '350px',
            },
            legend: {
                position: 'bottom',
                itemMargin: {
                    horizontal: 10, // Jarak antar item legend
                    vertical: 5 // Jarak vertikal antar item legend
                }
            },
            plotOptions: {
                pie: {
                    customScale: 1,
                    offsetX: 0,
                    offsetY: 0,
                    startAngle: 0,
                    endAngle: 360,
                    expandOnClick: !0,
                    dataLabels: {
                        offset: 0,
                        minAngleToShowLabel: 10
                    },
                    donut: {
                        size: "35%",
                        background: "transparent",
                        labels: {
                            show: !1,
                            name: {
                                show: !0,
                                fontSize: "16px",
                                fontFamily: void 0,
                                fontWeight: 600,
                                color: void 0,
                                offsetY: -10,
                                formatter: function(t) {
                                    return t
                                }
                            },
                            // value: {
                            //     show: !0,
                            //     fontSize: "20px",
                            //     fontFamily: void 0,
                            //     fontWeight: 400,
                            //     color: void 0,
                            //     offsetY: 10,
                            //     formatter: function(t) {
                            //         return t
                            //     }
                            // },
                            total: {
                                show: !1,
                                showAlways: !1,
                                label: "Total",
                                fontSize: "16px",
                                fontWeight: 400,
                                fontFamily: void 0,
                                color: void 0,
                                formatter: function(t) {
                                    return t.globals.seriesTotals.reduce((function(t, e) {
                                        return t + e
                                    }), 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.globals.series[opts.seriesIndex]; // Menampilkan jumlah suara, bukan persentase
                },
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#candidateChart"), options);
        chart.render();
        document.getElementById('download-chart1').addEventListener('click', function() {
            chart.dataURI().then((uri) => {
                // Buat elemen <a> untuk mengunduh gambar
                let a = document.createElement('a');
                a.href = uri.imgURI;
                a.download = 'chart-perbandingan-kandidat-pemilih.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
        });
    </script>
    {{-- <script>
        // Data kandidat (misalnya dari PHP atau sumber lain)
        let candidateNames = ['John Doe', 'Jane Smith', 'Mark Lee']; // Nama kandidat
        let candidateVotes = [15, 20, 10]; // Jumlah suara

        // Warna yang sesuai dengan jumlah kandidat
        let colors = [
            "#435ebe", // Warna untuk kandidat pertama
            "#55c6e8", // Warna untuk kandidat kedua
            "#ff6384", // Warna untuk kandidat ketiga
            // Tambahkan lebih banyak warna jika diperlukan
        ];

        // Membuat donut chart menggunakan Chart.js
        var ctx = document.getElementById('candidateChart').getContext('2d');
        var candidateChart = new Chart(ctx, {
            type: 'doughnut', // 'doughnut' untuk donut chart
            data: {
                labels: candidateNames,
                datasets: [{
                    data: candidateVotes,
                    backgroundColor: colors, // Warna untuk setiap bagian
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom', // Letak legenda di bawah chart
                },
                cutoutPercentage: 50, // Ukuran lubang di tengah (30% - 50% biasa digunakan untuk donut chart)
            }
        });
    </script> --}}
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
