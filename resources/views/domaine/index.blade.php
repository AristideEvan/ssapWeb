@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">

    <div class="main-card card">
    <div class="card-header py-0 d-flex align-items-center justify-content-between">
        <h4 class="mb-0">{{ __('Liste des domaines') }}</h4>
        <div class="ml-auto">
            @php echo $controler->newFormButton($rub,$srub,'domaine.create'); @endphp
        </div>
    </div>
        <!-- Sélecteur de thème collé à gauche -->
        <div class="row mx-2 my-1 px-2">
            <div class="col-md-5">
                <label for="themeFilter" class="form-label">
                    {{ __('Thèmes') }} 
                </label>
                <select id="themeFilter" class="form-control" onchange="filterDomains(this)">
                    <option value="">{{ __('Tous Les Thèmes') }}</option>
                    @foreach ($themes as $theme)
                        <option value="{{ $theme->theme_id }}">
                        {{ mb_convert_case(mb_strtolower($theme->themeLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table id="domainTable" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th>{{ __('Domaine') }}</th>
                        @php echo $controler->crudheader($rub,$srub); @endphp
                    </tr>
                </thead>
                <tbody>
                    @foreach($domaines as $item)
                        <tr data-themes="{{ json_encode($item->themes->pluck('theme_id')->toArray()) }}">
                            <td>{{ mb_convert_case(mb_strtolower($item->domaineLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8') }}</td>
                            @php 
                                $route = 'route'; 
                                echo $controler->crudbody($rub,$srub,$route,'domaine.edit','domaine.destroy',$item->domaine_id); 
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script de filtrage -->
@endsection
@push('scripts')
<script>
   function filterDomains(select) {
        let selectedTheme = select.value;
        // Récupère toutes les lignes du tableau
        let rows = document.querySelectorAll('#domainTable tbody tr');
        // Filtre les lignes en fonction du thème sélectionné
        rows.forEach(row => {
            let themes = JSON.parse(row.getAttribute('data-themes'));
            if (selectedTheme === "" || themes.includes(parseInt(selectedTheme))) {
                row.style.display = ""; // Affiche la ligne
            } else {
                row.style.display = "none"; // Cache la ligne
            }
        });
    }
</script>
@endpush