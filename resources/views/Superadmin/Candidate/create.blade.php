@extends('Superadmin.layouts.main')

@section('content')
    <div class="container-fluid px-4" style="margin-top: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Calon</div>
                    <div class="card-body">
                        <form id="mainForm" method="POST" action="{{ route('Candidate.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select id="status" name="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="" disabled>Pilih Status</option>
                                    <option value="perseorangan" {{ old('status') === 'perseorangan' ? 'selected' : '' }}>
                                        Perseorangan</option>
                                    <option value="ganda" {{ old('status') === 'ganda' ? 'selected' : '' }}>Ganda</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="nama_ketua" class="form-label">{{ __('Nama Ketua') }}</label>
                                <input id="nama_ketua" type="text"
                                    class="form-control @error('nama_ketua') is-invalid @enderror" name="nama_ketua"
                                    value="{{ old('nama_ketua') }}" required autocomplete="nama_ketua" autofocus>
                                @error('nama_ketua')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3" id="wakil_ketua_container">
                                <label for="nama_wakil_ketua" class="form-label">{{ __('Nama Wakil') }}</label>
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
                            <div class="mb-3">
                                <label for="visi" class="form-label">{{ __('Visi') }}</label>
                                <textarea id="visi" class="form-control summernote @error('visi') is-invalid @enderror" name="visi" required
                                    autocomplete="visi" autofocus>{{ old('visi') }}</textarea>
                                @error('visi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="misi" class="form-label">{{ __('Misi') }}</label>
                                <textarea id="misi" class="form-control summernote @error('misi') is-invalid @enderror" name="misi" required
                                    autocomplete="misi" autofocus>{{ old('misi') }}</textarea>
                                @error('misi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="slogan" class="form-label">{{ __('SLOGAN') }}</label>
                                <input id="slogan" type="text"
                                    class="form-control @error('slogan') is-invalid @enderror" name="slogan"
                                    value="{{ old('slogan') }}" required autocomplete="slogan" autofocus>
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
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

                            <div class="mb-3">
                                <label class="form-label">{{ __('Preview Gambar') }}</label>
                                <div id="imagePreview" class="mt-2">
                                    <!-- Preview gambar akan ditampilkan di sini -->
                                </div>
                                <button type="button" id="hapusPreviewBtn"
                                    class="btn btn-danger mt-2 d-none">Hapus</button>
                            </div>

                            <div class="mb-3">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">{{ __('Tambah') }}</button>
                                    <a href="{{ url('/dashboardSuperadmin/Candidate') }}"
                                        class="btn btn-secondary">{{ __('Batal') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusField = document.getElementById('status');
            const wakilKetuaField = document.getElementById('wakil_ketua_container');

            function toggleWakilKetua() {
                if (statusField.value === 'perseorangan') {
                    wakilKetuaField.style.display = 'none';
                } else {
                    wakilKetuaField.style.display = 'block';
                }
            }

            statusField.addEventListener('change', toggleWakilKetua);

            // Initialize visibility on page load
            toggleWakilKetua();
        });
        // Script untuk menampilkan preview gambar saat dipilih
        document.getElementById('foto').addEventListener('change', function(event) {
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-thumbnail mt-2";
                var previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = '';
                previewContainer.appendChild(img);

                // Tampilkan tombol Hapus
                document.getElementById('hapusPreviewBtn').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });

        // Script untuk menghapus preview gambar
        document.getElementById('hapusPreviewBtn').addEventListener('click', function() {
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = '';

            // Reset input file
            var fotoInput = document.getElementById('foto');
            fotoInput.value = '';

            // Sembunyikan tombol Hapus
            document.getElementById('hapusPreviewBtn').classList.add('d-none');
        });
    </script>
    <script>
        // Script untuk inisialisasi Summernote
        $(document).ready(function() {
            $('.summernote').summernote({
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
