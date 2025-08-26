@extends('layouts.front')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container bg-gray py-3">
    <div class="row d-flex justify-content-between bg-secondary bg-opacity-50 ">
        <div class="col-12 col-md-3 d-flex justify-content-start py-2">
            <div class="d-flex w-100 align-items-center border border-success " style="background: #48a74a;">
                <input type="text" id="searchInput" class="form-control bg-light text-dark border-0" placeholder="Entrez votre recherche">
                <i class="fas fa-search text-white px-2 cursor-pointer"></i>
            </div>
        </div>
        
        <div class="col-12 col-md-9 d-flex justify-content-end">
            <label id="domaine" class="fw-bold mt-2 text-white" >{{ $domaine->themeLibelle }}</label>
        </div>
    </div>

    <div class="mt-3 ">
        <div class=" text-white text-center fw-bold py-2" style="background: #48a74a;">
            <label>PRATIQUES</label>
        </div>
        
        <div class="bg-light py-3 " id="activitegroup">
            @if($pratiques->isEmpty())
                <div class="text-center text-primary fw-bold mt-4">
                    Aucune bibliothèque disponible pour le thème : {{ formatTexte($domaine->themeLibelle )}}.
                </div>
            @else
                @foreach($pratiques as $pratique)
                    <div class="row bg-white  mb-3  rounded mx-2 shadow-sm activite">
                        <div class="col-12 col-md-3 px-2 d-flex justify-content-center mb-2 mb-md-0 order-1 order-md-0">
                            <img src="{{ $pratique->vedette_url }}" alt="Image" class="img-fluid rounded activite-img" style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">
                        </div>
                        <div class="col-12 col-md-7 order-2 order-md-1">
                            <h5 class="fw-bold text-secondary activitelibelle" style="cursor: pointer;">{{ $pratique->pratiqueLibelle }}</h5>
                            <p class=" text-truncate" style="color:gray;font-size:14px !important; white-space: pre-wrap;">{{ Str::limit($pratique->objectif, 800, '...') }}</p>
                        </div>
                        <div class="col-12 col-md-2 d-flex flex-row flex-md-column justify-content-center align-items-center gap-2 order-3 order-md-2">
                            <button class="btn btn-light detail-btn" data-id="{{ $pratique->pratique_id }}">
                                <i class="fas fa-info-circle fs-3"></i>
                            </button>
                            @if (!empty($pratique->premier_document_url))
                            <a href="{{ $pratique->premier_document_url }}" download title="Télécharger le document">
                                <i class="fas fa-file-pdf text-dark fs-3"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="d-flex justify-content-center mt-3">
                    {{ $pratiques->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.detail-btn, .activitelibelle, .activite img').forEach(element => {
            element.addEventListener('click', function() {
                let pratiqueId = this.closest('.activite').querySelector('.detail-btn').getAttribute('data-id');
                window.location.href = `/details-pratiques/${pratiqueId}`;
            });
        });

        const searchInput = document.getElementById("searchInput");
        const searchIcon = document.querySelector(".fa-search");
        const activites = document.querySelectorAll(".activite");

        const messageContainer = document.createElement("div");
        messageContainer.classList.add("text-center", "text-primary", "fw-bold", "mt-3");
        messageContainer.style.display = "none";

        const activiteGroup = document.getElementById("activitegroup");
        activiteGroup.prepend(messageContainer);

        function rechercherActivites() {
            let searchText = searchInput.value.trim().toLowerCase();
            let found = false;

            activites.forEach(activite => {
                let libelle = activite.querySelector(".activitelibelle").textContent.toLowerCase();
                if (libelle.includes(searchText)) {
                    activite.style.display = "flex";
                    found = true;
                } else {
                    activite.style.display = "none";
                }
            });

            if (searchText === "") {
                messageContainer.style.display = "none";
                activites.forEach(activite => activite.style.display = "flex");
            } else if (found) {
                messageContainer.textContent = `Résultat de la recherche : "${searchInput.value}"`;
                messageContainer.style.display = "block";
                messageContainer.style="margin-bottom:10px;"
            } else {
                messageContainer.textContent = "Aucune activité correspondant à votre recherche.";
                messageContainer.style.display = "block";
            }
        }

        searchIcon.addEventListener("click", rechercherActivites);
        searchInput.addEventListener("keyup", rechercherActivites);
    });
</script>
@endpush

@endsection
