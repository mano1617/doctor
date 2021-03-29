@extends('backend.layouts.app')

@section('title', app_name() . ' | Users | Medical Student | Add New Medical Student')

@push('after-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <strong>Create New Institution</strong>
                    <a href="{{ route('admin.medical-student.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.homeopathic-institution.store') }}">
                    {{csrf_field()}}
                        <div>
                            <h3>Profile</h3>
                            <section>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Name of Institution<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gener">Established Since<sup class="text-danger">*</sup></label>
                                        <select name="since" class="form-control">
                                        @for($i=0;$i<=100;$i++)
                                            <option value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                                        @endfor
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <textarea name="landmark" class="form-control" ></textarea>
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
                                            @foreach($states as $sk => $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <select required name="district" id="district" class="form-control">
                                                <option value="">--select--</option>
                                            @foreach($cities as $ck)
                                            <option value="{{ $ck->id }}">{{ $ck->name }}</option>
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
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="email_address">Email Id<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="email_address" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Website</label>
                                        <input type="text" data-rule-url="true"  name="cli_website" class="form-control">
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
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_me">About Me</label>
                                        <textarea name="about_me" class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>

                             <h6>Contact Numbers:</h6>
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="landno">Name/Designation<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cnt_name_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="landno">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="hidden" name="rows" value="1">
                                        <a href="javascript:void(0);" id="addRow" class="btn btn-sm btn-success" style="margin-top:30px;"><i class="fa fa-fw fa-plus"></i>ADD</a>
                                    </div>
                                </div>
                            </div>
                            <div id="cnt_divs"></div>
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

                            <h3>Course Details</h3>
                            <section>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="courses">Courses Offered:<sup class="text-danger">*</sup></label>
                                            <select required name="courses[]" id="courses" multiple="multiple" class="form-control">
                                                @foreach($courses as $ck => $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @if(count($ug_groups)>0)
                                    <h5>UG</h5>
                                    @foreach($ug_groups as $ugdegree)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                            <input type="checkbox" name="ug_groups[]" value="{{ $ugdegree->id }}"> 
                                            {{ $ugdegree->name }}</label>
                                        </div>
                                    </div>
                                </div>
                                    @endforeach
                                @endif

                                @if(count($pg_groups)>0)
                                    <h5>PG</h5>
                                    @foreach($pg_groups as $pgdegree)
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">
                                            <input type="checkbox" name="pg_groups[]" value="{{ $pgdegree->id }}"> 
                                            {{ $pgdegree->name }}</label>
                                        </div>
                                    </div>
                                </div>
                                    @endforeach
                                @endif

                            </section>

                                <h3>Accreditations</h3>
                            <section>
                            <br>
                            <input type="hidden" name="acred_rows" value="1">
                            <div id="acrdDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">Accreditations</label>
                                            <textarea placeholder="If any..." name="ared_1" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addAred" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                                </div>
                            </div>
                            </section>

                            <h3>Details of Hospital</h3>
                            <section>
                            <br>
                            <input type="hidden" name="opd_rows" value="1">
                            <div id="opdDiv">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sector">OPD</label>
                                            <input type="text" class="form-control" placeholder="Details, If any" name="opd_1">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="sector">Number of Units</label>
                                            <select name="no_units_1"  class="form-control">
                                            @for($i=1;$i<=1000;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sector">Special OPD</label>
                                            <input type="text"  class="form-control" placeholder="Details, If any" name="sp_opd_1">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                    <a style="margin-top:30px;" id="addOpd" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sector">IPD</label>
                                            <input type="text" class="form-control" placeholder="Details, If any" name="ipd">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="sector">Number of Beds</label>
                                            <select name="no_beds"  class="form-control">
                                                <option value="">--select--</option>
                                            @for($i=1;$i<=1000;$i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="sector">Details</label>
                                            <input type="text" class="form-control" placeholder="Details, If any" name="ipd_details">
                                        </div>
                                    </div>
                                </div>

                            </section>

                        </div>
                    </form>


                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
@push('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $("#courses").select2({
        tags: true,
        width : '100%'
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

    $("#addAred").on("click", function(e)
    {
        var row = parseInt($("input[name='acred_rows']").val());
        row++;
        var content = '<div id="ared_row_'+row+'" class="achcl">';
            content+='<hr />';
            content+=' <div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">Accreditations</label>';
            content+= '<textarea name="ared_'+row+'" cols="30" rows="5" placeholder="If any..." class="form-control"></textarea></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#ared_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='acred_rows']").val(row);
        $("#acrdDiv").append(content);
    });

    var units = '';
    for (var i= 1; i <= 1000; i++) {
        units+= '<option value="'+i+'">'+i+'</option>';
    }

    $("#addOpd").on("click", function(e)
    {
        
        var row = parseInt($("input[name='opd_rows']").val());
        row++;
        var content = '<div id="ared_row_'+row+'" class="achcl">';
            content+='<hr />';
            content+=' <div class="row"><div class="col-sm-4"><div class="form-group"><label for="membership">OPD</label>';
            content+= '<input type="text" class="form-control" placeholder="Details, If any" name="opd_'+row+'"></div></div>';
            content+=' <div class="col-sm-2"><div class="form-group"><label for="membership">Number of Units</label>';
            content+= '<select name="no_units_'+row+'" class="form-control">'+units+'</select></div></div>';
            content+=' <div class="col-sm-4"><div class="form-group"><label for="membership">Special OPD</label>';
            content+= '<input type="text" class="form-control" placeholder="Details, If any" name="sp_opd_'+row+'"></div></div>';
            content+= '<div class="col-sm-2"><a style="margin-top:30px;" data-container="#ared_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='opd_rows']").val(row);
        $("#opdDiv").append(content);
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
            email : true
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
    startIndex: 0,
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
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
