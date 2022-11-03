<div class='btn-group btn-group-sm'>
    {{-- @can('eProviders.show')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.view_details')}}" href="" class='btn btn-link'>
            <i class="fas fa-eye"></i> </a>
    @endcan --}}

    

    @can('e_Providers.ShowService')

    <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.e_service_show')}}"
            href="{{ route('eServices.index' , ["e_provider_id"=>$id] ) }}" class='btn btn-link'>
        <i class="fas fa-diagnoses"></i> </a>

    @endcan

    @can('eProviders.EditServiesProvider')

    <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.e_service_provider_show')}}"
            href="{{ route('eServices.create' , ["provider_id"=>$id] ) }}" class='btn btn-link'>
        <i class="fas fa-address-card"></i> </a>

    @endcan

    @can('eProviders.edit')

    
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.e_provider_edit')}}" href="{{ route('eProviders.edit', $id) }}" class='btn btn-link'>
            <i class="fas fa-edit"></i> </a>
    @endcan

    @can('eProviders.destroy')
        {!! Form::open(['route' => ['eProviders.destroy', $id], 'method' => 'delete']) !!}
        {!! Form::button('<i class="fas fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-link text-danger',
        'onclick' => "return confirm('Are you sure?')"
        ]) !!}
        {!! Form::close() !!}
    @endcan
</div>
