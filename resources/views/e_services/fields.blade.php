@if(isset($customFields))
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
{{--    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">--}}
{{--        {!! Form::label('name', trans("lang.e_service_name"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}--}}
{{--        <div class="col-md-9">--}}
{{--            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_name_placeholder")]) !!}--}}
{{--            <div class="form-text text-muted">--}}
{{--                {{ trans("lang.e_service_name_help") }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Categories Field -->
{{--    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">--}}
{{--        {!! Form::label('categories[]', trans("lang.e_service_categories"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}--}}
{{--        <div class="col-md-9">--}}
{{--            {!! Form::select('categories[]', $category, $categoriesSelected, ['class' => 'select2 form-control not-required' , 'data-empty'=>trans('lang.e_service_categories_placeholder'),'multiple'=>'multiple']) !!}--}}
{{--            <div class="form-text text-muted">{{ trans("lang.e_service_categories_help") }}</div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- E Provider Id Field -->
    @if(!isset($static_provider_id))
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
            {!! Form::label('e_provider_id', trans("lang.e_service_e_provider_id"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
            <div class="col-md-9">
                {!! Form::select('e_provider_id', $eProvider, null, ["id"=>"provider_id",'class' => 'select2 form-control']) !!}
                <div class="form-text text-muted">{{ trans("lang.e_service_e_provider_id_help") }}</div>
            </div>
        </div>
    @else
        {!! Form::text('e_provider_id', $static_provider_id,  ["id"=>'provider_id','hidden'=>true,'class' => 'form-control datetimepicker-input','placeholder'=>  trans("lang.e_service_duration_placeholder"), 'data-target'=>'.timepicker.duration','data-toggle'=>'datetimepicker','autocomplete'=>'off']) !!}

    @endif
   <!-- Eservicetype Field -->
    <div class="etypes form-group align-items-baseline d-flex flex-column flex-md-row " >
        {!! Form::label('e_service_type_id', trans("lang.e_service_type"),[ 'class' => ' col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('e_service_type_id', $Eservicestypes, $typesSelected, ["id" => "estypes" , 'class' => ' select2 form-control not-required' , 'data-empty'=>trans('lang.e_service_types_placeholder')]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_service_categories_help") }}</div>
        </div>
    </div>

    <!-- Price Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('price', trans("lang.e_service_price"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('price', null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_price_placeholder")]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">{{setting('default_currency','$')}}</div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_price_help") }}
            </div>
        </div>
    </div>

    <!-- Discount Price Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('discount_price', trans("lang.e_service_discount_price"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('discount_price', null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_discount_price_placeholder")]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">{{setting('default_currency','$')}}</div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_discount_price_help") }}
            </div>
        </div>
    </div>

{{--    <!-- Price Unit Field -->--}}
{{--    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">--}}
{{--        {!! Form::label('price_unit', trans("lang.e_service_price_unit"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}--}}
{{--        <div class="col-md-9">--}}
{{--            {!! Form::select('price_unit',['hourly' => trans('lang.e_service_price_unit_hourly'),'fixed'=> trans('lang.e_service_price_unit_fixed')], null, ['class' => 'select2 form-control']) !!}--}}
{{--            <div class="form-text text-muted">{{ trans("lang.e_service_price_unit_help") }}</div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Quantity Unit Field -->--}}
{{--    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">--}}
{{--        {!! Form::label('quantity_unit', trans("lang.e_service_quantity_unit"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}--}}
{{--        <div class="col-md-9">--}}
{{--            {!! Form::text('quantity_unit', null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_quantity_unit_placeholder")]) !!}--}}
{{--            <div class="form-text text-muted">--}}
{{--                {{ trans("lang.e_service_quantity_unit_help") }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Duration Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('duration', trans("lang.e_service_duration"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group  duration">
                {!! Form::text('duration', null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_duration_placeholder"),'autocomplete'=>'off']) !!}
                <div id="widgetParentId"></div>
{{--                <div class="input-group-append" data-target=".timepicker.duration" data-toggle="datetimepicker">--}}
{{--                    <div class="input-group-text"><i class="fas fa-business-time"></i></div>--}}
{{--                </div>--}}
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_duration_help") }}
            </div>
        </div>
    </div>


</div>
<div class="d-flex flex-column col-sm-12 col-md-6">

    <!-- Image Field -->
    <div class="form-group align-items-start d-flex flex-column flex-md-row">
        {!! Form::label('image', trans("lang.e_service_image"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div style="width: 100%" class="dropzone image" id="image" data-field="image">
            </div>
            <a href="#loadMediaModal" data-dropzone="image" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-{{setting('theme_color','primary')}} btn-sm float-right mt-1">{{ trans('lang.media_select')}}</a>
            <div class="form-text text-muted w-50">
                {{ trans("lang.e_service_image_help") }}
            </div>
        </div>
    </div>
    @prepend('scripts')
        <script type="text/javascript">
            var var16110647911349350349ble = [];
            @if(isset($eService) && $eService->hasMedia('image'))
            @forEach($eService->getMedia('image') as $media)
            var16110647911349350349ble.push({
                name: "{!! $media->name !!}",
                size: "{!! $media->size !!}",
                type: "{!! $media->mime_type !!}",
                uuid: "{!! $media->getCustomProperty('uuid'); !!}",
                thumb: "{!! $media->getFirstMediaUrl('thumb'); !!}",
                collection_name: "{!! $media->collection_name !!}"
            });
            @endforeach
            @endif
            var dz_var16110647911349350349ble = $(".dropzone.image").dropzone({
                url: "{!!url('uploads/store')!!}",
                addRemoveLinks: true,
                maxFiles: 5 - var16110647911349350349ble.length,
                init: function () {
                    @if(isset($eService) && $eService->hasMedia('image'))
                    var16110647911349350349ble.forEach(media => {
                        dzInit(this, media, media.thumb);
                    });
                    @endif
                },
                accept: function (file, done) {
                    dzAccept(file, done, this.element, "{!!config('medialibrary.icons_folder')!!}");
                },
                sending: function (file, xhr, formData) {
                    dzSendingMultiple(this, file, formData, '{!! csrf_token() !!}');
                },
                complete: function (file) {
                    dzCompleteMultiple(this, file);
                    dz_var16110647911349350349ble[0].mockFile = file;
                },
                removedfile: function (file) {
                    dzRemoveFileMultiple(
                        file, var16110647911349350349ble, '{!! url("eServices/remove-media") !!}',
                        'image', '{!! isset($eService) ? $eService->id : 0 !!}', '{!! url("uploads/clear") !!}', '{!! csrf_token() !!}'
                    );
                }
            });
            dz_var16110647911349350349ble[0].mockFile = var16110647911349350349ble;
            dropzoneFields['image'] = dz_var16110647911349350349ble;
            // <script>

                $(document).ready(function(){
                    function gettypes(){     jQuery.ajax({
                        url: "{{route('eServiceTypes.namesindex')}}",
                        method: 'get',
                        async:true,
                        data: {
                        },
                        success: function(result){
                             var new_options = result.data ;
                            /* Remove all options from the select list */
                            $('#estypes').empty();
                            /* Insert the new ones from the array above */
                            $.each( new_options, function( index, value ){
                                 $('#estypes').append($("<option></option>").attr("value",index).text(value));

                            });
                        }}
                    );

                    }
                    function handleetype() {
                         gettypes();
                         var  e_provider =  $("#provider_id").val() ;
                         jQuery.ajax({
                            url: "{{route('eProviders.show' , '')}}"+"/" + e_provider,
                            method: 'get',
                            // async:false,
                            data: {
                                // e_provider:"hh"
                            },
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(result){
                                 if (result.eProvider.eprovider_type.name =="Doctor") {$("#estypes").val('1').change();
                                    $("#estypes").attr("disabled",true) ;
                                }
                                else {
                                    $("#estypes").attr("disabled",false) ;
                                    $("#estypes option[value='1']").remove();
                                }
                            }});
                      }
                 $('#formid').on('submit', function() {
                        $('#estypes').prop('disabled', false);
                    });
                     handleetype() ;
                    $("#provider_id").on("change",
                        function (e) {
                        handleetype() ;
                        }

                    ) ;
             });
{{--        </script>--}}



        </script>
@endprepend
<!-- Description Field -->
{{--    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">--}}
{{--        {!! Form::label('description', trans("lang.e_service_description"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}--}}
{{--        <div class="col-md-9">--}}
{{--            {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>--}}
{{--             trans("lang.e_service_description_placeholder")  ]) !!}--}}
{{--            <div class="form-text text-muted">{{ trans("lang.e_service_description_help") }}</div>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>
@if(isset($customFields))
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif
<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('featured', trans("lang.e_service_featured"),['class' => 'control-label my-0 mx-3']) !!}
        {!! Form::hidden('featured', 0, ['id'=>"hidden_featured"]) !!}
{{--        <span class="icheck-{{setting('theme_color')}}">--}}
                     {!! Form::checkbox('featured', 1, null,['onclick'=>"$(this).val(this.checked ? 1 : 0)"]) !!} <label for="featured"></label>
{{--        </span>--}}
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!!  Form::label('enable_booking', trans("lang.e_service_enable_booking"),['class' => 'control-label my-0 mx-3'], false)  !!}
        {!! Form::hidden('enable_booking', 0, ['id'=>"hidden_enable_booking"]) !!}
{{--        <span class="icheck-{{setting('theme_color')}}">--}}
             {!! Form::checkbox('enable_booking', 1, null,['onclick'=>"$(this).val(this.checked ? 1 : 0)"]) !!} <label for="enable_booking"></label>
        </span>
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('available', trans("lang.e_service_available"),['class' => 'control-label my-0 mx-3']) !!}
        {!! Form::hidden('available', 0, ['id'=>"hidden_available"]) !!}
{{--        <span class="icheck-{{setting('theme_color')}}">--}}
        {!! Form::checkbox('available', 1, null,['onclick'=>"$(this).val(this.checked ? 1 : 0)"]) !!} <label for="available"></label>
{{--        </span>--}}
    </div>
    <button type="submit" class="btn bg-{{setting('theme_color')}} mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.e_service')}}</button>
    <a href="{!! route('eServices.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
