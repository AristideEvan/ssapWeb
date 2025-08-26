@extends('layouts.front')

@section('content')

    <!-- Carousel Section -->
    <div id="practicesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if ($pratiques->isEmpty())
                {{-- Cas où il n'y a aucune pratique --}}
                <div class="carousel-item active">
                    <img src="{{ asset('img/carousel-default.jpg') }}" class="d-block w-100"
                        alt="Aucune pratique disponible" />
                    <div class="carousel-overlay">
                        <div class="practice-content">
                            <h3 class="practice-title">{{ __('Aucune pratique disponible') }}</h3>
                        </div>
                    </div>
                </div>
            @else
                {{-- Cas où il y a des pratiques - utiliser les images vedettes --}}
                @foreach ($pratiques as $index => $pratique)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        @if ($pratique->vedette_path)
                            <img src="{{ asset('storage/' . $pratique->vedette_path) }}" class="d-block w-100"
                                alt="Image vedette de {{ $pratique->pratiqueLibelle }}" />
                        @else
                            <img src="{{ asset('img/carousel-default.jpg') }}" class="d-block w-100"
                                alt="Image par défaut" />
                        @endif
                        <div class="carousel-overlay">
                            <div class="practice-content">
                                <h3 class="practice-title practice-theme">{{ $pratique->pratiqueLibelle }}</h3>
                                <p class="practice-desc">{{ Str::limit($pratique->objectif, 150) }}</p>
                                <a href="{{ route('pratique.details', $pratique->pratique_id) }}"
                                    class="btn btn-primary">Voir la pratique</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @if ($pratiques->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#practicesCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#practicesCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        @endif
    </div>

    <!-- About Section -->
    <section class="py-5 py-lg-7">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>À Propos de Notre Plateforme</h2>
                <p>Une initiative du CILSS-INSAH pour le partage des connaissances et bonnes pratiques</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    @if (!empty($page->apropos_img_path))
                        <img src="{{ asset('storage/' . $page->apropos_img_path) }}" alt="À propos CILSS-INSAH"
                            class="img-fluid rounded shadow" />
                    @else
                        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="À propos CILSS-INSAH" class="img-fluid rounded shadow" />
                    @endif
                </div>
                <div class="col-lg-6 readme" data-aos="fade-left">
                    <h3 class="mb-4">Plateforme de Partage et de Diffusion des Bonnes Pratiques</h3>
                    <p>{!! truncateHtml($page->apropos, 800) !!}</p>
                    <a href="{{ route('readmore', ['section' => 'apropos']) }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i> Lire la suite
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Goals Section -->
    <section class="goals-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center" data-aos="fade-up">
                    <h2 class="mb-3">But et Objectifs</h2>
                    <p class="lead">Découvrez les raisons d'être et les ambitions de notre plateforme</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="goal-card readme">
                        <h4>Notre But</h4>
                        <p>{!! truncateHtml($page->but, 300) !!}</p>
                        <a href="{{ route('readmore', ['section' => 'but']) }}"
                            class="btn btn-link ps-0 text-secondary text-decoration-none">
                            Lire la suite <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="goal-card readme">
                        <h4>Nos Objectifs</h4>
                        <p>{!! truncateHtml($page->objectif, 300) !!}</p>
                        <a href="{{ route('readmore', ['section' => 'objectif']) }}"
                            class="btn btn-link ps-0 text-secondary text-decoration-none">
                            Lire la suite <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 py-lg-7 bg-light">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Contenu</h2>
                <p>Découvrez les principales fonctionnalités de notre plateforme</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="feature-card card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h4 class="mb-3">Bibliothèque des Bonnes Pratiques</h4>
                            <p class="text-muted">
                                {{ truncateHtml('La bibliothèque des bonnes pratiques constitue un espace documentaire regroupant des ressources spécialisées sur des thématiques telles que la Sécurité alimentaire et nutrition, le Pastoralisme, le Changement climatique, la Gestion durable des terres, la Maitrise de l’eau, l’Accès aux Marchés et Population et développement. Elle met à disposition des fiches techniques de pratiques éprouvées permettant d’appuyer les décisions et les interventions sur le terrain.', 200) }}
                            </p>
                            <a href="{{ route('biblioteque', ['id' => 1]) }}"
                                class="btn btn-link ps-0 text-secondary text-decoration-none">
                                Explorer <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h4 class="mb-3">Carte Interactive</h4>
                            <p class="text-muted">
                                {{ truncateHtml('L’interface cartographique, grâce à des outils de visualisation avancés, permet d’explorer les initiatives passées et celles en cours, d’analyser les tendances et d’identifier les zones nécessitant une attention particulière. Cet outil interactif offre la possibilité de filtrer les données par pays, région, type d’intervention ou encore par indicateurs climatiques et socio-économiques et de d’aboutir à des recommandations de bonnes pratiques et initiatives à mettre à l’échelle.', 200) }}
                            </p>
                            <a href="{{ route('carte.showMap') }}"
                                class="btn btn-link ps-0 text-secondary text-decoration-none">
                                Visualiser <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card card h-100">
                        <div class="card-body p-4">
                            <div class="feature-icon">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h4 class="mb-3">Plateforme E-learning</h4>
                            <p class="text-muted">
                                {{ truncateHtml('Le volet e-learning propose un ensemble de formations et de ressources pédagogiques permettant aux utilisateurs d’acquérir des compétences techniques et méthodologiques sur les bonnes pratiques en matière de Sécurité alimentaire et nutrition, le Pastoralisme, le Changement climatique, la Gestion durable des terres, la Maitrise de l’eau, l’Accès aux Marchés et Population et développement. Il comprend des modules interactifs, des guides', 200) }}
                            </p>
                            <a href="/elearning" class="btn btn-link ps-0 text-secondary text-decoration-none">
                                Apprendre <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5 py-lg-7 text-center text-white">
        <div class="container">
            <!-- Ajoutez justify-content-center ici -->
            <div class="row justify-content-center mx-auto"> <!-- Modifié -->
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-item p-3">
                        <div class="stat-number" data-count="{{ $pratiquesList->count() ?? 250 }}">0</div>
                        <div class="stat-label">Bonnes Pratiques</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item p-3">
                        <div class="stat-number" data-count="{{ $countRessources }}">0</div>
                        <div class="stat-label">Ressources</div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item p-3">
                        <div class="stat-number" data-count="{{ $countPratiquePays }}">0</div>
                        <div class="stat-label">Pays Couverts</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guide Section -->
    <section class="guide-section py-5 py-lg-7">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Guide d'Utilisation</h2>
                <p>Comment tirer le meilleur parti de notre plateforme</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                    <img src="https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Guide d'utilisation" class="img-fluid guide-img" />
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="bg-white p-4 p-lg-5 shadow rounded readme">
                        <h3 class="mb-4">Naviguer efficacement</h3>
                        <p>{!! truncateHtml($page->guide, 300) !!}</p>
                        <a href="{{ route('readmore', ['section' => 'guide']) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-book-open me-2"></i> Lire le guide complet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 py-lg-7 bg-light">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Foire Aux Questions</h2>
                <p>Les réponses à vos questions les plus fréquentes</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        @foreach ($faqs as $faq)
                            <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up"
                                data-aos-delay="{{ $loop->index * 100 }}">
                                <h3 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button collapsed shadow-none rounded" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}"
                                        aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                        {{ $faq->question }}
                                    </button>
                                </h3>
                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {{ $faq->reponse }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mt-5" data-aos="fade-up">
                        <p class="lead">Vous ne trouvez pas la réponse à votre question ?</p>
                        <a href="{{ route('contact') }}" class="btn btn-secondary">Contactez notre équipe</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section py-5 py-lg-7">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2>Nos Partenaires</h2>
                <p>Institutions et organisations collaborant avec notre plateforme</p>
            </div>

            <div class="row justify-content-center align-items-center">
                @foreach ($partenaires as $partenaire)
                    <div class="col-4 col-sm-3 col-md-3 col-lg-2 mb-3 px-2" data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="partner-item h-100" style="height: 90px;">
                            <img src="{{ asset('logos/' . $partenaire->logo) }}" alt="{{ $partenaire->nom }}"
                                class="img-fluid w-100 h-100 object-fit-contain p-1" />
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5" data-aos="fade-up">
                <p class="lead">Vous souhaitez devenir partenaire ?</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary">Contactez-nous</a>
            </div>
        </div>
    </section>
@endsection
