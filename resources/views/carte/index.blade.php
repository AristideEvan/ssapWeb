@extends('layouts.'.getTemplate($rub,$srub))

@section('styles')
<style>
    @media (max-width: 768px) {
    .filters-container {
        display: none; /* Cache les filtres */
    }

    .search-icon {
        display: block; /* Affiche l'icône de recherche */
        z-index: 10000;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            position: absolute;
            top: 60px;
            right: 30px;
    }

    .map-container {
        display: block !important; /* Affiche la carte sur toute la largeur */
    }

    .filters-container.active {
        display: block; /* Affiche les filtres lorsqu'on clique sur l'icône de recherche */
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
        <!-- Conteneur de chargement -->
        <div id="resultat" class="col-12  justify-content-center align-items-center" style="position: fixed; top: 0; left: 0; background: rgba(255, 255, 255, 0.8); z-index: 9999; height: 100vh; display: none;">
            <img src="/images/Preloader_110.gif" alt="Chargement..." style="object-fit: cover;" />
        </div>

        <!-- Conteneur principal -->
        <div class="row vh-100">
            <div class=" search-icon d-md-none text-center">
                <i class="fas fa-filter" id="icon2" style=" border-radius: 50%; background-color:rgb(142, 223, 143); cursor: pointer; padding: 10px; color: white;"></i>
            </div>
            <!-- Conteneur de gauche (25%) -->
            <div class="col-md-2 filters-container  text-white p-3" style="background-color: rgba(130, 130, 130, 0.5);">
            <div class="form-group">
                            <label for="searchInput" style="color: black; font-weight: bold;">Rechercher</label>
                            <div style="display: flex; align-items: center; border: 1px solid rgb(2, 78, 3); background-color:#48a74a;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Entrez votre recherche" style="border: none; flex: 1; background:rgba(241, 252, 252, 0.89); outline: none; color: black; caret-color: blue;">
                                <i class="fas fa-search" id="rechercherp" style="color: white; cursor: pointer; padding: 5px; background: #48a74a;"></i>
                            </div>
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
                            <label for="select_theme" style="color: black; font-weight: bold;">Thème</label> <!-- Couleur du label -->
                            <select id="select_theme" class="form-control" onchange="showthemeSelection(this)">
                                <option value="selected disabled">Sélectionner</option>
                                @foreach(getThemes() as $sol)
                                    <option value="{{ $sol->theme_id }}">{{ mb_convert_case(mb_strtolower($sol->themeLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select_domaine" style="color: black; font-weight: bold;">Domaine</label> <!-- Couleur du label -->
                            <select id="select_domaine" class="form-control" onchange="showdomaineSelection(this)">
                                <option value="selected disabled">Sélectionner</option>
                                @foreach(getdomaine() as $sol)
                                    <option value="{{ $sol->domaine_id }}">{{ mb_convert_case(mb_strtolower($sol->domaineLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select_climat" style="color: black; font-weight: bold;">Climat</label> <!-- Couleur du label -->
                            <select id="select_climat" class="form-control" onchange="showClimatSelection(this)">
                                <option value="selected disabled">Sélectionner</option>
                                @foreach(getClimats() as $climat)
                                    <option value="{{ $climat->climat_id }}">{{ $climat->libelleClimat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="select_sol" style="color: black; font-weight: bold;">Sol</label> <!-- Couleur du label -->
                            <select id="select_sol" class="form-control" onchange="showSolSelection(this)">
                                <option value="selected disabled">Sélectionner</option>
                                @foreach(getSols() as $sol)
                                    <option value="{{ $sol->sol_id }}">{{ $sol->solLibelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button onclick="location.reload();" class="btn btn-block" style="background-color: rgba(129, 129, 129, 0.5); left: 0; position: absolute; bottom: 1px; color: white;">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
            </div>
            <!-- Conteneur de droite (75%) -->
            <div class="col-md-10 bg-light d-flex flex-column map-container ">
                <div id="map" class="w-100 h-100" style="  height: 100vh; overflow: hidden;"></div>
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
@endpush
