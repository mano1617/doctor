@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

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
@php
    $eduYears = collect([
        [
            'id' => 'first_year', 
            'name' => 'First Year', 
        ],
        [
            'id' => 'second_year', 
            'name' => 'Second Year', 
        ],
        [
            'id' => 'third_year', 
            'name' => 'Third Year', 
        ],
        [
            'id' => 'final_year', 
            'name' => 'Final Year', 
        ],
        [
            'id' => 'internship', 
            'name' => 'Internship', 
        ]
    ]);
@endphp
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Create New Medical Student</strong>
                    <a href="{{ route('admin.medical-student.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.medical-student.store') }}">
                    {{csrf_field()}}
                        <div>
                            <h3>Profile</h3>
                            <section>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required placeholder="Dr./Mr./Mrs./Ms" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="image">Profile Photo</label><br>
                                        <input type="file" name="image">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address">Email Address<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="email_address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mobile_no" class="form-control">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Age<sup class="text-danger">*</sup></label>
                                        <input type="text" required  name="age" data-rule-digits="true" data-rule-min="18" data-rule-max="60" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="dob" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gener">Sex<sup class="text-danger">*</sup></label>
                                        <select name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="transgender">Transgender</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="country">Country<sup class="text-danger">*</sup></label>
                                        <select required name="country" id="country" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($countries as $ck => $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <select required name="state" id="state" class="form-control">
                                            <option value="">--select--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="district" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" required name="pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="address" required class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_me">About Me<sup class="text-danger">*</sup></label>
                                        <textarea name="about_me" required class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                            </section>

                            <h3>Achievements / Designations</h3>
                            <section>
                            <br>
                            <input type="hidden" name="ach_rows" value="1">
                            <div id="achDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">About Achievment</label>
                                            <textarea placeholder="About Achievements / Designations" name="ach_1" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                                </div>
                            </div>
                            </section>

                            <h3>Education</h3>
                            <section>
                                <br>
                            <input type="hidden" name="main_row" value="1">
                            <div style="border:2px solid #A5846A;padding:10px;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_branch_of_medicine_1">Branch of Medicine<sup class="text-danger">*</sup></label>
                                            <select required name="edu_branch_of_medicine_1" class="form-control">
                                                <option value="homoeopathy">Homoeopathy</option>
                                                <option value="allopathy">Allopathy</option>
                                                <option value="ayurveda">Ayurveda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_college_1">Name of College<sup class="text-danger">*</sup></label>
                                            <input type="text" required name="edu_college_1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_place_1">Place<sup class="text-danger">*</sup></label>
                                            <input type="text" required name="edu_place_1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="edu_joinyear_1">Year of Admission
                                            <sup class="text-danger">*</sup></label>
                                            <select name="edu_joinyear_1" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="edu_year_1">Year<sup class="text-danger">*</sup></label>
                                            <select name="edu_year_1" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach($eduYears as $eYear)
                                                <option value="{{$eYear['id']}}">{{$eYear['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_mem_rows_1" value="1">
                                            <div id="edu_memDiv_1">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">Membership Title</label>
                                                            <select name="edu_mem_1_1" class="form-control">
                                                            <option value="">--select--</option>
                                                            @foreach($memberships as $member)
                                                            <option value="{{$member->id}}">{{$member->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <a style="margin-top:30px;" data-edu="1" class="btn btn-success addMembership"><i class="fa fa-fw fa-plus"></i></a>
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_ach_rows_1" value="1">
                                            <div id="edu_achDiv_1">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">About Achievment</label>
                                                            <textarea placeholder="About Achievements / Designations" name="edu_ach_1_1" cols="30" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <a style="margin-top:30px;" data-edu="1" class="btn btn-success eduAddAchiev"><i class="fa fa-fw fa-plus"></i></a>
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <hr>
                                            <a id="addMainRow" class="btn btn-success float-right"><i class="fa fa-fw fa-plus"></i></a>
                                        </div>
                                    </div>
                                <br>
                            </div>
                            <div id="mainRowCnt"></div>
                            </section>
                        </div>
                    </form>


                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/backend/jquery.steps/jquery.steps.min.js') }}"></script>
<script>
function Validate(event) {
        var regex = new RegExp("^[0-9+]");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
$(function()
{
    $("#addMainRow").on("click", function(e)
    {
        var row = parseInt($("input[name='main_row']").val());
        row++;

        var yearOptions = '<option value="">--select--</option>';
        @foreach($eduYears as $eYear)
            yearOptions +='<option value="{{$eYear['id']}}">{{$eYear['name']}}</option>';
        @endforeach

        var joinYearOptions ='<option value="">--select--</option>';
        @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
            joinYearOptions +='<option value="{{$year}}">{{$year}}</option>';
        @endforeach

        var memOptions ='<option value="">--select--</option>';
        @foreach($memberships as $member)
            memOptions +='<option value="{{$member->id}}">{{$member->name}}</option>';
        @endforeach


        var content = '<br><div style="border:2px solid #A5846A;padding:10px;" id="dyMainRow_'+row+'">';

            content += '<div class="row"><div class="col-sm-12"><hr><a style="float:right;" data-container="#dyMainRow_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div>';
            content += '</div>';

            content += '<div class="row"><div class="col-sm-6"><div class="form-group"><label for="edu_branch_of_medicine_'+row+'">Branch of Medicine<sup class="text-danger">*</sup></label>';
            content += '<select required name="edu_branch_of_medicine_'+row+'" class="form-control"><option value="homoeopathy">Homoeopathy</option><option value="allopathy">Allopathy</option>';
            content += '<option value="ayurveda">Ayurveda</option></select></div></div>';

            content += '<div class="col-sm-6"><div class="form-group"><label for="edu_college_'+row+'">Name of College<sup class="text-danger">*</sup></label><input type="text" required name="edu_college_'+row+'" class="form-control">';
            content += '</div></div></div>';

            content += '<div class="row"><div class="col-sm-6"><div class="form-group"><label for="edu_place_'+row+'">Place<sup class="text-danger">*</sup></label><input type="text" required name="edu_place_'+row+'" class="form-control">';
            content += '</div></div>';

            content += '<div class="col-sm-3"><div class="form-group"><label for="edu_joinyear_'+row+'">Year of Admission<sup class="text-danger">*</sup></label><select name="edu_joinyear_'+row+'" required class="form-control">';
            content +=  joinYearOptions+'</select></div></div>';

            content += '<div class="col-sm-3"><div class="form-group"><label for="edu_year_1'+row+'">Year<sup class="text-danger">*</sup></label>';
            content += '<select name="edu_year_1'+row+'" required class="form-control">'+yearOptions+'</select></div>';


            content += '</div></div>';

            content +='<div class="row"><div class="col-sm-6"><input type="hidden" name="edu_mem_rows_'+row+'" value="1">';
            content +='<div id="edu_memDiv_'+row+'"><div class="row"><div class="col-sm-10"><div class="form-group"><label for="edu_mem_'+row+'_1">Membership Title</label>';
            content +='<select name="edu_mem_'+row+'_1" class="form-control">'+memOptions+'</select></div></div><div class="col-sm-2">';
            content +='<a style="margin-top:30px;" data-edu="'+row+'" class="btn btn-success addMembership"><i class="fa fa-fw fa-plus"></i></a></div></div>';
            content +='</div></div><div class="col-sm-6"><input type="hidden" name="edu_ach_rows_'+row+'" value="1"><div id="edu_achDiv_'+row+'"><div class="row">';
            content +='<div class="col-sm-10"><div class="form-group"><label for="edu_ach_'+row+'_1">About Achievment</label><textarea placeholder="About Achievements / Designations" name="edu_ach_'+row+'_1" cols="30" rows="5" class="form-control"></textarea>';
            content +='</div></div><div class="col-sm-2"><a style="margin-top:30px;" data-edu="'+row+'" class="btn btn-success eduAddAchiev"><i class="fa fa-fw fa-plus"></i></a></div></div></div></div></div>';

            
            content += '<input type="hidden" name="edu_rows_'+row+'" value="1"></div><br>';

        $("input[name='main_row']").val(row);
        $("#mainRowCnt").append(content);
    });

    $("#country").on("change", function(e)
    {
        var content = '<option value="">--select--</option>';

        if($.trim($(this).val())=='')
        {
            $("#state").html(content);

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

                $("#state").html(content);

            },'JSON');
        }
    });

    $("input[name='dob']").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '-18y'
    });

    $(".since").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '+0d',
    });

    $(".monthYear").datepicker( {
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: "months",
        autoclose : true,
        endDate: '+0d',
    });

    $("#addAchiev").on("click", function(e)
    {
        var row = parseInt($("input[name='ach_rows']").val());
        row++;
        var content = '<div id="ach_row_'+row+'" class="achcl">';
            content+='<hr />';
            content+=' <div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">About Achievment</label>';
            content+= '<textarea name="ach_'+row+'" cols="30" rows="5" placeholder="About Achievements / Designations" class="form-control"></textarea></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#ach_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='ach_rows']").val(row);
        $("#achDiv").append(content);
    });

    $("body").on("click", ".eduAddAchiev",function(e)
    {
        var eduRow = $(this).data('edu');
        var row = parseInt($("input[name='edu_ach_rows_"+eduRow+"']").val());
        row++;
        var content = '<div id="edu_ach_row_'+eduRow+'_'+row+'" class="achcl">';
            content+=' <div class="row"><div class="col-sm-10"><div class="form-group"><label for="membership">About Achievment</label>';
            content+= '<textarea name="edu_ach_'+eduRow+'_'+row+'" cols="30" rows="5" placeholder="About Achievements / Designations" class="form-control"></textarea></div></div>';
            content+= '<div class="col-sm-2"><a style="margin-top:30px;" data-container="#edu_ach_row_'+eduRow+'_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='edu_ach_rows_"+eduRow+"']").val(row);
        $("#edu_achDiv_"+eduRow).append(content);
    });

    $("body").on("click", ".addMembership", function(e)
    {
        var eduRow = $(this).data('edu');
        var membs = '';
        @foreach($memberships as $member)
            membs+='<option value="{{$member->id}}">{{$member->name}}</option>';
        @endforeach

        var row = parseInt($("input[name='edu_mem_rows_"+eduRow+"']").val());
        row++;
        var content = '<div id="edu_mem_row_'+eduRow+'_'+row+'"><div class="row"><div class="col-sm-10"><div class="form-group"><label for="membership">Membership Title</label>';
            content+= '<select name="edu_mem_'+eduRow+'_'+row+'" class="form-control"><option value="">--select--</option>';
            content+= membs;
            content+='</select></div></div>';
            content+= '<div class="col-sm-2"><a style="margin-top:30px;" data-container="#edu_mem_row_'+eduRow+'_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='edu_mem_rows_"+eduRow+"']").val(row);
        $("#edu_memDiv_"+eduRow+"").append(content);

    });

    $("body").on("click", ".removeContainer", function(e)
    {
        $("body "+$(this).data('container')).remove();
    });

});

    var form = $("#createPhysician");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        password: {
            minlength:6
        },
        confirm_password: {
            equalTo: "#password"
        },
        email_address : {
            email : true,
            remote: {
                        url: "{{ route('admin.medical-student.checkEmail') }}",
                        type: "post",
                        data : {
                            '_token' : function() { return '{{ csrf_token() }}' }
                            }
                    }
        }
    },
    messages : {
        email_address : {
            remote : 'The email address is already exists'
        }
    },
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
    startIndex: 2,
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    // showFinishButtonAlways : true,
    enableAllSteps: true,
    enablePagination: true,
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
        //  return true;//form.valid();
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
