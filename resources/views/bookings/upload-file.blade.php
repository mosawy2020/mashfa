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
                    <h1 class="m-0 text-bold">{{trans('lang.booking_plural') }}<small class="mx-3">|</small><small>{{trans('lang.upload_file')}}</small>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fas fa-tachometer-alt"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{!! route('eProviders.index') !!}">{{trans('lang.booking_plural')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{trans('lang.upload_file')}}</li>
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
                            <a class="nav-link" href="{!! route('eProviders.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.booking_plural')}}</a>
                        </li>
                    @endcan
                  
                    <li class="nav-item">
                    </li>
                </ul>
            </div>
            <div class="card-body">

               
                {!! Form::model($uploadFile, ['route' => ['booking.StoreReservationFile', $uploadFile->id], 'method' => 'post' , 'enctype' => 'multipart/form-data']) !!}

                

                <div class="card-body">

                                <div class="container">

                                           <div class="row">
                                                        <!-- upload_file To Field -->
                                                        <div style="margin-bottom: 60px" class="form-group align-items-baseline d-flex flex-column flex-md-row">
                                                            {!! Form::label('name', trans("lang.upload_file"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
                                                            <div class="col-md-9 eProviderTypeValue">
                                                                {!! Form::file('upload_file') !!}
                                                            </div>
                                                        </div>
                                                

                                                </div>
                                </div>

                            <div>
                                <button type="submit" class="btn bg-{{setting('theme_color')}} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
                                    <i class="fa fa-save"></i> {{trans('lang.save')}}</button>
                                <a href="{!! route('bookings.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
                            </div>


                </div>
                {!! Form::close() !!}
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

@endpush


   
