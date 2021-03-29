@extends('backend.layouts.app')

@section('title', app_name() . ' | Users | Physicians | Branches | Update Branch')

@push('after-styles')
@endpush

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Update Branch</strong>
                    <a href="{{ route('admin.physician.branches.index',['physician' => request()->physician]) }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.branches.update',$data->id) }}">
                    {{csrf_field()}}
{{ method_field('PUT') }}
                <div class="card-body">
                            <div id="cliDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Name<sup class="text-danger">*</sup></label>
                                            <input type="text" name="cli_name" value="{{$data->name}}" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="mobile_no">Email Address<sup class="text-danger">*</sup></label>
                                            <input type="email" required name="cli_email" value="{{$data->email_address}}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">Address<sup class="text-danger">*</sup></label>
                                            <textarea name="cli_address" required class="form-control" >{{$data->address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="landmark">Landmark</label>
                                            <textarea name="cli_landmark" class="form-control" >{{$data->landmark}}</textarea>
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
                                                @foreach($states as $ck => $state)
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
                                            <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                            <input type="text" value="{{$data->pincode}}" required data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" name="cli_pincode" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                            <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" value="{{$data->mobile_no}}" data-rule-maxlength="11" name="cli_mobile_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="landno">Landline Number</label>
                                            <input type="text" value="{{$data->landline}}" data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="15"  name="cli_landno" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="landno">Website</label>
                                            <input type="text" data-rule-url="true"  name="cli_website" value="{{$data->website}}" class="form-control">
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
                                $clWorkingDays = $data->workingDays()->get();
                            @endphp
                            @foreach($days as $kday => $day)
                                @php
                                $kd = ($clRow - 2);

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
                                                <input type="checkbox" data-ex="{{ $clRow }}" data-day="{{ $kdays[$kd] ?? '' }}" @if(count($clWorkingDay)>0 && $keyDay==$kday) checked @endif value="{{ $kday }}" class="wrk_day" name="wrk_day_{{ $kday }}"> {{$day}}
                                            </label>
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
                                                <option @if(count($clWorkingDay)>0 && $evenTime[1]==\Carbon\Carbon::parse($i.':00')->format('H:i:s')) selected @endif value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $clRow++;
                                @endphp
                            @endforeach
                            @php
                                $clWorkingDaysOthrs = $data->workingDays()->where('day_name','others')->get();
                            @endphp
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>
                                        <input type="checkbox" @if(trim($data->other_description)!='') checked @endif name="wrk_times_others" value="1"> Others</label>
                                        <textarea class="form-control" name="cli_wrk_others" cols="30" rows="5">{{trim($data->other_description)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <hr />
                </div><!--card-body-->
    <div class="card-footer" align="right">
        <button type="submit" class="btn btn-success submit">Submit</button>
        <a href="{{ route('admin.physician.branches.index',['physician' => request()->physician]) }}" class="btn btn-danger">Cancel</a>
    </div>
                    </form>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
@push('after-scripts')
    <!-- <script src="{{ asset('assets/backend/jquery.maskedinput/jquery.maskedinput.js') }}"></script> -->
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

    var form = $("#createPhysician").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
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
    });

});

</script>

@endpush
