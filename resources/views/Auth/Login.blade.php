<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-VOTE SMP SAINS MIFTAHUL HUDA</title>
    <link rel="shortcut icon"
        href="https://arest.web.id/sites/default/files/styles/foto_company_singlepost/public/logo-smp-sains-miftahul-huda-nganjuk.jpg?itok=PFD1NgpJ"
        type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="Auth/login.css">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="wrapper">
        <div class="logo">
            <img src="https://arest.web.id/sites/default/files/styles/foto_company_singlepost/public/logo-smp-sains-miftahul-huda-nganjuk.jpg?itok=PFD1NgpJ"
                alt="">
        </div>
        <div class="text-center mt-3 opening-text">
            Welcome To
        </div>
        <div class="text-center mt-4 name">
            E-Vote Ketua Osis SMP Sains Miftahul Huda
        </div>
        <form class="p-3 mt-3" method="POST" action="{{ route('loginProcess') }}" autocomplete="off">
            @csrf
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password"
                    autocomplete="new-password">
            </div>
            <button type="submit" class="btn mt-3">Login</button>
        </form>
        <div class="text-center fs-6">
            <a href="{{ url('/') }}">Back to Landing Page?</a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {
            // Show success message if exists

            //  @if (Session::has('success'))
            //     toastr.success("{{ Session::get('success') }}");
            //     setTimeout(function() {
            //         window.location.href = "{{ route(Session::get('route')) }}";
            //     }, 5000); // 5 seconds delay
            // @endif

            // Show error messages for form fields
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif

            // Show error message for login failure
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        });
    </script>
</body>

</html>
