@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@push('after-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>UPDATE CLINIC</strong>
                    <a href="{{ route('admin.physician.clinics.index',['physician' => request()->physician]) }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.clinics.update',$data->id) }}">
                    {{csrf_field()}}
{{ method_field('PUT') }}
                <div class="card-body">
                            <div id="cliDiv">
                                <div class="row">
                                @if(!request()->physician)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Physicians<sup class="text-danger">*</sup></label>
                                            <p><b>{{$data->user->fullname}}</b></p>
                                        </div>
                                    </div>
                                @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Name<sup class="text-danger">*</sup></label>
                                            <input type="text" name="cli_name" value="{{$data->name}}" required class="form-control">
                                        </div>
                                    </div>
                                    @if(request()->physician)
                                    <input type="hidden" value="{{ request()->physician }}" name="mainChoice">
                                    <input type="hidden" value="{{ request()->physician }}" name="user">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="cli_address" required class="form-control" >{{$data->address}}</textarea>
                                    </div>
                                    </div>
                                    @endif
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
                                            @foreach($states as $ck => $state)
                                            <option @if($data->state==$state->id) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_district" value="{{$data->district}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{$data->pincode}}" required data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" name="cli_pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Email Address<sup class="text-danger">*</sup></label>
                                        <input type="email" required name="cli_email" value="{{$data->email_address}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Website</label>
                                        <input type="text" data-rule-url="true"  name="cli_website" value="{{$data->website}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required data-rule-digits="true" data-rule-minlength="10" value="{{$data->mobile_no}}" data-rule-maxlength="11" name="cli_mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Landline Number<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{$data->landline}}" required data-rule-minlength="5" data-rule-maxlength="15"  name="cli_landno" class="form-control">
                                    </div>
                                </div>                                                    
                            </div>
                            <div class="row">
                            @if(!request()->physician)
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="cli_address" required class="form-control" >{{$data->address}}</textarea>
                                    </div>
                                    </div>
                                    @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <textarea name="cli_landmark" class="form-control" >{{$data->landmark}}</textarea>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_us">About Us</label>
                                        <textarea name="cli_about_us" class="form-control" >{{$data->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h6>Working Days and Time schedule:</h6>
                            <h6 class="text-danger">Note:</h6>
                            <p>If no day selection, leave as blank all inputs.</p>
                            @php
                                $clWorkingDays = $data->workingDays()->get();
                            @endphp
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
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_mst"></label>
                                            <input type="text" placeholder="00:00" @if(count($clWorkingDay)>0) value="{{ $mornTime[0] }}" @endif name="cli_{{ $kday }}_mst" class="form-control timeFormats">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_mst_ap"></label>
                                            <select name="cli_{{ $kday }}_mst_ap" class="form-control">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_med"></label>
                                            <input type="text" placeholder="00:00" @if(count($clWorkingDay)>0) value="{{ $mornTime[1] }}" @endif name="cli_{{ $kday }}_med" class="form-control timeFormats">
                                        </div>
                                    </div>
                                    <div class="col-sm-1" style="border-right: 1px solid #000;">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_med_ap"></label>
                                            <select name="cli_{{ $kday }}_med_ap" class="form-control">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_nst"></label>
                                            <input type="text" placeholder="00:00" @if(count($clWorkingDay)>0) value="{{ $evenTime[1] }}" @endif name="cli_{{ $kday }}_nst" class="form-control timeFormats">
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="mobile_no"></label>
                                            <select name="cli_{{ $kday }}_nst_ap" class="form-control">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="cli_{{ $kday }}_ned"></label>
                                            <input type="text" placeholder="00:00" @if(count($clWorkingDay)>0) value="{{ $evenTime[1] }}" @endif name="cli_{{ $kday }}_ned" class="form-control timeFormats">
                                        </div>
                                    </div> 
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <label for="mobile_no"></label>
                                            <select name="cli_{{ $kday }}_ned_ap" class="form-control">
                                                <option value="am">AM</option>
                                                <option value="pm">PM</option>
                                            </select>
                                        </div>
                                    </div> 
                                </div>
                            @endforeach
                            @php
                                $clWorkingDaysOthrs = $data->workingDays()->where('day_name','others')->get();
                            @endphp
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label> 
                                        <input type="checkbox" @if(count($clWorkingDaysOthrs)>0) checked @endif name="wrk_times_others" value="1"> Others</label>
                                        <textarea class="form-control" name="cli_wrk_others" cols="30" rows="5">@if(count($clWorkingDaysOthrs)>0){{trim($clWorkingDaysOthrs[0]['description'])}}@endif</textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <hr />
                </div><!--card-body-->
    <div class="card-footer" align="right">
        <button type="submit" class="btn btn-success submit">Submit</button>
        <a href="{{ route('admin.physician.clinics.index',['physician' => request()->physician]) }}" class="btn btn-danger">Cancel</a>
    </div>
                    </form>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/backend/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script>
$(function()
{
    $('.timeFormats').mask('99:99');

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

</script>

@endpush