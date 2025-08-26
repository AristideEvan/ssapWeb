@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            <h4 class="card-title">
                {{ __('Ajouter un climat') }}
            </h4>
        </div>
        <div class="card-body">
            <form class="needs-validation" novalidate method="POST" action="{{ route('climat.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <fieldset>
                            <legend>Informations du climat</legend>
                            
                            <div class="form-group row">
                                <label for="libelleClimat" class="col-md-4 col-form-label text-md-right">{{ __('Libellé du climat') }} <span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" name="libelleClimat" id="libelleClimat" class="form-control @error('libelleClimat') is-invalid @enderror" required>
                                    <div class="invalid-feedback">
                                        {{ __('Ce champ est obligatoire') }}
                                    </div>
                                    @error('libelleClimat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                <div class="col-md-6">
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <input type="hidden" name="rub" value=" {{ $rub }} ">
                                        <input type="hidden" name="srub" value=" {{ $srub }} ">
                                        <input type="submit" value="{{__('Enregistrer')}}" class="btn btn-primary"/>
                                        <a href="{{ route('climat.index') }}/{{ $rub }}/{{ $srub }}"><input
                                        type="button" id="annuler" value={{ __('Annuler') }}
                                        class="btn btn-primary btnAnnuler" /></a>
                                    </div>
                                </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
