@extends('layouts.template')
@push('styles')
@endpush
@section('content')
    <div class="container">
        <form class="needs-validation pb-5" novalidate method="POST" action="{{ route('outil.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="titre"> {{ __('Titre') }} <span style="color: red">*</span> </label>
                    <input class="form-control @error('titre') is-invalid @enderror" type="text" name="titre"
                        id="titre" required value="{{ old('titre') }}">
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="typeoutil_id"> {{ __('Type d\'outil') }} <span style="color: red">*</span>
                    </label>
                    <select id="typeoutil_id" class="form-control @error('typeoutil_id') is-invalid @enderror"
                        name="typeoutil_id">
                        <option value=""></option>
                        @foreach ($typeOutils as $item)
                            <option value="{{ $item->typeoutil_id }}"
                                {{ $item->typeoutil_id == old('typeoutil_id') ? 'selected' : '' }}>
                                {{ $item->typeoutilLibelle }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('typeoutil_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
                <div class="form-group row">
                    <label for="image">{{ __('Image de l\'outil') }} <span style="color: red">*</span></label>
                    <div class="col-12">
                        <div id="myDropzone" class="dropzone d-flex justify-content-center" id="image">
                        </div>
                    </div>
                </div>
            <div class="form-group row">
                <label for="contenu">{{ __('Description de l\'outil') }} <span style="color: red">*</span></label>
                <div class="col-12">
                    <textarea class="form-control editor @error('contenu') is-invalid @enderror" name="contenu" required
                        placeholder="Description ..." rows="200">{{ old('contenu') }}</textarea>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('contenu')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="documents">{{ __('Documents') }}</label>
                <div class="col-12">
                    <div id="documentsDropzone" class="dropzone d-flex justify-content-center" id="image">
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <input type="hidden" name="publique" value="0">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="publique" value="1"
                    {{ old('publique') ? 'checked' : '' }}
                    >
                    <label class="custom-control-label" for="customCheck1">{{ __('Publier') }}</label>
                </div>
            </div>


            <!-- Boutons -->
            <div class="form-group row mb-0 mt-3 pb-5">
                <div class="col-12 text-center">
                    <input type="hidden" name="rub" value="{{ $rub }}">
                    <input type="hidden" name="srub" value="{{ $srub }}">

                    <!-- Bouton de soumission -->
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />

                    <!-- Bouton d'annulation -->
                    <a href="{{ route('outil.index') }}/{{ $rub }}/{{ $srub }}">
                        <input type="button" id="annuler" value="{{ __('Annuler') }}"
                            class="btn btn-secondary btnAnnuler" />
                    </a>
                </div>
            </div>
        </form>
    </div>
    @vite(['resources/js/xlab.js'])
    @push('scripts')
        <script>
            $(document).ready(function() {
                Dropzone.autoDiscover = false;
                xlab.InitDropZone2('#myDropzone', {
                    inputName: 'image',
                    addHidden: true,
                    maxFiles: 1,
                    maxFilesize: 2,
                    dictRemoveFile: "Supprimer",
                    message: 'Glissez et deposez l\'image ici <strong>(max 2Mo)</strong>'
                });

                xlab.InitDropZone2('#documentsDropzone', {
                    inputName: 'documents[]',
                    addHidden: true,
                    maxFiles: 3,
                    maxFilesize: 2,
                    dictRemoveFile: "Supprimer",
                    acceptedFiles: '.pdf,.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.odt,.rtf,.zip',
                    message: 'Glissez et deposez les documents ici <strong>(max 2Mo)</strong>'
                });
            })
        </script>
    @endpush
@endsection
