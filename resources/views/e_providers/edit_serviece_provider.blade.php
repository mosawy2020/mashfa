
@extends('layouts.app')
@push('css_lib')
    <link rel="stylesheet" href="{{asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/dropzone/min/dropzone.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-bold">{{trans('lang.e_provider_plural') }}<small class="mx-3">|</small><small>{{trans('lang.e_provider_desc')}}</small>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fas fa-tachometer-alt"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{!! route('eProviders.index') !!}">{{trans('lang.e_provider_plural')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{trans('lang.e_service_provider_show')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        

        {{-- --}}
        <div class="clearfix"></div>
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex flex-row align-items-start card-header-tabs">
                    @can('eProviders.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('eProviders.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.e_provider_table')}}</a>
                        </li>
                    @endcan
                  
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fas fa-edit mr-2"></i>{{trans('lang.e_service_provider_show')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <div class="row" style="margin-left: 44px;margin-right: 44px;">
                    <a href="{{ route('eProviders.CreateEserviesProvider' , $eProvider->id) }}"  title="{{trans('lang.add')}}" class='btn btn-outline-primary col-md-2'> {{trans('lang.add')}}
                    </a>
               </div>

                {{-- start foreach --}}

                @forelse ($EproviderEservices as $EproviderEservice)

                        {!! Form::model($eProvider, ['route' => ['eProviders.UpdateEserviesProvider', $eProvider->id], 'method' => 'post']) !!}
                        {!! Form::hidden('ids',  $EproviderEservice->id) !!}

                                    
                        <div class="card-body">
                                        
                            <div class="row">


                                            <!-- E Provider Type Id Field -->
                                        <div  class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                                {!! Form::label('name', trans("lang.e_service"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                            <div class="col-md-9 eProviderTypeValue" style="width: 268px">
                                                {!! Form::select('e_services_id',$Eservices, [$EproviderEservice->e_services_id], ['class' => 'select2 form-control']) !!}
                                                <div class="form-text text-muted">{{ trans("lang.e_service") }}</div>
                                            </div>
                                        </div>



                                             <!-- Price Field -->
                                        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                               {!! Form::label('price', trans("lang.e_service_price"), ['class' => 'col-md-5 control-label text-md-right mx-1']) !!}
                                            <div class="col-md-11">
                                                <div class="input-group">
                                                    {!! Form::number('price' , $EproviderEservice->price ,null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_price_placeholder")]) !!}
                                                    <div class="input-group-append">
                                                        <div class="input-group-text text-bold px-3">{{setting('default_currency','$')}}</div>
                                                    </div>
                                                </div>
                                                <div class="form-text text-muted">
                                                    {{ trans("lang.e_service_price_help") }}
                                                </div>
                                            </div>
                                        </div> 

                                        {{-- 'ranking[' . $application->S_ID . ']', --}}
                                        <!-- Discount Price Field -->
                                        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                            {!! Form::label('discount_price', trans("lang.e_service_discount_price"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    {!! Form::number('discount_price',$EproviderEservice->discount_price, null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_discount_price_placeholder")]) !!}
                                                    <div class="input-group-append">
                                                        <div class="input-group-text text-bold px-3">{{setting('default_currency','$')}}</div>
                                                    </div>
                                                </div>
                                                <div class="form-text text-muted">
                                                    {{ trans("lang.e_service_discount_price_help") }}
                                                </div>
                                            </div>
                                        </div> 



                                            <!-- Duration Field -->
                                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                                {!! Form::label('duration', trans("lang.e_service_duration"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                                <div class="col-md-9">
                                                    <div class="input-group timepicker duration" data-target-input="nearest">
                                                        {!! Form::text('duration',$EproviderEservice->duration,  ['class' => 'form-control datetimepicker-input','placeholder'=>  trans("lang.e_service_duration_placeholder"), 'data-target'=>'.timepicker.duration','data-toggle'=>'datetimepicker','autocomplete'=>'off']) !!}
                                                        <div id="widgetParentId"></div>
                                                        <div class="input-group-append" data-target=".timepicker.duration" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fas fa-business-time"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-text text-muted">
                                                        {{ trans("lang.e_service_duration_help") }}
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- Quantity Unit Field -->
                                            <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                                {!! Form::label('quantity_unit', trans("lang.e_service_quantity_unit"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                                <div class="col-md-10">
                                                    {!! Form::text('quantity_unit',$EproviderEservice->quantity_unit,null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_quantity_unit_placeholder")]) !!}
                                                    <div class="form-text text-muted">
                                                        {{ trans("lang.e_service_quantity_unit_help") }}
                                                    </div>
                                                </div>
                                            </div>    
                                            
                                            
                                                <!-- Price Unit Field -->
                                            <div  class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                                {!! Form::label('price_unit', trans("lang.e_service_price_unit"),['class' => 'col-md-4 control-label text-md-right mx-1']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::select('price_unit', ['hourly' => trans('lang.e_service_price_unit_hourly'),'fixed'=> trans('lang.e_service_price_unit_fixed')], $EproviderEservice->price_unit, ['class' => 'select2 form-control']) !!}
                                                    <div class="form-text text-muted">{{ trans("lang.e_service_price_unit_help") }}</div>
                                                </div>
                                            </div> 

                            </div>


                                        <div>
                                            <button type="submit" class="btn bg-{{setting('theme_color')}} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
                                                <i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.e_provider')}}</button>

                                                <a style="margin: 10px" href="{!! route('eProvider_.DestroyEserviesProvider' ,  $EproviderEservice->id) !!}" class="btn btn-danger"> {{trans('lang.delete')}}</a>
                                            <a href="{!! route('eProviders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
                                        </div>


                        </div>

            
                        {!! Form::close() !!}
                    @empty
                        <h3 class="text-center" >{{ __('lang.no_data')}}</h3>
                @endforelse
                {{-- end foreach --}}


                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@push('scripts_lib')
    <script src="{{asset('vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('vendor/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('vendor/dropzone/min/dropzone.min.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>

    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>

<script>

    var $repeater = $('.repeater').repeater();

    var repeater = $('.repeater-default').repeater({
     initval: 1,
     });
</script>


<script>
    $('.select2').select2();

    $('.select2').on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });
</script>


@endpush


   