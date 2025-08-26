@extends('layouts.template')

@section('content')
    <div class="container pb-5">
        <form class="needs-validation" novalidate method="POST" action="{{ route('page.update', $page->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="rub" value="{{ $rub }}">
            <input type="hidden" name="srub" value="{{ $srub }}">
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="carouselDropzone">{{ __('Images du carousel') }}<span style="color: red">*</span></label>
                    <div id="carouselDropzone" class="dropzone d-flex justify-content-center">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="aproposDropzone">{{ __('Images à propos') }}</label>
                    <div id="aproposDropzone" class="dropzone d-flex justify-content-center">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="apropos">{{ __('Texte à propos') }} <span style="color: red">*</span></label>
                    <textarea id="apropos" class="form-control editor @error('apropos') is-invalid @enderror" name="apropos" required>{{ old('apropos', $page->apropos) }}</textarea>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('apropos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12 form-group">
                    <label for="but">{{ __('But') }} <span style="color: red">*</span></label>
                    <textarea id="but" class="form-control editor @error('but') is-invalid @enderror" name="but" required>{{ old('but', $page->but) }}</textarea>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('but')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="objectif">{{ __('Objectif') }} <span style="color: red">*</span></label>
                    <textarea id="objectif" class="form-control editor @error('objectif') is-invalid @enderror" name="objectif" required>{{ old('objectif', $page->objectif) }}</textarea>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('objectif')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="contenu">{{ __('Contenu') }} <span style="color: red">*</span></label>
                    <textarea id="contenu" class="form-control editor @error('contenu') is-invalid @enderror" name="contenu" required>{{ old('contenu', $page->contenu) }}</textarea>
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
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="guide">{{ __('Guide') }} <span style="color: red">*</span></label>
                    <textarea id="guide" class="form-control editor @error('guide') is-invalid @enderror" name="guide" required>{{ old('guide', $page->guide) }}</textarea>
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('guide')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="communautesDropzone">{{ __('Image de la page des communautés') }}</label>
                    <div id="communautesDropzone" class="dropzone d-flex justify-content-center" aria-describedby="imageHelp"></div>
                    <small id="imageHelp" class="form-text text-muted">Veuillez choisir une nouvelle image sinon l'ancienne sera conservée</small>

                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-md-6 offset-md-4">
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />
                    <a href="{{ route('page.index') }}/{{ $rub }}/{{ $srub }}"><input type="objectifton"
                            id="annuler" value="{{ __('Annuler') }}" class="btn btn-primary btnAnnuler" /></a>
                </div>
            </div>
        </form>
    </div>
    @vite(['resources/js/xlab.js'])
    @push('scripts')
        <script>
            $(document).ready(function() {
                Dropzone.autoDiscover = false;
                var images = @json($page->images);
                var image2 = @json($page->communautes_image);
                var image3 = @json($page->apropos_image);
                xlab.InitDropZone2('#communautesDropzone', {
                    inputName: 'communautes_img',
                    addHidden: true,
                    maxFiles: 1,
                    maxFilesize: 2,
                    existingFiles: [image2],
                    dictRemoveFile: "Supprimer",
                    message: 'Glissez et déposez l\'image ici <strong>(max 2Mo)</strong>'
                });

                xlab.InitDropZone2('#carouselDropzone', {
                    inputName: 'carousel_img[]',
                    addHidden: true,
                    maxFilesize: 2,
                    maxFiles: 3,
                    existingFiles: images,
                    dictRemoveFile: "Supprimer",
                    message: 'Glissez et deposez les images du carousel ici <strong>(max 2Mo)</strong>'
                });

                xlab.InitDropZone2('#aproposDropzone', {
                    inputName: 'apropos_img',
                    addHidden: true,
                    maxFilesize: 2,
                    existingFiles: [image3],
                    dictRemoveFile: "Supprimer",
                    message: 'Glissez et deposez l\'image à propos ici <strong>(max 2Mo)</strong>'
                });
            });
        </script>
    @endpush
@endsection
