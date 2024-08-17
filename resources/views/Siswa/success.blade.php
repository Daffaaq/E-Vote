<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Pemilihan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Roboto', sans-serif;
        }

        .content-wrapper {
            text-align: center;
            background-color: transparent;
            padding: 40px;
            border-radius: 15px;
            max-width: 400px;
            margin: auto;
        }

        .content-wrapper img {
            width: 400px;
            height: 400px;
            margin-bottom: 20px;
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .content-wrapper img:hover {
            transform: scale(1.05);
        }

        .message p {
            margin: 10px 0;
            color: #333;
            font-size: 18px;
        }

        .back-button,
        .play-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #F7B217;
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .back-button:hover,
        .play-button:hover {
            background-color: #d99610;
        }

        @keyframes zoomInOut {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-zoom {
            animation: zoomInOut 1s ease-out;
            animation-fill-mode: forwards;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <img id="successImage" src="{{ asset('Image-Assets/Man-Vote.jpg') }}" alt="Success Image" />
        <div class="message">
            <p>Selamat!</p>
            <p>Votemu sudah masuk.</p>
        </div>
        <a href="{{ route('dashboard.voter') }}" class="back-button">Kembali ke Halaman Awal</a>
    </div>

    <audio id="applauseAudio" src="{{ asset('Mp3-Sound-Effect/applause.mp3') }}"></audio>

    <script>
        window.addEventListener('load', function() {
            const image = document.getElementById('successImage');
            image.classList.add('animate-zoom');

            image.addEventListener('animationend', function() {
                image.style.opacity = '1';
            });
            const audio = document.getElementById('applauseAudio');
            audio.autoplay = true;
        });
    </script>
</body>

</html>
