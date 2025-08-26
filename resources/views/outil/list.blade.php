@extends('layouts.front')
@push('styles')
    <style>
        /* Style général */
        .services {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        /* Barre de filtres avec couleurs vertes */
        .filter-container {
            max-width: 600px;
            margin: 0 auto 40px;
            background: white;
            border-radius: 50px;
            padding: 15px 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .select2-container--default .select2-selection--multiple {
            background-color: transparent !important;
            border: none !important;
            min-height: 46px;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: linear-gradient(135deg, #47da9d, #36c0a8) !important;
            border: none !important;
            color: white !important;
            border-radius: 20px !important;
            padding: 2px 15px;
            margin: 3px;
            font-size: 0.85rem;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            margin-right: 5px;
            border-right: 1px solid rgba(255,255,255,0.3) !important;
            padding-right: 5px;
        }
        
        /* Cartes d'outils avec couleurs vertes */
        .tools-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        
        .tool-card {
            width: 240px;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .tool-card-img-container {
            height: 160px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .tool-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .tool-card:hover img {
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
        
        .card-title {
            font-size: 1rem;
            margin-bottom: 12px;
            color: #212529;
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
        
        /* Animation de chargement */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #47da9d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@section('content')
    <div class="services">
        <div class="container">
            <!-- Barre de filtres -->
            <div class="filter-container">
                <select id="typeoutil_id"
                    class="form-control js-example-placeholder-multiple @error('typeoutil_id') is-invalid @enderror"
                    name="typeoutil_id" multiple>
                    @foreach ($typeOutils as $item)
                        <option value="{{ $item->typeoutil_id }}"
                            {{ $item->typeoutil_id == old('typeoutil_id') ? 'selected' : '' }}>
                            {{ $item->typeoutilLibelle }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Titre de section -->
            <div class="text-center">
                <h3 class="section-title">{{ __('Liste des outils') }}</h3>
                <p class="section-subtitle">Découvrez nos outils pratiques</p>
            </div>
            
            <!-- Loading spinner -->
            <div id="loading-spinner" class="loading-spinner">
                <div class="spinner"></div>
                <p class="mt-2">Chargement des outils...</p>
            </div>
            
            <!-- Grille d'outils -->
            <div class="tools-grid" id="tools-container">
                @foreach ($outils as $outil)
                    <div class="tool-card">
                        <a href="{{ route('outils.details', $outil->id) }}" class="text-decoration-none text-dark">
                            <div class="tool-card-img-container">
                                @if($outil->image_path)
                                    <img src="{{ asset('storage/' . $outil->image_path) }}" alt="{{ $outil->titre }}" loading="lazy">
                                @else
                                    <img src="https://via.placeholder.com/300x160?text=Outil" alt="Image par défaut" loading="lazy">
                                @endif
                            </div>
                            <div class="card-body">
                                <span class="badge-custom">{{ $outil->typeOutil->typeoutilLibelle }}</span>
                                <h5 class="card-title">{{ Str::limit($outil->titre, 40) }}</h5>
                                <button class="btn btn-details">Voir détails</button>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialisation de Select2
            $(".js-example-placeholder-multiple").select2({
                placeholder: "Filtrer par catégorie...",
                width: '100%',
                closeOnSelect: false
            });
            
            // Gestion du filtre AJAX avec token CSRF
            $('#typeoutil_id').on('change', function() {
                let selectedTypes = $(this).val();
                
                // Afficher le spinner de chargement
                $('#loading-spinner').show();
                $('#tools-container').css('opacity', '0.5');
                
                $.ajax({
                    url: "{{ route('outils.filter') }}",
                    type: "POST",
                    data: { 
                        typeoutil_id: selectedTypes,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $("#tools-container").html(data.html);
                    },
                    error: function(xhr) {
                        console.error("Erreur lors du filtrage:", xhr.responseText);
                        alert("Une erreur est survenue lors du filtrage.");
                    },
                    complete: function() {
                        $('#loading-spinner').hide();
                        $('#tools-container').css('opacity', '1');
                    }
                });
            });
        });
    </script>
@endpush