@extends('layouts.template')

@section('content')
    {{-- En-tête --}}
    <div class="container mt-4">
        <h2 class="font-weight-semibold h4 text-dark">
            {{-- {{ __('Profile') }} --}}
        </h2>
    </div>

    {{-- Contenu principal --}}
    <div class="py-5">
        <div class="container">
            {{-- Section : Mise à jour du mot de passe --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mx-auto" style="max-width: 600px;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
