@extends('layouts.template')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-none overflow-hidden">
                <div class="p-6 text-gray-900 mb-5">
                    {{ __("Dashboard") }}
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h3 class="badge badge-primary">{{ $statistiques['nb_pratiques'] }}</h3>
          
                          <p>{{ __("Toutes les pratiques") }}</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-chart-bar"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h3 class="badge badge-success">{{ $statistiques['nb_pratiques_publiques'] }}</h3>
          
                          <p>{{ __("Pratiques publiques") }}</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-eye"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h3 class="badge badge-warning">{{ $statistiques['nb_pratiques'] - $statistiques['nb_pratiques_publiques'] }}</h3>
          
                          <p>{{ __("Pratiques non publiées") }}</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-eye-slash"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h3 class="badge badge-info">{{ $statistiques['nb_utilisateurs_actifs'] }}</h3>
          
                          <p>{{ __("Utilisateurs actifs") }}</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                    <!-- ./col -->
                  </div>
           
                </div>
                <p>{{ __("Pratiques publiées par pays") }}</p>
                <div class="row mt-2">
                    @foreach ($statistiques['nb_pratiques_pays'] as $statistique)

                    <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box bg-light">
                        <div class="inner">
                          <h3>{{ $statistique->nb_pratiques_publiques }}</h3>
          
                          <p>{{ __($statistique->pays) }}</p>
                        </div>
                        <div class="icon">
                          {{-- <i class="fas fa-chart-bar"></i> --}}
                        </div>
                      </div>
                    </div>
                        
                    @endforeach
    
                </div>
        </div>
    </div>
@endsection
