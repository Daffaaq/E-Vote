<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="Auth/login.css">
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-bird-symbols-png-logo-0.png"
                alt="">
        </div>
        <div class="text-center mt-4 name">
            Twitter
        </div>
        <form class="p-3 mt-3" method="POST" action="{{ route('loginProcess') }}">
            @csrf <!-- Tambahkan CSRF token -->
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
                <!-- Ganti name menjadi "username" -->
            </div>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
                <!-- Tampilkan pesan validasi jika terjadi kesalahan pada email -->
            @enderror
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
                <!-- Tampilkan pesan validasi jika terjadi kesalahan pada password -->
            @enderror
            <button type="submit" class="btn mt-3">Login</button> <!-- Tambahkan type="submit" pada tombol login -->
        </form>
        <div class="text-center fs-6">
            <a href="{{ url('/') }}">Back to Landing Page?</a>
        </div>
    </div>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="stylesheet">
</body>

</html>
