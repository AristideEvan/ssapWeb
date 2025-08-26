@extends('layouts.template')

@section('content')
<div class="container-fluid" >
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-0">{{ __('Ajouter menu') }}</div>
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('menu.update',$menuConcerne->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset>
                                        <legend>Menus</legend>
                                        <div class="form-group row">
                                            <label for="parent" class="col-md-4 col-form-label text-md-right">{{ __('Parent') }}{{-- <span style="color: red">*</span> --}}</label>
                                            <div class="col-md-6">
                                                <select id="parent" class="form-control @error('parent') is-invalid @enderror" name="parent"
                                                 autocomplete="parent" autofocus>
                                                    <option value=""></option>
                                                    @foreach ($parents as $parent)
                                                        <option value="{{ $parent->id }}" @if($menuConcerne->parent_id==$parent->id) selected @endif>{{ $parent->nomMenu }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('parent')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="menu" class="col-md-4 col-form-label text-md-right">{{ __('Menus') }}<span style="color: red">*</span></label>
                                            <div class="col-md-6">
                                                <input type="text" name="menu" id="menu" value="{{ $menuConcerne->nomMenu }}" class="form-control @error('menu') is-invalid @enderror " required>
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('menu')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="lien" class="col-md-4 col-form-label text-md-right">{{ __('Lien') }}{{-- <span style="color: red">*</span> --}}</label>
                                            <div class="col-md-6">
                                                <input type="text" name="lien" id="lien" value="{{ $menuConcerne->lien }}" class="form-control @error('lien') is-invalid @enderror " >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('lien')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="icone" class="col-md-4 col-form-label text-md-right">{{ __('Icone') }}{{-- <span style="color: red">*</span> --}}</label>
                                            <div class="col-md-6">
                                                <input type="text" value="{{ $menuConcerne->icon }}" name="icone" id="icone" class="form-control @error('lien') is-invalid @enderror " >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('icone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="ordre" class="col-md-4 col-form-label text-md-right">{{ __('Ordre') }}{{-- <span style="color: red">*</span> --}}</label>
                                            <div class="col-md-6">
                                                <input type="number" name="ordre" id="ordre" value="{{ $menuConcerne->ordre }}" class="form-control @error('lien') is-invalid @enderror " >
                                            </div>
                                            <div class="invalid-feedback">
                                                {{__('formulaire.Obligation')}}
                                            </div>
                                            @error('ordre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row">
                                            <label for="interface" class="col-md-4 col-form-label text-md-right">{{ __('Interface') }} <span style="color: red">*</span> </label>
                                            <div class="col-md-6">
                                                <select id="interface" class="form-control @error('interface') is-invalid @enderror" name="interface" required
                                                    autocomplete="interface" >
                                                    <option value=""></option>
                                                    <option value="1" @if($menuConcerne->interface==1) selected @endif>{{ __('BACKEND-END') }}</option>
                                                    <option value="2" @if($menuConcerne->interface==2) selected @endif>{{ __('FRONT-END') }}</option>
                                                    <option value="3" @if($menuConcerne->interface==3) selected @endif>{{ __('FRONT-END & BACKEND-END') }}</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('parent')
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
                                        <legend>Actions</legend>
                                        <div class="form-group row">
                                            <label for="action" class="col-md-4 col-form-label text-md-right">{{ __('Action') }}{{-- <span style="color: red">*</span> --}}</label>
                                            <div class="col-md-6">
                                                <select id="action" class="form-control @error('action') is-invalid @enderror" name="action[]"
                                                 autocomplete="action" multiple autofocus>
                                                    <option value=""></option>
                                                    @foreach ($actions as $action)
                                                    <option value="{{ $action->id }}" 
                                                        @if(count($tabAction)!=0)
                                                                @foreach ($tabAction as $item)
                                                                    @if($action->id==$item->action_id) selected @endif
                                                                @endforeach
                                                                   
                                                        @endif
                                                        >
                                                        {{ $action->nomAction }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{__('formulaire.Obligation')}}
                                                </div>
                                                @error('action')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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
                                    <a href="{{route('menu.index')}}/{{$rub}}/{{$srub}}"><input type="button" id="annuler" value={{__('Annuler')}} class="btn btn-primary btnAnnuler"/></a>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection