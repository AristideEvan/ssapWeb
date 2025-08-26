@extends('layouts.front')

@section('content')
    <div class="container-fluid services py-5 mb-5">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeIn" data-wow-delay=".3s" style="max-width: 600px;">
                <h3>{{ $actualite->titre }}</h3>
                <p class="fs-6">{{ $actualite->created_at->diffForHumans() }}</p>
            </div>
            <div class="row g-2 services-inner d-flex justify-content-center">
                <div class="bg-white">
                    <div class="p-4 text-center">
                            <div>
                                {!! $actualite->contenu !!}
                            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
