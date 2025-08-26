@extends('layouts.'.getTemplate($rub,$srub))

@section('styles')
<link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-fullscreen/dist/leaflet.fullscreen.css" />
@endsection

@section('content') 
    <div class="container-fluid">
    <div id="resultat" class="col-12 col-md-12" style=" position: fixed; top: 0; left: 0; background: rgba(255, 255, 255, 0.8); z-index: 9999; height:100vh; display: none; align-items: center; justify-content: center;">
    <img src="/images/Preloader_110.gif" alt="Chargement..." style=" object-fit: cover;" />
    </div>
        <div class="main-card card">
            <div class="card-body">
                <div class="row">
                    <!-- Colonne pour les combobox, occupe 25% de la largeur, mais s'adapte -->
                    <div class="col-12 col-md-3" style="position: relative; padding-bottom: 50px; background-color: rgba(130, 130, 130, 0.5);"> <!-- Fond légèrement transparent -->
                        <div class="form-group" style>
                            <label for="searchInput" style="color: black; font-weight: bold;">Rechercher</label>
                            <div style="display: flex; align-items: center; border: 1px solidrgb(2, 78, 3);background-color:#48a74a  ">
                                <input type="text" id="searchInput" class="form-control" placeholder="Entrez votre recherche" style="border: none; flex: 1; background:rgba(241, 252, 252, 0.89); outline: none; color: black; caret-color: blue;">
                                <i class="fas fa-search" style="color: white; cursor: pointer; padding: 5px; background: #48a74a;"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select_climat" style="color: black; font-weight: bold;">Climat</label> <!-- Couleur du label -->
                            <select id="select_climat" class="form-control" onchange="showClimatSelection(this)">
                                <option value="">Sélectionner</option>
                                @foreach(getClimats() as $climat)
                                    <option value="{{ $climat->climat_id }}">{{ $climat->libelleClimat }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="select_sol" style="color: black; font-weight: bold;">Sol</label> <!-- Couleur du label -->
                            <select id="select_sol" class="form-control" onchange="showSolSelection(this)">
                                <option value="">Sélectionner</option>
                                @foreach(getSols() as $sol)
                                    <option value="{{ $sol->sol_id }}">{{ $sol->solLibelle }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="select1" style="color: black; font-weight: bold;">Pays</label> <!-- Couleur du label -->
                            <select id="select1" class="form-control" data-next="select2" onchange="showSelection(this)">
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="select2" style="color: black; font-weight: bold;">Localités</label> <!-- Couleur du label -->
                            <select id="select2" class="form-control" data-next="select5" onchange="showSelection2(this)">
                                <option value="">Sélectionner</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="select5" style="color: black; font-weight: bold;">Pratiques</label> <!-- Couleur du label -->
                            <select id="select5" class="form-control" onchange="showLocalite(this)">
                                
                            </select>
                        </div>
                        <button onclick="location.reload();" style="background-color: rgba(129, 129, 129, 0.5); left: 0; position: absolute; bottom: 1px; border: none; color: white; padding: 5px 20px; font-size: 16px; cursor: pointer; width: 100%;">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
                    </div>

                    <!-- Colonne pour la carte, occupe 75% de la largeur avec un shadow -->
                    <div class="col-12 col-md-9">
                        <!-- Ajout d'une classe pour shadow -->
                        <div id="map" class="w-100" style=" border: 1px solid #ccc; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
       const rub = @json($rub);
       const srub = @json($srub);
    </script>
    <script src="{{ asset('js/carte.js') }}"></script>
    <script src="https://unpkg.com/leaflet-fullscreen@2.1.0/dist/leaflet.fullscreen.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/HeFVQ5ILQklc8x2M5ev5PeZj29GxD+9u/oP0e" crossorigin="anonymous"></script>
@endpush
