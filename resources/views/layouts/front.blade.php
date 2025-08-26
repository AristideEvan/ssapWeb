<!DOCTYPE html>
<html lang="fr">

<head>

    <!-- Google Web Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.Default.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.fullscreen.css') }}" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Saira:wght@500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css"> --}}
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.rtnotify.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sigobs.css') }}" />
    <meta charset="utf-8" />
    <title>Plateforme CILSS-INSAH | Partage de Bonnes Pratiques</title>
    <meta name="description"
        content="Plateforme de partage et diffusion des bonnes pratiques pour la résilience au Sahel" />
    <meta name="keywords" content="CILSS, INSAH, Sahel, sécurité alimentaire, pastoralisme, changement climatique" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="CILSS-INSAH" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />

    <!-- Fonts Google Premium -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap"
        rel="stylesheet" />

    <!-- Leaflet CSS -->
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" /> --}}

    <!-- Google Web Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
    {{-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> --}}
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.Default.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.fullscreen.cs') }}" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/css/bootstrap-grid.min.css"
        integrity="sha512-79vX0oXpL1ee3k+V7jJxmmT+xdb7UrE7Fce5RYu3/l1oO/EWaMGEjDDObLXe2JSrDZtoRntVv0Iolv6i4TDWKw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">
    @stack('styles')

    <style>
        :root {
            --primary: #007646;
            --primary-light: rgba(16, 187, 81, 0.88);
            --secondary: #fd7e14;
            --secondary-light: rgba(253, 126, 20, 0.1);
            --dark: #212529;
            --light: #f8f9fa;
            --accent: #1842b6;
            --gray: #6c757d;
        }

        body {
            font-family: "Montserrat", sans-serif;
            color: var(--dark);
            background-color: #f8fcff;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Playfair Display", serif;
            font-weight: 600;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        .text-secondary {
            color: var(--secondary) !important;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: #006238;
            border-color: #006238;
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .navbar {
            transition: all 0.3s ease;
            padding: 15px 0;
        }

        .navbar.scrolled {
            padding: 10px 0;
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
        }

        .navbar-brand h1 {
            font-size: 1.5rem;
            margin-bottom: 0;
            font-weight: 700;
        }

        .nav-link {
            font-weight: 500;
            padding: 8px 15px !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--secondary) !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--secondary-light);
            color: var(--secondary);
        }

        /* Carousel Section */
        .carousel-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }

        .carousel-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 400px;
        }

        .carousel-img {
            height: 250px;
            object-fit: cover;
        }

        .carousel-body {
            padding: 20px;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background-color: var(--secondary);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
        }

        .carousel-control-prev {
            left: -20px;
        }

        .carousel-control-next {
            right: -20px;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }

        .section-header h2::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary);
        }

        .section-header p {
            color: var(--gray);
            max-width: 700px;
            margin: 15px auto 0;
        }

        /* Feature Cards */
        .feature-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.2);
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(rgba(0, 118, 70, 0.9), rgba(0, 118, 70, 0.9)),
                url("{{ asset('img/mais1600x1200.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 100px 0;
            color: white;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* Guide Section */
        .guide-section {
            background-color: #f8f9fa;
            padding: 80px 0;
        }

        .guide-img {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Partners Section */
        .partners-section {
            padding: 80px 0;
        }

        .partner-logo {
            height: 80px;
            object-fit: contain;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
            padding: 15px;
        }

        .partner-logo:hover {
            filter: grayscale(0);
            opacity: 1;
        }

        /* Footer */
        .footer {
            background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)),
                url("{{ asset('img/mais1600x1200.png') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding-top: 80px;
            position: relative;
        }

        .footer h4 {
            color: white;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer h4::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: var(--secondary);
            padding-left: 5px;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: var(--secondary);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            padding-bottom: 20px;
            margin-top: 40px;
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--secondary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            z-index: 99;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .back-to-top.active {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .section-header h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 2rem;
            }

            .navbar-brand h1 {
                font-size: 1.2rem;
            }

            .carousel-control-prev {
                left: 10px;
            }

            .carousel-control-next {
                right: 10px;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand h1 {
                margin-left: -41px !important;
            }

            .logo {
                height: 70px !important;
                width: 70px !important;
            }

            .card {
                margin-bottom: 20px;
            }
        }
    </style>

    <style>
        .carousel-container {
            position: relative;
            max-width: 1200px;
            margin: 40px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            height: 400px;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .carousel-item img {
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .practice-theme {
            font-size: 1rem;
            color: #fd7e14;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .practice-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .practice-desc {
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background-color: rgba(253, 126, 20, 0.9);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: calc(40% + 20px);
        }

        @media (max-width: 992px) {
            .carousel-overlay {
                width: 50%;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .carousel-container {
                height: 500px;
            }

            .carousel-overlay {
                position: relative;
                width: 100%;
                height: auto;
                padding: 25px;
            }

            .carousel-control-next {
                right: 20px;
            }

            .practice-title {
                font-size: 1.5rem;
            }
        }
    </style>

    <style>
        /* Nouveau style pour le carousel */
        #practicesCarousel {
            width: 100%;
            height: 500px;
        }

        #practicesCarousel .carousel-inner,
        #practicesCarousel .carousel-item {
            height: 100%;
        }

        #practicesCarousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 30px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .practice-theme {
            font-size: 1rem;
            color: #fd7e14;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .practice-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .practice-desc {
            font-size: 1rem;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background-color: rgba(253, 126, 20, 0.9);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 1;
        }

        .carousel-control-prev {
            left: 20px;
        }

        .carousel-control-next {
            right: calc(40% + 20px);
        }

        @media (max-width: 992px) {
            .carousel-overlay {
                width: 50%;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            #practicesCarousel {
                height: 600px;
            }

            .carousel-overlay {
                position: relative;
                width: 100%;
                height: auto;
                padding: 25px;
                background: rgba(0, 0, 0, 0.9);
            }

            .carousel-control-next {
                right: 20px;
            }

            .practice-title {
                font-size: 1.5rem;
            }
        }

        /* But et Objectifs */
        .goals-section {
            background-color: var(--light);
            padding: 60px 0;
        }

        .goal-card {
            border-left: 4px solid var(--secondary);
            padding: 20px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .goal-card h4 {
            color: var(--primary);
        }

        .dropdown-toggle::after {
            content: url('data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>');
            border: none;
            width: 10px;
            height: auto;
            margin-left: 0.4rem;
            vertical-align: middle;
        }

        /* to be removed */

        @media (max-width: 768px) {
            .logo {
                margin: 0 !important;
                height: 70px !important;
                width: 70px !important;
                padding: 5px;
                padding-bottom: 5px;
            }

            .gutter-md-0 {
                width: 100%;
                margin-left: auto !important;
                margin-right: auto !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }


        }

        .logo {
            margin-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .logo {
            width: 87px;
            margin: auto;
            height: 81px;
        }

        .navbar .nav-link {
            color: black;
        }

        .pl-5px {
            padding-left: 10px !important;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
            color: black !important;
        }

        .navbar-nav .dropdown-item {
            color: black;
            font-weight: 400 !important;
        }

        /* Optionnel: pour les liens actifs */
        .navbar-nav .nav-link.active {
            font-weight: bold !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--secondary) !important;
        }
    </style>
</head>

<body>
    <div class="container-fluid bg-light sticky-top">
        <div class="container-fluid container-md gutter-md-0">
            <nav class="navbar navbar-light navbar-expand-lg py-0">
                <!-- 1. Toggler en premier -->
                <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- 2. Logo + Brand (version compacte) -->
                <a href="/" class="text-decoration-none d-flex align-items-center me-auto">
                    <img class="logo" src="{{ asset('images/logo.png') }}" alt="" width="80"
                        height="40" />
                    <h1 class="fw-bold m-0 ms-2" style="font-size: 1rem">
                        <span class="text-dark">CILSS-</span><span class="text-secondary">INSAH</span>
                    </h1>
                </a>

                @auth
                    <div class="dropdown order-lg-2 d-lg-none ms-auto">
                        <a href="#" class="nav-link px-2" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Espace de travail</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Déconnexion</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                @auth
                    <div class="dropdown order-lg-2 ms-2 d-none d-lg-block">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center py-1"
                            data-bs-toggle="dropdown">
                            <span class="text-truncate" style="max-width: 150px;">{{ Auth::user()->email }}</span>
                            {{-- <i class="fas fa-caret-down ms-1"></i> --}}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Espace de travail</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="#"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Déconnexion</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                <!-- 5. Menu principal -->
                <div class="collapse navbar-collapse order-lg-1" id="navbarCollapse">
                    <!-- Accueil -->
                    {{-- <div class="navbar-nav me-auto ms-lg-3">
                        <a href="/" class="nav-item nav-link {{ Route::is('/') ? 'active' : '' }}">Accueil</a>
                    </div> --}}

                    <!-- Menu droite -->
                    <div class="navbar-nav ms-auto">
                        <a href="/" class="nav-item nav-link {{ Route::is('/') ? 'active' : '' }}">Accueil</a>
                        <!-- Bibliothèque -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ Route::is('biblioteque') ? 'active' : '' }} px-lg-2"
                                href="#" data-bs-toggle="dropdown">Bibliothèque</a>
                            <div class="dropdown-menu py-3 bg-light m-0">
                                @php
                                    $domaines = getDomaines();
                                    $count = count($domaines);
                                @endphp
                                @foreach ($domaines as $index => $domaine)
                                    <a href="{{ route('biblioteque', ['id' => $domaine->theme_id]) }}"
                                        class="dropdown-item"
                                        id="{{ $domaine->theme_id }}">{{ ucfirst(mb_strtolower($domaine->themeLibelle)) }}</a>
                                    @if ($index < $count - 1)
                                        <div class="dropdown-divider"></div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Carte -->
                        <a href="{{ route('carte.showMap') }}" class="nav-item nav-link px-lg-2">Carte</a>

                        <!-- E-learning -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-lg-2" href="#"
                                data-bs-toggle="dropdown">E-learning</a>
                            <div class="dropdown-menu py-3 bg-light m-0">
                                <a href="{{ route('outils') }}" class="dropdown-item">{{ __('Ressources') }}</a>
                                <div class="dropdown-divider"></div>
                                <a href="/elearning" class="dropdown-item">{{ __('Catalogue des formations') }}</a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('communautes') }}"
                                    class="dropdown-item">{{ __('Communautés de pratiques') }}</a>
                            </div>
                        </div>

                        <!-- Actualités -->
                        <a href="{{ route('actualites.liste') }}" class="nav-item nav-link px-lg-2">Actualités</a>

                        <!-- Contacts -->
                        <a href="{{ route('contact') }}" class="nav-item nav-link px-lg-2">Contacts</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-about">
                        <a href="/" class="d-inline-block mb-3">
                            <img src="{{ asset('images/logo.png') }}" alt="CILSS-INSAH" height="50" />
                        </a>
                        <p>
                            Plateforme de partage et de diffusion des bonnes pratiques pour la résilience au Sahel.
                        </p>
                        <div class="social-icons mt-4">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="{{ route('login') }}"><i class="fas fa-lock"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h4>Liens rapides</h4>
                    <div class="footer-links d-flex flex-column">
                        <a href="/">Accueil</a>
                        <a href="{{ route('biblioteque', ['id' => 1]) }}">Bibliothèque</a>
                        <a href="{{ route('carte.showMap') }}">Carte</a>
                        <a href="/elearning">E-learning</a>
                        <a href="{{ route('actualites.liste') }}">Actualités</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4>Thématiques</h4>
                    <div class="footer-links d-flex flex-column">
                        @foreach ($domaines as $domaine)
                            <a
                                href="{{ route('biblioteque', ['id' => $domaine->theme_id]) }}">{{ $domaine->themeLibelle }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4>Contactez-nous</h4>
                    <div class="footer-contact">
                        <p><i class="fas fa-map-marker-alt me-2 text-secondary"></i> B.P :1530, Bamako, Mali
                        </p>
                        <p><i class="fas fa-phone-alt me-2 text-secondary"></i> (223) 20 22 47 06 </p>
                        <p><i class="fas fa-envelope me-2 text-secondary"></i>administration.insah@cilss.int</p>
                        <p><i class="fas fa-clock me-2 text-secondary"></i> Lundi - Vendredi: 07h30 - 16h</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom mt-5 pt-4 border-top border-secondary">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0">&copy; {{ date('Y') }} CILSS-INSAH. Tous droits réservés.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <style>
        @import "https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap";

        .readme p * {
            font-size: 1rem !important;
            font-weight: 300 !important;
            font-family: "Montserrat", sans-serif !important;
            line-height: 2 !important;
            color: var(--dark) !important;
            line-height: 24px !important;
        }

        .readme {
            text-align: justify !important;
        }

        .readme>p,
        .readme>h1,
        .readme>h2,
        .readme>h3,
        .readme>h4,
        .readme>h5,
        .readme>h6,
        .readme>span,
        .readme>a,
        .readme>ul,
        .readme>ol {
            font-family: 'Roboto', 'Calibri', 'Bree Serif', sans-serif;
            line-height: 2 !important;
        }
    </style>

    <!-- Back to Top -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"
        integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/js/bootstrap.min.js"
        integrity="sha512-zKeerWHHuP3ar7kX2WKBSENzb+GJytFSBL6HrR2nPSR1kOX1qjm+oHooQtbDpDBSITgyl7QXZApvDfDWvKjkUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script src="https://unpkg.com/leaflet-fullscreen/dist/Leaflet.fullscreen.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>
    <script src="{{ asset('js/carte/leaflet.js') }}"></script>
    <script src="{{ asset('js/carte/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('js/carte/Leaflet.fullscreen.min.js') }}"></script>
    <script src="{{ asset('js/carte/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/carte/Control.Geocoder.js') }}"></script>
    <script src="{{ asset('js/carte/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('js/carte/lang/summernote-fr-FR.js') }}"></script>

    <script src="{{ asset('js/summernote-image-attributes.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
        });

        // Back to top button
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $(".back-to-top").addClass("active");
            } else {
                $(".back-to-top").removeClass("active");
            }
        });

        $(".back-to-top").click(function(e) {
            e.preventDefault();
            $("html, body").animate({
                scrollTop: 0
            }, "300");
        });

        // Navbar scroll effect
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $(".navbar").addClass("scrolled");
            } else {
                $(".navbar").removeClass("scrolled");
            }
        });

        // Counter animation
        $(document).ready(function() {
            $(".stat-number").each(function() {
                $(this)
                    .prop("Counter", 0)
                    .animate({
                        Counter: $(this).data("count"),
                    }, {
                        duration: 2000,
                        easing: "swing",
                        step: function(now) {
                            $(this).text(Math.ceil(now));
                        },
                    });
            });
        });
    </script>
    <script>
    $(document).ready(function() {
        $('table.dataTable').DataTable({
            language: {
                "lengthMenu": "Afficher _MENU_ entrées par page",
                "zeroRecords": "Aucun résultat trouvé",
                "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "infoEmpty": "Aucune donnée disponible",
                "infoFiltered": "(filtré à partir de _MAX_ entrées totales)",
                "search": "Rechercher :",
                "paginate": {
                    "first": "Premier",
                    "last": "Dernier",
                    "next": "Suivant",
                    "previous": "Précédent"
                }
            }
        });
    });
</script>

    @stack('scripts')
</body>

</html>
