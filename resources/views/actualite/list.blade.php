@extends('layouts.front')

@push('styles')
    <style>
        /* Style général */
        .news-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        /* Cartes d'actualités */
        .news-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        
        .news-card {
            width: 280px;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .news-card-img-container {
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .news-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .news-card:hover img {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 16px;
            text-align: center;
        }
        
        .badge-custom {
            background: linear-gradient(135deg, #47da9d, #36c0a8);
            color: white;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .news-date {
            color: #6c757d;
            font-size: 0.85rem;
            margin-bottom: 10px;
            font-style: italic;
        }
        
        .news-content {
            text-align: justify;
            color: #495057;
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .btn-details {
            font-size: 0.85rem;
            padding: 5px 15px;
            background-color: white;
            border: 1px solid #47da9d;
            color: #36c0a8;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .btn-details:hover {
            background: linear-gradient(135deg, #47da9d, #36c0a8);
            color: white;
            border-color: transparent;
        }
        
        .section-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: #212529;
            position: relative;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #47da9d, #36c0a8);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
    </style>
@endpush

@section('content')
<div class="news-section">
    <div class="container">
        <!-- Titre de section -->
        <div class="text-center">
            <h3 class="section-title">{{ __('Liste des actualités') }}</h3>
            <p class="section-subtitle">Restez informé de nos dernières nouvelles</p>
        </div>
        
        <!-- Grille d'actualités -->
        <div class="news-grid">
            @foreach ($actualites as $actualite)
                <div class="news-card">
                    <a href="{{ route('actualites.details', $actualite->id) }}" class="text-decoration-none text-dark">
                        <div class="news-card-img-container">
                            @if($actualite->image_path)
                                <img src="{{ asset('storage/' . $actualite->image_path) }}" alt="{{ $actualite->titre }}" loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/300x160?text=Actualité" alt="Image par défaut" loading="lazy">
                            @endif
                        </div>
                        <div class="card-body">
                            <span class="badge-custom">{{ $actualite->titre }}</span>
                            <p class="news-date">{{ $actualite->created_at->diffForHumans() }}</p>
                            <div class="news-content">{!! truncateHtml($actualite->contenu, 100) !!}</div>
                            <button class="btn btn-details">Voir détails</button>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection