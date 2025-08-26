<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="logo">
        <img class="logo" src="{{asset('/images/logo.png')}}" alt="" >
    </div>
    <form method="POST" action="{{ route('login') }}" class="p-3 mt-4">
        @csrf
        <!-- Email Address -->
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <x-text-input id="identifiant" type="text" name="identifiant" :value="old('identifiant')" required autofocus autocomplete="identifiant" placeholder="Identifiant"/>
            {{-- <x-input-error :messages="$errors->get('identifiant')" class="mt-2" /> --}}
               
        </div>

        <!-- Password -->
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <x-text-input id="password" class=""
                            type="password"
                            name="password" placeholder="Mot de passe"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="form-field d-flex align-items-center">
            <x-text-input id="actif" type="hidden" name="actif" value="TRUE" required/>
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div> --}}

        <div class="flex items-center justify-end mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}
            @error('identifiant')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <x-primary-button class="btn  mt-2 bg-success text-white">
                {{ __('Connexion') }}
            </x-primary-button>

            <br>
            {{-- <a class="btn btn-link" href="{{ route('register') }}">
                {{ __('Créer un compte') }}
            </a> --}}
        </div>
    </form>
</x-guest-layout>
