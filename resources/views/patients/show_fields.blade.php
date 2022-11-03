


<!-- Name Field -->
<div class="form-group row col-6">
    {!! Form::label('name', 'Name:', ['class' => 'control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->UserName->name !!}</p>
    </div>
</div>

<!-- Email Field -->
<div class="form-group row col-6">
    {!! Form::label('email', 'Email:', ['class' => 'control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->UserName->email !!}</p>
    </div>
</div>

<!-- phone Field -->
<div class="form-group row col-6">
    {!! Form::label('phone_number', 'Phone:', ['class' => 'control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->UserName->phone_number !!}</p>
    </div>
</div>





====================================================




<!-- services Field -->
{{-- <div class="form-group row col-6">
    {!! Form::label('Services', trans("patient.Services"), ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        @foreach ($Booking as $Bookings)

           <p>{!! $Bookings->e_service !!}</p>

        @endforeach

    </div>
</div> --}}
<!-- Diseases Suffers From Id Field -->
<div class="form-group row col-6">
    {!! Form::label('Diseases Suffers From', trans("patient.Diseases_Suffers_From"), ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->diseases_suffers_from !!}</p>
    </div>
</div>

<!-- married Field -->
<div class="form-group row col-6">
    {!! Form::label('Married', trans("patient.Married"), ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->married !!}</p>
    </div>
</div>

<!-- age Field -->
<div class="form-group row col-6">
    {!! Form::label('Age', trans("patient.age"), ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->age !!}</p>
    </div>
</div>

<!-- medications takes Number Field -->
<div class="form-group row col-6">
    {!! Form::label('Medications Takes', trans("patient.Medications_Takes") , ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->medications_takes !!}</p>
    </div>
</div>

<!-- history operations Number Field -->
<div class="form-group row col-6">
    {!! Form::label('History Operations', trans("patient.History_Operations"), ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->history_operations !!}</p>
    </div>
</div>

<!-- user_id Field -->
<div class="form-group row col-6">
    {!! Form::label('User Name', trans("patient.user_name") , ['class' => ' control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $PatientMedicalsFile->UserName->name !!}</p>
    </div>
</div>


<!-- File Field -->
<div class="form-group row col-6">
    {!! Form::label('File', trans("patient.file") , ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <iframe src="{!! $PatientMedicalsFile->file !!}" style="height:600px;width:700px;" title="Iframe Example"></iframe>

    </div>
</div>


====================================================

@foreach ($Booking as $Bookings)

    {{-- <div class="form-group row col-6">
        {!! Form::label('Provider', trans("patient.Provider"), ['class' => ' control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $Bookings->e_provider !!}</p>
        </div>
    </div> --}}

    <div class="form-group row col-6">
        {!! Form::label('Service', trans("patient.Service"), ['class' => ' control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $Bookings->e_service !!}</p>
        </div>
    </div>

    {{-- <div class="form-group row col-6">
        {!! Form::label('Options', trans("patient.Options"), ['class' => ' control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $Bookings->options !!}</p>
        </div>
    </div> --}}

    <div class="form-group row col-6">
        {!! Form::label('booking_at', trans("patient.booking_at"), ['class' => ' control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $Bookings->booking_at !!}</p>
        </div>================================

    </div>

@endforeach



