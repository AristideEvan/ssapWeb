@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier bénéficiaire') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('beneficiaire.update', $beneficiaire->beneficiaire_id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Type de bénéficiaire -->
                        <div class="form-group row">
                            <label for="typeBeneficiaire" class="col-md-4 col-form-label text-md-right">{{ __('Type de bénéficiaire') }}</label>
                            <div class="col-md-6">
                                <select id="typeBeneficiaire" name="typeBeneficiaire" class="form-control @error('typeBeneficiaire') is-invalid @enderror" >
                                    <option value="">{{ __('Sélectionner un type') }}</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->typeBeneficiaire_id }}" 
                                            {{ $beneficiaire->typeBeneficiaire_id == $type->typeBeneficiaire_id ? 'selected' : '' }}>
                                            {{ $type->typeBeneficiaireLibelle }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('typeBeneficiaire')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Libellé du bénéficiaire -->
                        <div class="form-group row">
                            <label for="beneficiaireLibelle" class="col-md-4 col-form-label text-md-right">{{ __('Libellé du bénéficiaire') }}<span style="color: red">*</span></label>
                            <div class="col-md-6">
                                <input id="beneficiaireLibelle" type="text" class="form-control @error('beneficiaireLibelle') is-invalid @enderror" 
                                name="beneficiaireLibelle" value="{{ $beneficiaire->beneficiaireLibelle }}" required autocomplete="beneficiaireLibelle" autofocus>
                                <div class="invalid-feedback">
                                    {{ __('formulaire.Obligation') }}
                                </div>
                                @error('beneficiaireLibelle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                                    <input type="hidden" name="rub" value={{$rub}} >
                                    <input type="hidden" name="srub" value={{$srub}} >
                                    <input type="submit" id="valider" value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{ route('beneficiaire.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
