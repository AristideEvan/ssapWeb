@extends('layouts.'.getTemplate($rub,$srub))

@section('content')
<div class="container-fluid">
    <div class="main-card card">
        <div class="card-header py-0">
            @php echo $controler->newFormButton($rub, $srub,'faq.create'); @endphp
            <h4>{{ __('Liste des FAQs') }}</h4>
        </div>
    <div class="card-body table-responsive">
        <table id="example" class="table table-striped table-bordered table-hover dataTable">
            <thead >
                <tr>
                    <th>{{__('question')}} </th>
                    <th>{{__('reponse')}} </th>
                    @php echo $controler->crudheader($rub, $srub); @endphp
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $item)
                    <tr>
                        <td>{{$item->question}}</td>
                        <td>{{$item->reponse}}</td>
                        @php $route = 'route'; echo $controler->crudbody($rub, $srub, $route,'faq.edit','faq.destroy',$item->id); @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
    {{-- <a href="/exportExcelCause" >
        <button class="btn btn-primary btnEnregistrer">{{ __('liste.exporter') }}</button>
    </a> --}}
</div>
@endsection