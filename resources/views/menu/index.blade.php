@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
    <div class="container-fluid">
        <div class="main-card card">
            <div class="card-header py-0">
                @php echo $controler->newFormButton($rub,$srub,'menu.create'); @endphp
                <h4 class="card-title">
                    {{__('Liste des menus')}}
                </h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover dataTable">
                    <thead >
                        <tr>
                            <th>Menu</th>
                            <th>Parent</th>
                            <th>{{__('lien')}} </th>
                            <th>{{__('Interface')}} </th>
                            <th>{{__('Ordre')}} </th>
                            <th>{{__('Icone')}} </th>
                            <th>{{__('visible')}} </th>
                            @php echo $controler->crudheader($rub,$srub); @endphp
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listeMenus as $item)
                            <tr>
                                <td>{{$item->nomMenu}}</td>
                                <td>{{$item->nomParent}}</td>
                                <td>{{$item->lien}}</td>
                                <td>@if($item->interface==1) BACK-END @elseif($item->interface==2) FRONT-END @else BACK-END & FRONT-END @endif</td>
                                <td>{{$item->ordre}}</td>
                                <td><i class="{{$item->icon}}"></i> {{$item->icon}}</td>
                                <td><input type="checkbox" name="visible{{$item->id}}" id="/setVisibleMenu/{{$item->id}}" value="{{$item->id}}"
                                        @if($item->visible) checked @endif
                                    
                                     onclick="setVisible(this.id)">
                                </td>
                                @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'menu.edit','menu.destroy',$item->id); @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection