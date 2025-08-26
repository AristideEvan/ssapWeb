@extends('layouts.template')
@section('styles')
<style>
    .logo-preview {
        width: 150px;
        height: 150px;
        overflow: hidden;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #34733c ;
    }
    .logo-preview img {
        width: 100%;
        height: auto;
        object-fit: cover;
        width: 150px; 
        height: 150px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier partenaire') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('partenaire.update', $partenaire->partenaire_id) }}"  enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Première section: Partenaire -->
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Partenaire</legend>
                                        <div class="form-group row">
                                            <label for="type_partenaire" class="col-md-4 col-form-label text-md-right">{{ __('Type Partenaire') }}</label>
                                            <div class="col-md-6">
                                                <select id="type_partenaire" class="form-control @error('type_partenaire') is-invalid @enderror" name="type_partenaire" >
                                                    <option value=""></option>
                                                    @foreach ($typesPartenaire as $type)
                                                        <option value="{{ $type->typePartenaire_id }}" @if($partenaire->typePartenaire_id == $type->typePartenaire_id) selected @endif>{{ $type->typePartenaireLibelle }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('type_partenaire')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nom_partenaire" class="col-md-4 col-form-label text-md-right">{{ __('Nom Partenaire') }} <span style="color: red">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" name="nom_partenaire" id="nom_partenaire" value="{{ $partenaire->nomPartenaire }}" class="form-control @error('nom_partenaire') is-invalid @enderror" required>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('nom_partenaire')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="sigle" class="col-md-4 col-form-label text-md-right">{{ __('Sigle') }}</label>
                                            <div class="col-md-6">
                                                <input type="text" name="sigle" id="sigle" value="{{ $partenaire->sigle }}" class="form-control @error('sigle') is-invalid @enderror">
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('sigle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                        <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="logo-preview">
                                                <img id="logo-preview" alt="Logo" src="{{ url('logos/'.$partenaire->logo) }}" class="img-thumbnail" style="border-radius: 50%; display: none; border-radius: 50%; display: {{ $partenaire->logo ? 'block' : 'none' }};"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" name="logo" id="logo"  class="form-control @error('logo') is-invalid @enderror" onchange="previewLogo(event)">
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('logo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    </fieldset>
                                </div>

                                <!-- Deuxième section: Répondant -->
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Répondant</legend>
                                        <div class="form-group row">
                                            <label for="nom_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>
                                            <div class="col-md-6">
                                                <input type="text" name="nom_repondant" id="nom_repondant" value="{{ $partenaire->nomRepondant }}" class="form-control @error('nom_repondant') is-invalid @enderror" >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('nom_repondant')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="prenom_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }} </label>
                                            <div class="col-md-6">
                                                <input type="text" name="prenom_repondant" id="prenom_repondant" value="{{ $partenaire->prenomRepondant }}" class="form-control @error('prenom_repondant') is-invalid @enderror" >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('prenom_repondant')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="telephone_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }} </label>
                                            <div class="col-md-6">
                                                <input type="text" name="telephone_repondant" id="telephone_repondant" value="{{ $partenaire->telephoneRepondant }}" class="form-control @error('telephone_repondant') is-invalid @enderror" >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('telephone_repondant')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="email_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Email') }} </label>
                                            <div class="col-md-6">
                                                <input type="email" name="email_repondant" id="email_repondant" value="{{ $partenaire->emailRepondant }}" class="form-control @error('email_repondant') is-invalid @enderror" >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('email_repondant')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                    </fieldset>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <input type="submit" id="valider" value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{ route('partenaire.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('logo-preview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
    
</script>
@endpush
@endsection
