@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tambah Banner Baru') }}</div>
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <script>
                            setTimeout(function() {
                                const alert = document.querySelector('.alert');
                                if (alert) {
                                    alert.classList.remove('show');
                                    alert.classList.add('fade');
                                    setTimeout(function() {
                                        alert.remove();
                                    }, 500);
                                }
                            }, 5000); // 5000 milliseconds = 5 seconds
                        </script>
                    @endif

                    <div class="card-body">
                        <form method="POST" action="{{ route('banner.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3 row">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" required autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="description"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="image"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                                <div class="col-md-6 d-flex align-items-center">
                                    <input id="image" type="file"
                                        class="form-control @error('image') is-invalid @enderror" name="image" required
                                        onchange="previewImage(event)">
                                    <button type="button" class="btn btn-danger ml-2" id="removeImage"
                                        style="display: none;" onclick="removeImage()">X</button>

                                    @error('image')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid mt-3"
                                        style="display: none;">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Tambah') }}
                                    </button>
                                    <a href="{{ route('banner.index') }}" class="btn btn-secondary">
                                        {{ __('Batal') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var imagePreview = document.getElementById('imagePreview');
                var removeButton = document.getElementById('removeImage');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block';
                removeButton.style.display = 'inline-block';
            };
            reader.readAsDataURL(input.files[0]);
        }

        function removeImage() {
            var imageInput = document.getElementById('image');
            var imagePreview = document.getElementById('imagePreview');
            var removeButton = document.getElementById('removeImage');
            imageInput.value = '';
            imagePreview.style.display = 'none';
            removeButton.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('removeImage').addEventListener('click', removeImage);
        });
    </script>
@endsection
