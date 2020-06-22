@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@push('after-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>EDIT CLINIC</strong>
                    <a href="{{ route('admin.physician.clinics.index',['physician' => request()->physician]) }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.clinics.store') }}">
                    {{csrf_field()}}
                <div class="card-body">
                            <div id="cliDiv">
                                <div class="row">
                                @if(!request()->physician)
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Physicians<sup class="text-danger">*</sup></label>
                                            <select required name="user" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($physicians as $phy)
                                            <option @if($data->user_id) selected="selected" @endif value="{{$phy->id}}">{{ $phy->fullname }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Name<sup class="text-danger">*</sup></label>
                                            <input type="text" name="cli_name" value="<?php echo $data->name;?>" required class="form-control">
                                        </div>
                                    </div>
                                    @if(request()->physician)
                    <input type="hidden" value="{{ request()->physician }}" name="mainChoice">
                    <input type="hidden" value="{{ request()->physician }}" name="user">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="cli_address" required class="form-control" ><?php echo $data->address;?></textarea>
                                    </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_district" value="<?php echo $data->district;?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_state" class="form-control" value="<?php echo $data->state;?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="country">Country<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_country" class="form-control" value="<?php echo $data->country;?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" value="<?php echo $data->pincode;?>" required data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" name="cli_pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Email Address<sup class="text-danger">*</sup></label>
                                        <input type="email" required name="cli_email" value="<?php echo $data->email_address;?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Website</label>
                                        <input type="text" data-rule-url="true"  name="cli_website" value="<?php echo $data->website;?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required data-rule-digits="true" data-rule-minlength="10" value="<?php echo $data->mobile_no;?>" data-rule-maxlength="11" name="cli_mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Landline Number<sup class="text-danger">*</sup></label>
                                        <input type="text" value="<?php echo $data->landine;?>" required data-rule-minlength="5" data-rule-maxlength="15"  name="cli_landno" class="form-control">
                                    </div>
                                </div>                                                    
                            </div>
                            <div class="row">
                            @if(!request()->physician)
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="cli_address" required class="form-control" ><?php echo $data->address;?></textarea>
                                    </div>
                                    </div>
                                    @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <textarea name="cli_landmark" class="form-control" ><?php echo $data->landmark;?></textarea>
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
                                $clWorkingDay = $clWorkingDays->where('day_name',$kday);
                                echo $clWorkingDay[0]->day_name;
                            @endphp
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label style="margin-top:17px;"> <input type="checkbox" value="{{ $kday }}" class="wrk_day" name="wrk_day_{{ $kday }}"> {{$day}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_{{ $kday }}_mst"></label>
                                        <input type="text" placeholder="00:00"  name="cli_{{ $kday }}_mst" class="form-control timeFormats">
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
                                        <input type="text" placeholder="00:00" name="cli_{{ $kday }}_med" class="form-control timeFormats">
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
                                        <input type="text" placeholder="00:00" name="cli_{{ $kday }}_nst" class="form-control timeFormats">
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
                                        <input type="text" placeholder="00:00"  name="cli_{{ $kday }}_ned" class="form-control timeFormats">
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label> <input type="checkbox" name="wrk_times_others" value="1"> Others</label>
                                        <textarea class="form-control" name="cli_wrk_others" cols="30" rows="5"></textarea>
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