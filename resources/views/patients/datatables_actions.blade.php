<div class='btn-group btn-group-sm'>
    @can('PatientMedical.show')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.view_details')}}" href="{{ route('PatientMedical.show', $id) }}" class='btn btn-link'>
            <i class="fas fa-eye"></i> </a> @endcan

    @can('PatientMedical.edit')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.category_edit')}}" href="{{ route('PatientMedical.edit', $id) }}" class='btn btn-link'>
            <i class="fas fa-edit"></i> </a> @endcan

    @can('PatientMedical.destroy') {!! Form::open(['route' => ['PatientMedical.destroy', $id], 'method' => 'delete']) !!} {!! Form::button('<i class="fas fa-trash"></i>', [ 'type' => 'submit', 'class' => 'btn btn-link text-danger', 'onclick' => "return confirm('Are you sure?')" ]) !!} {!! Form::close() !!} @endcan
</div>
