@extends('Superadmin.layouts.index')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .alert {
        position: relative;
    }

    .btn-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }

    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }

    input[type="password"]::-webkit-textfield-decoration-container {
        display: none;
    }
</style>

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Daftar Pemilih</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
@endsection

@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit User</h4>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px"
                            role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->uuid) }}">
                            @csrf
                            @method('PUT') {{-- Menggunakan method PUT untuk update --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="name">Nama</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name" class="form-control" name="name"
                                                value="{{ old('name', $user->name) }}" placeholder="Cahyo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="username">Username</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="username" class="form-control" name="username"
                                                value="{{ old('username', $user->username) }}" placeholder="123456">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="password">Password</label>
                                        <div class="col-lg-9 position-relative">
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Kosongkan jika tidak ingin mengubah password"
                                                autocomplete="new-password" style="padding-right: 40px;">
                                            <span toggle="#password"
                                                class="fa fa-fw fa-eye password-toggle-icon position-absolute"
                                                style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="role">Role</label>
                                            <select class="form-select" id="role" name="role">
                                                <option value="superadmin"
                                                    {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>
                                                    Superadmin
                                                </option>
                                                <option value="admin"
                                                    {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                    Admin
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ url('/dashboardSuperadmin/Users') }}"
                                        class="btn btn-primary rounded-pill me-1 mb-1">
                                        {{ __('Batal') }}
                                    </a>
                                    <button type="submit" class="btn btn-success rounded-pill me-1 mb-1">Update</button>
                                    <button type="reset" class="btn btn-warning rounded-pill me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </section>

    <script>
        document.querySelector('.password-toggle-icon').addEventListener('click', function() {
            let input = document.querySelector('#password');
            let icon = this;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>

@endsection
