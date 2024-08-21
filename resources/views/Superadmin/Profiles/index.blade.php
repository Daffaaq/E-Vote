@extends('Superadmin.layouts.index')
<style>
    hr {
        border: none;
        border-top: 1px solid;
        opacity: 0.6;
        /* Transparansi untuk mengurangi kontras */
    }

    [data-bs-theme="light"] hr {
        border-color: #000 !important;
    }

    [data-bs-theme="dark"] hr {
        border-color: #ffffff !important;
    }
</style>
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Daftar Profile</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="container mt-1 mb-5">
        <h2 class="mb-0">Profiles</h2>
        @foreach ($profiles as $profile)
            <!-- Profile Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ Storage::url($profile->logo_profiles) }}" alt="Profile Avatar" class="rounded-circle"
                            style="width: 80px; height: 80px; object-fit: cover;">
                        <div class="ms-3">
                            <h4 class="mb-0">{{ $profile->name_profiles ?? '' }}</h4>
                            <p class="text-muted">{{ $profile->address_profiles ?? '' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profiles.edit-logo', $profile->uuid) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Personal Information</h5>
                    <a href="{{ route('profiles.edit-personal', $profile->uuid) }}"
                        class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Nama Profil</label>
                            <p class="form-control-plaintext">{{ $profile->name_profiles ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Singkatan Nama Profil</label>
                            <p class="form-control-plaintext">{{ $profile->nickname_profiles ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">Email Profil</label>
                            <p class="form-control-plaintext">{{ $profile->email_profiles ?? '' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">No Telephone Profil</label>
                            <p class="form-control-plaintext">{{ $profile->phone_profiles ?? '' }}</p>
                        </div>
                        <div class="col-md-12 mb-3 text-center">
                            <label class="form-label text-muted">Deskripsi Profil</label>
                            <p class="form-control-plaintext">{{ $profile->description_profiles ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Social Media</h5>
                    <a href="{{ route('profiles.edit-sosial-media', $profile->uuid) }}"
                        class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
                <hr>
                <div class="card-body">
                    <div class="row">
                        @if ($profile->twitter_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Twitter</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->twitter_url }}" target="_blank">
                                        <i class="bi bi-twitter-x"></i> Twitter
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->facebook_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Facebook</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->facebook_url }}" target="_blank">
                                        <i class="bi bi-facebook"></i> Facebook
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->instagram_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Instagram</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->instagram_url }}" target="_blank">
                                        <i class="bi bi-instagram"></i> Instagram
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->instagram_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Threads</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->instagram_url }}" target="_blank">
                                        <i class="bi bi-threads-fill"></i> Threads
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->line_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">line</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->line_url }}" target="_blank">
                                        <i class="bi bi-line"></i> line
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->linkedin_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">LinkedIn</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->linkedin_url }}" target="_blank">
                                        <i class="bi bi-linkedIn"></i> LinkedIn
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->youtube_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">YouTube</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->youtube_url }}" target="_blank">
                                        <i class="bi bi-youtube"></i> YouTube
                                    </a>
                                </p>
                            </div>
                        @endif
                        @if ($profile->tiktok_url)
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Tiktok</label>
                                <p class="form-control-plaintext">
                                    <a href="{{ $profile->tiktok_url }}" target="_blank">
                                        <i class="bi bi-tiktok"></i> Tiktok
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<style>
    .card {
        border-radius: 10px;
    }

    .card-header {
        border-bottom: 1px solid #e9ecef;
    }

    .form-control-plaintext {
        margin-bottom: 0;
    }

    .btn-outline-secondary {
        display: inline-flex;
        align-items: center;
    }

    .btn-outline-secondary i {
        margin-right: 5px;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .fab {
        margin-right: 8px;
        color: #007bff;
        /* Warna biru default, bisa disesuaikan dengan brand color */
    }

    .fab.fa-twitter {
        color: #1DA1F2;
    }

    .fab.fa-facebook {
        color: #1877F2;
    }

    .fab.fa-instagram {
        color: #E1306C;
    }

    .fab.fa-linkedin {
        color: #0077B5;
    }

    .fab.fa-youtube {
        color: #FF0000;
    }
</style>
