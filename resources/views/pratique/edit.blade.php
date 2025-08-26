@extends('layouts.template')
@vite(['resources/js/xlab.js'])
@section('content')
    <style>
        .img-fluid {
            height: auto !important;
        }

        .removeZone:first {
            display: none;
        }

        .zone-container,
        .zonep-container {
            margin-top: 10px;
            padding: 5px;
            border: 2px dashed #ccc !important;
            border-radius: 5px;
        }

        .btn-primary-custom {
            background-color: #060 !important;
            border-color: #060 !important;
            color: #fff !important;
        }

        .btn-primary-custom:hover {
            background-color: #045;
            border-color: #034;
        }

        .btn-primary-custom:active {
            background-color: #034;
            border-color: #023;
        }
    </style>
    <div class="row justify-content-center" style="max-width: 100%">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter Pratiques') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST"
                        action="{{ route('pratique.update', $pratique->pratique_id) }}" enctype="multipart/form-data"
                        id="form-pratique">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset>
                                    <legend>{{ __('Informations générales') }}</legend>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label for="pratiqueLibelle"> {{ __('Titre de la pratique') }} <span
                                                    style="color: red">*</span> </label>
                                            <input class="form-control @error('pratiqueLibelle') is-invalid @enderror"
                                                type="text" name="pratiqueLibelle" id="pratiqueLibelle" required
                                                value="{{ old('pratiqueLibelle', $pratique->pratiqueLibelle) }}">
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('pratiqueLibelle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-5">
                                            <label for="theme"> {{ __('Thèmes') }} <span style="color: red">*</span>
                                            </label>
                                            <select id="theme" class="form-control @error('theme') is-invalid @enderror"
                                                name="theme[]" multiple required>
                                                <option value=""></option>
                                                @foreach ($themes as $theme)
                                                    <option value="{{ $theme->theme_id }}"
                                                        {{ in_array($theme->theme_id, old('theme', optional($pratique)->themes ? $pratique->themes->pluck('theme_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $theme->themeLibelle }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('theme')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="objectif"> {{ __('Objectif') }} <span style="color: red">*</span>
                                            </label>
                                            <textarea class="form-control @error('objectif') is-invalid @enderror" type="text" name="objectif" id="objectif"
                                                required>{{ old('objectif', $pratique->objectif) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('objectif')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="description"> {{ __('Description') }} <span
                                                    style="color: red">*</span> </label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" type="text" name="description"
                                                id="description" required>{{ old('description', $pratique->description) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            {{-- <div class="row">
                                                <div class="col-md-12">
                                                    <label for="periodeDebut"> {{ __('Période de début') }} <span
                                                            style="color: red">*</span> </label>
                                                    <input
                                                        class="form-control calendrier @error('periodeDebut') is-invalid @enderror"
                                                        type="text" name="periodeDebut" id="periodeDebut" required
                                                        value="{{ old('periodeDebut', integerToDate($pratique->periodeDebut)) }}">
                                                    <div class="invalid-feedback">
                                                        {{ __('formulaire.Obligation') }}
                                                    </div>
                                                    @error('periodeDebut')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="periodeFin"> {{ __('Période de fin') }} <span
                                                            style="color: red">*</span> </label>
                                                    <input
                                                        class="form-control calendrier @error('periodeFin') is-invalid @enderror"
                                                        type="text" name="periodeFin" id="periodeFin" required
                                                        value="{{ old('periodeFin', integerToDate($pratique->periodeFin)) }}">
                                                    <div class="invalid-feedback">
                                                        {{ __('formulaire.Obligation') }}
                                                    </div>
                                                    @error('periodeFin')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <label for="periode"> {{ __('Période de mise en œuvre') }} <span
                                                        style="color: red">*</span>
                                                </label>
                                                <textarea class="form-control @error('periode') is-invalid @enderror" type="text" name="periode" id="periode"
                                                    required>{{ old('periode', $pratique->periode) }}</textarea>
                                                <div class="invalid-feedback">
                                                    {{ __('formulaire.Obligation') }}
                                                </div>
                                                @error('periode')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <label for="avantage"> {{ __('Résultats obtenus') }} <span
                                                    style="color: red">*</span>
                                            </label>
                                            <textarea class="form-control @error('avantage') is-invalid @enderror" type="text" name="avantage" id="avantage"
                                                required>{{ old('avantage', $pratique->avantage) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('avantage')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contrainte"> {{ __('Contraintes/Difficultés rencontrées') }} <span
                                                    style="color: red">*</span> </label>
                                            <textarea class="form-control @error('contrainte') is-invalid @enderror" type="text" name="contrainte"
                                                id="contrainte" required>{{ old('contrainte', $pratique->contrainte) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('contrainte')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="cout"> {{ __('Coût de mise en oeuvre') }} <span
                                                    style="color: red">*</span>
                                            </label>
                                            <input class="form-control  @error('cout') is-invalid @enderror" type="number"
                                                step="100000" min="0" name="cout" id="cout" required
                                                value="{{ old('cout', $pratique->cout) }}">
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('cout')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="conseil"> {{ __('Conseils') }} <span style="color: red">*</span>
                                            </label>
                                            <textarea class="form-control @error('conseil') is-invalid @enderror" type="text" name="conseil" id="conseil"
                                                required>{{ old('conseil', $pratique->conseil) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('conseil')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                        <div class="col-md-4">
                                            <label for="mesure"> {{ __('Types d’accompagnement') }} <span
                                                    style="color: red">*</span> </label>
                                            <textarea class="form-control @error('mesure') is-invalid @enderror" type="text" name="mesure" id="mesure"
                                                required>{{ old('mesure', $pratique->mesure) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('mesure')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="description_env_humain">{{ __('Partenariats') }}
                                                <span style="color: red">*</span> </label>
                                            <textarea class="form-control  @error('cout') is-invalid @enderror" type="text" name="description_env_humain"
                                                id="description_env_humain" required>{{ old('description_env_humain', $pratique->description_env_humain) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('description_env_humain')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="recommandation"> {{ __('Leçons tirées') }} <span
                                                    style="color: red">*</span> </label>
                                            <textarea class="form-control @error('recommandation') is-invalid @enderror" type="text" name="recommandation"
                                                id="recommandation" required>{{ old('recommandation', $pratique->recommandation) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('recommandation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <label for="defis"> {{ __('Défis de mise en ouvre') }} <span
                                                    style="color: red">*</span> </label>
                                            <textarea class="form-control @error('defis') is-invalid @enderror" type="text" name="defis" id="defis"
                                                required>{{ old('defis', $pratique->defis) }}</textarea>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('defis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <fieldset class="mt-3">
                                    <legend>I{{ __('Informations spécifiques') }} </legend>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="climat"> {{ __('Climat') }} <span style="color: red">*</span>
                                            </label>
                                            <select id="climat"
                                                class="form-control @error('climat') is-invalid @enderror"
                                                name="climat[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($climats as $climat)
                                                    <option value="{{ $climat->climat_id }}"
                                                        {{ in_array($climat->climat_id, old('climat', optional($pratique)->climats ? $pratique->climats->pluck('climat_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $climat->libelleClimat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('climat.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="sol"> {{ __('Sol') }} <span style="color: red">*</span>
                                            </label>
                                            <select id="sol"
                                                class="form-control @error('sol') is-invalid @enderror" name="sol[]"
                                                multiple autofocus>
                                                <option value=""></option>

                                                @foreach ($sols as $sol)
                                                    <option value="{{ $sol->sol_id }}"
                                                        {{ in_array($sol->sol_id, old('sol', optional($pratique)->sols ? $pratique->sols->pluck('sol_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $sol->solLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('sol.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="domaine"> {{ __('Domaines') }}
                                            </label>
                                            <select id="domaine"
                                                class="form-control @error('domaine') is-invalid @enderror"
                                                name="domaine[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($domaines as $domaine)
                                                    <option value="{{ $domaine->domaine_id }}"
                                                        {{ in_array($domaine->domaine_id, old('domaine', optional($pratique)->domaines ? $pratique->domaines->pluck('domaine_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $domaine->domaineLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('domaine.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="pilier"> {{ __('Piliers') }}
                                            </label>
                                            <select id="pilier"
                                                class="form-control @error('pilier') is-invalid @enderror"
                                                name="pilier[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($piliers as $pilier)
                                                    <option value="{{ $pilier->pilier_id }}"
                                                        {{ in_array($pilier->pilier_id, old('pilier', optional($pratique)->piliers ? $pratique->piliers->pluck('pilier_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $pilier->pilierLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('pilier.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="typeChoc"> {{ __('Types de chocs') }} <span
                                                    style="color: red">*</span>
                                            </label>
                                            <select id="typeChoc"
                                                class="form-control @error('typeChoc') is-invalid @enderror"
                                                name="typeChoc[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($typeChocs as $typeChoc)
                                                    <option value="{{ $typeChoc->typeChoc_id }}"
                                                        {{ in_array($typeChoc->typeChoc_id, old('typeChoc', optional($pratique)->typesChocs ? $pratique->typesChocs->pluck('typeChoc_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $typeChoc->typeChocLibelle }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('typeChoc.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="typeReponse"> {{ __('Types de réponse') }}
                                            </label>
                                            <select id="typeReponse"
                                                class="form-control @error('typeReponse') is-invalid @enderror"
                                                name="typeReponse[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($typeReponses as $typeReponse)
                                                    <option value="{{ $typeReponse->typeReponse_id }}"
                                                        {{ in_array($typeReponse->typeReponse_id, old('typeReponse', optional($pratique)->reponses ? $pratique->reponses->pluck('typeReponse_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $typeReponse->typeReponseLibelle }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('typeReponse.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="secteurActivite"> {{ __('Secteurs d\'activité') }}</label>
                                            <select id="secteurActivite"
                                                class="form-control @error('secteurActivite') is-invalid @enderror"
                                                name="secteurActivite[]" multiple autofocus>
                                                <option value=""></option>
                                                @foreach ($secteurs as $secteurActivite)
                                                    <option value="{{ $secteurActivite->secteurActivite_id }}"
                                                        {{ in_array($secteurActivite->secteurActivite_id, old('secteurActivite', optional($pratique)->secteurs ? $pratique->secteurs->pluck('secteurActivite_id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $secteurActivite->secteurActiviteLibelle }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('formulaire.Obligation') }}
                                            </div>
                                            @error('secteurActivite.*')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div>
                            <fieldset>
                                <legend>{{ __('Acteurs') }}</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="partenaire"> {{ __('Partenaires') }}</label>
                                        <select id="partenaire"
                                            class="form-control @error('partenaire') is-invalid @enderror"
                                            name="partenaire[]" multiple autofocus>
                                            <option value=""></option>
                                            @foreach ($partenaires as $partenaire)
                                                <option value="{{ $partenaire->partenaire_id }}"
                                                    {{ in_array($partenaire->partenaire_id, old('partenaire', optional($pratique)->partenaires ? $pratique->partenaires->pluck('partenaire_id')->toArray() : [])) ? 'selected' : '' }}>
                                                    {{ $partenaire->nomPartenaire }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ __('formulaire.Obligation') }}
                                        </div>
                                        @error('partenaire.*')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="beneficiaire"> {{ __('Bénéficiaires') }}</label>
                                        <select id="beneficiaire"
                                            class="form-control @error('beneficiaire') is-invalid @enderror"
                                            name="beneficiaire[]" multiple autofocus>
                                            <option value=""></option>
                                            @foreach ($beneficiaires as $beneficiaire)
                                                <option value="{{ $beneficiaire->beneficiaire_id }}"
                                                    {{ in_array($beneficiaire->beneficiaire_id, old('beneficiaire', optional($pratique)->beneficiaires ? $pratique->beneficiaires->pluck('beneficiaire_id')->toArray() : [])) ? 'selected' : '' }}>
                                                    {{ $beneficiaire->beneficiaireLibelle }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{ __('formulaire.Obligation') }}
                                        </div>
                                        @error('beneficiaire.*')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div>
                            <fieldset class="mt-3">
                                <legend>{{ __('Zones d\'application') }}</legend>
                                <div id="zones-container">
                                    @php
                                        $zones = $pratique->zonesActuelles;
                                    @endphp
                                    @foreach ($zones as $zone)
                                        @php
                                            $result = DB::select(
                                                'SELECT "p0" as localite_id, "nomLocalite" FROM "listeLocalite" WHERE "localite_id" = ?',
                                                [$zone->localite_id],
                                            );
                                            $parent = $result[0];
                                            $enfants = DB::select(
                                                'SELECT "localite_id", "nomLocalite" FROM "listeLocalite" WHERE "p0" = ?',
                                                [$parent->localite_id],
                                            );
                                        @endphp
                                        @if (!session('zoneActuellesForm'))
                                            <div class="zone-container">
                                                <div class="row">
                                                    <div class="col-12 col-md-6">
                                                        <label for="pays{{ $loop->iteration }}">{{ __('Pays') }}
                                                            <span style="color: red">*</span>

                                                        </label>

                                                        <span title="{{ __('Supprimer') }}"
                                                            class="fa fa-trash text-danger float-right d-md-none removeZone"
                                                            style="cursor: pointer;"></span>

                                                        <select name="zones[{{ $loop->iteration }}][pays]"
                                                            id="pays{{ $loop->iteration }}" class="form-control pays">
                                                            <option value="">{{ __('Sélectionnez une localité') }}
                                                            </option>
                                                            @foreach ($pays as $item)
                                                                <option value="{{ $item->localite_id }}"
                                                                    {{ $item->localite_id == $parent->localite_id ? 'selected' : '' }}>
                                                                    {{ $item->nomLocalite }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-12 col-md-6">
                                                        <label
                                                            for="localite{{ $loop->iteration }}">{{ __('Localité') }}</label>
                                                        <span title="{{ __('Supprimer') }}"
                                                            class="fa fa-trash text-danger float-right d-none d-md-inline removeZone"
                                                            style="cursor: pointer;"></span>
                                                        <select name="zones[{{ $loop->iteration }}][localite]"
                                                            id="longitude{{ $loop->iteration }}" class="localite">
                                                            @foreach ($enfants as $enfant)
                                                                <option value="{{ $enfant->localite_id }}"
                                                                    {{ $enfant->localite_id == $zone->localite_id ? 'selected' : '' }}>
                                                                    {{ $enfant->nomLocalite }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="latitude{{ $loop->iteration }}">
                                                            {{ __('latitude') }}</label>
                                                        <input type="text"
                                                            name="zones[{{ $loop->iteration }}][latitude]"
                                                            class="form-control coordinates latitude"
                                                            id="latitude{{ $loop->iteration }}"
                                                            value="{{ $zone->coordonnees['latitude'] }}"
                                                            pattern="^-?([1-8]?\d(\.\d+)?|90(\.0+)?)$"
                                                            placeholder="12.2418505">
                                                        @if ($errors->has("zones.{$loop->iteration}.latitude"))
                                                            <small
                                                                class="text-danger">{{ $errors->first("zones.{$loop->iteration}.latitude") }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="longitude{{ $loop->iteration }}">
                                                            {{ __('Longitude') }}</label>
                                                        <input type="text"
                                                            name="zones[{{ $loop->iteration }}][longitude]"
                                                            class="form-control coordinates longitude"
                                                            id="longitude{{ $loop->iteration }}"
                                                            value="{{ $zone->coordonnees['longitude'] }}"
                                                            pattern="^-?((1[0-7]\d|[1-9]?\d)(\.\d+)?|180(\.0+)?)$"
                                                            placeholder="-1.5567604999999958">
                                                        @if ($errors->has("zones.{$loop->iteration}.longitude"))
                                                            <small
                                                                class="text-danger">{{ $errors->first("zones.{$loop->iteration}.longitude") }}
                                                                - </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (session('zoneActuellesForm'))
                                        {!! session('zoneActuellesForm') !!}
                                    @endif
                                    {{-- Add more zones here --}}
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-right mr-2">
                                        <button class="btn btn-primary-custom border-0 mr-1" type="button"
                                            id="addZone" style="border-radius: 50%; width: 40px; height: 40px">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="mt-3">
                                <legend>{{ __('Zone d\'application potentielles') }}</legend>
                                <div class="zonesp-container" id="zonesp-container">
                                    @php
                                        $zonesp = $pratique->zonesPotentielles;
                                    @endphp
                                    @foreach ($zonesp as $potentielle)
                                        @php
                                            $result = DB::select(
                                                'SELECT "p0" as localite_id, "nomLocalite" FROM "listeLocalite" WHERE "localite_id" = ?',
                                                [$potentielle->localite_id],
                                            );
                                            $parent = $result[0];
                                            $enfants = DB::select(
                                                'SELECT "localite_id", "nomLocalite" FROM "listeLocalite" WHERE "p0" = ?',
                                                [$parent->localite_id],
                                            );
                                        @endphp
                                        @if (!session('zonePotentiellesForm'))
                                            <div class="zonep-container">
                                                <div class="row mt-3">
                                                    <div class="col-12 col-md-6">
                                                        <label for="paysp{{ $loop->iteration }}"> {{ __('Pays') }}
                                                        </label>
                                                        <select id="paysp{{ $loop->iteration }}"
                                                            class="form-control paysp @error('zonesp.{{ $loop->iteration }}.pays') is-invalid @enderror"
                                                            name="zonesp[{{ $loop->iteration }}][pays]">
                                                            @foreach ($pays as $item)
                                                                <option value="{{ $item->localite_id }}"
                                                                    {{ $item->localite_id == $parent->localite_id ? 'selected' : '' }}>
                                                                    {{ $item->nomLocalite }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            {{ __('formulaire.Obligation') }}
                                                        </div>
                                                        @error('zonep.{{ $loop->iteration }}pays')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <label for="localitep{{ $loop->iteration }}">
                                                            {{ __('Localité') }}
                                                        </label>
                                                        <span title="{{ __('Supprimer') }}"
                                                            class="fa fa-trash text-danger float-right removeZonep"
                                                            style="cursor: pointer;"></span>

                                                        <select id="localitep{{ $loop->iteration }}"
                                                            class="form-control localitep @error('zonesp.{{ $loop->iteration }}.localite') is-invalid @enderror"
                                                            name="zonesp[{{ $loop->iteration }}][localite]">
                                                            @foreach ($enfants as $enfant)
                                                                <option value="{{ $enfant->localite_id }}"
                                                                    {{ $enfant->localite_id == $potentielle->localite_id ? 'selected' : '' }}>
                                                                    {{ $enfant->nomLocalite }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            {{ __('formulaire.Obligation') }}
                                                        </div>
                                                        @error('zonep.{{ $loop->iteration }}localite')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if (session('zonePotentiellesForm'))
                                        {!! session('zonePotentiellesForm') !!}
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 text-right mr-2">
                                        <button class="btn btn-primary mr-1 btn-primary-custom" type="button"
                                            id="addZonep" style="border-radius: 50%; width: 40px; height: 40px">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div>
                            <fieldset class="mt-3">
                                <legend>{{ __('Fichiers') }}</legend>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="images-vedette">{{ __('Image vedette') }}</label>
                                            <span style="color: red">*</span>

                                            <div class="dropzone d-flex justify-content-center justify-content-md-left"
                                                id="vedetteDropzone">
                                            </div>
                                            @error('image_vedette')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="images">{{ __('Images') }}</label>
                                    <div class="dropzone d-flex justify-content-center justify-content-md-left flex-wrap"
                                        id="imageDropzone"></div>
                                    @error('images.*')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="documents">{{ __('Documents') }}</label>
                                    <span style="color: red">*</span>
                                    <div class="dropzone d-flex justify-content-center justify-content-md-left flex-wrap"
                                        id="documentDropzone"></div>
                                    @error('documents.*')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </fieldset>
                        </div>
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" name="rub" value=" {{ $rub }} ">
                                <input type="hidden" name="srub" value=" {{ $srub }} ">
                                <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                                    class="btn btn-primary btnEnregistrer" />
                                <a href="{{ route('pratique.index') }}/{{ $rub }}/{{ $srub }}"><input
                                        type="button" id="annuler" value={{ __('Annuler') }}
                                        class="btn btn-primary btnAnnuler" /></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
    @push('scripts')
        <script>
            $(document).ready(function() {
                var images = <?php echo json_encode($pratique->images ?? []); ?>;
                var vedette = <?php echo json_encode($pratique->vedette ?? []); ?>;
                console.log(vedette);
                var documents = <?php echo json_encode($pratique->documents ?? []); ?>;
                var localites = <?php echo json_encode($localites); ?>;
                xlab.DynamicZone();
                xlab.InputsTrim(); // trim input on blur
                xlab.InitDropZone2('#vedetteDropzone', {
                    inputName: 'image_vedette',
                    addHidden: true,
                    maxFiles: 1,
                    maxFilesize: 2,
                    dictRemoveFile: "Supprimer",
                    existingFiles: [vedette],
                    message: 'Glissez et deposez l\'image vedette ici <strong>(max 2Mo)</strong>'
                });

                xlab.InitDropZone2('#imageDropzone', {
                    inputName: 'images[]',
                    addHidden: true,
                    maxFilesize: 2,
                    dictRemoveFile: "Supprimer",
                    existingFiles: images,
                    message: 'Glissez et deposez les autres images ici <strong>(max 2Mo)</strong>'
                });

                xlab.InitDropZone2('#documentDropzone', {
                    inputName: 'documents[]',
                    addHidden: true,
                    maxFilesize: 2,
                    dictRemoveFile: "Supprimer",
                    existingFiles: documents,
                    acceptedFiles: '.pdf,.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.odt,.rtf,.zip',
                    message: 'Glissez et deposez les documents ici <strong>(max 2Mo)</strong>'
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                var pratique_id = "{{ $pratique->pratique_id }}";
                $('#theme').on('change', function() {
                    let selectedValues = $(this).val();

                    if (selectedValues.length > 0) {
                        $.ajax({
                            url: '{{ route('themes.domains') }}',
                            method: 'POST',
                            data: {
                                theme_ids: selectedValues,
                                pratique_id: pratique_id,
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                $('#domaine').html(response
                                    .html);
                            },
                            error: function(xhr, status, error) {
                                // console.error('Error:', error);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
