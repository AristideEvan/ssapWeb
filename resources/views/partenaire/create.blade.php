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
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-0">{{ __('Ajouter un partenaire') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('partenaire.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Informations sur le partenaire -->
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Partenaire</legend>
                                    <div class="form-group row">
                                        <label for="type_partenaire" class="col-md-4 col-form-label text-md-right">{{ __('Type de partenaire') }} </label>
                                        <div class="col-md-6">
                                            <select id="type_partenaire" class="form-control @error('type_partenaire') is-invalid @enderror" name="type_partenaire" required autocomplete="type_partenaire" autofocus>
                                                <option value=""></option>
                                                @foreach ($typesPartenaire as $type)
                                                    <option value="{{ $type->typePartenaire_id }}">{{ $type->typePartenaireLibelle }}</option>
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
                                        <label for="nom_partenaire" class="col-md-4 col-form-label text-md-right">{{ __('Nom du partenaire') }} <span style="color: red">*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" name="nom_partenaire" id="nom_partenaire" class="form-control @error('nom_partenaire') is-invalid @enderror" required>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('nom_partenaire')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sigle" class="col-md-4 col-form-label text-md-right">{{ __('Sigle') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" name="sigle" id="sigle" class="form-control @error('sigle') is-invalid @enderror">
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('sigle')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <div class="logo-preview">
                                                <img id="logo-preview" src="#" alt="Logo" class="img-thumbnail" style="border-radius: 50%; display: none;"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" onchange="previewLogo(event)">
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

                            <!-- Informations sur le répondant -->
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Répondant</legend>
                                    <div class="form-group row">
                                        <label for="nom_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Nom du répondant') }}</label>
                                        <div class="col-md-6">
                                            <input type="text" name="nom_repondant" id="nom_repondant" class="form-control @error('nom_repondant') is-invalid @enderror">
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="prenom_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Prénom du répondant') }} </label>
                                        <div class="col-md-6">
                                            <input type="text" name="prenom_repondant" id="prenom_repondant" class="form-control @error('prenom_repondant') is-invalid @enderror" >
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="telephone_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }} </label>
                                        <div class="col-md-6">
                                            <input type="text" name="telephone_repondant" id="telephone_repondant" class="form-control @error('telephone_repondant') is-invalid @enderror" >
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email_repondant" class="col-md-4 col-form-label text-md-right">{{ __('Email') }} </label>
                                        <div class="col-md-6">
                                            <input type="email" name="email_repondant" id="email_repondant" class="form-control @error('email_repondant') is-invalid @enderror" >
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="hidden" name="rub" value=" {{$rub}} ">
                                <input type="hidden" name="srub" value=" {{$srub}} ">
                                <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                <a href="{{route('partenaire.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                            </div>
                        </div>
                    </form>
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
