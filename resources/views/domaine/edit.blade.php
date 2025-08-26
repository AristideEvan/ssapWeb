@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-8"> 
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier domaine') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('domaine.update',$domaine->domaine_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                            <label for="domaine" class="col-md-4 col-form-label text-md-right">
                                {{ __('Thèmes') }} <span style="color: red">*</span>
                            </label >  
                            <div class="col-md-6">                         
                            <select id="theme" class="form-control @error('theme') is-invalid @enderror" name="theme[]" multiple required>
                                    <option value=""></option>
                                    @foreach ($themes as $theme)
                                        <option value="{{ $theme->theme_id }}" 
                                            {{ in_array($theme->theme_id, old('theme', $domaine->themes->pluck('theme_id')->toArray()) ?? []) ? 'selected' : '' }}>
                                            {{ mb_convert_case(mb_strtolower($theme->themeLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8') }}
                                        </option>
                                    @endforeach
                                </select>
                            <div class="invalid-feedback">
                                {{ __('formulaire.Obligation') }}
                            </div>
                            @error('theme.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                            <div class="form-group row">
                                <label for="domaine" class="col-md-4 col-form-label text-md-right">{{ __('domaine') }}<span style="color: red">*</span></label>
                                <div class="col-md-6">
                                    <input id="domaine" type="text" class="form-control @error('domaine') is-invalid @enderror" name="domaine"
                                    value="{{ $domaine->domaineLibelle }}" required autocomplete="domaine" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                    <div class="invalid-feedback">
                                        {{__('formulaire.Obligation')}}
                                    </div>
                                    @error('domaine')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <input type="hidden" name="rub" value={{$rub}} >
                                <input type="hidden" name="srub" value={{$srub}} >
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                                    <a href="{{route('domaine.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection