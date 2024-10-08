@extends('Admin.layouts.index')
@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('Candidate.index') }}">Daftar Kandidat</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Daftar Kandidat</li>
        </ol>
    </nav>
@endsection
@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Candidate</h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px"
                            role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form id="mainForm" method="POST" action="{{ route('Candidate.admin.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="status" class="col-lg-3 col-form-label">{{ __('Status') }}</label>
                                    <div class="col-lg-9">
                                        <select id="status" name="status"
                                            class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="" disabled>Pilih Status</option>
                                            <option value="perseorangan"
                                                {{ old('status') === 'perseorangan' ? 'selected' : '' }}>Perseorangan
                                            </option>
                                            <option value="ganda" {{ old('status') === 'ganda' ? 'selected' : '' }}>
                                                Ganda</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="no_urut_kandidat"
                                        class="col-lg-3 col-form-label">{{ __('Nomer Urut Kandidat') }}</label>
                                    <div class="col-lg-9">
                                        <input id="no_urut_kandidat" type="number"
                                            class="form-control @error('no_urut_kandidat') is-invalid @enderror"
                                            name="no_urut_kandidat" value="{{ old('no_urut_kandidat') }}" required
                                            autocomplete="no_urut_kandidat" autofocus>
                                        @error('no_urut_kandidat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="nama_ketua" class="col-lg-3 col-form-label">{{ __('Nama Ketua') }}</label>
                                    <div class="col-lg-9">
                                        <input id="nama_ketua" type="text"
                                            class="form-control @error('nama_ketua') is-invalid @enderror" name="nama_ketua"
                                            value="{{ old('nama_ketua') }}" required autocomplete="nama_ketua" autofocus>
                                        @error('nama_ketua')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="wakil_ketua_container">
                                <div class="form-group row align-items-center">
                                    <label for="nama_wakil_ketua"
                                        class="col-lg-3 col-form-label">{{ __('Nama Wakil') }}</label>
                                    <div class="col-lg-9">
                                        <input id="nama_wakil_ketua" type="text"
                                            class="form-control @error('nama_wakil_ketua') is-invalid @enderror"
                                            name="nama_wakil_ketua" value="{{ old('nama_wakil_ketua') }}"
                                            autocomplete="nama_wakil_ketua" autofocus>
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="visi" class="form-label">{{ __('Visi') }}</label>
                                    <textarea id="visi" class="form-control summernote @error('visi') is-invalid @enderror" name="visi" required
                                        autocomplete="visi" autofocus>{{ old('visi') }}</textarea>
                                    @error('visi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="misi" class="form-label">{{ __('Misi') }}</label>
                                    <textarea id="misi" class="form-control summernote @error('misi') is-invalid @enderror" name="misi" required
                                        autocomplete="misi" autofocus>{{ old('misi') }}</textarea>
                                    @error('misi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="slogan" class="col-lg-3 col-form-label">{{ __('Slogan') }}</label>
                                    <input id="slogan" type="text"
                                        class="form-control @error('slogan') is-invalid @enderror" name="slogan"
                                        value="{{ old('slogan') }}" required autocomplete="slogan" autofocus>
                                    @error('slogan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="foto" class="form-label">{{ __('Foto') }}</label>
                                    <div class="input-group">
                                        <input id="foto" type="file"
                                            class="form-control @error('foto') is-invalid @enderror" name="foto"
                                            accept="image/*">
                                        <label class="input-group-text" for="foto">Pilih File</label>
                                    </div>
                                    <small class="text-muted">Pilih file gambar (JPG, PNG) maksimal 2MB</small>
                                    @error('foto')
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Preview Gambar') }}</label>
                                    <div id="imagePreview" class="mt-2">
                                        <!-- Preview gambar akan ditampilkan di sini -->
                                    </div>
                                    <button type="button" id="hapusPreviewBtn"
                                        class="btn btn-danger mt-2 d-none">Hapus</button>
                                </div>
                            </div>
                            <div class="col-md-12" id="wakil_ketua_foto">
                                <div class="form-group">
                                    <label for="foto_wakil" class="form-label">{{ __('Foto Wakil') }}</label>
                                    <div class="input-group">
                                        <input id="foto_wakil" type="file"
                                            class="form-control @error('foto_wakil') is-invalid @enderror"
                                            name="foto_wakil" accept="image/*">
                                        <label class="input-group-text" for="foto_wakil">Pilih File</label>
                                    </div>
                                    <small class="text-muted">Pilih file gambar (JPG, PNG) maksimal 2MB</small>
                                    @error('foto_wakil')
                                        <div class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12" id="wakil_ketua_foto_preview">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Preview Gambar Wakil') }}</label>
                                    <div id="foto_wakil_preview" class="mt-2">
                                        <!-- Preview gambar wakil akan ditampilkan di sini -->
                                    </div>
                                    <button type="button" id="hapusPreviewWakilBtn"
                                        class="btn btn-danger mt-2 d-none">Hapus</button>
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-3">
                                <a href="{{ route('Candidate.admin.index') }}"
                                    class="btn btn-primary rounded-pill me-1 mb-1">
                                    {{ __('Batal') }}
                                </a>
                                <button type="button" class="btn btn-info rounded-pill me-1 mb-1" id="reviewBtn"
                                    style="display: none;">Review</button>
                                <button type="submit" class="btn btn-success rounded-pill me-1 mb-1">Tambah</button>
                                <button type="reset" class="btn btn-warning rounded-pill me-1 mb-1">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Review Foto Kandidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="reviewFoto"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusField = document.getElementById('status');
            const wakilKetuaField = document.getElementById('wakil_ketua_container');
            const wakilKetuaField1 = document.getElementById('wakil_ketua_foto');
            const wakilKetuaField2 = document.getElementById('wakil_ketua_foto_preview');
            const reviewBtn = document.getElementById('reviewBtn');
            const hapusPreviewBtn = document.getElementById('hapusPreviewBtn');

            function toggleWakilKetua() {
                if (statusField.value === 'perseorangan') {
                    wakilKetuaField.style.display = 'none';
                    wakilKetuaField1.style.display = 'none';
                    wakilKetuaField2.style.display = 'none';
                } else {
                    wakilKetuaField.style.display = 'block';
                    wakilKetuaField1.style.display = 'block';
                    wakilKetuaField2.style.display = 'block';
                }
            }

            statusField.addEventListener('change', toggleWakilKetua);

            // Initialize visibility on page load
            toggleWakilKetua();

            // Hide review button if no image is selected initially
            if (document.getElementById('imagePreview').innerHTML.trim() === '') {
                reviewBtn.style.display = 'none';
            }
        });

        // Script untuk menampilkan preview gambar saat dipilih
        document.getElementById('foto').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-thumbnail mt-2";
                img.style.width = "200px"; // Set width
                img.style.height = "200px"; // Set height
                var previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = '';
                previewContainer.appendChild(img);

                // Tampilkan tombol Hapus dan Review
                document.getElementById('hapusPreviewBtn').classList.remove('d-none');
                document.getElementById('reviewBtn').style.display = 'inline-block';
            };
            reader.readAsDataURL(file);
        });

        document.getElementById('foto_wakil').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-thumbnail mt-2";
                img.style.width = "200px"; // Set width
                img.style.height = "200px"; // Set height
                var previewContainer = document.getElementById('foto_wakil_preview');
                previewContainer.innerHTML = '';
                previewContainer.appendChild(img);

                // Tampilkan tombol Hapus
                document.getElementById('hapusPreviewWakilBtn').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });

        // Script untuk menghapus preview gambar wakil
        document.getElementById('hapusPreviewWakilBtn').addEventListener('click', function() {
            var previewContainer = document.getElementById('foto_wakil_preview');
            previewContainer.innerHTML = '';

            // Reset input file
            var fotoWakilInput = document.getElementById('foto_wakil');
            fotoWakilInput.value = '';

            // Sembunyikan tombol Hapus
            document.getElementById('hapusPreviewWakilBtn').classList.add('d-none');
        });

        // Script untuk menampilkan foto di modal saat tombol Review diklik
        document.getElementById('reviewBtn').addEventListener('click', function() {
            const previewContainerKetua = document.getElementById('imagePreview').innerHTML;
            const previewContainerWakil = document.getElementById('foto_wakil_preview').innerHTML;

            // Gabungkan kedua preview dalam satu modal
            const reviewContent = `
        <h5>Foto Ketua</h5>
        ${previewContainerKetua}
        <h5 class="mt-4">Foto Wakil</h5>
        ${previewContainerWakil}
    `;

            document.getElementById('reviewFoto').innerHTML = reviewContent;
            $('#reviewModal').modal('show');
        });

        // Script untuk menghapus preview gambar ketua
        document.getElementById('hapusPreviewBtn').addEventListener('click', function() {
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            // Reset input file
            var fotoInput = document.getElementById('foto');
            fotoInput.value = '';

            // Sembunyikan tombol Hapus dan Review
            document.getElementById('hapusPreviewBtn').classList.add('d-none');
            document.getElementById('reviewBtn').style.display = 'none';
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#visi').summernote({
                tabsize: 2,
                height: 200,
                dialogsInBody: true,
                codeviewFilter: true,
                codeviewIframeFilter: true,
                popover: {
                    air: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ]
                }
            });

            $('#misi').summernote({
                tabsize: 2,
                height: 200,
                dialogsInBody: true,
                codeviewFilter: true,
                codeviewIframeFilter: true,
                popover: {
                    air: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']],
                    ]
                }
            });
        });
    </script>
@endsection
