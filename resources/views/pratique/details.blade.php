@extends('layouts.front')

<style>
    :root {
        --primary: #007646;
        --secondary: #FD7E14;
        --light-gray: #f8f9fa;
        --medium-gray: #eaecf0;
        --dark-gray: #54595d;
        --text-color: #202122;
    }

    body {
        font-family: 'Helvetica', 'Arial', sans-serif;
        color: var(--text-color);
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background-color: var(--light-gray);
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: normal;
        margin: 0;
        padding: 0;
        color: var(--text-color);
    }

    /* Content Layout */
    .content {
        display: flex;
        flex-wrap: wrap;
    }

    .main-content {
        flex: 1;
        min-width: 0;
        padding: 0 20px 20px 0;
    }

    .sidebar {
        width: 300px;
        padding: 0 0 20px 20px;
    }

    /* Infobox (Wikipedia-style) */
    .infobox {
        border: 1px solid var(--medium-gray);
        background-color: var(--light-gray);
        padding: 15px;
        margin-bottom: 20px;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .infobox-title {
        background-color: var(--primary);
        color: white;
        padding: 8px 12px;
        margin: -15px -15px 15px -15px;
        font-size: 1.1rem;
        text-align: center;
    }

    .infobox-image {
        text-align: center;
        margin-bottom: 10px;
    }

    .infobox-image img {
        max-width: 100%;
        height: auto;
    }

    .infobox-data {
        margin-bottom: 8px;
    }

    .infobox-label {
        font-weight: bold;
        color: var(--dark-gray);
    }

    /* Section Styles */
    .section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: normal;
        border-bottom: 1px solid var(--medium-gray);
        padding-bottom: 5px;
        margin-bottom: 15px;
    }

    /* Table of Contents */
    .toc {
        display: table;
        background-color: var(--light-gray);
        border: 1px solid var(--medium-gray);
        padding: 15px;
        margin: 15px 0;
        font-size: 0.9rem;
    }

    .toc-title {
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    .toc ul {
        list-style-type: none;
        padding-left: 0;
        margin: 0;
    }

    .toc li {
        margin-bottom: 5px;
    }

    /* Images and Media */
    .thumb {
        float: right;
        clear: right;
        margin: 0 0 15px 15px;
        background: white;
        padding: 5px;
        border: 1px solid var(--medium-gray);
    }

    .thumb img {
        display: block;
    }

    .thumbcaption {
        font-size: 0.8rem;
        line-height: 1.4;
        padding: 5px 0;
    }

    /* Featured Image */
    .featured-image {
        width: 100%;
        margin-bottom: 20px;
        text-align: center;
    }

    .featured-image img {
        max-width: 100%;
        height: auto;
        border: 1px solid var(--medium-gray);
    }

    .featured-image-caption {
        font-size: 0.9rem;
        margin-top: 5px;
        color: var(--dark-gray);
    }

    /* Gallery Styles */
    .gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin: 20px 0;
    }

    .gallery-item {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-item img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border: 1px solid var(--medium-gray);
    }

    .view-more {
        text-align: center;
        margin: 15px 0;
    }

    /* Lightbox Styles */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .lightbox-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
    }

    .lightbox-img {
        max-width: 100%;
        max-height: 80vh;
    }

    .lightbox-caption {
        color: white;
        text-align: center;
        margin-top: 10px;
    }

    .lightbox-close,
    .lightbox-prev,
    .lightbox-next {
        position: absolute;
        color: white;
        font-size: 2rem;
        cursor: pointer;
    }

    .lightbox-close {
        top: -40px;
        right: 0;
    }

    .lightbox-prev {
        left: -50px;
        top: 50%;
    }

    .lightbox-next {
        right: -50px;
        top: 50%;
    }

    /* References Section */
    .references {
        font-size: 0.9rem;
        padding-top: 20px;
        margin-top: 30px;
    }

    .references ol {
        padding-left: 20px;
    }

    .references li {
        margin-bottom: 10px;
    }

    /* Responsive Adjustments */
    @media (max-width: 900px) {
        .content {
            flex-direction: column;
        }

        .main-content {
            padding-right: 0;
        }

        .sidebar {
            width: 100%;
            padding-left: 0;
        }

        .thumb {
            float: none;
            margin: 0 auto 15px auto;
            display: table;
        }

        .lightbox-prev {
            left: 10px;
        }

        .lightbox-next {
            right: 10px;
        }
    }

    /* Special Elements */
    .badge {
        display: inline-block;
        padding: 2px 8px;
        background-color: var(--medium-gray);
        border-radius: 3px;
        font-size: 0.8rem;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .primary-badge {
        background-color: var(--primary);
        color: white;
    }

    .secondary-badge {
        background-color: var(--secondary);
        color: white;
    }

    /* Hidden images */
    .hidden-images {
        display: none;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 10px;
        margin: 20px 0;
    }

    .show-more-btn {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .show-more-btn:hover {
        background-color: #006238;
    }

    @media (min-width: 768px) {
        .page-title {
            margin-left: 110px !important;
        }
    }
</style>

@section('content')
    <div class="container">
        <!-- Page Header -->
        <header class="page-header mt-4 ml-lg-5">
            <h1 class="page-title my-3 ml-lg-5px">{{ __($pratique->pratiqueLibelle) }}</h1>
        </header>

        <!-- Content Area -->
        <div class="content">
            <!-- Main Content -->
            <main class="main-content">
                <!-- Featured Image -->
                @if ($pratique->images->count() > 0)
                    <div class="featured-image">
                        <img loading="lazy" src="{{ asset('storage/' . $pratique->vedette_path) }}"
                            alt="Image vedette - {{ $pratique->pratiqueLibelle }}">
                        <div class="featured-image-caption">Image vedette : {{ $pratique->pratiqueLibelle }}</div>
                    </div>
                @endif

                <!-- Table of Contents -->
                <div class="toc">
                    <div class="toc-title">Sommaire</div>
                    <ul>
                        <li><a href="#objectif">1. Objectif</a></li>
                        <li><a href="#description">2. Description</a></li>
                        <li><a href="#periode">3. Période de mise en œuvre</a></li>
                        <li><a href="#avantages">4. Résultats obtenus</a></li>
                        <li><a href="#contraintes">5. Contraintes/Difficultés rencontrées</a></li>
                        <li><a href="#cout">6. Coût de mise en oeuvre</a></li>
                        <li><a href="#mesures">7. Types d'accompagnement</a></li>
                        <li><a href="#recommandation">8. Leçons tirées</a></li>
                        <li><a href="#partenaires">9. Partenariats</a></li>
                        <li><a href="#zones-application">10. Zones d'application</a></li>
                        <li><a href="#zones-pentielle">11. Zone d'application potentielle</a></li>
                        <li><a href="#galerie">12. Galerie</a></li>
                        <li><a href="#documents">13. Documents</a></li>
                    </ul>
                </div>

                <!-- Objective Section -->
                <section id="objectif" class="section">
                    <h2 class="section-title">Objectif</h2>
                    <p>{{ __($pratique->objectif) }}</p>
                </section>

                <!-- Description Section -->
                <section id="description" class="section">
                    <h2 class="section-title">Description</h2>
                    <p>{{ __($pratique->description) }}</p>
                </section>

                <!-- Period Section -->
                <section id="periode" class="section">
                    <h2 class="section-title">Période de mise en œuvre</h2>
                    <p>{{ __($pratique->periode) ?? 'Non spécifiée' }}</p>
                </section>

                <!-- Advantages Section -->
                <section id="avantages" class="section">
                    <h2 class="section-title">Résultats obtenus</h2>
                    <p>{{ __($pratique->avantage) }}</p>
                </section>

                <!-- Constraints Section -->
                <section id="contraintes" class="section">
                    <h2 class="section-title">Contraintes/Difficultés rencontrées</h2>
                    <p>{{ __($pratique->contrainte) }}</p>
                </section>

                <!-- Cost Section -->
                <section id="cout" class="section">
                    <h2 class="section-title">Coût de mise en oeuvre</h2>
                    <p>{{ __($pratique->cout) }}</p>
                </section>

                <!-- Measure Section -->
                <section id="mesures" class="section">
                    <h2 class="section-title">Types d'accompagnement</h2>
                    <p>{{ __($pratique->mesure) }}</p>
                </section>

                <!-- Recommendation Section -->
                <section id="recommandation" class="section">
                    <h2 class="section-title">Leçons tirées</h2>
                    <p>{{ __($pratique->recommandation) }}</p>
                </section>

                <!-- Partnerships Section -->
                <section id="partenaires" class="section">
                    <h2 class="section-title">Partenariats</h2>
                    <p>{{ __($pratique->description_env_humain) }}</p>
                </section>

                <!-- Zones Section -->
                <section id="zones-application" class="section">
                    <h2 class="section-title">Zones d'application</h2>
                    <div id="zones-container">
                        <ul @class(['list-unstyled' => $pratique->zonesActuelles->count() <= 1])>
                            @foreach ($pratique->zonesActuelles as $zone)
                                <li class="localite">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <span class="localite">{{ getLocalites($zone->localite_id) }}</span>
                                        </div>
                                        @if ($zone->coordonnees['latitude'] && $zone->coordonnees['longitude'])
                                            <div class="col-12 col-md-3">
                                                <span class="label">{{ __('Latitude') }}</span>:
                                                {{ $zone->coordonnees['latitude'] }}
                                            </div>
                                            <div class="col-12 col-md-3">
                                                <span class="label">{{ __('Longitude') }}</span>:
                                                {{ $zone->coordonnees['longitude'] }}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>

                <!-- Potential Zones Section -->
                <section id="zones-pentielle" class="section">
                    <h2 class="section-title">Zone d'application potentielle</h2>
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
                </section>

                <!-- Gallery Section -->
                @if ($pratique->images->count() > 0)
                    <section id="galerie" class="section">
                        <h2 class="section-title">Galerie</h2>
                        <div class="gallery">
                            @foreach ($pratique->images as $index => $image)
                                <div class="gallery-item" onclick="openLightbox({{ $index }})">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="Image {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Documents Section -->
                @if ($pratique->documents->count() > 0)
                    <section id="documents" class="section">
                        <h2 class="section-title">Documents</h2>
                        <div class="references">
                            <ol>
                                @foreach ($pratique->documents as $document)
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
    // Ajoutez d'autres extensions au besoin
                                        ];

                                        // Icône par défaut si l'extension n'est pas reconnue
                                        $defaultIcon = 'https://cdn-icons-png.flaticon.com/512/2965/2965300.png';
                                        $icon = $icons[$extension] ?? $defaultIcon;
                                    @endphp

                                    <li>
                                        <a href="{{ asset('storage/' . $document->path) }}"
                                            download="{{ $document->nom }}">
                                            <img src="{{ $icon }}" alt="{{ strtoupper($extension) }}"
                                                style="width:20px; vertical-align:middle; margin-right:5px;">
                                            {{ $document->nom }}
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </section>
                @endif
            </main>

            <!-- Sidebar -->
            <aside class="sidebar">
                <!-- Infobox -->
                <div class="infobox">
                    <div class="infobox-title">Fiche technique</div>

                    <div class="infobox-data">
                        <span class="infobox-label">Thèmes :</span>
                        @foreach ($pratique->themes as $theme)
                            <span class="badge primary-badge">{{ $theme->themeLibelle }}</span>
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Domaines :</span>
                        @foreach ($pratique->domaines as $domaine)
                            <span>{{ $domaine->domaineLibelle }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Piliers :</span>
                        @foreach ($pratique->piliers as $pilier)
                            <span>{{ $pilier->pilierLibelle }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Types de chocs :</span>
                        @foreach ($pratique->typesChocs as $typeChoc)
                            <span>{{ $typeChoc->typeChocLibelle }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Types de réponses :</span>
                        @foreach ($pratique->reponses as $typeReponse)
                            <span>{{ $typeReponse->typeReponseLibelle }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Sols :</span>
                        @foreach ($pratique->sols as $sol)
                            <span>{{ $sol->solLibelle }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Climats :</span>
                        @foreach ($pratique->climats as $climat)
                            <span>{{ $climat->libelleClimat }}</span>{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Partenaires :</span>
                        @foreach ($pratique->partenaires as $partenaire)
                            <span class="badge text-dark">{{ $partenaire->nomPartenaire }}</span>
                        @endforeach
                    </div>

                    <div class="infobox-data">
                        <span class="infobox-label">Bénéficiaires :</span>
                        @foreach ($pratique->beneficiaires as $beneficiaire)
                            <span class="badge text-dark">{{ $beneficiaire->beneficiaireLibelle }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Facts Box -->
                {{-- <div class="infobox">
                    <div class="infobox-title">Informations clés</div>
                    <div class="infobox-data">
                        <span class="infobox-label">Coût :</span> {{ __($pratique->cout) ?? 'Non spécifié' }}
                    </div>
                    <div class="infobox-data">
                        <span class="infobox-label">Couverture :</span> {{ $pratique->zonesActuelles->count() }} localités
                    </div>
                </div> --}}
            </aside>
        </div>
    </div>

    <!-- Lightbox -->
    @if ($pratique->images->count() > 0)
        <div id="lightbox" class="lightbox">
            <div class="lightbox-content">
                <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
                <span class="lightbox-prev" onclick="changeImage(-1)">&#10094;</span>
                <span class="lightbox-next" onclick="changeImage(1)">&#10095;</span>
                <img id="lightbox-img" class="lightbox-img" src="" alt="">
                <div id="lightbox-caption" class="lightbox-caption"></div>
            </div>
        </div>
    @endif

    <script>
        // Lightbox functionality
        @if ($pratique->images->count() > 0)
            const images = [
                @foreach ($pratique->images as $image)
                    {
                        src: "{{ asset('storage/' . $image->path) }}",
                        caption: "{{ $pratique->pratiqueLibelle }} - Image {{ $loop->iteration }}"
                    },
                @endforeach
            ];

            let currentImageIndex = 0;

            function openLightbox(index) {
                currentImageIndex = index;
                document.getElementById('lightbox-img').src = images[index].src;
                document.getElementById('lightbox-caption').textContent = images[index].caption;
                document.getElementById('lightbox').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                document.getElementById('lightbox').style.display = 'none';
                document.body.style.overflow = 'auto';
            }

            function changeImage(step) {
                currentImageIndex += step;

                if (currentImageIndex >= images.length) {
                    currentImageIndex = 0;
                } else if (currentImageIndex < 0) {
                    currentImageIndex = images.length - 1;
                }

                document.getElementById('lightbox-img').src = images[currentImageIndex].src;
                document.getElementById('lightbox-caption').textContent = images[currentImageIndex].caption;
            }

            // Close lightbox when clicking outside the image
            document.getElementById('lightbox').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeLightbox();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (document.getElementById('lightbox').style.display === 'flex') {
                    if (e.key === 'Escape') {
                        closeLightbox();
                    } else if (e.key === 'ArrowRight') {
                        changeImage(1);
                    } else if (e.key === 'ArrowLeft') {
                        changeImage(-1);
                    }
                }
            });
        @endif
    </script>
@endsection
