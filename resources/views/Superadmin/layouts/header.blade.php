<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>E-VOTE SMP SAINS MIFTAHUL HUDA</title>
    <link rel="shortcut icon"
        href="https://arest.web.id/sites/default/files/styles/foto_company_singlepost/public/logo-smp-sains-miftahul-huda-nganjuk.jpg?itok=PFD1NgpJ"
        type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('Dashboard/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">E-VOTE</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        @php
            $actif = session()->get('actif', 1);
            $periode = DB::table('periode')->where('actif', $actif)->first();
        @endphp
        @if ($periode)
            <button class="btn btn-light btn-sm mr-2">
                Periode : &nbsp;
                <i class="fa fa-check-square text-primary"></i>&nbsp;
                <span class="text-primary font-weight-bold">
                    <strong>{{ $periode->periode_nama }}</strong>
                </span>
            </button>
        @else
            <button class="btn btn-light btn-sm mr-2">
                Periode : &nbsp;
                <i class="fa fa-check-square text-primary"></i>&nbsp;
                <span class="text-primary font-weight-bold">
                    <strong></strong>
                </span>
            </button>
            <!-- Tindakan yang diambil jika tidak ada periode yang sesuai -->
        @endif
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
