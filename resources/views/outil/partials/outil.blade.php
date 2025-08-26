@foreach ($outils as $outil)
    <div class="tool-card">
        <a href="{{ route('outils.details', $outil->id) }}" class="text-decoration-none text-dark">
            <div class="tool-card-img-container">
                @if($outil->image_path)
                    <img src="{{ asset('storage/' . $outil->image_path) }}" alt="{{ $outil->titre }}" loading="lazy">
                @else
                    <img src="https://via.placeholder.com/300x160?text=Outil" alt="Image par défaut" loading="lazy">
                @endif
            </div>
            <div class="card-body">
                <span class="badge-custom">{{ $outil->typeOutil->typeoutilLibelle }}</span>
                <h5 class="card-title">{{ Str::limit($outil->titre, 40) }}</h5>
                <button class="btn btn-details">Voir détails</button>
            </div>
        </a>
    </div>
@endforeach

@if(isset($message) && $message)
    <p class="text-center text-muted mt-4">{{ $message }}</p>
@endif