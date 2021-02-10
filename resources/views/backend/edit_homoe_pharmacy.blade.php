@extends('backend.layouts.app')

@section('title', app_name() . ' | Edit Hospital' )

@section('content')
@include('backend.includes.alert')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Edit Pharmacy</strong>
                <a
                @if($data->parent_id!=0)
                 href="{{ route('admin.homeopathic-pharmacy.viewBranchs',$data->parent_id) }}"
                 @else
                 href="{{ route('admin.homeopathic-pharmacy.index') }}"
                 @endif
                 class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-close"></i>Cancel
                </a>
            </div>
        <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.homeopathic-pharmacy.update',$data->id) }}">
            {{csrf_field()}}
            {{ method_field('PUT') }}

            <div class="card-body">
                        <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Name of Pharmacy<sup class="text-danger">*</sup></label>
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
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $data->mobile_no }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cli_mobile_no" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="cli_email">Landline</label>
                            <input type="email" value="{{ $data->landline }}" onkeypress="return Validate(event);" name="cli_landline" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                        @if(trim($data->profile_image)!='')
                        <img src="{{ url('storage/app/avatars/'.$data->profile_image) }}" width="65" height="65" alt="">
                        @endif
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="about_us">About Us</label>
                            <textarea name="cli_about_us" class="form-control" >{{ $data->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-sm-6" @if($data->parent_id!=0) style="display:none;" @endif>
                        <div class="form-group">
                            <label for="sector">Have Branches<sup class="text-danger">*</sup></label>
                            <div class="col-form-label">
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" @if($data->have_branch==1) checked @endif name="clinic_br_detail" id="inline_br_radio11" type="radio" value="1">
                                    <label class="form-check-label" for="inline_br_radio11">Yes</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input" @if($data->have_branch==0) checked @endif name="clinic_br_detail" id="inline_br_radio22" type="radio" value="0" >
                                    <label class="form-check-label" for="inline_br_radio22">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <hr />
                        <h6>Working Days and Time schedule:</h6>
                        <h6 class="text-danger">Note:</h6>
                        <p>If no day selection, leave as blank all inputs.</p>
                        @php
                                $clRow = 1;
                                $kdays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                            @endphp
                            @foreach($days as $kday => $day)
                                @php
                                    $kd = ($clRow-2);

                                $keyDay='';
                                $clWorkingDay = $data->workingDays()->where('day_name',$kday)->get();
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
                                    <input type="checkbox" data-ex="{{ $clRow }}" data-day="{{ $kdays[$kd] ?? '' }}" @if(count($clWorkingDay)>0 && $keyDay==$kday) checked @endif value="{{ $kday }}" class="wrk_day" name="wrk_day_{{ $kday }}"> {{$day}}
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="cli_{{ $kday }}_mst"></label>
                                    <select name="cli_{{ $kday }}_mst" id="cli_{{ $kday }}_mst_{{ $clRow }}" class="form-control removeSel">
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
                                    <select name="cli_{{ $kday }}_med" id="cli_{{ $kday }}_med_{{ $clRow }}" class="form-control removeSel">
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
                                    <select name="cli_{{ $kday }}_nst" id="cli_{{ $kday }}_nst_{{ $clRow }}" class="form-control removeSel">
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
                                    <select name="cli_{{ $kday }}_ned" id="cli_{{ $kday }}_ned_{{ $clRow }}" class="form-control removeSel">
                                        <option value="">--select--</option>
                                        @for($i=13;$i<=24;$i++)
                                        <option  @if(count($clWorkingDay)>0 && $evenTime[1]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        @php
                                $clRow++;
                            @endphp
                        @endforeach
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label> <input type="checkbox" @if(trim($data->other_description)!='') checked @endif name="wrk_times_others" value="1"> Others</label>
                                    <textarea class="form-control" name="cli_wrk_others" cols="30" rows="5">{{trim($data->other_description)}}</textarea>
                                </div>
                            </div>
                        </div>
                      
                                
            </div>
             <div class="card-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i>Submit</button>
                <a 
                @if($data->parent_id!=0)
                 href="{{ route('admin.homeopathic-pharmacy.viewBranchs',$data->parent_id) }}"
                 @else
                 href="{{ route('admin.homeopathic-pharmacy.index') }}"
                 @endif
                 class="btn btn-danger"><i class="fa fa-fw fa-close"></i>Cancel</a>
            </div>
                </form>
        </div><!--card-->
    </div><!--col-->
</div><!--row-->
@endsection
@push('after-scripts')
<script>
$(function()
{

$(".wrk_day").on("change", function(e)
    {
        var row = parseInt($(this).data('ex'));
        var cday = $(this).val();
        var dday = $(this).data('day');

        if(row!=1)
        {
            if($(this).is(':checked'))
            {
                if($.trim($("#cli_"+cday+"_mst_"+row).val())=='' && $.trim($("#cli_"+cday+"_med_"+row).val())=='')
                {
                    $("#cli_"+cday+"_mst_"+row).val($("#cli_"+dday+"_mst_"+(row-1)).val());
                    $("#cli_"+cday+"_med_"+row).val($("#cli_"+dday+"_med_"+(row-1)).val());
                }

                if($.trim($("#cli_"+cday+"_nst_"+row).val())=='' && $.trim($("#cli_"+cday+"_ned_"+row).val())=='')
                {
                    $("#cli_"+cday+"_nst_"+row).val($("#cli_"+dday+"_nst_"+(row-1)).val());
                    $("#cli_"+cday+"_ned_"+row).val($("#cli_"+dday+"_ned_"+(row-1)).val());
                }
            }
        }
        form . resetForm();

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

</script>

@endpush
