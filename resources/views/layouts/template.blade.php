<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'WEBMAPPING') }}</title>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/MarkerCluster.Default.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/carte/leaflet.fullscreen.css') }}" />
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}

    {{-- <link href="{{ asset('css/main.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.rtnotify.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" rel="stylesheet">


    @yield('styles')
    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css" />

    <style>
        .truncate-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .truncate-text2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dropzone {
            border: 2px dashed #ccc !important;
            border-radius: 5px;
        }

        /* Datatable responsive */

        @media (max-width: 768px) {

            /* Aligner le sélecteur de lignes à gauche */
            .table-responsive .dataTables_length {
                display: flex !important;
                justify-content: flex-start !important;
                /* Aligné à gauche */
                align-items: center;
                width: 100%;
            }

            .table-responsive .dataTables_length label {
                font-size: 0;
                /* Cache le texte */
                display: flex;
                align-items: center;
            }

            .table-responsive .select2-container--default .select2-selection--single {
                font-size: 14px;
                position: relative;
                top: 14px;
            }


            .table-responsive .dataTables_length select {
                font-size: 14px;
                /* Garde le select visible */
                width: auto;
                margin-left: 5px;
                /* Ajuste l'espacement */
            }

            /* Ajuste le champ de recherche pour qu'il prenne toute la largeur */
            .table-responsive .dataTables_filter {
                display: flex !important;
                justify-content: flex-end;
                /* Aligné à droite */
                width: 100%;
            }

            .table-responsive .dataTables_filter label {
                font-size: 0;
                /* Cache le texte */
            }

            .table-responsive .dataTables_filter input {
                font-size: 14px;
                width: 100%;
                padding-left: 30px;
            }

            .table-responsive .select2-container--default .select2-selection--single {
                border-radius: 0px;
                border: 1px solid #004e99;
                margin-right: 5px;
                width: 85px !important;
                height: 32px;
                background-color: #e5f6ea;
                color: #000;
                padding-right: 10px !important;
                align-self: flex-start !important;
            }

            .table-responsive div.dataTables_wrapper div.dataTables_filter input {
                margin-left: 0.5em;
                width: auto;
                background-color: aliceblue;
                height: 32px !important;
                align-self: flex-start !important;

            }

            .table-responsive .dataTables_filter::before {
                content: "🔍";
                font-size: 14px;
                color: gray;
                position: relative;
                left: 30px;
                top: 8px;
            }

        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/sigobs.css') }}" />
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="se-pre-con"></div>
    <div id="envoi"></div>
    <!-- entete <body entete> -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light pushmenu">
        {{-- Outiel a gauche --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- ------------------------ Afficher la date et l heure ------------------------------------ --}}
            <li class="nav-item">
                <h5 class="nav-link active " id="dateheure"></h5>
            </li>
            <script>
                function pause(ms) {
                    return new Promise(resolve => setTimeout(resolve, ms));
                }
                async function afficherDate() {
                    while (true) {
                        await pause(1000);
                        var cejour = new Date();
                        var options = {
                            weekday: "long",
                            year: "numeric",
                            month: "long",
                            day: "2-digit"
                        };
                        var date = cejour.toLocaleDateString("fr-FR", options);
                        var heure = ("0" + cejour.getHours()).slice(-2) + ":" + ("0" + cejour.getMinutes()).slice(-2) + ":" + (
                            "0" + cejour.getSeconds()).slice(-2);
                        var dateheure = date + "  |  " + heure;
                        var dateheure = dateheure.replace(/(^\w{1})|(\s+\w{1})/g, lettre => lettre.toUpperCase());
                        document.getElementById('dateheure').innerHTML = dateheure;
                    }
                }
                afficherDate();
            </script>
            {{-- ----------------------------------------------------------------- --}}
        </ul>
        <!-- outiel a droite -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-user"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Menu -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <div>
            <a href="/">
                <img class="armoirieimg mt-1" src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
            <hr color="#708090">
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-1 pb-2 mb-3 d-flex justify-content-center">
                <h6 class="nameuser retouralaligne" color="#000">{{ Auth()->user()->identifiant }}</h6>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item parent">
                        <a href="/dashboard" class="nav-link titreMenu majuscule bg-success text-white">
                            <i class="nav-icon fas fa-home"></i>
                             <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @foreach (session('menus') as $key => $item)
                        <li class="nav-item parent" id="colapse-{{ $item[0]->id }}" onclick="Collapser(this.id);"
                            style="margin-bottom: 3px">
                            <a href="#" class="nav-link titreMenu majuscule bg-success text-white"
                                id="heading{{ $item[0]->id }}">
                                <i class="nav-icon {{ $item[0]->icon }}"></i>
                                <p>
                                    {{ $item[0]->nomMenu }}
                                    <i class="fas fa-angle-double-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (!empty($item[1]))
                                    @foreach ($item[1] as $skey => $sousMenu)
                                        @php $test= "route" ; @endphp
                                        <li class="nav-item">
                                            <a href="{{ $test($sousMenu[0]->lien) }}/{{ $item[0]->id }}/{{ $sousMenu[0]->id }}"
                                                id="sousMenu{{ $sousMenu[0]->id }}">
                                                <i class="metismenu-icon"></i>
                                                <p style="margin-left: 10%">{{ $sousMenu[0]->nomMenu }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endforeach
                    {{-- Deconnexion --}}
                    <br>
                    <li class="nav-item d-flex justify-content-center">
                        <a class="btn btn-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{-- <i class="nav-icon fas fa-th"></i> --}}
                            <i class=" nav-icon fa-solid fa-right-from-bracket"></i>
                            {{-- {{ __('Déconnexion ') }} --}}
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    <!-- Contenu de la page <body main> -->
    <!-- Main content -->
    <div class="  content-wrapper">
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success" id="notif">
                    <button class="close" type="button" onclick="$('#notif').hide();" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" id="notifError">
                    <button class="close" type="button" onclick="$('#notifError').hide();" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    {{ session('error') }}
                </div>
            @endif
            <br>
            @yield('content')
            <!-- /.container-fluid -->
        </div>
    </div>
    <!-- informations utilisateur -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="bg-dark">
            <div class="card-body bg-dark box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/avatar.png') }}"
                        alt="User profile picture">
                </div>
                <h3 class="profile-username text-center retouralaligne">{{ Auth()->user()->prenom }}
                    {{ Auth()->user()->nom }} </h3>
                {{--  <h6 class="text-muted text-center retouralaligne">{{ getRole()}}</h6> --}}
                <ul class="list-group bg-dark mb-3">
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa fa-user-circle pr-2"></i><b
                                class="retouralaligne">{{ Auth()->user()->identifiant }}</b> </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa fa-envelope pr-2"></i><b
                                class="retouralaligne">{{ useremail() }}</b> </a>
                    </li>
                    <li class="list-group-item">
                        <a href="#" class="d-flex align-items-center"><i class="fa-solid fa-phone pr-2"></i><b
                                class="retouralaligne">{{ usertelephone() }}</b> </a>
                    </li>
                    <li class="list-group-item">
                        <a href="/profile" class="d-flex align-items-center"><i class="fa-solid fa-user-edit pr-2"></i><b
                                class="retouralaligne">Mot de passe</b> </a>
                    </li>
                </ul>
                <a class="btn btn-danger d-flex justify-content-center" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                    <i class=" nav-icon fa-solid fa-right-from-bracket"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </div>
        </div>
    </aside>
    <!-- piedpage  <body piedpage>-->
    <footer class="main-footer ">
        <div class="d-flex justify-content-center ">
            <strong class="mr-1">Copyright &copy; </strong> <?php $year = date('Y');
            echo " <strong > | 2024-$year|</strong>"; ?> <a class="mr-2 ml-2"
                href="tel:+22664610959"><img width="50" height="50" src="{{ asset('images/logo.png') }}"
                    alt="Logo"></a><a href="#">|WEBMAPPING - tous droits réservés</a>.
        </div>
    </footer>
    {{-- <footer class="main-footer">
            <strong class="mr-2">Copyright &copy; </strong> <?php $year = date('Y');
            echo " <strong > | 2024-$year|</strong>"; ?> <a class="mr-2 ml-2" href="tel:+22670147315"><img  width="50" height="50" src="{{asset('images/armoirie2.jpg')}}"></a><a href="#">|Projet Repas tous droits réservés</a>.
            <div class="float-right d-none d-sm-inline-block">
              <b>Version</b> 1.0
            </div>
        </footer> --}}
    <div class="modal" id="suppModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="suppFileModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header suppModel">
                    <h5 class="modal-title" id="suppFileModalLabel">{{ __('Confirmer la suppression') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-horizontal" id="pourSupp">
                        <!--verbes-->
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center; font-size:15pt;">
                                    <!--fichier de langue-->
                                    {{ __('Etes vous sûre de vouloir supprimer cet élément?') }}
                                    <br>
                                    <small id="nb"
                                        style="color:red; font-size: 50%; font-weight: 800;"></small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                id="AnnulerSuppFile">Annuler</button>
                            <input type="submit" class="btn btn-primary" style="background-color:#F00"
                                value="Supprimer" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeEtatModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="changeEtatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="validModalLabel">{{ __("Changer d'état") }}</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="form-horizontal" id="changeEtat">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12" style="text-align:center; font-size:15pt;">
                                    <!--fichier de langue-->
                                    Êtes vous sûr de vouloir changer {{ __("l'état ") }}
                                    <span id="zoneMessage"></span>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <input type="submit" class="btn btn-primary" style="background-color:#060"
                                value="Valider" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="apercuDoc" class="modal" data-backdrop="static">
        <div class="modal-dialog" role="document" style="width: 1000px; max-width: 1200px;">
            <div class="modal-content" style="height:600px">
                <div class="modal-header entetePopup">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{ __('Aperçu du document') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="docZone">

                </div>
                <div class="modal-footer">
                    <input type="submit" id="validerArret" style="display: none" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />
                    <button type="button" class="btn btn-primary btnAnnuler" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div id="loader" class="modal" data-backdrop="static">
        <div class="modal-dialog" role="document" style="width: 100px; max-width: 100px;">
            <div class="modal-content">
                <div class="modal-body" id="docZone" style="text-align: center">
                    <img src="{{ asset('images/Preloader_11.gif') }}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="popupAlert" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="popupAlertModalLabel" aria-hidden="true">
        <div id="detailChe"></div>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suppModalLabel">{{ __('infos') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12" style="text-align:center; font-size:15pt;">
                                <p id="zoneMessage"></p>
                            </div>
                        </div>
                    </div>
                    {{--  <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- REQUIRED SCRIPTS -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.rtnotify.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/fr.js') }}"></script>
    <script src="{{ asset('js/pdfobject.js') }}"></script>
    <script src="{{ asset('js/table.js') }}"></script>
    <script src="{{ asset('js/chargerFichier.js') }}"></script>
    <script src="{{ asset('js/scriptAjax.js') }}"></script>
    <script src="{{ asset('js/sigobs.js') }}"></script>
    <script src="{{ asset('leaflet/leaflet.js') }}"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <script src="{{ asset('js/carte/leaflet.js') }}"></script>
    <script src="{{ asset('js/carte/leaflet.markercluster.js') }}"></script>
    <script src="{{ asset('js/carte/Leaflet.fullscreen.min.js') }}"></script>
    <script src="{{ asset('js/carte/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/carte/Control.Geocoder.js') }}"></script>
    <script src="{{ asset('js/carte/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('js/carte/lang/summernote-fr-FR.js') }}"></script>

    <script src="{{ asset('js/summernote-image-attributes.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
    <script>
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });
    </script>
    @stack('scripts')
</body>
<script>
    // Exemple de JavaScript de démarrage pour désactiver les soumissions de formulaire s'il y a des champs invalides
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Récupérer tous les formulaires auxquels nous voulons appliquer des styles de validation Bootstrap personnalisés
            var forms = document.getElementsByClassName('needs-validation');
            // Faites une boucle sur eux et empêchez la soumission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script>
    $('.calendrier').datepicker({
        dateFormat: 'dd-mm-yy',
        closeText: 'Fermer',
        prevText: 'Precedant',
        nextText: 'Suivant',
        currentText: "Aujourd'hui",
        monthNames: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre',
            'Octobre', 'Novembre', 'Decembre'
        ],
        monthNamesShort: ['Jan', 'Fev', 'Mars', 'Avr', 'Mai', 'Juin', 'Juill', 'Août', 'Sept', 'Oct', 'Nov',
            'Dec'
        ],
        dayNames: ['Dichanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
        dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
        weekHeader: 'sem'
    });
</script>
<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 300, // Hauteur de l'éditeur
            lang: 'fr-FR', // Langue de l'éditeur
            placeholder: 'Écrire ici...',
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough',
                    'clear'
                ]], // Style et mise en forme
                ['font', ['fontname', 'fontsize', 'color']], // Police, taille et couleur
                ['para', ['ul', 'ol', 'paragraph']], // Paragraphes et listes
                ['insert', ['link', 'picture', 'table', 'hr', 'video']], // Insertion
                ['view', ['fullscreen', 'codeview', 'help']], // Vue
                ['undo', ['undo', 'redo']] // Annuler / Rétablir
            ],

            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                figureClass: 'figureClass',
                figcaptionClass: 'captionClass',
                captionText: 'Caption Goes Here.',
                manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
            },
            popover: {
                image: [
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageAttributes']],
                ],
            },
            dialogsInBody: true, // Permet d'afficher les dialogues à l'intérieur du corps du document
            callbacks: {
                onInit: function() {


                }
            }
        });
    });
</script>
@stack('scripts')

</html>