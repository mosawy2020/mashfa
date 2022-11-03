

@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-bold">{{trans('lang.e_provider_plural') }}<small class="mx-3">|</small><small>{{trans('lang.e_service_desc')}}</small>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="fas fa-tachometer-alt"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-itema ctive"><a href="{!! route('eProviders.index') !!}">{{trans('lang.e_provider_plural')}}</a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex flex-row align-items-start card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="{!! route('eServices.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.e_service_desc')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{trans('lang.e_service_show')}}
                        </a>
                    </li>
                </ul>
            </div>

            @forelse ($Eservices as $Eservicess)

                    <div class="card-body">
                        <div class="row">

                                
                                    {{-- price --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('price', trans("lang.e_service_price"), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->price !!}</p>
                                    </div>
                                </div>

                                {{-- discount_price --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('discount_price', trans("lang.e_service_discount_price"), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->discount_price !!}</p>
                                    </div>
                                </div>

                                {{-- price_unit --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('price_unit',  trans("lang.e_service_price_unit"), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->price_unit !!}</p>
                                    </div>
                                </div>


                                {{-- quantity_unit --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('quantity_unit', trans("lang.e_service_quantity_unit"), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->quantity_unit !!}</p>
                                    </div>
                                </div>

                                {{-- duration --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('duration', trans("lang.e_service_duration"), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->duration !!}</p>
                                    </div>
                                </div>

                                {{-- name Services --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('name', __('lang.name_'), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->EServiceType->name !!}</p>
                                    </div>
                                </div>

                                {{-- description Services --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('description', __('lang.e_service_description'), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->EServiceType->description !!}</p>
                                    </div>
                                </div>

                                {{-- created Services --}}
                                <div class="form-group row col-6">
                                    {!! Form::label('created_at', __('lang.user_created_at'), ['class' => 'col control-label text-md-right mx-1']) !!}
                                    <div class="col-md-9">
                                        <p>{!! $Eservicess->EServiceType->created_at !!}</p>
                                    </div>
                                </div>

                            



                            <div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center">
                                    <a style="margin-right: 15px;margin-left: 15px ; height: 34px; margin-top:5px " title="{{trans('lang.e_service_edit')}}" href="{{ route('eServices.edit', $Eservicess->id) }}" class="btn btn-primary btn-sm">{{trans('lang.e_service_edit')}}</a>
                                    {{-- <a title="{{trans('lang.e_service_delete')}}" href="{{ route('eServices.destroy', $Eservicess->id) }}" class="btn btn-danger">{{trans('lang.e_service_delete')}}</a> --}}
                                    {!! Form::open(['route' => ['eServices.destroy', $Eservicess->id], 'method' => 'delete']) !!} {!! Form::button('<a  class="btn btn-danger btn-sm">Delete Eservice</a>', [ 'type' => 'submit', 'class' => 'btn btn-link text-danger', 'onclick' => "return confirm('Are you sure?')" ]) !!} {!! Form::close() !!}
                            </div>

                          

                            <div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
                            </div>


                        </div>
                        <div class="clearfix"></div>
                    </div>

                @empty
                        
                        <div class="form-group row col-6">
                            <h4 style="text-align: center ; margin-top: 20px">{{ __('lang.no_data_Eservices_eProviders') }}</h4>
                        </div>

            @endforelse


                    <div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center">
                        <a href="{!! route('eProviders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.back')}}</a>
                    </div>
        </div>
    </div>
@endsection

