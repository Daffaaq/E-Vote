<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail {{ $candidate->nama_ketua }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            background-color: #f0f2f5;
            font-family: "Roboto", sans-serif;
        }

        .card-detail {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px;
            background-color: #ffffff;
            margin-top: 50px;
        }

        .card-detail h1 {
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #007bff, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-detail img {
            border-radius: 50%;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            width: 150px;
            height: 150px;
        }

        .card-detail p {
            font-size: 18px;
            color: #666;
            line-height: 1.6;
        }

        .card-detail ul {
            padding-left: 0;
            list-style: none;
            margin: 0 auto;
            display: table;
        }

        .card-detail ul li {
            font-size: 18px;
            margin-bottom: 10px;
            display: table;
            text-align: left;
        }

        .card-detail ul li i {
            margin-right: 10px;
            display: table-cell;
            vertical-align: middle;
        }

        .card-detail ul li span {
            display: table-cell;
            vertical-align: middle;
        }

        .card-detail .btn-primary,
        .card-detail .btn-success {
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 50px;
            margin: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .card-detail .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .card-detail .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }

        .card-detail .btn-success {
            background-color: #28a745;
            border: none;
        }

        .card-detail .btn-success:hover {
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .divider {
            height: 4px;
            background: linear-gradient(90deg, #007bff, #00d4ff);
            width: 60px;
            margin: 20px auto;
            border-radius: 3px;
        }

        .back-button {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        @media (min-width: 768px) {
            .back-button {
                flex-direction: row;
            }
        }

        .footer-icons .social-btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease-in-out;
        }

        .footer-icons .social-btn:active {
            transform: scale(0.9);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card-detail text-center">
            <img src="{{ asset('storage/' . $candidate->foto) }}" alt="Foto {{ $candidate->nama_ketua }}"
                class="img-fluid" />
            <h1>Detail Kandidat: <span>{{ $candidate->no_urut_kandidat }}</span></h1>
            <div class="divider"></div>

            <!-- Nama Ketua -->
            <p>
                <i class="fas fa-user-tie" style="color: #007bff"></i>
                <strong>Nama Ketua:</strong>
                <span style="color: #343a40; font-weight: 600">{{ $candidate->nama_ketua }}</span>
            </p>

            <!-- Nama Wakil Ketua (If not perseorangan) -->
            @if ($candidate->status !== 'perseorangan')
                <p>
                    <i class="fas fa-user-friends" style="color: #28a745"></i>
                    <strong>Nama Wakil Ketua:</strong>
                    <span style="color: #343a40; font-weight: 600">{{ $candidate->nama_wakil_ketua }}</span>
                </p>
            @endif

            <!-- Visi -->
            <p>
                <i class="fas fa-bullseye" style="color: #007bff"></i>
                <strong>Visi:</strong>
                <span style="color: #495057">{!! $candidate->visi !!}</span>
            </p>

            {{-- <?php
            $htmlContent = $candidate->misi;
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true); // Suppress errors for invalid HTML
            $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors(); // Clear errors after parsing
            $items = $dom->getElementsByTagName('li');
            ?>
            <!-- Misi -->
            <p>
                <i class="fas fa-tasks" style="color: #007bff"></i>
                <strong>Misi:</strong>
            </p>
            <ul>
                @foreach ($items as $item)
                    <li>
                        <i class="fas fa-check-circle" style="color: #28a745"></i>
                        <span>{!! $item->nodeValue !!}</span>
                    </li>
                @endforeach
            </ul> --}}

            <!-- Misi -->
            <p>
                <i class="fas fa-tasks" style="color: #007bff"></i>
                <strong>Misi:</strong>
            </p>
            <ul>
                @foreach ($uniqueItems as $item)
                    <li>
                        <i class="fas fa-check-circle" style="color: #28a745"></i>
                        <!-- Render berdasarkan tag -->
                        <span style="text-align: justify; display: block;"> &nbsp; {!! $item['content'] !!}</span>
                    </li>
                @endforeach
            </ul>

            <!-- Slogan -->
            <p>
                <i class="fas fa-quote-left" style="color: #007bff"></i>
                <strong>Slogan:</strong>
                <span style="font-style: italic; color: #495057">{{ $candidate->slogan }}</span>
            </p>

            <div class="back-button">
                <a href="{{ route('dashboard.voter') }}" class="btn btn-primary">Kembali</a>
                <a href="#" class="btn btn-success">Vote</a>
            </div>
        </div>
    </div>

    <!-- Menambahkan jarak antara dua div -->
    <div style="margin-top: 50px"></div>

    <div class="container-fluid">
        <footer class="bg-dark text-center text-white p-4" style="margin-bottom: 0">
            <section class="mb-4 footer-icons">
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #3b5998" href="#!"
                    role="button">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #55acee" href="#!"
                    role="button">
                    <i class="fab fa-twitter"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #dd4b39" href="#!"
                    role="button">
                    <i class="fab fa-google"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #ac2bac" href="#!"
                    role="button">
                    <i class="fab fa-instagram"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #0082ca" href="#!"
                    role="button">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="btn btn-primary btn-floating m-1 social-btn" style="background-color: #333333" href="#!"
                    role="button">
                    <i class="fab fa-github"></i>
                </a>
            </section>
        </footer>
        <div class="text-center p-3 bg-dark text-white">
            &copy; 2024 Sistem Pemilihan. All rights reserved. Developed by Ache.
        </div>
    </div>
</body>

</html>
