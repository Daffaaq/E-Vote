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
            <li class="breadcrumb-item active" aria-current="page">Edit Social Media Profile</li>
        </ol>
    </nav>
@endsection
@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Social Media Profile</h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px"
                            role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('profiles.update-sosial-media', $profile->uuid) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="twitter_url">Twitter URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="twitter_url" class="form-control" name="twitter_url"
                                                value="{{ $profile->twitter_url }}"
                                                placeholder="https://twitter.com/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="facebook_url">Facebook URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="facebook_url" class="form-control" name="facebook_url"
                                                value="{{ $profile->facebook_url }}"
                                                placeholder="https://facebook.com/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="instagram_url">Instagram URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="instagram_url" class="form-control"
                                                name="instagram_url" value="{{ $profile->instagram_url }}"
                                                placeholder="https://instagram.com/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="linkedin_url">LinkedIn URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="linkedin_url" class="form-control" name="linkedin_url"
                                                value="{{ $profile->linkedin_url }}"
                                                placeholder="https://linkedin.com/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="line_url">LINE URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="line_url" class="form-control" name="line_url"
                                                value="{{ $profile->line_url }}" placeholder="https://line.me/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="tiktok_url">TikTok URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="tiktok_url" class="form-control" name="tiktok_url"
                                                value="{{ $profile->tiktok_url }}"
                                                placeholder="https://tiktok.com/@yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="youtube_url">YouTube URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="youtube_url" class="form-control" name="youtube_url"
                                                value="{{ $profile->youtube_url }}"
                                                placeholder="https://youtube.com/yourprofile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row align-items-center">
                                        <label class="col-lg-3 col-form-label" for="threads_url">Threads URL</label>
                                        <div class="col-lg-9">
                                            <input type="url" id="threads_url" class="form-control"
                                                name="threads_url" value="{{ $profile->threads_url }}"
                                                placeholder="https://threads.net/@yourprofile">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ route('profiles.index') }}"
                                        class="btn btn-primary rounded-pill me-1 mb-1">
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
