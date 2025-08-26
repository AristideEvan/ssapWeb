

<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend>Candidat</legend>
            <div class="form-group row">
                <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}<span style="color: red">*</span></label>
                <div class="col-md-8">
                    <input name="nom" id="nom" value="{{$datas->nom}}" class="formulaire" readonly>
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
                <div class="col-md-8">
                    <input name="prenom" id="prenom" value="{{$datas->prenom}}" class="formulaire" readonly>
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
                <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Téléphone') }}</label>
                <div class="col-md-8">
                    <input name="telephone" id="telephone" value="{{$datas->telephone}}" class="formulaire phone">
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
            <input type="hidden" name="iue" id="iue" value="{{ $datas->iue }}">
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset>
            <legend>Compte</legend>
            <div class="form-group row">
                <label for="identifiant" class="col-md-5 col-form-label text-md-right">{{ __('Identifiant') }}<span style="color: red">*</span></label>
                <div class="col-md-7">
                    <input id="identifiant" type="identifiant" class="formulaire @error('identifiant') is-invalid @enderror" 
                    name="identifiant" value="{{ $code }}" required autocomplete="identifiant" readonly>
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
                <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Mot de passe') }}<span style="color: red">*</span></label>
                <div class="col-md-7">
                    <input id="password" type="password" class="formulaire @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
                <label for="password_confirmation" class="col-md-5 col-form-label text-md-right">{{ __('Confirmé') }}<span style="color: red">*</span></label>
                <div class="col-md-7">
                    <input id="password_confirmation" type="password" class="formulaire @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
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
        </fieldset>
    </div>
</div>
<script>
    jQuery(".phone").inputmask({"mask": "(+226) 99-99-99-99"});
</script>