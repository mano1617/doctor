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
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Lists</strong>
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.store') }}">
                    {{csrf_field()}}
                        <div>
                            <h3>Account</h3>
                            <section>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="lastname" class="form-control">
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="password">Password<sup class="text-danger">*</sup></label>
                                        <input type="password" autocomplete="off" id="password" required name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password<sup class="text-danger">*</sup></label>
                                        <input type="password" required name="confirm_password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="image">Image</label><br>
                                        <input type="file" name="image">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="gener">Gender<sup class="text-danger">*</sup></label>
                                        <select name="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="transgender">Transgender</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="dob" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Landline Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="landno" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="address" required class="form-control" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="district" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="state" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="country">Country<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="country" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <textarea name="landmark" class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="loc_image">Location Image</label><br>
                                        <input type="file" name="loc_image">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="qr_code_image">QR Code Image</label><br>
                                        <input type="file" name="qr_code_image">
                                    </div>
                                </div>                        
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_me">About Me<sup class="text-danger">*</sup></label>
                                        <textarea name="about_me" required class="form-control" ></textarea>
                                    </div>
                                </div>  
                            </div>
                            </section>

                            <h3>Education</h3>
                            <section>
                                <br>
                            <input type="hidden" name="edu_rows" value="1">
                            <div id="eduDiv">
                            <div class="row">                               
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="branch_of_medicine_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_desig">Registration Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="registration_no_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_desig">Medical Council<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="medical_council_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_desig">Professional Qualification<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="professional_qualification_1" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="education">Additional Qualification</label>
                                        <textarea name="additional_qualification_1" class="form-control" ></textarea>
                                    </div>
                                </div>                               
                                <div class="col-sm-3">
                                    <a style="margin-top:30px;" id="addEducation" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                            </div>
                            <hr>
							</div>
                            </section>
                            <h3>Profession</h3>
                            <section>
                            <br>
                            <input type="hidden" name="prof_rows" value="1">
                            <div id="profDiv">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sector">Sector<sup class="text-danger">*</sup></label>                                    
                                    <div class="col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" checked name="sector_1" id="inline-radio1" type="radio" value="1">
                                            <label class="form-check-label" for="inline-radio1">Private</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" name="sector_1" id="inline-radio2" type="radio" value="2">
                                            <label class="form-check-label" for="inline-radio2">Government</label>
                                            </div>
                                            </div>
                                </div></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sector">Details of Clinic<sup class="text-danger">*</sup></label>                                    
                                    <div class="col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" checked name="clinic_detail_1" id="inline-radio1" type="radio" value="1">
                                            <label class="form-check-label" for="inline-radio11">Own Clinic</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                            <input class="form-check-input" name="clinic_detail_1" id="inline-radio2" type="radio" value="2" >
                                            <label class="form-check-label" for="inline-radio22">Others</label>
                                            </div>
                                            </div>
                                </div></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_desig">Designation<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="prof_desig_1" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_org">Organisation<sup class="text-danger">*</sup></label>
                                        <input type="text"  required name="prof_org_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_palce">Place<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="prof_palce_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">Since<sup class="text-danger">*</sup></label>
                                        <input type="text"  required name="prof_since_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a style="margin-top:30px;" id="addProfession" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                            </div>
                            <hr>
</div>

                            </section>

                        <h3>Experience</h3>
                            <section>
                            <br>
                            <input type="hidden" name="exp_rows" value="1">
                            <div id="expDiv">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Designation<sup class="text-danger">*</sup></label>                                    
                                        <input type="text" required name="exp_desig_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prof_desig">Worked At<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="exp_wrkat_1" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                
                             <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prof_palce">Place<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="exp_place_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">From Year<sup class="text-danger">*</sup></label>
                                        <input type="text"  required name="exp_fryr_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">End Year<sup class="text-danger">*</sup></label>
                                        <input type="text"  required name="exp_toyr_1" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>                                    
                                        <input type="text" required name="exp_homoeo_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addExperience" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                            </div>

                            <hr>
</div>
                            </section>

                            <h3>Memberships</h3>
                            <section>
                            <br>
                            <input type="hidden" name="mem_rows" value="1">
                            <div id="memDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">Membership Title</label>
                                            <select name="mem_1" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($memberships as $member)
                                            <option value="{{$member->id}}">{{$member->name}}</option>
                                            @endforeach
                                            </select>                                   
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addMembership" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                                </div>
                            </div>
                            </section>

                            <h3>Achievements</h3>
                            <section>
                            <br>
                            <input type="hidden" name="ach_rows" value="1">
                            <div id="achDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">About Achievment</label>
                                            <textarea name="ach_1" cols="30" rows="5" class="form-control"></textarea>                                 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
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
    <script src="{{ asset('assets/backend/jquery.steps/jquery.steps.min.js') }}"></script>
