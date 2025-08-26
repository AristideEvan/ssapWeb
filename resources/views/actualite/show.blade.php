@extends('layouts.front')

@section('content')
    <style>

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            
            .page-header {
                padding: 80px 0 60px;
            }
        }

        .page-header {
            background-image: url('{{ asset('storage/' . $actualite->image_path) ?? 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80' }}');
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
            <h1 data-aos="fade-down">{{ ucfirst('Actualité') }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ ucfirst('Actualité') }}</li>
                </ol>
            </nav>
        </div>
    </section>
    
    <div class="container-fluid services py-5 mb-5">
        <div class="container-md outils-container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <p class="card-text fs-6 text-italic">{{ $actualite->created_at->diffForHumans() }}</p>
                <h1 class="badge-custom">{{ $actualite->titre }}</h1>
            </div>
            <div class="row g-2 services-inner d-flex justify-content-center">
                <div class="col-12 col-md-9 mx-auto">
                    <div class="p-md-4 text-justify">
                        {!! $actualite->contenu !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection