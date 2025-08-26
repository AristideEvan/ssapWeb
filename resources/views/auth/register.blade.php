@extends('layouts.front')

@section('content')

<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">{{ __('Création de compte') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <fieldset>
                                        <legend>Examen</legend>
                                        <div class="form-group row">
                                            <label for="examen" class="col-md-5 col-form-label text-md-right">{{ __('Type') }}</label>
                                            <div class="col-md-7">
                                                <select name="examen" id="examen" class="formulaire" onchange="getDonnees('getSessionByExamen',this.id,'session');">
                                                    <option value=""></option>
                                                    @foreach ($examens as $item)
                                                        <option value="{{ $item->examen_id }}">{{ $item->examen }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="session" class="col-md-5 col-form-label text-md-right">{{ __('Session') }}</label>
                                            <div class="col-md-7">
                                                <select name="session" id="session" class="formulaire" onchange="getDonnees('getFils',this.id,'province');">
                                                    <option value=""></option>
                                                
                                                </select>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <label for="numeroPV" class="col-md-5 col-form-label text-md-right">{{ __('numeroPV') }}<span style="color: red">*</span></label>
                                            <div class="col-md-7">
                                                <input name="numeroPV" id="numeroPV" value="{{old('numeroPV')}}" class="formulaire" >
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('numeroPV')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row" >
                                            <label for="dateNaissance" class="col-md-5 col-form-label text-md-right">{{ __('Date Naissance') }}<span style="color: red">*</span></label>
                                            <div class="col-md-7">
                                                <input name="dateNaissance" id="dateNaissance" value="{{old('dateNaissance')}}" class="formulaire calendrier">
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('dateNaissance')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                           
                                        </div>
                                        <div class="form-group row" >
                                            <div class="col-md-2 offset-10">
                                                <input onclick="getCandidat('candidat');" class="btn btn-primary btnEnregistrer" style="float:right" value="{{ __('Afficher') }}" />
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-8" id="candidat">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Candidat</legend>
                                                    <div class="form-group row">
                                                        <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}<span style="color: red">*</span></label>
                                                        <div class="col-md-8">
                                                            <input name="nom" id="nom" value="{{old('nom')}}" class="formulaire" onkeyup="this.value = this.value.toUpperCase();">
                                                            <div class="invalid-feedback">
                                                                {{__('formulaire.Obligation')}}
                                                            </div>
                                                            @error('nom')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prenoms') }}<span style="color: red">*</span></label>
                                                        <div class="col-md-8">
                                                            <input name="prenom" id="prenom" value="{{old('prenom')}}" class="formulaire">
                                                            <div class="invalid-feedback">
                                                                {{__('formulaire.Obligation')}}
                                                            </div>
                                                            @error('prenom')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}</label>
                                                        <div class="col-md-8">
                                                            <input name="telephone" id="telephone" value="{{old('telephone')}}" class="formulaire phone">
                                                            <div class="invalid-feedback">
                                                                {{__('formulaire.Obligation')}}
                                                            </div>
                                                            @error('telephone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <legend>Compte</legend>
                                                <div class="form-group row">
                                                    <label for="identifiant" class="col-md-5 col-form-label text-md-right">{{ __('Identifiant') }}<span style="color: red">*</span></label>
                                                    <div class="col-md-7">
                                                        <input id="identifiant" type="identifiant" class="formulaire @error('identifiant') is-invalid @enderror" 
                                                        name="identifiant" value="{{ old('identifiant') }}" required autocomplete="identifiant">
                                                        <div class="invalid-feedback">
                                                            {{__('formulaire.Obligation')}}
                                                        </div>
                                                        @error('identifiant')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Mot de passe') }}<span style="color: red">*</span></label>
                                                    <div class="col-md-7">
                                                        <input id="password" type="password" class="formulaire @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                        <div class="invalid-feedback">
                                                            {{__('formulaire.Obligation')}}
                                                        </div>
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="password_confirmation" class="col-md-5 col-form-label text-md-right">{{ __('Confirmé') }}<span style="color: red">*</span></label>
                                                    <div class="col-md-7">
                                                        <input id="password_confirmation" type="password" class="formulaire @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                                                        <span toggle="#password_confirmation" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                                        <div class="invalid-feedback">
                                                            {{__('formulaire.Obligation')}}
                                                        </div>
                                                        @error('password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" style="display: none">
                                <label for="actif" class="col-md-4 col-form-label text-md-right">{{ __('Activer le compte?') }}</label>
                                <div class="col-md-6">
                                    <label class="switch">
                                        <input name="actif" id="actif" type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="form-group row mb-0">
                               {{--  <input type="hidden" name="rub" value=" {{$rub}} ">
                                <input type="hidden" name="srub" value=" {{$srub}} "> --}}
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="/"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection