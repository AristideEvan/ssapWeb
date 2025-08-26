@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter utilisateur') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('user.store') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="profil" class="col-md-4 col-form-label text-md-right">{{ __('Profil') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <select name="profil" id="profil" class="formulaire" >
                                        <option value=""></option>
                                        @foreach ($profils as $item)
                                            <option value="{{ $item->id }}">{{ $item->nomProfil }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('profil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
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
                                <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
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
                            <div class="form-group row">
                                <label for="identifiant" class="col-md-4 col-form-label text-md-right">{{ __('Identifiant') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="identifiant" type="identifiant" class="form-control formulaire @error('identifiant') is-invalid @enderror" 
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
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-mail') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input name="email" id="email" type="email" value="{{old('email')}}" class="formulaire phone">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control formulaire @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ __('Confirmé') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control formulaire @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
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
                            <div class="form-group row">
                                <label for="actif" class="col-md-4 col-form-label text-md-right">{{ __('Activer le compte?') }}</label>
                                <div class="col-md-6">
                                    <label class="switch">
                                        <input name="actif" id="actif" type="checkbox" checked>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <input type="hidden" name="rub" value=" {{$rub}} ">
                                <input type="hidden" name="srub" value=" {{$srub}} ">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('user.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection