@extends('Superadmin.layouts.index')

@section('content')
    <section id="horizontal-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Candidate</h4>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-light-danger alert-dismissible fade show" style="height: 50px" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card-body">
                        <form id="mainForm" method="POST" action="{{ route('Candidate.update', $candidate->uuid) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-12">
                                <div class="form-group row align-items-center">
                                    <label for="status" class="col-lg-3 col-form-label">{{ __('Status') }}</label>
                                    <div class="col-lg-9">
                                        <select id="status" name="status"
                                            class="form-control @error('status') is-invalid @enderror" required readonly>
                                            <option value="" disabled>Pilih Status</option>
                                            <option value="perseorangan"
                                                {{ old('status', $candidate->status) === 'perseorangan' ? 'selected' : '' }}>
                                                Perseorangan
                                            </option>
                                            <option value="ganda"
                                                {{ old('status', $candidate->status) === 'ganda' ? 'selected' : '' }}>
                                                Ganda
                                            </option>
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
                                            name="no_urut_kandidat" readonly
                                            value="{{ old('no_urut_kandidat', $candidate->no_urut_kandidat) }}" required
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
                                            value="{{ old('nama_ketua', $candidate->nama_ketua) }}" required
                                            autocomplete="nama_ketua" autofocus>
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
                                    <label for="nama_wakil_ketua" class="form-label">{{ __('Nama Wakil') }}</label>
                                    <input id="nama_wakil_ketua" type="text"
                                        class="form-control @error('nama_wakil_ketua') is-invalid @enderror"
                                        name="nama_wakil_ketua"
                                        value="{{ old('nama_wakil_ketua', $candidate->nama_wakil_ketua) }}"
                                        autocomplete="nama_wakil_ketua" autofocus>
                                    @error('nama_wakil_ketua')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="visi" class="form-label">{{ __('Visi') }}</label>
                                    <textarea id="visi" class="form-control summernote @error('visi') is-invalid @enderror" name="visi" required
                                        autocomplete="visi" autofocus>{{ old('visi', $candidate->visi) }}</textarea>
                                    @error('visi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea id="misi" class="form-control summernote @error('misi') is-invalid @enderror" name="misi" required
                                        autocomplete="misi" autofocus>{{ old('misi', $candidate->misi) }}</textarea>
                                    @error('misi')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group row align-items-center"">
                                    <label for="slogan" class="form-label">{{ __('SLOGAN') }}</label>
                                    <input id="slogan" type="text"
                                        class="form-control @error('slogan') is-invalid @enderror" name="slogan"
                                        value="{{ old('slogan', $candidate->slogan) }}" required autocomplete="slogan"
                                        autofocus>
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
                                        @if ($candidate->foto)
                                            <img src="{{ asset('storage/' . $candidate->foto) }}"
                                                class="img-thumbnail mt-2" style="height: 200px; width: 200px"
                                                id="currentImage">
                                        @endif
                                    </div>
                                    <button type="button" id="hapusPreviewBtn"
                                        class="btn btn-danger mt-2 {{ $candidate->foto ? '' : 'd-none' }}">Hapus</button>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end mt-3">
                                <a href="{{ url('/dashboardSuperadmin/Candidate') }}"
                                    class="btn btn-primary rounded-pill me-1 mb-1">
                                    {{ __('Batal') }}
                                </a>
                                <button type="button" class="btn btn-info rounded-pill me-1 mb-1"
                                    id="reviewBtn">Review</button>
                                <button type="submit" class="btn btn-success rounded-pill me-1 mb-1">Tambah</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const currentImageHtml = imagePreview.innerHTML;
        document.addEventListener('DOMContentLoaded', function() {

            const statusSelect = document.getElementById('status');
            const wakilKetuacontainer = document.getElementById('wakil_ketua_container');

            function toggleWakilKetuacontainer() {
                if (statusSelect.value === 'ganda') {
                    wakilKetuacontainer.style.display = 'block';
                } else {
                    wakilKetuacontainer.style.display = 'none';
                }
            }

            // Initialize visibility based on the current status
            toggleWakilKetuacontainer();

            // Add event listener for status change
            statusSelect.addEventListener('change', toggleWakilKetuacontainer);
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

                // Tampilkan tombol Hapus
                document.getElementById('hapusPreviewBtn').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        });

        reviewBtn.addEventListener('click', function() {
            const previewContainer = document.getElementById('imagePreview').innerHTML;
            reviewFoto.innerHTML = previewContainer;
            $('#reviewModal').modal('show');
        });

        // Script untuk menghapus preview gambar
        hapusPreviewBtn.addEventListener('click', function() {
            // Hapus hanya jika gambar baru dipilih
            var img = document.getElementById('currentImage');
            if (!img) {
                imagePreview.innerHTML = currentImageHtml;
                document.getElementById('foto').value = '';

                // Sembunyikan tombol Hapus
                hapusPreviewBtn.classList.add('d-none');
            } else {
                alert('Gambar lama tidak bisa dihapus');
            }
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
