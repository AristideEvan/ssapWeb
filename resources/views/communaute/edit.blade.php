@extends('layouts.template')

@section('content')
    <div class="container">
        <form class="needs-validation" novalidate method="POST" action="{{ route('communaute.update', $communaute->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="rub" value={{ $rub }}>
            <input type="hidden" name="srub" value={{ $srub }}>
            <div class="form-group row">
                <div class="col-md-12">
                    <label for="titre"> {{ __('Libellé') }} <span
                            style="color: red">*</span> </label>
                    <input class="form-control @error('titre') is-invalid @enderror"
                        type="text" name="titre" id="titre" required
                        value="{{ old('titre', $communaute->titre) }}">
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
                <label for="contenu">{{ __('Description de la communanuté') }} <span style="color: red">*</span></label>
                <div class="col-md-12">
                    <textarea id="contenu" class="form-control editor @error('contenu') is-invalid @enderror" name="contenu" required>{{ old('communaute', $communaute->contenu) }}</textarea>
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
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <input type="submit" id="valider" value="{{ __('Enregistrer') }}"
                        class="btn btn-primary btnEnregistrer" />
                    <a href="{{ route('communaute.index') }}/{{ $rub }}/{{ $srub }}"><input type="button"
                            id="annuler" value={{ __('Annuler') }} class="btn btn-primary btnAnnuler" /></a>
                </div>
            </div>
        </form>
    </div>
@endsection
