@extends('layouts.front')

@section('content')
    <style>
        @import "https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap";

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            
            .page-header {
                padding: 80px 0 60px;
            }
        }

        .page-header {
            background: linear-gradient(rgba(0, 118, 70, 0.9), rgba(0, 118, 70, 0.9)), url('{{ $img_path ?? 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80' }}');
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
            <h1 data-aos="fade-down">{{ ucfirst($titre) }}</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ ucfirst($titre) }}</li>
                </ol>
            </nav>
        </div>
    </section>
    
    <div class="container-fluid services py-5 mb-5">
        <div class="container-md outils-container">
            <div class="row container g-2 services-inner d-flex justify-content-center">
                <div class="col-12 col-md-9">
                    
                    <div class="text-justify readme fs-5" style="line-height: 4;">
                        {!! $content !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection