@extends('layouts.template')

@section('content')
    <div class="container pb-5">
        <form class="needs-validation" novalidate method="POST" action="{{ route('outil.update', $outil->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="rub" value="{{ $rub }}">
            <input type="hidden" name="srub" value="{{ $srub }}">
            <div class="form-group row">
                <div class="col-md-8">
                    <label for="titre"> {{ __('Libellé') }} <span style="color: red">*</span> </label>
                    <input class="form-control @error('titre') is-invalid @enderror" type="text" name="titre"
                        id="titre" required value="{{ old('titre', $outil->titre) }}">
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
                                {{ $item->typeoutil_id == old('typeoutil_id', $outil->typeoutil_id) ? 'selected' : '' }}>
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
                <div class="col-md-12">
                    <textarea id="contenu" class="form-control editor @error('contenu') is-invalid @enderror" name="contenu" required>{{ old('outil', $outil->contenu) }}</textarea>
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
                        {{ $outil->publique ? 'checked' : '' }}>
                    <label class="custom-control-label" for="customCheck1">{{ __('Publier') }}</label>
                </div>
            </div>

            <div class="form-group row mt-3">
                <div class="col-md-6 offset-md-4">
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />
                    <a href="{{ route('outil.index') }}/{{ $rub }}/{{ $srub }}"><input type="button"
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
                var image = @json($outil->image);
                xlab.InitDropZone2('#myDropzone', {
                    inputName: 'image',
                    addHidden: true,
                    maxFiles: 1,
                    maxFilesize: 2,
                    existingFiles: [image],
                    message: 'Glissez et deposez l\'image ici <strong>(max 2Mo)</strong>'
                });

                var documents = @json($outil->documents);
                xlab.InitDropZone2('#documentsDropzone', {
                    inputName: 'documents[]',
                    addHidden: true,
                    maxFiles: 3,
                    maxFilesize: 2,
                    existingFiles: documents,
                    acceptedFiles: '.pdf,.txt,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.csv,.odt,.rtf,.zip',
                    message: 'Glissez et deposez les documents ici <strong>(max 2Mo)</strong>'
                });
            })
        </script>
    @endpush
@endsection
