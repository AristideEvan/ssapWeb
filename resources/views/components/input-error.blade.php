@props(['messages'])

@if ($messages)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $messages }}</strong>
    </span>
    {{-- <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul> --}}
@endif
