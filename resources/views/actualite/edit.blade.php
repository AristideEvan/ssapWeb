@extends('layouts.template')

@section('content')
    <div class="container">
        <form class="needs-validation pb-5" novalidate method="POST" action="{{ route('actualite.update', $actualite->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="rub" value="{{ $rub }}">
            <input type="hidden" name="srub" value="{{ $srub }}">
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="titre"> {{ __('Titre') }} <span
                            style="color: red">*</span> </label>
                    <input class="form-control @error('titre') is-invalid @enderror"
                        type="text" name="titre" id="titre" required
                        value="{{ old('titre', $actualite->titre) }}">
                    <div class="invalid-feedback">
                        {{ __('formulaire.Obligation') }}
                    </div>
                    @error('titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="image">{{ __('Image de l\'actualité') }} <span style="color: red">*</span></label>
                <div class="col-12">
                    <div id="myDropzone" class="dropzone d-flex justify-content-center" id="image">
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="contenu">{{ __('Description de l\'actualité') }} <span style="color: red">*</span></label>
                <div class="col-md-12">
                    <textarea id="contenu" class="form-control editor @error('contenu') is-invalid @enderror" name="contenu" required>{{ old('contenu', $actualite->contenu) }}</textarea>
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
                <input type="hidden" name="publique" value="0">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="publique" value="1" 
                           {{ $actualite->publique ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customCheck1">{{ __('Publier') }}</label>
                </div>
            </div>
            
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />
                    <a href="{{ route('actualite.index') }}/{{ $rub }}/{{ $srub }}"><input type="button"
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
                var image = @json($actualite->image);
                xlab.InitDropZone2('#myDropzone', {
                    inputName: 'image',
                    addHidden: true,
                    maxFiles: 1,
                    maxFilesize: 2,
                    existingFiles: [image],
                    message: 'Glissez et deposez l\'image ici'
                });
            })
        </script>
    @endpush
@endsection
