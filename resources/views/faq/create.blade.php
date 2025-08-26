@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-0">{{ __('Ajouter question') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('faq.store') }}">
                            @csrf
                            <input type="hidden" name="rub" value={{ $rub }}>
                            <input type="hidden" name="srub" value={{ $srub }}>
                            <div class="form-group row">
                                <label for="question"
                                    class="col-md-4 col-form-label text-md-right">{{ __('question') }}<span
                                        style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="question" type="text"
                                        class="form-control @error('question') is-invalid @enderror" name="question"
                                        value="{{ old('question') }}" required autofocus
                                        onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{ __('formulaire.Obligation') }}
                                    </div>
                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="reponse"
                                    class="col-md-4 col-form-label text-md-right">{{ __('reponse') }}<span
                                        style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <textarea id="reponse" class="form-control @error('reponse') is-invalid @enderror" name="reponse" required>{{ old('reponse') }}</textarea>
                                    <div class="invalid-feedback">
                                        {{ __('formulaire.Obligation') }}
                                    </div>
                                    @error('reponse')
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
                                    <a href="{{ route('faq.index') }}/{{ $rub }}/{{ $srub }}"><input
                                            type="button" id="annuler" value={{ __('Annuler') }}
                                            class="btn btn-primary btnAnnuler" /></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
