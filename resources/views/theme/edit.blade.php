@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header py-0">{{ __('Modifier le thème') }}</div>
                <div class="card-body">
                    <form class="needs-validation" novalidate method="POST" action="{{ route('theme.update', $theme->theme_id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="themeLibelle" class="col-md-4 col-form-label text-md-right">{{ __('Libellé du thème') }}<span style="color: red">*</span></label>
                            <div class="col-md-6">
                                <input id="themeLibelle" type="text" class="form-control @error('themeLibelle') is-invalid @enderror" name="themeLibelle"
                                value="{{ $theme->themeLibelle }}" required autocomplete="themeLibelle" autofocus onkeyup="this.value = this.value.toUpperCase();">
                                <div class="invalid-feedback">
                                    {{__('formulaire.Obligation')}}
                                </div>
                                @error('themeLibelle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                            <input type="hidden" name="rub" value={{$rub}} >
                            <input type="hidden" name="srub" value={{$srub}} >
                            <input type="submit" id="valider"  value="{{__('Enregistrer')}}" class="btn btn-primary btnEnregistrer"/>
                            <a href="{{route('theme.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
