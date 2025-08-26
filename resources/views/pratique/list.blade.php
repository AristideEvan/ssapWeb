@extends('layouts.front')
@vite(['resources/js/xlab.js'])
<style>
    .truncate-text2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .main-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 15px;
        vertical-align: middle;
        border: none !important;
    }

    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        border-left: none;
        border-right: none;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table tbody tr:first-child td {
        border-top: none;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .badge-vedette {
        background-color: #ffc107;
        color: #212529;
        font-size: 0.75rem;
        margin-left: 8px;
    }

    .card-body {
        padding: 1.5rem;
    }

    h4 {
        color: #343a40;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .btn-details {
        background-color: #0d6efd;
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-details:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.25);
    }

    .btn-details i {
        font-size: 0.9rem;
    }

    /* Effet hover sur la ligne */
    .table tbody tr:hover {
        background-color: #f1f8ff;
        /* Bleu très clair */
    }

    /* Effet hover sur le bouton Détails */
    .btn-details:hover {
        background-color: #28a745;
        /* Vert */
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.25);
    }

    /* Pour que le bouton reste visible au survol de la ligne */

    .table tbody tr:hover .btn-details:hover {
        background-color: #28a745;
        /* Vert au survol direct */
        color: #fff
    }

    .table> :not(caption)>*>* {
        border-bottom-width: 0px !important;
    }
</style>

@section('content')
    <div class="container mt-5" style="min-height: 90vh !important;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{ __('Liste des pratiques') }}</h4>
            {{-- <div>
                <button class="btn btn-outline-secondary me-2">
                    <i class="fas fa-filter me-1"></i> {{ __('Filtrer') }}
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fas fa-download me-1"></i> {{ __('Exporter') }}
                </button>
            </div> --}}
        </div>

        <div class="main-card card">
            <div class="card-body table-responsive">
                <table id="example" class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>{{ __('Libellé') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Période') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pratiquesListe as $item)
                            <tr data-vedette="{{ $item->vedette ? $item->pratique_id : '' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <p class="truncate-text2 mb-0">{{ $item->pratiqueLibelle }}</p>
                                        @if ($item->vedette)
                                            <span class="badge badge-vedette">VEDETTE</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <p class="truncate-text2 mb-0">{{ $item->description }}</p>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item->periode }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('pratique.details', $item->pratique_id) }}" class="btn btn-details"
                                        title="Voir les détails">
                                        <i class="fas fa-eye"></i> Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
