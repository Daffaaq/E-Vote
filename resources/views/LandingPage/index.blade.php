<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Pemilihan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
        }

        .navbar-light {
            background-color: #273a6b !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-light .navbar-brand,
        .navbar-light .navbar-nav .nav-link {
            color: white;
        }

        .navbar-light .navbar-brand:hover,
        .navbar-light .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .hero-section {
            background-image: url('{{ asset('Image-Assets/Home.png') }}');
            background-position: center;
            background-size: cover;
            color: white;
            padding: 150px 20px;
            text-align: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            z-index: 1;
            position: relative;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            z-index: 1;
            position: relative;
        }

        .hero-section .btn {
            z-index: 1;
            position: relative;
        }

        .timeline {
            display: flex;
            justify-content: space-around;
            position: relative;
            margin: 30px 0;
            padding: 0 20px;
            flex-wrap: wrap;
        }

        .timeline::before {
            content: "";
            position: absolute;
            top: 35px;
            left: 0;
            right: 0;
            height: 2px;
            background: #ddd;
            z-index: 0;
            /* Ensure it is behind the timeline items */
        }

        .timeline-item {
            position: relative;
            text-align: center;
            flex: 1;
            min-width: 150px;
            margin: 10px 0;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            top: 17px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #273a6b;
            border: 2px solid #fff;
            z-index: 1;
            /* Ensure it is above the horizontal line */
        }

        .timeline-item h6 {
            margin-bottom: 20px;
            margin-top: -10px;
        }

        .timeline-item p {
            margin-top: 40px;
        }

        .card-no-border {
            border: none;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #273a6b;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 24px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
        }

        .scroll-to-top:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .timeline {
                flex-direction: column;
                padding: 0;
            }

            .timeline::before {
                content: "";
                position: absolute;
                top: 0;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 2px;
                background: #ddd;
                height: auto;
            }

            .timeline-item {
                margin: 20px 0;
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
                position: relative;
            }

            .timeline-item::before {
                top: 0;
                left: calc(50% - 10px);
                /* Center it with respect to the timeline */
                transform: translateX(-50%);
            }

            .timeline-item h6 {
                margin: 0;
                padding: 0;
                text-align: left;
                position: relative;
                left: 75px;
                /* Adjust this value to move it closer to the blue circle */
            }

            .timeline-item p {
                margin-left: 50%;
                padding-left: 20px;
            }

            .card-img-top {
                width: 100px;
                height: 100px;
            }

            .card-body {
                padding: 1rem;
            }
        }

        .modern-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .modern-form .form-control {
            border-radius: 50px;
            padding: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .modern-form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
        }

        .modern-form textarea.form-control {
            border-radius: 20px;
        }

        .modern-form button {
            border-radius: 50px;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .modern-form button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .form-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .form-container img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: 1px solid #273a6b;
            height: 1px;
            background: #273a6b;
            margin: 40px 0;
        }

        .footer-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-bottom: 0;
        }

        .footer-icons a {
            color: white;
            transition: color 0.3s ease;
        }

        .footer-icons a:hover {
            color: #273a6b;
        }

        .social-btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .social-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .social-btn:active {
            transform: translateY(-2px);
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                text-align: center;
            }

            .form-container img {
                margin-bottom: 20px;
                max-width: 100%;
            }
        }

        .about-section {
            padding: 60px 20px;
            background: #f9f9f9;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            text-align: center;
        }

        .about-section h5 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #007bff;
            font-weight: bold;
        }

        .about-section p {
            font-size: 1.2rem;
            color: #555;
        }

        .card-title span.badge {
            font-size: 0.75rem;
            margin-top: 5px;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #273a6b;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- Navbar dengan Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">{{ $profile->name_events }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="scrollToSection('home')">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="scrollToSection('about')">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="scrollToSection('schedule')">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="scrollToSection('caketos')">Caketos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="scrollToSection('advice')">Advice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Home) -->
    <div id="home" class="hero-section">
        <h1>Selamat Datang di {{ $profile->name_events }} {{ $profile->nickname_profiles }}!</h1>
        <p>Sistem ini digunakan untuk melakukan {{ $profile->name_events }} dengan mudah dan cepat.</p>
        <a href="javascript:void(0)" class="btn btn-success btn-lg" style="border-radius: 50px;"
            onclick="scrollToSection('caketos')">Mulai
            Sekarang</a>
    </div>

    <hr>

    <!-- About Section -->
    <div id="about" class="container mb-4 mt-4">
        <div class="about-section">
            <h5 class="section-title" style="color: #273a6b;">Informasi Sistem</h5>
            <p class="card-text text-center">Sistem ini memungkinkan Anda untuk memilih kandidat favorit Anda dengan
                cara yang mudah dan aman.</p>
        </div>
    </div>

    <hr>

    <!-- Schedule Section -->
    <div id="schedule" class="container mb-4">
        <div class="card card-no-border">
            <div class="card-body">
                <h5 class="section-title">Jadwal Pemilihan</h5>
                <div class="timeline">
                    @if ($jadwalOrasi)
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($jadwalOrasi->tanggal_orasi_vote)->translatedFormat('d F Y') }}
                            </h6>
                            <p><i class="fas fa-bullhorn"></i> Orasi</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $jadwalOrasi->tempat_orasi }}</p>
                            <p><i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($jadwalOrasi->jam_orasi_mulai)->format('H:i') }}</p>
                        </div>
                    @else
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i> Tanggal Orasi</h6>
                            <p><i class="fas fa-bullhorn"></i> Orasi</p>
                            <p><i class="fas fa-map-marker-alt"></i> </p>
                            <p><i class="fas fa-clock"></i></p>
                        </div>
                    @endif
                    @if ($jadwalVotes)
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($jadwalVotes->tanggal_awal_vote)->translatedFormat('d F Y') }}
                            </h6>
                            <p><i class="fas fa-vote-yea"></i> Mulai Voting</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $jadwalVotes->tempat_vote }}</p>
                        </div>
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($jadwalVotes->tanggal_akhir_vote)->translatedFormat('d F Y') }}
                            </h6>
                            <p><i class="fas fa-vote-yea"></i> Penutupan Voting</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $jadwalVotes->tempat_vote }}</p>
                        </div>
                    @else
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i> Tanggal Mulai Voting</h6>
                            <p><i class="fas fa-vote-yea"></i> Mulai </p>
                            <p><i class="fas fa-map-marker-alt"></i> </p>
                        </div>
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i> Tanggal Penutupan Voting</h6>
                            <p><i class="fas fa-vote-yea"></i> Penutupan </p>
                            <p><i class="fas fa-map-marker-alt"></i> </p>
                        </div>
                    @endif
                    @if ($jadwalResultVote)
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($jadwalResultVote->tanggal_result_vote)->translatedFormat('d F Y') }}
                            </h6>
                            <p><i class="fas fa-poll"></i> Pembacaan Hasil</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $jadwalResultVote->tempat_result_vote }}</p>
                            <p><i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($jadwalResultVote->jam_result_vote)->format('H:i') }}</p>
                        </div>
                    @else
                        <div class="timeline-item">
                            <h6><i class="fas fa-calendar-alt"></i> Tanggal Pembacaan Hasil</h6>
                            <p><i class="fas fa-poll"></i> Pembacaan</p>
                            <p><i class="fas fa-map-marker-alt"></i> </p>
                            <p><i class="fas fa-clock"></i></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Caketos Section -->
    <div id="caketos" class="container mb-4">
        <h5 class="section-title">Kandidate Ketua Osis</h5>
        <div class="row">
            @forelse ($candidate as $item)
                @if ($item->status == 'ganda')
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card"
                            style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); min-height: 300px; position: relative;">
                            <div
                                style="position: absolute; top: 10px; right: 5px; background-color: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                                1
                            </div>
                            <div class="d-flex justify-content-center align-items-center flex-wrap"
                                style="height: 100%">
                                <div class="text-center mt-2" style="margin: 0 10px">
                                    <img src="{{ Storage::url($item->foto) }}" class="card-img-top"
                                        alt="Foto Kandidat" style="width: 100px; height: 100px" />
                                    <h5 class="card-title mt-2 mb-0" style="font-size: 15px">{{ $item->nama_ketua }}
                                    </h5>
                                    <span class="badge badge-success">Ketua</span>
                                    <p class="card-text">{{ $item->slogan }}</p>
                                </div>
                                <div class="text-center mt-2" style="margin: 0 10px">
                                    <img src="{{ Storage::url($item->foto) }}" class="card-img-top"
                                        alt="Foto Kandidat" style="width: 100px; height: 100px" />
                                    <h5 class="card-title mt-2 mb-0" style="font-size: 15px">
                                        {{ $item->nama_wakil_ketua }}/h5>
                                        <span class="badge badge-info mt-2">Wakil</span>
                                        <p class="card-text">{{ $item->slogan }}</p>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('detail.candidate.landing-page', $item->slug) }}"
                                    class="btn btn-primary" style="border-radius: 50px;">Detail</a>
                                <a href="#" class="btn btn-success disabled"
                                    style="border-radius: 50px;">Vote</a>
                            </div>
                        </div>
                    </div>
                @elseif ($item->status == 'perseorangan')
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card"
                            style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); min-height: 300px; position: relative;">
                            <div
                                style="position: absolute; top: 10px; left: 10px; background-color: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                                {{ $item->no_urut_kandidat }}
                            </div>
                            <div class="d-flex justify-content-center align-items-center flex-column"
                                style="height: 100%">
                                <img src="{{ Storage::url($item->foto) }}" class="card-img-top mt-2"
                                    alt="Foto Kandidat" style="width: 150px; height: 150px; margin: auto" />
                                <div class="card-body text-center mb-0">
                                    <h5 class="card-title mb-0" style="font-size: 15px">{{ $item->nama_ketua }}</h5>
                                    <span class="badge badge-success">Ketua</span>
                                    <p class="card-text">{{ $item->slogan }}</p>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <a href="{{ route('detail.candidate.landing-page', $item->slug) }}"
                                    class="btn btn-primary" style="border-radius: 50px;">Detail</a>
                                <a href="#" class="btn btn-success disabled"
                                    style="border-radius: 50px;">Vote</a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card"
                        style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); min-height: 300px; position: relative;">
                        <div
                            style="position: absolute; top: 10px; right: 5px; background-color: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            1
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-wrap" style="height: 100%">
                            <div class="text-center mt-2" style="margin: 0 10px">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Foto Kandidat"
                                    style="width: 100px; height: 100px" />
                                <h5 class="card-title mt-2 mb-0" style="font-size: 15px">Candra Waskito Utomo</h5>
                                <span class="badge badge-success">Ketua</span>
                                <p class="card-text">Kelas: XII IPA 1</p>
                            </div>
                            <div class="text-center mt-2" style="margin: 0 10px">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Foto Kandidat"
                                    style="width: 100px; height: 100px" />
                                <h5 class="card-title mt-2 mb-0" style="font-size: 15px">Dwi Fatah Rahayu</h5>
                                <span class="badge badge-info mt-2">Wakil</span>
                                <p class="card-text">Kelas: XII IPA 1</p>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary" style="border-radius: 50px;">Detail</a>
                            <a href="#" class="btn btn-success" style="border-radius: 50px;">Vote</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card"
                        style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); min-height: 300px; position: relative;">
                        <div
                            style="position: absolute; top: 10px; left: 10px; background-color: #007bff; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            1
                        </div>
                        <div class="d-flex justify-content-center align-items-center flex-column"
                            style="height: 100%">
                            <img src="https://via.placeholder.com/150" class="card-img-top mt-2" alt="Foto Kandidat"
                                style="width: 150px; height: 150px; margin: auto" />
                            <div class="card-body text-center mb-0">
                                <h5 class="card-title mb-0" style="font-size: 15px">Richard</h5>
                                <span class="badge badge-success">Ketua</span>
                                <p class="card-text">Kelas: XII IPA 1</p>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary" style="border-radius: 50px;">Detail</a>
                            <a href="#" class="btn btn-success" style="border-radius: 50px;">Vote</a>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>
        <!-- Repeat other candidates -->
    </div>



    <hr>

    <!-- Advice Section -->
    <div id="advice" class="container mb-4">
        <h5 class="section-title">Kotak Saran</h5>
        <div class="form-container">
            <div class="image-container">
                <img src="{{ asset('Image-Assets/Aspiration.png') }}" alt="Gambar Pendukung" />
            </div>
            <div class="modern-form">
                <h5 class="section-title">Berikan Saran Anda</h5>
                <form id="complaint-create-form" action="{{ route('aspiration.store') }}" method="POST"
                    enctype="multipart/form-data" onsubmit="event.preventDefault(); handleComplaintCreate();">
                    @csrf

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="text" name="nis" class="form-control" id="nis"
                            placeholder="Masukkan NIS Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input type="text" name="kelas" class="form-control" id="kelas"
                            placeholder="Masukkan Kelas Anda" required>
                    </div>

                    <div class="form-group">
                        <label for="description_profiles">Saran</label>
                        <textarea name="description_profiles" class="form-control" id="description_profiles" rows="4"
                            placeholder="Masukkan Saran Anda" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Saran</button>
                </form>
            </div>
        </div>
    </div>


    <hr>
    <div id="faq" class="container mb-4">
        <h5 class="section-title">FAQ (Frequently Asked Questions)</h5>
        <div class="accordion" id="faqAccordion" style="max-height: 300px; overflow-y: auto;">
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingOne">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                            Bagaimana cara saya melakukan voting?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseOne"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseOne" class="collapse" aria-labelledby="faqHeadingOne"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Untuk melakukan voting, Anda perlu masuk ke akun Anda, pilih kandidat yang Anda dukung, dan klik
                        tombol "Vote".
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingTwo">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                            Apakah voting saya anonim?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseTwo"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseTwo" class="collapse" aria-labelledby="faqHeadingTwo"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Ya, voting Anda sepenuhnya anonim dan dijamin keamanannya.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingThree">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                            Kapan hasil voting akan diumumkan?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseThree"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseThree" class="collapse" aria-labelledby="faqHeadingThree"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Hasil voting akan diumumkan pada tanggal yang telah ditentukan setelah proses perhitungan suara
                        selesai.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingFour">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                            Apakah saya dapat mengubah suara saya setelah voting?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseFour"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseFour" class="collapse" aria-labelledby="faqHeadingFour"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Tidak, setelah Anda melakukan voting, suara Anda tidak dapat diubah.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingFive">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseFive" aria-expanded="false" aria-controls="faqCollapseFive">
                            Apakah saya perlu mendaftar untuk voting?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseFive"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseFive" class="collapse" aria-labelledby="faqHeadingFive"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Ya, Anda harus mendaftar dan memiliki akun untuk dapat melakukan voting.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingSix">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseSix" aria-expanded="false" aria-controls="faqCollapseSix">
                            Bagaimana cara mengetahui kandidat mana yang saya pilih?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseSix"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseSix" class="collapse" aria-labelledby="faqHeadingSix"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Setelah Anda memilih kandidat, pilihan Anda akan ditampilkan di halaman konfirmasi sebelum
                        menyelesaikan voting.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingSeven">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseSeven" aria-expanded="false" aria-controls="faqCollapseSeven">
                            Apa yang terjadi jika saya kehilangan koneksi internet saat voting?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseSeven"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseSeven" class="collapse" aria-labelledby="faqHeadingSeven"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Jika Anda kehilangan koneksi internet, coba untuk menyambung kembali dan lanjutkan proses
                        voting.
                        Data Anda aman dan tidak akan hilang.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingEight">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseEight" aria-expanded="false" aria-controls="faqCollapseEight">
                            Apakah saya dapat memeriksa status voting saya?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseEight"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseEight" class="collapse" aria-labelledby="faqHeadingEight"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Ya, Anda dapat memeriksa status voting Anda dengan masuk ke akun Anda dan melihat riwayat
                        voting.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingNine">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseNine" aria-expanded="false" aria-controls="faqCollapseNine">
                            Dapatkah saya melakukan voting lebih dari satu kali?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseNine"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseNine" class="collapse" aria-labelledby="faqHeadingNine"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Tidak, Anda hanya dapat melakukan voting satu kali per akun untuk menjaga integritas sistem
                        voting.
                    </div>
                </div>
            </div>
            <div class="card mb-3 border-0 shadow-sm" style="border-radius: 50px;">
                <div class="card-header text-white" style="background-color: red;" id="faqHeadingTen">
                    <h2 class="mb-0">
                        <a class="btn btn-link text-white d-flex justify-content-between align-items-center w-100 collapsed"
                            type="button" style="text-decoration: none;" data-toggle="collapse"
                            data-target="#faqCollapseTen" aria-expanded="false" aria-controls="faqCollapseTen">
                            Bagaimana saya tahu bahwa suara saya telah dihitung?
                            <i class="fas fa-chevron-down text-white" aria-controls="faqCollapseTen"></i>
                        </a>
                    </h2>
                </div>
                <div id="faqCollapseTen" class="collapse" aria-labelledby="faqHeadingTen"
                    data-parent="#faqAccordion">
                    <div class="card-body" style="border-radius: 50px;">
                        Setelah Anda melakukan voting, Anda akan menerima notifikasi bahwa suara Anda telah berhasil
                        dihitung.
                    </div>
                </div>
            </div>
            <!-- Tambahkan FAQ lainnya di sini sesuai kebutuhan -->
        </div>
    </div>



    <!-- Footer -->
    <div class="mb-0">
        <footer class="bg-dark text-center text-white p-4" style="margin-bottom: 0">
            <section class="mb-4 footer-icons">
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #3b5998"
                    href="#!" role="button">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #55acee"
                    href="#!" role="button">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #dd4b39"
                    href="#!" role="button">
                    <i class="fab fa-google"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #ac2bac"
                    href="#!" role="button">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #0082ca"
                    href="#!" role="button">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #333333"
                    href="#!" role="button">
                    <i class="fab fa-github"></i>
                </a>
            </section>
        </footer>
        <div class="footer-icons">
            <a href="#!" class="social-btn"><i class="fab fa-facebook-f"></i></a>
            <a href="#!" class="social-btn"><i class="fab fa-twitter"></i></a>
            <a href="#!" class="social-btn"><i class="fab fa-google"></i></a>
            <a href="#!" class="social-btn"><i class="fab fa-instagram"></i></a>
            <a href="#!" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#!" class="social-btn"><i class="fab fa-github"></i></a>
        </div>
        <div class="footer-copyright text-center p-3">
            &copy; 2024 Sistem Pemilihan. All rights reserved. Developed by Ache.
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" onclick="scrollToSection('home')" title="Back to Top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript (jQuery, Popper.js, Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Fungsi untuk menampilkan SweetAlert
        function showSweetAlert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
            });
        }

        // Fungsi untuk menangani permintaan HTTP dengan menggunakan Fetch API
        function handleComplaintCreate() {
            const form = document.getElementById(
                'complaint-create-form'); // Mendapatkan elemen form dengan ID 'complaint-create-form'
            const formData = new FormData(form); // Membuat objek FormData dari form

            fetch(form.action, {
                    method: 'POST', // Menggunakan metode HTTP POST untuk mengirim data
                    body: formData, // Mengirim data formulir menggunakan objek FormData
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'
                        ) // Mengirim token CSRF yang diperlukan untuk melindungi aplikasi dari serangan CSRF
                    }
                })
                .then(response => response.json()) // Menguraikan respons HTTP sebagai JSON
                .then(data => {
                    if (data.success) {
                        // Tampilkan SweetAlert dengan pesan sukses jika permintaan berhasil
                        showSweetAlert('Hore!', 'Aspirasi berhasil di ajukan. Terimakasih', 'success');

                        form.reset();
                    } else {
                        // Tampilkan SweetAlert dengan pesan kesalahan jika ada kesalahan dalam permintaan
                        showSweetAlert('Oops!', data.message || 'Terjadi kesalahan saat Mengajukan Pengaduan.',
                            'error');

                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <!-- Custom Scroll Script -->
    <script>
        function toggleCollapse(faqId) {
            const faqElement = document.getElementById(faqId);
            const isCollapsed = faqElement.classList.contains('show');

            if (isCollapsed) {
                faqElement.classList.remove('show');
            } else {
                faqElement.classList.add('show');
            }
        }

        function scrollToSection(sectionId) {
            document
                .getElementById(sectionId)
                .scrollIntoView({
                    behavior: "smooth"
                });
        }

        // Show/Hide Scroll to Top Button
        window.onscroll = function() {
            const scrollToTopBtn = document.querySelector(".scroll-to-top");
            if (
                document.body.scrollTop > 300 ||
                document.documentElement.scrollTop > 300
            ) {
                scrollToTopBtn.style.display = "flex";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        };
    </script>
</body>

</html>
