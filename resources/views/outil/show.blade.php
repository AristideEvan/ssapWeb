@extends('layouts.front')

@section('content')
    <style>
        @import "https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap";

        .card-img-top {
            border-radius: 0 !important;
        }

        @media (min-width: 768px) {
            .outils-container {
                width: 60%;
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            
            .page-header {
                padding: 80px 0 60px;
            }
        }

        .page-header {
            background: linear-gradient(rgba(0, 118, 70, 0.9), rgba(0, 118, 70, 0.9)), url('{{ $outil->image_path ?? 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80' }}');
            background-size: cover;
            background-position: center;
            padding: 120px 0 80px;
            color: white;
            text-align: center;
            position: relative;
        }

        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .page-header h1::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--secondary);
        }

        .breadcrumb {
            justify-content: center;
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: white;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
    
    <section class="page-header">
        <div class="container">
            <h1 data-aos="fade-down">{{ $outil->titre }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Ressources</a></li>
                    <li class="breadcrumb-item"><a href="#">{{ ucfirst(strtolower($outil->typeOutil->typeoutilLibelle)) }}</a></li>
                </ol>
            </nav>
        </div>
    </section>
    
    <div class="container-fluid services py-5 mb-5">
        <div class="container-md outils-container">
            <h3 class="outil-titre text-center">{{ $outil->titre }}</h3>
            <div class="row g-2 services-inner d-flex justify-content-center">
                <div>
                    <div class="p-md-4 text-justify2 readme">
                        {!! $outil->contenu !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if ($outil->documents->count() > 0)
    <section id="documents" class="section">
        <h2 class="section-title text-center">{{ __('Documents associés') }}</h2>
        <div class="references">
            <ol class="list-unstyled d-flex flex-column align-items-center">
                @foreach ($outil->documents as $document)
                    @php
                        // Extraire l'extension du fichier
                        $extension = pathinfo($document->nom, PATHINFO_EXTENSION);
                        $extension = strtolower($extension);

                        // Définir les icônes par extension
                        $icons = [
                            'pdf' => 'https://cdn-icons-png.flaticon.com/512/337/337946.png',
                            'doc' => 'https://cdn-icons-png.flaticon.com/512/281/281760.png',
                            'docx' => 'https://cdn-icons-png.flaticon.com/512/281/281760.png',
                            'xls' => 'https://cdn-icons-png.flaticon.com/512/732/732220.png',
                            'xlsx' => 'https://cdn-icons-png.flaticon.com/512/732/732220.png',
                            'ppt' => 'https://cdn-icons-png.flaticon.com/512/281/281764.png',
                            'pptx' => 'https://cdn-icons-png.flaticon.com/512/281/281764.png',
                            'txt' => 'https://cdn-icons-png.flaticon.com/512/281/281785.png',
                            'zip' => 'https://cdn-icons-png.flaticon.com/512/136/136544.png',
                            'rar' => 'https://cdn-icons-png.flaticon.com/512/136/136544.png',
                            'gif' => 'https://cdn-icons-png.flaticon.com/512/281/281793.png',
                        ];

                        // Icône par défaut si l'extension n'est pas reconnue
                        $defaultIcon = 'https://cdn-icons-png.flaticon.com/512/2965/2965300.png';
                        $icon = $icons[$extension] ?? $defaultIcon;
                    @endphp

                    <li class="mb-2">
                        <a href="{{ asset('storage/' . $document->path) }}" 
                           download="{{ $document->nom }}"
                           class="text-decoration-none d-flex align-items-center gap-2">
                            <img src="{{ $icon }}" 
                                 alt="{{ strtoupper($extension) }}"
                                 style="width:20px; height:20px; object-fit:contain;">
                            <span>{{ $document->nom }}</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
@endif
@endsection