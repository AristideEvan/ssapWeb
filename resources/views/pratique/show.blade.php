@extends('layouts.template')
@push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <style>
        @import "https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        :root {
            --primary-color: #060;
            --primary-color-2: #045;
        }

        body {
            font-size: 1rem;
        }

        p {
            line-height: 1.5;
        }

        .btn-primary-custom {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
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

        .img-preview img {
            width: 200px;
            height: 200px;
        }

        .document-icon {
            width: 15px;
            height: 15px;
        }

        .title {
            color: black
        }

        .card-header {
            color: black;
            font-size: 1rem !important;
        }

        h5 {
            margin-top: 25px;
        }

        #libelle,
        h5 {
            font-weight: bold;
        }

        .container p {
            text-align: justify;
            display: block;
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            unicode-bidi: isolate;
            line-height: 2;
        }

        .custom-control-input:checked~.custom-control-label::before {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .custom-control-input:focus~.custom-control-label::before {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        @keyframes dots {
            0% {
                content: ".";
            }

            33% {
                content: "..";
            }

            66% {
                content: "...";
            }

            100% {
                content: "";
            }
        }

        .dots::after {
            content: "";
            animation: dots 1.5s steps(1, end) infinite;
        }

    </style>
@endpush
@section('content')
    <p class="text-center" style="color: green; display: none" id="loading">
        {{ __('Modification en cours. Vous serai redirigé vers la liste des pratiques') }}<span class="dots"></span>
    </p>
    <br>
    @include('pratique.partials.publication')


    <div class="container">


        <h5 class="font-weight-bold text-primary">
            <i class="fas fa-list mr-2"></i>
            <span> {{ __('Informations spécifiiques') }}</span>
            <a class="d-inline ml-2"
                href="{{ route('pratique.section.edit', ['section' => 1, 'id' => $pratique->pratique_id, 'rub' => $rub, 'srub' => $srub]) }}">
                <span title="{{ __('Modifier') }}" class="fas fa-edit fa-xs"
                    style="color:#060; cursor: pointer; size: 10px;"></span>
            </a>
        </h5>

        <hr>
        <section id="libelle" class="mb-5">
            <p class="text-uppercase">{{ __($pratique->pratiqueLibelle) }}</p>
            <h5>{{ __('Thèmes') }}</h5>
            <ul @class(['list-unstyled' => $pratique->themes->count() <= 1])>
                @foreach ($pratique->themes as $theme)
                    <li class="badge badge-primary">{{ $theme->themeLibelle }}</li>
                @endforeach
            </ul>
        </section>
        <section id="periode">
            <h5>{{ __('Période de mise en œuvre') }}</h5>
        </section>

        <section id="cout">
            <h5>{{ __('Coût') }}</h5>
            <p>{{ __($pratique->cout) }}</p>
        </section>

        <section id="objectif">
            <h5>{{ __('Objectif') }}</h5>
            <p>{{ __($pratique->objectif) }}</p>
        </section>
        <section id="description">
            <h5>{{ __('Description') }}</h5>
            <p> {{ __($pratique->description) }} </p>
        </section>
        <section id="avantages">
            <h5>{{ __('Résultats obtenus') }}</h5>
            <p>{{ __($pratique->avantage) }}</p>
        </section>
        <section id="contraintes">
            <h5>{{ __('Contraintes/Difficultés rencontrées') }}</h5>
            <p>{{ __($pratique->contrainte) }}</p>
        </section>
        
        <section id="mesures">
            <h5>{{ __('Types d’accompagnement') }}</h5>
            <p>{{ __($pratique->mesure) }}</p>
        </section>
        <section id="recommandation">
            <h5>{{ __('Leçons tirées') }}</h5>
            <p>{{ __($pratique->recommandation) }}</p>
        </section>

        <section id="description_env_humain">
            <h5>{{ __('Partenariats') }}</h5>
            <p>{{ __($pratique->description_env_humain) }}</p>
        </section>

        <h5 class="font-weight-bold text-primary">
            <i class="fas fa-info-circle mr-2"></i>
            <span> {{ __('Informations complementaires') }} </span>
            <a class="d-inline ml-2"
                href="{{ route('pratique.section.edit', ['section' => 2, 'id' => $pratique->pratique_id, 'rub' => $rub, 'srub' => $srub]) }}">
                <span title="{{ __('Modifier') }}" class="fas fa-edit fa-xs"
                    style="color:#060; cursor: pointer; size: 10px;"></span>
            </a>
        </h5>
        <hr>
        <section id="complementaires">
            <h5>{{ __('Domaines') }}</h5>
            <p>
            <ul @class(['list-unstyled' => $pratique->domaines->count() <= 1])>
                @foreach ($pratique->domaines as $domaine)
                    <li>{{ $domaine->domaineLibelle }}</li>
                @endforeach
            </ul>

            </p>
        </section>
        <section id="piliers">
            <h5>{{ __('Piliers') }}</h5>
            <p>
            <ul @class(['list-unstyled' => $pratique->piliers->count() <= 1])>
                @foreach ($pratique->piliers as $pilier)
                    <li>{{ $pilier->pilierLibelle }}</li>
                @endforeach
            </ul>

            </p>
        </section>
        <section id="type-chocs">
            <h5>{{ __('Types de chocs') }}</h5>
            <p>
            <p>
            <ul @class(['list-unstyled' => $pratique->typesChocs->count() <= 1])>
                @foreach ($pratique->typesChocs as $typeChoc)
                    <li>{{ $typeChoc->typeChocLibelle }}</li>
                @endforeach
            </ul>

            </p>

            </p>
        </section>
        <section id="type-reponses">
            <h5>{{ __('Types de reponses') }}</h5>
            <p>
            <ul @class(['list-unstyled' => $pratique->reponses->count() <= 1])>
                @foreach ($pratique->reponses as $typeReponse)
                    <li>{{ $typeReponse->typeReponseLibelle }}</li>
                @endforeach
            </ul>

            </p>

        </section>
        <section id="sol-climat">
            <h5>{{ __('Sols') }}</h5>
            <ul @class(['list-unstyled' => $pratique->sols->count() <= 1])>
                @foreach ($pratique->sols as $sol)
                    <li>{{ $sol->solLibelle }}</li>
                @endforeach
            </ul>
            <h5>{{ __('Climats') }}</h5>
            <ul @class(['list-unstyled' => $pratique->climats->count() <= 1])>
                @foreach ($pratique->climats as $climat)
                    <li>{{ $climat->libelleClimat }}</li>
                @endforeach
            </ul>
        </section>
        <h5 class="font-weight-bold text-primary">
            <i class="fas fa-users mr-2"></i>
            <span> {{ __('Acteurs') }}</span>
            <a class="d-inline ml-2"
                href="{{ route('pratique.section.edit', ['section' => 5, 'id' => $pratique->pratique_id, 'rub' => $rub, 'srub' => $srub]) }}">
                <span title="{{ __('Modifier') }}" class="fas fa-edit fa-xs"
                    style="color:#060; cursor: pointer; size: 10px;"></span>
            </a>
        </h5>
        <section id="partenaires">
            <h5>{{ __('Partenaires') }}</h5>
            <p>
            <ul @class(['list-unstyled' => $pratique->partenaires->count() <= 1])>
                @foreach ($pratique->partenaires as $partenaire)
                    <li>{{ $partenaire->nomPartenaire }}</li>
                @endforeach
            </ul>

            </p>
        </section>
        <section id="beneficiaires">
            <h5>{{ __('Beneficiaires') }}</h5>
            <p>
            <ul @class(['list-unstyled' => $pratique->beneficiaires->count() <= 1])>
                @foreach ($pratique->beneficiaires as $beneficiaire)
                    <li>{{ $beneficiaire->beneficiaireLibelle }}</li>
                @endforeach
            </ul>

            </p>
        </section>
        <h5 class="font-weight-bold text-primary">
            <i class="fas fa-map-marker-alt mr-2"></i>
            <span> {{ __('Zones') }} </span>
            <a class="d-inline ml-2"
                href="{{ route('pratique.section.edit', ['section' => 3, 'id' => $pratique->pratique_id, 'rub' => $rub, 'srub' => $srub]) }}">
                <span title="{{ __('Modifier') }}" class="fas fa-edit fa-xs"
                    style="color:#060; cursor: pointer; size: 10px;"></span>
            </a>
        </h5>
        <hr>
        <section id="zones-application">
            <h5>{{ __('Zones d\'application') }}</h5>
            <p>
            <div id="zones-container">
                <ul @class(['list-unstyled' => $pratique->zonesActuelles->count() <= 1])>

                    @foreach ($pratique->zonesActuelles as $zone)
                        <li class="localite">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <span class="localite"
                                        id="localite{{ $loop->iteration }}">{{ getLocalites($zone->localite_id) }}</span>
                                </div>
                                @if ($zone->coordonnees['latitude'] && $zone->coordonnees['longitude'])
                                    <div class="col-12 col-md-3">
                                        <span class="label">{{ __('Latitude') }}</span> :
                                        {{ $zone->coordonnees['latitude'] }}</span>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <span class="label">{{ __('Longitude') }}</span> :
                                        {{ $zone->coordonnees['longitude'] }}
                                    </div>
                                @endif

                            </div>

                        </li>
                    @endforeach
                </ul>
            </div>

            </p>
        </section>
        <hr>
        <section id="zones-pentielle">
            <h5>{{ __('Zone d\'application potentielle') }}</h5>
            <p>
            <div class="zonesp-container" id="zonesp-container">
                <ul @class([
                    'list-unstyled' => $pratique->zonesPotentielles->count() <= 1,
                ])>
                    @foreach ($pratique->zonesPotentielles as $potentielle)
                        <li class="localitep">
                            {{ getLocalites($potentielle->localite_id) }}
                        </li>
                    @endforeach
                </ul>
            </div>

            </p>
        </section>
        <section id="fichiers">
            <h5>{{ __('Fichiers') }}</h5>
            <!-- Fichiers Section -->
            <h5 class="font-weight-bold text-primary">
                <i class="fas fa-file-alt mr-2"></i>
                <span>{{ __('Fichiers') }}</span>
                <a class="d-inline ml-2"
                    href="{{ route('pratique.section.edit', ['section' => 4, 'id' => $pratique->pratique_id, 'rub' => $rub, 'srub' => $srub]) }}">
                    <span title="{{ __('Modifier') }}" class="fas fa-edit fa-xs"
                        style="color:#060; cursor: pointer; size: 10px;"></span>
                </a>
            </h5>
            <hr>
            @if ($pratique->images()->count() > 1 || $pratique->documents()->count() > 0)
                <div class="mt-3 p-3 pb-5">
                    <h5 class="mb-3 text-info" style="font-size: 12px;">{{ __('Images') }}</h5>
                    @if ($pratique->images()->count() > 0)
                        <div id="images-container" class="d-flex justify-content-start flex-wrap gap-3">
                            @foreach ($pratique->images as $image)
                                <div class="img-preview text-center">
                                    <img class="img-thumbnail d-block" src="{{ asset('storage/' . $image->path) }}"
                                        alt="Image Preview" />
                                    <a class="btn btn-link mt-2" href="{{ asset('storage/' . $image->path) }}"
                                        style="position: relative; top: -100px">
                                        <i title="{{ __('Voir') }}" class="fas fa-eye text-white"
                                            style="cursor: pointer"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>{{ __('Aucune image disponible') }}</p>
                    @endif
                    <h5 class="mt-5 mb-3 text-info" style="font-size: 12px;">{{ __('Documents') }}</h5>
                    @if ($pratique->documents()->count() > 0)
                        <div id="documents-container" class="d-flex flex-wrap gap-3">
                            @foreach ($pratique->documents as $document)
                                <div class="doc-preview text-center">
                                    <img class="document-icon" src="{{ $document->url }}" alt="" />
                                    <a class="btn btn-link" href="{{ asset('storage/' . $document->path) }}"
                                        download="{{ $document->nom }}">
                                        {{ $document->nom }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>{{ 'Aucun document disponible' }}</p>
                    @endif
                </div>
            @else
                <p>{{ __('Aucun fichier disponible') }}</p>
            @endif


    </div>
    </div>
    @push('scripts')
        @vite(['resources/js/xlab.js'])
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const rub = <?php echo $rub; ?>;
                const srub = <?php echo $srub; ?>;
                const switchElement = document.getElementById('switchElement');
                switchElement.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isChecked = switchElement.checked;
                    var requestBody = {};
                    if (isChecked) {
                        requestBody = {
                            new_values: [switchElement.value],
                            action: "publique",
                            returnHtml: false
                        };
                    } else {
                        requestBody = {
                            unselected_values: [switchElement.value],
                            action: "publique",
                            returnHtml: false
                        };
                    }
                    const container = document.getElementById('pratique-container');
                    const message = "Modification en cours";
                    const errorMessage = 'Une erreur s\'est produite lors de la publication.';
                    fetch(`/update-pratiques/${rub}/${srub}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: JSON.stringify(requestBody),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.success) {
                                switchElement.checked = !!data.publique;
                                document.querySelector('#loading').style.display = 'block';
                                setTimeout(() => {
                                    window.location.href = `/pratique/${rub}/${srub}`;
                                }, 3000); // 3000 millisecondes = 3 secondes
                            }
                        })
                        .catch(error => {
                            console.log('error message', error);
                        });
                });

                // scroll the section
                let sectionId = "{{ $section_id ?? '' }}";
                if (sectionId) {
                    let section = document.getElementById(sectionId);
                    console.log('scrolling to section');
                    if (section) {
                        console.log('scrolling to section');
                        section.scrollIntoView({
                            behavior: "smooth"
                        });
                    }
                }
            });
        </script>
    @endpush
@endsection
