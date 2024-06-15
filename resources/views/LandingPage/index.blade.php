<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Scholar - Online School HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('LandingPage/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('LandingPage/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('LandingPage/assets/css/templatemo-scholar.css') }}">
    <link rel="stylesheet" href="{{ asset('LandingPage/assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('LandingPage/assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!--

TemplateMo 586 Scholar

https://templatemo.com/tm-586-scholar

-->
</head>

<body>
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="index.html" class="logo">
                            <h1>EVOTE</h1>
                        </a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Serach Start ***** -->
                        {{-- <div class="search-input">
                            <form id="search" action="#">
                                <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword"
                                    onkeypress="handle" />
                                <i class="fa fa-search"></i>
                            </form>
                        </div> --}}
                        <!-- ***** Serach Start ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                            <li class="scroll-to-section"><a href="#services">About</a></li>
                            <li class="scroll-to-section"><a href="#events">Schedule</a></li>
                            <li class="scroll-to-section"><a href="#courses">Caketos</a></li>
                            <li class="scroll-to-section"><a href="#team">Team</a></li>
                            <li class="scroll-to-section"><a href="#contact">Advice</a></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        <div class="item item-1">
                            <div class="header-text">
                                <span class="category">Our Courses</span>
                                <h2>With Scholar Teachers, Everything Is Easier</h2>
                                <p>Scholar is free CSS template designed by TemplateMo for online educational related
                                    websites. This layout is based on the famous Bootstrap v5.3.0 framework.</p>
                            </div>
                        </div>
                        <div class="item item-2">
                            <div class="header-text">
                                <span class="category">Best Result</span>
                                <h2>Get the best result out of your effort</h2>
                                <p>You are allowed to use this template for any educational or commercial purpose. You
                                    are not allowed to re-distribute the template ZIP file on any other website.</p>
                            </div>
                        </div>
                        <div class="item item-3">
                            <div class="header-text">
                                <span class="category">Online Learning</span>
                                <h2>Online Learning helps you save the time</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporious
                                    incididunt ut labore et dolore magna aliqua suspendisse.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="main-banner" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel owl-banner">
                        @foreach ($banners as $banner)
                            <div class="item" style="background-image: url('{{ $banner->image_url }}');">
                                <div class="header-text">
                                    <span class="category">{{ $banner->category }}</span>
                                    <h2>{{ $banner->title }}</h2>
                                    <p>{{ $banner->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div class="services section" id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="assets/images/service-01.png" alt="online degrees">
                        </div>
                        <div class="main-content">
                            <h4>Online Degrees</h4>
                            <p>Whenever you need free templates in HTML CSS, you just remember TemplateMo website.</p>
                            <div class="main-button">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="assets/images/service-02.png" alt="short courses">
                        </div>
                        <div class="main-content">
                            <h4>Short Courses</h4>
                            <p>You can browse free templates based on different tags such as digital marketing, etc.</p>
                            <div class="main-button">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-item">
                        <div class="icon">
                            <img src="assets/images/service-03.png" alt="web experts">
                        </div>
                        <div class="main-content">
                            <h4>Web Experts</h4>
                            <p>You can start learning HTML CSS by modifying free templates from our website too.</p>
                            <div class="main-button">
                                <a href="#">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="services section" id="services">
        <div class="container">
            <div class="service-item">
                <div class="main-content" style="width: 100%;">
                    <h4 style="text-align: center; margin-top: -66px;">Welcome to E-Vote Ketua Osis SMP Miftahul Huda
                    </h4>
                    <p>E-Voting, atau Electronic Voting, adalah sistem pemungutan suara yang memanfaatkan teknologi
                        elektronik Website E-Voting ini khusus dirancang untuk pemilihan ketua OSIS di SMP Sains
                        Miftahul Huda Nganjuk. </p>
                    {{-- <div class="main-button">
                            <a href="#">Read More</a>
                        </div> --}}
                </div>
            </div>
        </div>
    </div>

    {{-- 
    <div class="section about-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-1">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Where shall we begin?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Dolor <strong>almesit amet</strong>, consectetur adipiscing elit, sed doesn't
                                    eiusmod tempor incididunt ut labore consectetur <code>adipiscing</code> elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse
                                    ultrices gravida.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    How do we work together?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    Dolor <strong>almesit amet</strong>, consectetur adipiscing elit, sed doesn't
                                    eiusmod tempor incididunt ut labore consectetur <code>adipiscing</code> elit, sed do
                                    eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse
                                    ultrices gravida.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    Why SCHOLAR is the best?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    There are more than one hundred responsive HTML templates to choose from
                                    <strong>Template</strong>Mo website. You can browse by different tags or categories.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    Do we get the best support?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    You can also search on Google with specific keywords such as <code>templatemo
                                        business templates, templatemo gallery templates, admin dashboard templatemo,
                                        3-column templatemo, etc.</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>About Us</h6>
                        <h2>What make us the best academy online?</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravid risus commodo.</p>
                        <div class="main-button">
                            <a href="#">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="section events" id="events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Timeline</h6>
                        <h2>Pemilihan Ketua OSIS Masa Bakti</h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="image">
                                    <img src="assets/images/event-01.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <ul>
                                    <li>
                                        <span class="category">Jadwal Orasi</span>
                                    </li>
                                    <li>
                                        <span>Date:</span>
                                        @if ($jadwalOrasi)
                                            <h6>{{ Carbon::parse($jadwalOrasi->tanggal_orasi_vote)->translatedFormat('l, d F Y') }}
                                            </h6>
                                        @else
                                            <h6>Tanggal belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Time</span>
                                        @if ($jadwalOrasi)
                                            <h6>{{ Carbon::parse($jadwalOrasi->jam_orasi_mulai)->format('H:i') }} -
                                                Selesai</h6>
                                        @else
                                            <h6>Jam belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Place</span>
                                        @if ($jadwalOrasi)
                                            <h6>{{ $jadwalOrasi->tempat_orasi }}</h6>
                                        @else
                                            <h6>Tempat belum ditentukan</h6>
                                        @endif
                                    </li>
                                </ul>
                                <a><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="image">
                                    <img src="assets/images/event-02.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <ul>
                                    <li>
                                        <span class="category">Pemungutan Suara</span>
                                    </li>
                                    <li>
                                        <span>First Date:</span>
                                        @if ($jadwalVotes)
                                            <h6>{{ Carbon::parse($jadwalVotes->tanggal_awal_vote)->translatedFormat('l, d F Y') }}
                                            </h6>
                                        @else
                                            <h6>Tanggal awal belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Last Date:</span>
                                        @if ($jadwalVotes)
                                            <h6>{{ Carbon::parse($jadwalVotes->tanggal_akhir_vote)->translatedFormat('l, d F Y') }}
                                            </h6>
                                        @else
                                            <h6>Tanggal akhir belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Place</span>
                                        @if ($jadwalVotes)
                                            <h6>{{ $jadwalVotes->tempat_vote }}</h6>
                                        @else
                                            <h6>Tempat belum ditentukan</h6>
                                        @endif
                                    </li>
                                </ul>
                                <a><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6">
                    <div class="item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="image">
                                    <img src="assets/images/event-03.jpg" alt="">
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <ul>
                                    <li>
                                        <span class="category">Pembacaan Hasil</span>
                                    </li>
                                    <li>
                                        <span>Date:</span>
                                        @if ($jadwalResultVote)
                                            <h6>{{ Carbon::parse($jadwalResultVote->tanggal_result_vote)->translatedFormat('l, d F Y') }}
                                            </h6>
                                        @else
                                            <h6>Tanggal belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Time</span>
                                        @if ($jadwalResultVote)
                                            <h6>{{ Carbon::parse($jadwalResultVote->jam_result_vote)->format('H:i') }}
                                                - Selesai</h6>
                                        @else
                                            <h6>Jam belum ditentukan</h6>
                                        @endif
                                    </li>
                                    <li>
                                        <span>Place</span>
                                        @if ($jadwalResultVote)
                                            <h6>{{ $jadwalResultVote->tempat_result_vote }}</h6>
                                        @else
                                            <h6>Tempat belum ditentukan</h6>
                                        @endif
                                    </li>
                                </ul>
                                <a href="#"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section courses" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="main-content">
                            <img src="assets/images/member-01.jpg" alt="">
                            <span class="category">UX Teacher</span>
                            <h4>Sophia Rose</h4>

                            <a href="#" class="btn btn-primary mt-3"
                                style="background-color: #7a6ad8;">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="main-content">
                            <img src="assets/images/member-02.jpg" alt="">
                            <span class="category">Graphic Teacher</span>
                            <h4>Cindy Walker</h4>
                            <a href="#" class="btn btn-primary mt-3"
                                style="background-color: #7a6ad8;">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="main-content">
                            <img src="assets/images/member-03.jpg" alt="">
                            <span class="category">Full Stack Master</span>
                            <h4>David Hutson</h4>
                            <a href="#" class="btn btn-primary mt-3"
                                style="background-color: #7a6ad8;">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="main-content">
                            <img src="assets/images/member-04.jpg" alt="">
                            <span class="category">Digital Animator</span>
                            <h4>Stella Blair</h4>
                            <a href="#" class="btn btn-primary mt-3"
                                style="background-color: #7a6ad8;">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="section courses" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="section-heading">
                        <h6>Latest Courses</h6>
                        <h2>Latest Courses</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="assets/images/course-01.jpg" class="card-img-top" alt="Course Image 1">
                        <div class="card-body">
                            <h5 class="card-title">1. Learn Web Design</h5>
                            <p class="card-text">Stella Blair</p>
                            <a href="#" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="assets/images/course-02.jpg" class="card-img-top" alt="Course Image 2">
                        <div class="card-body">
                            <h5 class="card-title">2. Web Development Tips</h5>
                            <p class="card-text">Cindy Walker</p>
                            <a href="#" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="assets/images/course-03.jpg" class="card-img-top" alt="Course Image 3">
                        <div class="card-body">
                            <h5 class="card-title">3. Latest Web Trends</h5>
                            <p class="card-text">David Hutson</p>
                            <a href="#" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan lebih banyak card sesuai kebutuhan -->
            </div>
        </div>
    </section> --}}


    <div class="section fun-facts">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="wrapper">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="150" data-speed="1000"></h2>
                                    <p class="count-text ">Students</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="804" data-speed="1000"></h2>
                                    <p class="count-text ">voter count</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="counter">
                                    <h2 class="timer count-title count-number" data-to="50" data-speed="1000"></h2>
                                    <p class="count-text ">Employed Students</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team section" id="team">
        <div class="container" style="justify-content: center;">
            <div class="row" style="justify-content: center;">
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="main-content">
                            <img src="LandingPage/assets/images/member-03.jpg" alt="">
                            <span class="category">Web Developer</span>
                            <h4>Daffa Aqila R</h4>
                            <ul class="social-icons">
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="section testimonials">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="owl-carousel owl-testimonials">
                        <div class="item">
                            <p>“Please tell your friends or collegues about TemplateMo website. Anyone can access the
                                website to download free templates. Thank you for visiting.”</p>
                            <div class="author">
                                <img src="assets/images/testimonial-author.jpg" alt="">
                                <span class="category">Full Stack Master</span>
                                <h4>Claude David</h4>
                            </div>
                        </div>
                        <div class="item">
                            <p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravid.”
                            </p>
                            <div class="author">
                                <img src="assets/images/testimonial-author.jpg" alt="">
                                <span class="category">UI Expert</span>
                                <h4>Thomas Jefferson</h4>
                            </div>
                        </div>
                        <div class="item">
                            <p>“Scholar is free website template provided by TemplateMo for educational related
                                websites. This CSS layout is based on Bootstrap v5.3.0 framework.”</p>
                            <div class="author">
                                <img src="assets/images/testimonial-author.jpg" alt="">
                                <span class="category">Digital Animator</span>
                                <h4>Stella Blair</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 align-self-center">
                    <div class="section-heading">
                        <h6>TESTIMONIALS</h6>
                        <h2>What they say about us?</h2>
                        <p>You can search free CSS templates on Google using different keywords such as templatemo
                            portfolio, templatemo gallery, templatemo blue color, etc.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="contact-us section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6  align-self-center">
                    <div class="section-heading">
                        <h6>Contact Us</h6>
                        <h2>Feel free to contact us anytime</h2>
                        <p>Thank you for choosing our templates. We provide you best CSS templates at absolutely 100%
                            free of charge. You may support us by sharing our website to your friends.</p>
                        <div class="special-offer">
                            <span class="offer">off<br><em>50%</em></span>
                            <h6>Valide: <em>24 April 2036</em></h6>
                            <h4>Special Offer <em>50%</em> OFF!</h4>
                            <a href="#"><i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-us-content">
                        <form id="contact-form" action="" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="name" name="name" id="name"
                                            placeholder="Your Name..." autocomplete="on" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*"
                                            placeholder="Your E-mail..." required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" id="message" placeholder="Your Message"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="orange-button">Send Message
                                            Now</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="col-lg-12">
                <p>Copyright © 2024 Daffa Aqila Rahmatullah. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('LandingPage/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('LandingPage/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('LandingPage/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('LandingPage/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('LandingPage/assets/js/counter.js') }}"></script>
    <script src="{{ asset('LandingPage/assets/js/custom.js') }}"></script>


</body>

</html>
