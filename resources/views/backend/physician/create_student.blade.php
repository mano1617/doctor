@extends('backend.layouts.app')

@section('title', app_name() . ' | Users | Medical Student | Add New Medical Student')

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
<div class="modal fade" id="addDynamicBranch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Branch Of Medicine</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="post"  id="add_desg">
                    {{csrf_field()}}
                    <input type="hidden" name="return_mode" value="ajax">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="add_memb_name" name="memb_name" placeholder="Enter membership name" class="form-control">
                                    <input type="hidden" name="memb_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" id="add_desg_btn" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Register New Medical Student</strong>
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
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <select name="title" class="form-control">
                                            <option value="dr">Dr</option>
                                            <option value="mr">Mr</option>
                                            <option value="mrs">Mrs</option>
                                            <option value="ms">Ms</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="firstname">Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required placeholder="Enter name" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Age<sup class="text-danger">*</sup></label>
                                        <input type="text" required placeholder="Age in years" name="age" data-rule-digits="true" data-rule-min="18" data-rule-max="60" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="address" required class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <select required name="district" id="district" class="form-control">
                                            @foreach($cities as $ck)
                                            <option value="{{ $ck->id }}">{{ $ck->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <select required name="state" id="state" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($states as $sk => $state)
                                            <option @if($state->id==19) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
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
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" required name="pincode" class="form-control">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address">Email Address<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="email_address" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_me">About Me</label>
                                        <textarea name="about_me" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="image">Profile Photo</label><br>
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            <div class="row">
                                
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
                                            <label for="sector">Achievements / Designations</label>
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
                                                <option value="">--select--</option>
                                                @foreach($branchOfMedicine as $ck => $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                        <a href="#addDynamicBranch" data-toggle="modal" class="mt-3" ><i class="fa fa-fw fa-plus"></i>Add New</a>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_college_1">Name of College<sup class="text-danger">*</sup></label>
                                            <input type="text" placeholder="Enter college Name" required name="edu_college_1" class="form-control">
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
                                                            <label for="sector">Membership</label>
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
                                                            <label for="sector">Achievements / Designations</label>
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

$('#addDynamicBranch').on('hidden.bs.modal', function () {
        $("#add_desg_btn").prop('disabled',false);
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

    $("#addAchiev").on("click", function(e)
    {
        var row = parseInt($("input[name='ach_rows']").val());
        row++;
        var content = '<div id="ach_row_'+row+'" class="achcl">';
            content+='<hr />';
            content+=' <div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">Achievements / Designations</label>';
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
            content+=' <div class="row"><div class="col-sm-10"><div class="form-group"><label for="membership">Achievements / Designations</label>';
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
        var content = '<div id="edu_mem_row_'+eduRow+'_'+row+'"><div class="row"><div class="col-sm-10"><div class="form-group"><label for="membership">Membership</label>';
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

    $("#state").on("change", function(e)
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
                        content+='<option value="'+vals.id+'">'+vals.name+'</option>';
                    });
                }

                $("#district").html(content);

            },'JSON');
        }
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

var createForm = $("#add_desg").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            memb_name : {
                required : true,
                remote: {
                    url: "{{ route('admin.mstr.branch_medicine.checkDuplicate') }}",
                    type: "post",
                    data : {
                        '_token' : function() { return $("meta[name='csrf-token']").attr('content'); }
                    }
                }
            }
        },
        messages : {
            memb_name : {
                remote : 'The medicine name is already exists'
            }
        },
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass("error invalid-feedback");
            //error.parent("div.form-group").addClass("has-error");
            element.parent("div.form-group").append(error);
            element.addClass('is-invalid');
            $("#add_desg_btn").prop('disabled',false);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid");
            $("#add_desg_btn").prop('disabled',false);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
            $("#add_desg_btn").prop('disabled',false);
        },
        submitHandler: function(form) {

            $.ajax({
                method : 'post',
                url : "{{ route('admin.mstr.branch_medicine.store') }}",
                data : $(form).serialize(),
                dataType:'json',
                success:function(result)
                {
                    var options = '<option value="">--select--</option>'

                    $(result.data).each(function(ind,val)
                    {
                        options+= '<option value="'+val['id']+'">'+val['name']+'</option>'
                    });

                    $("select[name='edu_branch_of_medicine_1']").html(options);

                    Swal.fire('Success!',result.message,'success').then(()=>{
                        createForm.resetForm();
                        $(form)[0].reset();
                        $("#addDynamicBranch").modal("hide");
                        
                    });
                },
            });
        }
    });

form.children("div").steps({
    startIndex: 0,
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
