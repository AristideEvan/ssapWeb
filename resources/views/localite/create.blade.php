@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter une localité') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('localite.store') }}">
                        @csrf
                        
                        <!-- Type de localité -->
                        <div class="form-group row">
                            <label for="typeLocalite" class="col-md-4 col-form-label text-md-right">{{ __('Type de localité') }}</label>
                            <div class="col-md-6">
                            <select id="typeLocalite" name="typeLocalite" class="form-control @error('typeLocalite') is-invalid @enderror" required>
                                <option value="">{{ __('Sélectionner un type') }}</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->typeLocalite_id }}">{{ $type->typeLocaliteLibelle }}</option>
                                @endforeach
                            </select>

                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('typeLocalite')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Nom de la localité -->
                        <div class="form-group row">
                            <label for="localiteNom" class="col-md-4 col-form-label text-md-right">{{ __('Nom de la localité') }}<span style="color: red">*</span></label>
                            <div class="col-md-6">
                                <input id="localiteNom" type="text" class="form-control @error('localiteNom') is-invalid @enderror"
                                name="localiteNom" value="{{ old('localiteNom') }}" required autofocus>
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('localiteNom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Localité parent -->
                        <div class="form-group row">
                            <label for="parent" class="col-md-4 col-form-label text-md-right">{{ __('Localité parent') }}</label>
                            <div class="col-md-6">
                                <select id="parent" name="parent" class="form-control @error('parent') is-invalid @enderror">
                                    <option value=""></option>
                                    @foreach($localites as $localite)
                                        <option value="{{ $localite->localite_id }}">{{ $localite->localiteNom }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('parent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Code Alpha-2 -->
                        <div class="form-group row">
                            <label for="codeAlpha2" class="col-md-4 col-form-label text-md-right">{{ __('Code Alpha-2') }}</label>
                            <div class="col-md-6">
                                <input id="codeAlpha2" type="text" class="form-control @error('codeAlpha2') is-invalid @enderror"
                                name="codeAlpha2" value="{{ old('codeAlpha2') }}">
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('codeAlpha2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Code Alpha-3 -->
                        <div class="form-group row">
                            <label for="codeAlpha3" class="col-md-4 col-form-label text-md-right">{{ __('Code Alpha-3') }}</label>
                            <div class="col-md-6">
                                <input id="codeAlpha3" type="text" class="form-control @error('codeAlpha3') is-invalid @enderror"
                                name="codeAlpha3" value="{{ old('codeAlpha3') }}">
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('codeAlpha3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Code Numérique -->
                        <div class="form-group row">
                            <label for="codeNumerique" class="col-md-4 col-form-label text-md-right">{{ __('Code Numérique') }}</label>
                            <div class="col-md-6">
                                <input id="codeNumerique" type="text" class="form-control @error('codeNumerique') is-invalid @enderror"
                                name="codeNumerique" value="{{ old('codeNumerique') }}">
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('codeNumerique')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" name="rub" value=" {{$rub}} ">
                                <input type="hidden" name="srub" value=" {{$srub}} ">
                                <input type="submit" id="valider" value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                <a href="{{route('localite.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection