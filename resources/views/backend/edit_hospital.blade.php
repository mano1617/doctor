@extends('backend.layouts.app')

@section('title', app_name() . ' | Edit Hospital' )

@push('after-styles')
<link rel="stylesheet" href="{{ asset('assets/backend/jquery.steps/jquery.steps.css') }}">
<style>
/* .wizard>.content{display:block;min-height:35em;overflow-y: auto;position:relative} */

.wizard .content {
    min-height: 100px;
}
.wizard .content > .body {
    width: 100%;
    height: auto;
    padding: 15px;
    position: relative;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Edit Hospital</strong>
                <a href="{{ route('admin.hospitals.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK
                </a>
            </div>
            <div class="card-body">
            <br>
                <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.hospitals.update',$data->id) }}">
                {{csrf_field()}}
{{ method_field('PUT') }}

                    <div>
                        <h3>Profile</h3>
                        <section>
                        <br>
                        <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Name of Hospital<sup class="text-danger">*</sup></label>
                            <input type="text" name="name" required class="form-control" value="{{ $data->name }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Established Since<sup class="text-danger">*</sup></label>
                            <select name="since" class="form-control">
                            @for($i=0;$i<=100;$i++)
                                <option @if($data->since==(date('Y')-$i)) selected @endif value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                            @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="address">Address<sup class="text-danger">*</sup></label>
                            <textarea name="cli_address" required class="form-control" >{{ $data->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="landmark">Land Mark</label>
                            <textarea name="cli_landmark" class="form-control" >{{ $data->landmark }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="country">Country<sup class="text-danger">*</sup></label>
                            <select required name="cli_country" id="cli_country" class="form-control">
                                <option value="">--select--</option>
                                @foreach($countries as $ck => $country)
                                <option @if($data->country==$country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="state">State<sup class="text-danger">*</sup></label>
                            <select required name="cli_state" id="cli_state" class="form-control">
                                <option value="">--select--</option>
                                @foreach($states as $sk => $state)
                                <option @if($data->state==$state->id) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="district">District<sup class="text-danger">*</sup></label>
                            <select required name="cli_district" id="district" class="form-control">
                                <option value="">--select--</option>
                                @foreach($cities as $ck)
                                <option @if($data->district==$ck->id) selected @endif value="{{ $ck->id }}">{{ $ck->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="pincode">PIN code<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $data->pincode }}" required data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" name="cli_pincode" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $data->mobile_no }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cli_mobile_no" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="cli_email">Email Id<sup class="text-danger">*</sup></label>
                            <input type="email" value="{{ $data->email_address }}" required name="cli_email" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Website</label>
                            <input type="text" value="{{ $data->website }}" data-rule-url="true"  name="cli_website" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Profile Photo</label>
                            <input type="file" name="photo">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="about_us">About Us</label>
                            <textarea name="cli_about_us" class="form-control" >{{ $data->about_us }}</textarea>
                        </div>
                    </div>
                </div>
                @php
                    $cnts = unserialize($data->contact_numbers);
                    $clWorkingDays = $data->workingDays()->get();
                @endphp
                <h6>Contact Numbers:</h6>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="landno">Name/Designation<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $cnts[0]['name'] }}" required name="cnt_name_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="landno">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $cnts[0]['number'] }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="hidden" name="rows" value="{{ count($cnts) }}">
                            <a href="javascript:void(0);" id="addRow" class="btn btn-sm btn-success" style="margin-top:30px;"><i class="fa fa-fw fa-plus"></i>ADD</a>
                        </div>
                    </div>
                </div>
                <div id="cnt_divs">
                @foreach($cnts as $ck => $cval)
                @php
                    if($ck==0)
                    {
                        continue;
                    }
                @endphp
                <div class="row" id="cnt_row_{{ ($ck+1) }}">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="landno">Name/Designation<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $cval['name'] }}" required name="cnt_name_{{ ($ck+1) }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="landno">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $cval['number'] }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_{{ ($ck+1) }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <a style="margin-top:30px;" data-container="#cnt_row_{{ ($ck+1) }}" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
                </div>

                        <hr />
                        <h6>Working Days and Time schedule:</h6>
                        <h6 class="text-danger">Note:</h6>
                        <p>If no day selection, leave as blank all inputs.</p>
                        @foreach($days as $kday => $day)
                            @php
                                $keyDay='';
                                $clWorkingDay = $clWorkingDays->where('day_name',$kday);
                                if(count($clWorkingDay)>0)
                                {
                                    $keys = $clWorkingDay->keys();
                                    $keyDay = $clWorkingDay[$keys[0]]['day_name'];

                                    $mornTime = ['', ''];
                                    $evenTime = ['', ''];

                                    if(trim($clWorkingDay[$keys[0]]['morning_session_time'])!='')
                                    {
                                        $mornTime = explode('-',trim($clWorkingDay[$keys[0]]['morning_session_time']));
                                    }
                                    
                                    if(trim($clWorkingDay[$keys[0]]['evening_session_time'])!='')
                                    {
                                        $evenTime = explode('-',trim($clWorkingDay[$keys[0]]['evening_session_time']));
                                    }
                                }
                            @endphp
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label style="margin-top:17px;">
                                    <input type="checkbox" @if(count($clWorkingDay)>0 && $keyDay==$kday) checked @endif value="{{ $kday }}" class="wrk_day" name="wrk_day_{{ $kday }}"> {{$day}}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cli_{{ $kday }}_mst"></label>
                                    <select name="cli_{{ $kday }}_mst" class="form-control removeSel">
                                        <option value="">--select--</option>
                                        @for($i=0;$i<=11;$i++)
                                        <option @if(count($clWorkingDay)>0 && $mornTime[0]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2" style="border-right:1px solid #000;">
                                <div class="form-group">
                                    <label for="cli_{{ $kday }}_med"></label>
                                    <select name="cli_{{ $kday }}_med" class="form-control removeSel">
                                        <option value="">--select--</option>
                                        @for($i=1;$i<=12;$i++)
                                        <option @if(count($clWorkingDay)>0 && $mornTime[1]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cli_{{ $kday }}_nst"></label>
                                    <select name="cli_{{ $kday }}_nst" class="form-control removeSel">
                                        <option value="">--select--</option>
                                        @for($i=12;$i<=23;$i++)
                                        <option @if(count($clWorkingDay)>0 && $evenTime[0]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cli_{{ $kday }}_ned"></label>
                                    <select name="cli_{{ $kday }}_ned" class="form-control removeSel">
                                        <option value="">--select--</option>
                                        @for($i=13;$i<=24;$i++)
                                        <option  @if(count($clWorkingDay)>0 && $evenTime[1]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(trim($data->other_description)!='') checked @endif name="wrk_times_others" value="1"> Others</label>
                                    <textarea class="form-control" name="cli_wrk_others" cols="30" rows="5">{{trim($data->other_description)}}</textarea>
                                </div>
                            </div>
                        </div>
                        </section>
                        <h3>Achievements</h3>
                        <section>
                        <br>
                        <input type="hidden" name="ach_rows" value="{{ $data->achievements()->count() }}">
                        <div id="achDiv">
                            @if($data->achievements()->count()>0)
                                @foreach($data->achievements as $ack => $aval)
                            <div class="row" id="ach_row_{{ $ack+1 }}">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <textarea name="ach_{{ $ack+1 }}" placeholder="About Achievements" cols="30" rows="5" class="form-control">{{ $aval->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if($ack==0)
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus"></i>ADD</a>
                                    @else
                                    <a style="margin-top:30px;" data-container="#ach_row_{{ $ack+1 }}" class="btn btn-sm removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                    @endif
                                </div>
                            </div>
                                @endforeach
                            @else
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <textarea name="ach_1" placeholder="About Achievements" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus"></i>ADD</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        </section>

                        <h3>Branches</h3>
                        <section>
                        <br />
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sector">Have Branches<sup class="text-danger">*</sup></label>
                                        <div class="col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($data->is_branch==1) checked @endif name="clinic_br_detail" id="inline_br_radio11" type="radio" value="1">
                                                <label class="form-check-label" for="inline_br_radio11">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($data->is_branch==0) checked @endif name="clinic_br_detail" id="inline_br_radio22" type="radio" value="0" >
                                                <label class="form-check-label" for="inline_br_radio22">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </form>
            </div>
        </div><!--card-->
    </div><!--col-->
</div><!--row-->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/backend/jquery.steps/jquery.steps.min.js') }}"></script>
<script>
$(function()
{
    $("#addAchiev").on("click", function(e)
    {
        var row = parseInt($("input[name='ach_rows']").val());
        row++;
        var content = '<div id="ach_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group">';
            content+= '<textarea name="ach_'+row+'" placeholder="About Achievements / Designations" cols="30" rows="5" class="form-control"></textarea></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#ach_row_'+row+'" class="btn btn-sm removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';
        $("input[name='ach_rows']").val(row);
        $("#achDiv").append(content);

    });

    $("#addRow").on("click", function(e)
    {
        var row = parseInt($("input[name='rows']").val());
        row++;
        var content = '<div id="cnt_row_'+row+'"><div class="row"><div class="col-sm-5"><div class="form-group"><label for="name_desig_'+row+'">Name/Designation</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required name="cnt_name_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-5"><div class="form-group"><label for="mob_no_'+row+'">Mobile Number</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-2"><a style="margin-top:30px;" data-container="#cnt_row_'+row+'" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='rows']").val(row);
        $("#cnt_divs").append(content);
    });

    $("body").on("click", ".removeContainer", function(e)
    {
        $("body "+$(this).data('container')).remove();
    });

    $(".wrk_day").on("change", function(e)
    {
        if($(this).is(':checked'))
        {
            //$("input[name='cli_"+$(this).val()+"_mst'], input[name='cli_"+$(this).val()+"_med'], input[name='cli_"+$(this).val()+"_nst'], input[name='cli_"+$(this).val()+"_ned']").attr("required","required");
        }else{
            //$("input[name='cli_"+$(this).val()+"_mst'], input[name='cli_"+$(this).val()+"_med'], input[name='cli_"+$(this).val()+"_nst'], input[name='cli_"+$(this).val()+"_ned']").removeAttr("required");
        }

        form.resetForm();
        //$("span.error").hide();
        //$(".error").removeClass("error");
    });

    $("#cli_state").on("change", function(e)
    {
        var content = '<option value="">--select--</option>';

        if($.trim($(this).val())=='')
        {
            $("#district").html(content);

        }else{
            $.get("{{ url('admin/list/districts') }}",{stateId:$(this).val()},function(result)
            {
                if(result['data'].length>0)
                {
                    $(result['data']).each(function(ind,vals)
                    {
                        // if(vals.id==18)
                        // {
                            content+='<option value="'+vals.id+'">'+vals.name+'</option>';
                        //}
                    });
                }

                $("#district").html(content);

            },'JSON');
        }
    });

    $("#cli_country").on("change", function(e)
    {
        var content = '<option value="">--select--</option>';

        if($.trim($(this).val())=='')
        {
            $("#cli_state").html(content);

        }else{
            $.get("{{ url('admin/list/states') }}",{countryId:$(this).val()},function(result)
            {
                if(result['data'].length>0)
                {
                    $(result['data']).each(function(ind,vals)
                    {
                        content+='<option value="'+vals.id+'">'+vals.name+'</option>';
                    });
                }

                $("#cli_state").html(content);

            },'JSON');
        }
    });

    var form = $("#createPhysician").validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        cli_name : {
            // remote: {
            //             url: "{{ route('admin.physician.checkEmail') }}",
            //             type: "post",
            //             data : {
            //                 '_token' : function() { return '{{ csrf_token() }}' }
            //                 }
            //         }
        }
    },
    messages : {
        cli_name : {
            remote : 'The email address is already exists'
        }
    },
    errorElement: "span",
    errorPlacement: function(error, element) {
        $(".submit").attr("disabled", false);
        error.addClass("error invalid-feedback");
        //error.parent("div.form-group").addClass("has-error");
        element.parent("div.form-group").append(error);
        element.addClass('is-invalid');
    },
    highlight: function(element, errorClass, validClass) {
        $(element).addClass("is-invalid");
        $(".submit").attr("disabled", false);
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass("is-invalid");
        $(".submit").attr("disabled", false);
    },
    // submitHandler: function(form) { // <- pass 'form' argument in
    //     $(".submit").attr("disabled", true);
    //     form.submit(); // <- use 'form' argument here.
    // }
});

});
function Validate(event) {
    var regex = new RegExp("^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}


jQuery.validator.addMethod("regex", function(value, element) {
  // allow any non-whitespace characters as the host part
  return this.optional( element ) || /^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/.test( value );
}, 'Please enter a valid email address.');

$.validator.addMethod(
        "regex22",
        function(value, element, regexp) {
            var re = new RegExp("^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$/");
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);

    var form = $("#createPhysician");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass("error invalid-feedback");
            //error.parent("div.form-group").addClass("has-error");
            element.parent("div.form-group").append(error);
            element.addClass('is-invalid');
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
        },
    });

    form.children("div").steps({
        startIndex: 0,
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        showFinishButtonAlways : true,
        enableAllSteps: true,
        enablePagination: true,
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
            // return true;//form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            form.submit();
        }
    });
</script>

@endpush
