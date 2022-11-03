{{-- @if($PatientMedicalFile)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
    {{-- <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('services', trans("patient.Services"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('services', null,  ['class' => 'form-control','placeholder'=>  trans("patient.Services")]) !!}
            <div class="form-text text-muted">
            </div>
        </div>
    </div> --}}

    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('Diseases Suffers From', trans("patient.Diseases_Suffers_From"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('diseases_suffers_from', null,  ['class' => 'form-control','placeholder'=>   trans("patient.Diseases_Suffers_From")]) !!}
            <div class="form-text text-muted">
            </div>
        </div>
    </div>

    <!-- Color Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('Married', trans("patient.Married"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('married', ['YES' => 'YES', 'NO' => 'NO'] , null,  ['class' => 'form-control','placeholder'=>  trans("")]) !!}
            <div class="form-text text-muted">

            </div>
        </div>
    </div>


    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('age', trans("patient.age"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::number('age', null,  ['class' => 'form-control','placeholder'=>  trans("patient.age")]) !!}
            <div class="form-text text-muted">

            </div>
        </div>
    </div>


    
    

    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('medications_takes', trans("patient.Medications_Takes"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::textarea('medications_takes', null,  ['class' => 'form-control','step'=>'1','min'=>'0', 'placeholder'=>   trans("patient.Medications_Takes")]) !!}
            <div class="form-text text-muted">

            </div>
        </div>
    </div>


    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('history_operations',  trans("patient.History_Operations"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::textarea('history_operations', null,  ['class' => 'form-control','step'=>'1','min'=>'0', 'placeholder'=>  trans("patient.History_Operations")]) !!}

            
            </div>
        </div>
    </div>


    
    
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
       
      
           {{-- <iframe src="{!! $PatientMedicalFile->file !!}" style="height:500px;width:700px;" title="Iframe Example"></iframe> --}}
        {!! Form::label('File',trans("patient.file"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::file('file', null,  ['class' => 'form-control','step'=>'1','min'=>'0', 'placeholder'=>   trans("patient.file")]) !!}

            
            </div>
       
      
        </div>
    </div>



</div>

    
</div>






<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('featured', trans("patient.Featured_Patient"),['class' => 'control-label my-0 mx-3'],false) !!} {!! Form::hidden('featured', 0, ['id'=>"hidden_featured"]) !!}
        <span class="icheck-{{setting('theme_color')}}">
            {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
    </div>
    <button type="submit" class="btn bg-{{setting('theme_color')}} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{trans('patient.save_Patient')}} 
    </button>
    <a href="{!! route('categories.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
