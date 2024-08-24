@extends('Superadmin.layouts.index')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    input[type="password"]::-webkit-textfield-decoration-container {
        display: none;
    }
</style>
@section('content')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">My Profiles</li>
        </ol>
    </nav>
@endsection
<div class="container mb-4">
    <div class="card-header py-1">
        <h6 class="m-0 font-weight-bold text-primary">My Profiles</h6>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <!-- Profile Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    @if ($user->foto_profile)
                        <img src="{{ Storage::url($user->foto_profile) }}" class="mb-3" alt="Profile Image"
                            style="width: 200px; height: 230px; object-fit: contain; border: 5px solid #808080;">
                    @else
                        <img src="{{ asset('Image-Assets/avatar-1.png') }}" class="mb-3" alt="Profile Image"
                            style="width: 150px; height: 150px; object-fit: cover; border: 5px solid #808080; background-color: #f0f0f0;">
                    @endif
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <!-- Change Profile Picture Button -->
                    <form method="POST" action="{{ route('superadmin.updateProfile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="foto_profile" class="form-control mb-3" required>
                        </div>
                        <button type="submit" class="btn btn-success">Ganti Foto Profil</button>
                    </form>
                    @if ($user->foto_profile)
                        <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                            data-bs-target="#confirmDeleteModal">
                            Hapus Foto Profil
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Password Change Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ganti Password</h5>
                    <form method="POST" action="{{ route('superadmin.changePassword') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Username Login:</label>
                            <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label>Password Lama:</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                placeholder="Masukan Password Lama" required>
                            <span toggle="#current_password"
                                class="fa fa-fw fa-eye password-toggle-icon position-absolute"
                                style="top: 65%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label>Password Baru:</label>
                            <input type="password" name="new_password" id="new_password" class="form-control"
                                placeholder="Masukan Password Baru" required>
                            <span toggle="#new_password" class="fa fa-fw fa-eye password-toggle-icon position-absolute"
                                style="top: 65%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                        </div>
                        <div class="form-group mb-3 position-relative">
                            <label>Ulangi Password Baru:</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" placeholder="Ulangi Password Baru" required>
                            <span toggle="#new_password_confirmation"
                                class="fa fa-fw fa-eye password-toggle-icon position-absolute"
                                style="top: 65%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Konfirmasi Hapus Foto Profil -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus foto profil Anda?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('superadmin.deleteProfilePhoto') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.password-toggle-icon').forEach(item => {
        item.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('toggle'));
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection
