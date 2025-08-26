@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
    <div class="container-fluid">
        <div class="main-card card">
            <div class="card-header py-0">
                @php echo $controler->newFormButton($rub,$srub,'sol.create'); @endphp
                <h4 class="card-title">
                    {{__('Liste des sols')}}
                </h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover dataTable">
                    <thead>
                        <tr>
                            <th>{{__('Libellé du sol')}}</th>
                            <th>{{__('Description')}}</th>
                            <th>{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listeSols as $item)
                            <tr>
                                <td> {{ mb_convert_case(mb_strtolower($item->solLibelle, 'UTF-8'), MB_CASE_TITLE, 'UTF-8')}} </td>
                                <td>{{mb_strtolower($item->description ,'UTF-8')}}</td>
                                <td>
                                @php $route = 'route'; echo $controler->crudbody($rub,$srub,$route,'sol.edit','sol.destroy',$item->sol_id); @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
