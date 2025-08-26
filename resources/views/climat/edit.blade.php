@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier Climat') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('climat.update', $climat->climat_id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <legend>Informations du climat</legend>
                                    <div class="form-group row">
                                        <label for="libelleClimat" class="col-md-4 col-form-label text-md-right">{{ __('Libellé Climat') }}<span style="color: red">*</span></label>
                                        <div class="col-md-6">
                                            <input type="text" name="libelleClimat" id="libelleClimat" value="{{ old('libelleClimat', $climat->libelleClimat) }}" class="form-control @error('libelleClimat') is-invalid @enderror" required>
                                        </div>
                                        <div class="invalid-feedback">
                                            {{__('formulaire.Obligation')}}
                                        </div>
                                        @error('libelleClimat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                        <div class="col-md-6">
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $climat->description) }}</textarea>
                                        </div>
                                        @error('description')
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
                                        <input type="hidden" name="rub" value=" {{ $rub }} ">
                                        <input type="hidden" name="srub" value=" {{ $srub }} ">
                                        <input type="submit" value="{{__('Enregistrer')}}" class="btn btn-primary"/>
                                        <a href="{{ route('climat.index') }}/{{ $rub }}/{{ $srub }}"><input
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
