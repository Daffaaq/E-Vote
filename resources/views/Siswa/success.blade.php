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

        /* Canvas untuk kembang api */
        #fireworksCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1000;
        }

        #confettiCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 999;
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

    <canvas id="confettiCanvas"></canvas>
    <canvas id="fireworksCanvas"></canvas>

    <audio id="applauseAudio" src="{{ asset('Mp3-Sound-Effect/applause.mp3') }}"></audio>

    <script>
        // Fireworks Animation
        window.addEventListener('load', function() {
            const canvas = document.getElementById('fireworksCanvas');
            const ctx = canvas.getContext('2d');

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            function random(min, max) {
                return Math.random() * (max - min) + min;
            }

            function Firework(x, y, radius, color, speedX, speedY) {
                this.x = x;
                this.y = y;
                this.radius = radius;
                this.color = color;
                this.speedX = speedX;
                this.speedY = speedY;
                this.alpha = 1;
            }

            Firework.prototype.draw = function() {
                ctx.save();
                ctx.globalAlpha = this.alpha;
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = this.color;
                ctx.fill();
                ctx.restore();
            };

            Firework.prototype.update = function() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.alpha -= 0.02;
            };

            const fireworksArray = [];

            function createFireworks() {
                const x = random(100, canvas.width - 100);
                const y = random(50, canvas.height / 2);
                const radius = random(3, 6); // Larger particles
                const color = `hsl(${random(0, 360)}, 100%, 50%)`;
                const particles = 40; // More particles

                for (let i = 0; i < particles; i++) {
                    const speedX = random(-4, 4); // Faster speed
                    const speedY = random(-4, 4);
                    fireworksArray.push(new Firework(x, y, radius, color, speedX, speedY));
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                for (let i = 0; i < fireworksArray.length; i++) {
                    fireworksArray[i].update();
                    fireworksArray[i].draw();

                    if (fireworksArray[i].alpha <= 0) {
                        fireworksArray.splice(i, 1);
                        i--;
                    }
                }

                requestAnimationFrame(animate);
            }

            setInterval(createFireworks, 700); // Faster fireworks
            animate();

            // Animasi gambar dan suara applause
            const image = document.getElementById('successImage');
            image.classList.add('animate-zoom');

            image.addEventListener('animationend', function() {
                image.style.opacity = '1';
                const audio = document.getElementById('applauseAudio');
                audio.play(); // Memutar suara applause setelah animasi selesai
            });
        });

        // Confetti Animation
        window.addEventListener('load', function() {
            const confettiCanvas = document.getElementById('confettiCanvas');
            const confettiCtx = confettiCanvas.getContext('2d');

            confettiCanvas.width = window.innerWidth;
            confettiCanvas.height = window.innerHeight;

            const confettiArray = [];
            const confettiColors = ['#f7b217', '#e91e63', '#9c27b0', '#00bcd4', '#4caf50', '#ff5722',
                '#795548'
            ]; // More colors

            function Confetti(x, y, size, color) {
                this.x = x;
                this.y = y;
                this.size = size;
                this.color = color;
                this.speedX = random(-2, 2); // Faster speed
                this.speedY = random(2, 5);
                this.opacity = 1;
                this.rotation = random(0, Math.PI * 2);
            }

            Confetti.prototype.draw = function() {
                confettiCtx.save();
                confettiCtx.globalAlpha = this.opacity;
                confettiCtx.translate(this.x, this.y);
                confettiCtx.rotate(this.rotation);
                confettiCtx.fillStyle = this.color;
                confettiCtx.fillRect(-this.size / 2, -this.size / 2, this.size, this
                    .size); // Rectangular confetti
                confettiCtx.restore();
            };

            Confetti.prototype.update = function() {
                this.y += this.speedY;
                this.x += this.speedX;
                this.rotation += 0.05;
                this.opacity -= 0.007;

                if (this.opacity <= 0) {
                    this.x = random(0, confettiCanvas.width);
                    this.y = -10;
                    this.opacity = 1;
                    this.rotation = random(0, Math.PI * 2);
                }
            };

            function createConfetti() {
                const x = random(0, confettiCanvas.width);
                const y = random(-confettiCanvas.height, 0);
                const size = random(5, 8); // Larger confetti
                const color = confettiColors[Math.floor(random(0, confettiColors.length))];
                confettiArray.push(new Confetti(x, y, size, color));
            }

            function animateConfetti() {
                confettiCtx.clearRect(0, 0, confettiCanvas.width, confettiCanvas.height);

                for (let i = 0; i < confettiArray.length; i++) {
                    confettiArray[i].update();
                    confettiArray[i].draw();
                }

                requestAnimationFrame(animateConfetti);
            }

            for (let i = 0; i < 200; i++) { // More confetti
                createConfetti();
            }

            animateConfetti();
        });
    </script>
</body>

</html>
