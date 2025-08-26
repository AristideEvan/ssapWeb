@extends('layouts.template')
<style>
    .container {
        display: flex;
        justify-content: center;
    }

    .truncate-text2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 1024px) {
        .text-sm-size {}
    }

    /* Style de base pour le loader */
    .loader {
        /* Caché par défaut */
        width: 16px;
        height: 16px;
        border: 2px solid #ccc;
        border-top: 2px solid #007bff;
        /* Couleur principale */
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0;
        padding: 0;
    }

    /* Animation de rotation */
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    #publique-loader {
        position: relative;
        top: -18px;
        left: 115px;
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
@section('content')
    <div class="container-fluid">
        <form id="filter-form">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="pays"> {{ __('Pays') }}</label>
                    <select class="form-control pays" name="pays" id="pays">
                        <option value="all" selected> {{ __('Tout') }}</option>
                        @foreach ($pays as $item)
                            <option value="{{ $item->localite_id }}"> {{ $item->nomLocalite }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label for="publique"> {{ __('Publiées') }} ?</label>
                    <select id="publique" class="form-control localite" name="publique">
                        <option value="all" selected> {{ __('Tout') }}</option>
                        <option value="true"> {{ __('Publiées') }}</option>
                        <option value="false"> {{ __('Non publiées') }}</option>
                    </select>
                </div>
            </div>
            <div class="row mb-5 mt-1">
                <div class="col-1">
                    <button type="button" class="btn btn-primary mt-2" id="filter-button">{{ 'Afficher' }}</button>
                </div>
            </div>
        </form>
        <div class="main-card card">
            <div class="card-header py-1 d-flex align-items-center flex-nowrap">
                <div class="flex-grow-1">{{ __('Liste des pratiques') }}</div>
                <div class="ms-auto">@php echo $controler->newFormButton($rub, $srub, 'pratique.create'); @endphp</div>
            </div>

            <div class="card-body table-responsive" id="table-container">
                <table id="example" class="table table-striped table-bordered table-hover dataTable">
                    <thead>
                        <tr>
                            <th>{{ __('Libellé') }} </th>
                            <th style="max-width: 200px">{{ __('Description') }} </th>
                            <th>{{ __('Coût') }} (F FCA) </th>
                            @if (canMakePublic(Auth::user()))
                                <th>
                                    {{ __('Depublier') }}
                                    <i class="fa fa-save ml-3" style="cursor: pointer" id="publique-pratiques"></i>
                                    <div class="loader" id="publique-loader" style="display: none"></div>
                                </th>
                            @endif
                            <th></th>
                            @php echo $controler->crudheader($rub,$srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @include('pratique.partials.table')
                    </tbody>
                </table>
            </div>
        </div>
        <br>
    </div>
    @push('scripts')
        @vite(['resources/js/xlab.js'])
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const rub = <?php echo $rub; ?>;
                const srub = <?php echo $srub; ?>;
                const publiqueButton = document.getElementById('publique-pratiques');
                const filterForm = document.getElementById('filter-form');
                const container = document.querySelector('#table-container tbody');
                // const vedetteButton = document.getElementById('publique-pratiques');
                const publiqueForm = new xlab.Form({
                    checkboxesSelector: '.publique-checkbox',
                    initialDataKey: 'publique',
                    loaderSelector: '#publique-loader',
                    endpoint: `/update-pratiques/${rub}/${srub}`,
                    action: 'publique',
                });

                if (publiqueButton) {
                    publiqueButton.addEventListener('click', () => {
                        const pays = filterForm.querySelector('select[name="pays"]').value;
                        const selected = document.querySelector('input[name="selected_pratiques[]"]').value;
                        const publique = filterForm.querySelector('select[name="publique"]').value;

                        const moreData = {
                            pays: pays,
                            publique: publique,
                        };

                        const requestBody = {
                            unselected_values: [selected],
                            new_values: [],
                            action: "publique",
                            returnHtml: true,
                            ...moreData
                        };

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
                                    console.log('response', data);
                                    const htmlContent = data.html
                                    container.innerHTML = htmlContent;
                                    window.location.reload(true);
                                } else {
                                    console.error('Response error:', data);
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:',
                                    error); // Affiche l'erreur en cas de problème avec la requête
                            });
                    });
                }


                // const vedetteForm = new xlab.Form({
                //     checkboxesSelector: '.publique-checkbox',
                //     initialDataKey: 'publique',
                //     loaderSelector: '#publique-loader',
                //     endpoint: '/update-pratiques',
                //     action: 'publique',
                // });

                // vedetteButton.addEventListener('click', () => {
                //     vedetteForm.massActions();
                // });

                // Filter pratiques
                document.getElementById('filter-button').addEventListener('click', function(event) {
                    event.preventDefault();
                    console.log('clicked');
                    const formData = new FormData(filterForm);
                    const queryString = new URLSearchParams(formData).toString();
                    history.pushState(null, '', `?${queryString}`);
                    fetch(`/pratiques/${rub}/${srub}/filter?${queryString}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.success) {
                                const htmlContent = data.html
                                container.innerHTML = htmlContent;
                            }

                        })
                        .catch(error => console.error('Erreur:', error));
                });

                function integerToDate(timestamp) {
                    const date = new Date(timestamp * 1000);
                    const formattedDate = date.toISOString().split('T')[0];
                    return formattedDate;
                }


            });

            // Send update request
            // updateButton.addEventListener('click', () => {
            //     const selectedIds = Array.from(document.querySelectorAll('.pratique-checkbox:checked'))
            //         .map((checkbox) => checkbox.value);

            //     if (!selectedIds || selectedIds.length === 0) {
            //         alert('Veuillez sélectionner au moins une pratique.');
            //         return;
            //     }

            //     fetch('/update-vedette-pratiques', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
            //                     .getAttribute('content'),
            //             },
            //             body: JSON.stringify({
            //                 selected_pratiques: selectedIds
            //             }),
            //         })
            //         .then((response) => response.json())
            //         .then((data) => {
            //             if (data.error) {
            //                 alert(data.error);
            //             } else {
            //                 alert(data.message);
            //             }
            //         })
            //         .catch((error) => console.error('Erreur:', error));
            // });
        </script>
    @endpush
@endsection
