@extends('Superadmin.layouts.index')
<style>
    .alert {
        position: relative;
    }

    .btn-close {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
</style>
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}">Daftar Profile</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Personal Profile</li>
        </ol>
    </nav>
@endsection
@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Personal Profile</h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px"
                            role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('profiles.update-personal', $profile->uuid) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="name_profiles">Nama Profil</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="name_profiles" class="form-control"
                                                name="name_profiles" value="{{ $profile->name_profiles }}"
                                                placeholder="Student Council Brillantmont International School">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="nickname_profiles">Singkatan Nama
                                            Profil</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="nickname_profiles" class="form-control"
                                                value="{{ $profile->nickname_profiles }}" name="nickname_profiles"
                                                placeholder="SCBIS">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="address_profiles">Alamat Nama
                                            Profil</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="address_profiles" class="form-control"
                                                value="{{ $profile->address_profiles }}" name="address_profiles"
                                                placeholder="Avenue Charles-Secrétan 16 · 1005 Lausanne, Switzerland">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="phone_profiles">No Telephone
                                            Profil</label>
                                        <div class="col-lg-9">
                                            <input type="text" id="phone_profiles" class="form-control"
                                                value="{{ $profile->phone_profiles }}" name="phone_profiles"
                                                placeholder="+4121 310 0400">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="email_profiles">Email Profil</label>
                                        <div class="col-lg-9">
                                            <input type="text" style="width: 690px" id="email_profiles"
                                                class="form-control" value="{{ $profile->email_profiles }}"
                                                name="email_profiles" placeholder="info@brillantmont.ch">
                                        </div>
                                    </div>
                                </div>
                                <!-- Pindahkan Deskripsi Profil ke sini -->
                                <!-- Akhir dari Deskripsi Profil -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row align-items-center">
                                    <label class="col-lg-3 col-form-label" for="description_profiles">Deskripsi
                                        Profil</label>
                                    <div class="col-lg-9">
                                        <textarea id="description_profiles" style="width: 690px; height: 250px" class="form-control"
                                            name="description_profiles">{{ $profile->description_profiles }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ route('profiles.index') }}" class="btn btn-primary rounded-pill me-1 mb-1">
                                        {{ __('Batal') }}
                                    </a>
                                    <button type="submit" class="btn btn-success rounded-pill me-1 mb-1">Submit</button>
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
@endsection