<script>
$(function()
{
    $("input[name='dob']").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '-18y'
    });

    $("#addAchiev").on("click", function(e)
    {
        var row = parseInt($("input[name='ach_rows']").val());
        row++;
        var content = '<div id="ach_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">About Achievment</label>';
            content+= '<textarea name="ach_'+row+'" cols="30" rows="5" class="form-control"></textarea></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#ach_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';
        $("input[name='ach_rows']").val(row);
        $("#achDiv").append(content);

    });

    $("#addMembership").on("click", function(e)
    {
        var membs = '';
        @foreach($memberships as $member)
            membs+='<option value="{{$member->id}}">{{$member->name}}</option>';
        @endforeach
                                            
        var row = parseInt($("input[name='mem_rows']").val());
        row++;
        var content = '<div id="mem_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">Membership Title</label>';
            content+= '<select name="mem_'+row+'" class="form-control"><option value="">--select--</option>';
            content+= membs;
            content+='</select></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#mem_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';
        $("input[name='mem_rows']").val(row);
        $("#memDiv").append(content);

    });

    $("#addProfession").on("click", function(e)
    {
        var row = parseInt($("input[name='prof_rows']").val());
        row++;
        var content = '<div id="prof_row_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="sector">Sector<sup class="text-danger">*</sup></label>';
            content+= '<div class="col-form-label"><div class="form-check form-check-inline mr-1"><input class="form-check-input" checked name="sector_'+row+'" id="inline-radio1" type="radio" value="1">';
            content+= '<label class="form-check-label" for="inline-radio1">Private</label></div><div class="form-check form-check-inline mr-1"><input class="form-check-input" name="sector_'+row+'" id="inline-radio2" type="radio" value="2">';
            content+= '<label class="form-check-label" for="inline-radio2">Government</label></div></div></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="sector">Details of Clinic<sup class="text-danger">*</sup></label><div class="col-form-label">';
            content+= '<div class="form-check form-check-inline mr-1"><input class="form-check-input" checked name="clinic_detail_'+row+'" id="inline-radio1" type="radio" value="1"><label class="form-check-label" for="inline-radio11">Own Clinic</label>';
            content+= '</div><div class="form-check form-check-inline mr-1"><input class="form-check-input" name="clinic_detail_'+row+'" id="inline-radio2" type="radio" value="2" ><label class="form-check-label" for="inline-radio22">Others</label>';
            content+= '</div></div></div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Designation<sup class="text-danger">*</sup></label><input type="text" required name="prof_desig_'+row+'" class="form-control">';
            content+= '</div></div></div><div class="row"><div class="col-sm-3"><div class="form-group"><label for="prof_org">Organisation<sup class="text-danger">*</sup></label><input type="text"  required name="prof_org_'+row+'" class="form-control">';
            content+= '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_palce">Place<sup class="text-danger">*</sup></label><input type="text" required name="prof_palce_'+row+'" class="form-control">';
            content+= '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_since">Since<sup class="text-danger">*</sup></label><input type="text"  required name="prof_since_'+row+'" class="form-control">';
            content+= '</div></div><div class="col-sm-3"><a style="margin-top:30px;" data-container="#prof_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';
$("input[name='prof_rows']").val(row);
        $("#profDiv").append(content);

    });

    $("#addExperience").on("click", function(e)
    {
        var row = parseInt($("input[name='exp_rows']").val());
        row++;
        var content = '<div id="exp_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Designation<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_desig_'+row+'" class="form-control"></div></div><div class="col-sm-6"><div class="form-group">';
            content +='<label for="prof_desig">Worked At<sup class="text-danger">*</sup></label><input type="text" required name="exp_wrkat_'+row+'" class="form-control">';
            content +='</div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="prof_palce">Place<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_place_'+row+'" class="form-control"></div></div><div class="col-sm-2"><div class="form-group">';
            content +='<label for="prof_since">From Year<sup class="text-danger">*</sup></label><input type="text"  required name="exp_fryr_'+row+'" class="form-control">';
            content +='</div></div><div class="col-sm-2"><div class="form-group"><label for="prof_since">End Year<sup class="text-danger">*</sup></label>';
            content +='<input type="text"  required name="exp_toyr_'+row+'" class="form-control"></div></div></div>';
            content +='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>';                                    
            content +='<input type="text" required name="exp_homoeo_'+row+'" class="form-control"></div></div><div class="col-sm-2">';
            content +='<a style="margin-top:30px;" data-container="#exp_row_'+row+'" class="btn removeContainer btn-danger" data-action="experience"><i class="fa fa-fw fa-minus"></i></a></div></div>';

        $("input[name='exp_rows']").val(row);
        $("#expDiv").append(content);

    });


     $("#addEducation").on("click", function(e)
    {
        var row = parseInt($("input[name='edu_rows']").val());
        row++;
        var content = '<div id="edu_row_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label><input type="text" required name="branch_of_medicine_'+row+'" class="form-control"></div></div>';
            
            content+= '<div class="col-sm-3"><div class="form-group"><label for="prof_desig">Registration Number<sup class="text-danger">*</sup></label><input type="text" required name="registration_no_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="prof_desig">Medical Council<sup class="text-danger">*</sup></label><input type="text" required name="medical_council_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="prof_desig">Professional Qualification<sup class="text-danger">*</sup></label><input type="text" required name="professional_qualification_'+row+'" class="form-control"></div></div>';
            content+='</div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="education">Additional Qualification</label><textarea name="additional_qualification_'+row+'" class="form-control" ></textarea></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#edu_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';
$("input[name='edu_rows']").val(row);
        $("#eduDiv").append(content);

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
                        url: "{{ route('admin.physician.checkEmail') }}",
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
        return true;//form.valid();
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