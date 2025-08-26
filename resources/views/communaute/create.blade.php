@extends('layouts.template')
@push('styles')
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.2.0/ckeditor5.css" /> --}}
@endpush
@section('content')
    <div class="container">
        <form class="needs-validation" novalidate method="POST" action="{{ route('communaute.store') }}">
            @csrf
            <div class="form-group row">
                <div class="col-md-12">
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
            </div>
            <div class="form-group row mt-5">
                <label for="contenu">{{ __('Description de la communanuté') }} <span style="color: red">*</span></label>
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

            <!-- Boutons -->
            <div class="form-group row mb-0 mt-3">
                <div class="col-12 text-center">
                    <input type="hidden" name="rub" value="{{ $rub }}">
                    <input type="hidden" name="srub" value="{{ $srub }}">

                    <!-- Bouton de soumission -->
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />

                    <!-- Bouton d'annulation -->
                    <a href="{{ route('communaute.index') }}/{{ $rub }}/{{ $srub }}">
                        <input type="button" id="annuler" value="{{ __('Annuler') }}"
                            class="btn btn-secondary btnAnnuler" />
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
