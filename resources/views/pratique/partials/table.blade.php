        @foreach ($pratiques as $item)
            <tr data-publique="{{ $item->publique ? $item->pratique_id : '' }}"
                data-publique="{{ $item->publique ? $item->pratique_id : '' }}">
                <td>
                    <p class="truncate-text2">{{ $item->pratiqueLibelle }}</p>
                </td>
                <td>
                    <p class="truncate-text2">{{ $item->description }}</p>
                </td>
                <td>{{ formatCurrency($item->cout) }}</td>
                @if (canMakePublic(Auth::user()))
                    <td id="publique-{{ $item->pratique_id }}">
                        @if($item->publique)
                        <input type="checkbox" class="publique-checkbox" name="selected_pratiques[]" value="{{ $item->pratique_id }}">
                        @else
                        <input type="checkbox" checked disabled>
                        @endif

                    </td>
                @endif
                @php
                    $route = 'route';
                    echo $controler->crudbody(
                        $rub,
                        $srub,
                        $route,
                        'pratique.edit',
                        'pratique.destroy',
                        $item->pratique_id,
                        'pratique.show',
                    );
                @endphp
            </tr>
        @endforeach
