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

@php
$cYear = date('Y');
@endphp
@section('content')
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
                    <button class="btn btn-success" id="bBtn" type="submit">Submit</button>
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
                    <strong>Create New Physician</strong>
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.store') }}">
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
                                        <label for="image">Profile Picture</label><br>
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
                                        <input type="text" onkeypress="return Validate(event);" required placeholder="+91 XXXXXXXXXX" data-rule-minlength="10" data-rule-maxlength="14" name="mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Landline Number</label>
                                        <input type="text" data-rule-digits="true" placeholder="std_code XXXXXX" data-rule-minlength="5" data-rule-maxlength="15" name="landno" class="form-control">
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
                                        <label for="district">City<sup class="text-danger">*</sup></label>
                                        <select required name="district" id="district" class="form-control">
                                            <option value="">--select--</option>
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
                                        <label for="landmark">Landmark</label>
                                        <textarea name="landmark" class="form-control" ></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="loc_image">Location Image</label><br>
                                        <input type="file" name="loc_image">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label><br>
                                        <input type="text" class="form-control" name="latitude">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label><br>
                                        <input type="text" class="form-control" name="longitude">
                                    </div>
                                </div> -->
                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="qr_code_image">QR Code Image</label><br>
                                        <input type="file" name="qr_code_image">
                                    </div>
                                </div>                         -->
                            
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
                            <input type="hidden" name="main_row" value="1">
                            <div style="border:2px solid #A5846A;padding:10px;">
                                <div class="row">                                    
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label>
                                            <select required name="branch_of_medicine_1" class="form-control">
                                                <option value="">--select--</option>
                                                @foreach($branchOfMedicine as $ck => $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                @endforeach
                                            </select>
                                            <a href="#addDynamicBranch" data-option="1" data-toggle="modal" class="mt-3 crBr" ><i class="fa fa-fw fa-plus"></i>Add New</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="prof_desig">Medical Registration Number<sup class="text-danger">*</sup></label>
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
                                            <select name="professional_qualification_1" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach($professionals as $brMedicine)
                                                <option value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="prof_desig">College<sup class="text-danger">*</sup></label>
                                            <input type="text" required name="prof_college_1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="prof_desig">Joining Year
                                            <sup class="text-danger">*</sup></label>
                                            <select name="prof_joinyear_1" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="prof_desig">Place<sup class="text-danger">*</sup></label>
                                            <input type="text" required name="prof_place_1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="edu_rows_1" value="1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <a style="margin-top:30px;" data-id="1" class="btn btn-success addEducation">
                                            <i class="fa fa-fw fa-plus"></i> Additional Education
                                        </a>
                                    </div>
                                </div>
                                <div id="eduDiv_1"></div>
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
                            
                            <h3>Work</h3>
                            <section>
                            <br>
                            <input type="hidden" name="prof_rows" value="1">
                            <div id="profDiv">
                            <div class="row">
                                <div class="col-sm-12">
                            <h5>Working as:</h5>
                                </div>
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
                                    </div>
                                </div>
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="prof_desig">Designation<sup class="text-danger">*</sup></label>&nbsp;&nbsp;
                                    <select name="prof_desig_1" required class="form-control">
                                        <option value="">--select--</option>
                                        @foreach($designations as $desig)
                                        <option value="{{$desig->id}}">{{$desig->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                 <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label class="mr-1" for="prof_org">At<sup class="text-danger">*</sup></label>&nbsp;&nbsp;
                                    <input type="text"  required name="prof_org_1" placeholder="Name of Institution/ Clinic/ Hospital/ Etc." class="form-control">
                                </div>

                                <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label for="prof_palce">Place<sup class="text-danger">*</sup></label>&nbsp;&nbsp;
                                    <input type="text" placeholder="Enter place" required name="prof_palce_1" class="form-control">
                                </div>

                                <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label for="prof_since">Since<sup class="text-danger">*</sup></label>&nbsp;&nbsp;
                                    <input type="text" placeholder="dd-mm-yyyy" style="background-color:white" readOnly required name="prof_since_1" class="form-control since">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <a style="margin-top:30px;" id="addProfession" class="btn btn-success"><i class="fa fa-fw fa-plus"></i></a>
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
                            <div class="col-sm-12"><h5>Worked as:</h5></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Designation<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="exp_desig_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prof_desig">Worked At<sup class="text-danger">*</sup></label>
                                        <input type="text" placeholder="Name of Institution/ Clinic/ Hospital/ etc." required name="exp_wrkat_1" class="form-control">
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
                                        <select name="exp_fryr_1" data-ex="1" class="form-control expFr">
                                            @for($i=0;$i<=60;$i++)
                                            <option value="{{ $cYear-$i }}">{{ $cYear-$i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">End Year<sup class="text-danger">*</sup></label>
                                        <select name="exp_toyr_1" data-ex="1"  class="form-control expEd">
                                            @for($i=0;$i<=60;$i++)
                                            <option value="{{ $cYear-$i }}">{{ $cYear-$i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Mention<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="exp_homoeo_1" placeholder="Mention in years" class="form-control">
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
                                            <label for="sector">Member of</label>
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

                            <h3>Achievements / Designations</h3>
                            <section>
                            <br>
                            <input type="hidden" name="ach_rows" value="1">
                            <div id="achDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <textarea name="ach_1" placeholder="About Achievements / Designations" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                                </div>
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
                                                    <input class="form-check-input" checked name="clinic_br_detail" id="inline_br_radio11" type="radio" value="1">
                                                    <label class="form-check-label" for="inline_br_radio11">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline mr-1">
                                                    <input class="form-check-input" name="clinic_br_detail" id="inline_br_radio22" type="radio" value="0" >
                                                    <label class="form-check-label" for="inline_br_radio22">No</label>
                                                </div>
                                            </div>
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
function Validate(event) {
        var regex = new RegExp("^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$");
        var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    }
$(function()
{

    $(".wrk_day").on("change", function(e)
    {
        var dayKey = $(this).val();
        if($(this).data('ex')!=1)
        {
            if($.trim($("#cli_"+dayKey+"_mst_"+$(this).data('ex')).val())=='' || $.trim($("#cli_"+dayKey+"_med_"+$(this).data('ex')).val())=='')
            {
                alert(day)
            }
        }
    });

    $("body").on("change", ".expFr", function(e)
    {
        var rowIndex = $(this).data('ex');
        if($(this).val() > $("select[name='exp_toyr_"+rowIndex+"']").val())
        {
            $("select[name='exp_toyr_"+rowIndex+"']").val($("select[name='exp_toyr_"+rowIndex+"'] option:first").val());
        }
    });

    $("body").on("change", ".expEd", function(e)
    {
        var rowIndex = $(this).data('ex');
        if($("select[name='exp_fryr_"+rowIndex+"']").val() > $(this).val())
        {
            $("select[name='exp_toyr_"+rowIndex+"']").val($("select[name='exp_toyr_"+rowIndex+"'] option:first").val());
        }
    });

    $("#addMainRow").on("click", function(e)
    {
        var row = parseInt($("input[name='main_row']").val());
        row++;

        var desigOptions = '<option value="">--select--</option>';
        @foreach($professionals as $brMedicine)
            desigOptions +='<option value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>';
        @endforeach

        var joinYearOptions ='<option value="">--select--</option>';
        @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
            joinYearOptions +='<option value="{{$year}}">{{$year}}</option>';
        @endforeach

        var brMedicines ='<option value="">--select--</option>';
        @foreach($branchOfMedicine as $ck => $branch)
            brMedicines +='<option value="{{ $branch->id }}">{{ $branch->name }}</option>';
        @endforeach

        var content = '<br><div style="border:2px solid #A5846A;padding:10px;" id="dyMainRow_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label><select required name="branch_of_medicine_'+row+'" class="form-control">'+brMedicines+'</select>';
            content += '<a href="#addDynamicBranch" data-option="'+row+'" data-toggle="modal" class="mt-3 crBr" ><i class="fa fa-fw fa-plus"></i>Add New</a>';
            content += '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Medical Registration Number<sup class="text-danger">*</sup></label><input type="text" required name="registration_no_'+row+'" class="form-control">';
            content += '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Medical Council<sup class="text-danger">*</sup></label><input type="text" required name="medical_council_'+row+'" class="form-control">';
            content += '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Professional Qualification<sup class="text-danger">*</sup></label><select name="professional_qualification_'+row+'" required class="form-control">';
            content += desigOptions+'</select></div></div></div>';
            content += '<div class="row"><div class="col-sm-3"><div class="form-group"><label for="prof_desig">College<sup class="text-danger">*</sup></label><input type="text" required name="prof_college_'+row+'" class="form-control">';
            content += '</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Joining Year<sup class="text-danger">*</sup></label><select name="prof_joinyear_'+row+'" required class="form-control">';
            content +=  joinYearOptions+'</select></div></div><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Place<sup class="text-danger">*</sup></label><input type="text" required name="prof_place_'+row+'" class="form-control">';
            content += '</div></div></div><div class="row"><div class="col-sm-3"><a style="margin-top:30px;" data-id="'+row+'" class="btn btn-success addEducation"><i class="fa fa-fw fa-plus"></i>Additional Education</a></div></div>';

            content += '<input type="hidden" name="edu_rows_'+row+'" value="1"><div id="eduDiv_'+row+'"></div>';
            content+= '<div class="row"><div class="col-sm-12"><hr><a style="float:right;" data-container="#dyMainRow_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div><br>';

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
                        // if(vals.id==18)
                        // {
                            content+='<option value="'+vals.id+'">'+vals.name+'</option>';
                        //}
                    });
                }

                $("#state").html(content);

            },'JSON');
        }
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

    $("input[name='dob']").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '-18y'
    });

    var yrs = '';
    @for($i=0;$i<=60;$i++)
        yrs+='<option value="{{ $cYear-$i }}">{{ $cYear-$i }}</option>';
    @endfor

    $(".since").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '+0d',
    });


    $("#addAchiev").on("click", function(e)
    {
        var row = parseInt($("input[name='ach_rows']").val());
        row++;
        var content = '<div id="ach_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group">';
            content+= '<textarea name="ach_'+row+'" placeholder="About Achievements / Designations" cols="30" rows="5" class="form-control"></textarea></div></div>';
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
        var content = '<div id="mem_row_'+row+'"><hr><div class="row"><div class="col-sm-6"><div class="form-group"><label for="membership">Member of</label>';
            content+= '<select name="mem_'+row+'" class="form-control"><option value="">--select--</option>';
            content+= membs;
            content+='</select></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#mem_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='mem_rows']").val(row);
        $("#memDiv").append(content);

    });

    $("#addProfession").on("click", function(e)
    {

        var desigOptions = '<option value="">--select--</option>';
        @foreach($designations as $desig)
            desigOptions +='<option value="{{$desig->id}}">{{$desig->name}}</option>';
        @endforeach

        var row = parseInt($("input[name='prof_rows']").val());
        row++;
        var content = '<div id="prof_row_'+row+'"><div class="row"><div class="col-sm-12"><h5>Working as:</h5></div><div class="col-sm-3"><div class="form-group"><label for="sector">Sector<sup class="text-danger">*</sup></label>';
            content+= '<div class="col-form-label"><div class="form-check form-check-inline mr-1"><input class="form-check-input" checked name="sector_'+row+'" id="inline-radio1" type="radio" value="1">';
            content+= '<label class="form-check-label" for="inline-radio1">Private</label></div><div class="form-check form-check-inline mr-1"><input class="form-check-input" name="sector_'+row+'" id="inline-radio2" type="radio" value="2">';
            content+= '<label class="form-check-label" for="inline-radio2">Government</label></div></div></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="sector">Details of Clinic<sup class="text-danger">*</sup></label><div class="col-form-label">';
            content+= '<div class="form-check form-check-inline mr-1"><input class="form-check-input" checked name="clinic_detail_'+row+'" id="inline-radio1" type="radio" value="1"><label class="form-check-label" for="inline-radio11">Own Clinic</label>';
            content+= '</div><div class="form-check form-check-inline mr-1"><input class="form-check-input" name="clinic_detail_'+row+'" id="inline-radio2" type="radio" value="2" ><label class="form-check-label" for="inline-radio22">Others</label>';
            content+= '</div></div></div></div></div>';
            content+= '<div class="form-inline"><div class="form-group"><label for="prof_desig">Designation<sup class="text-danger">*</sup></label>&nbsp;&nbsp;<select name="prof_desig_'+row+'" required class="form-control">'+desigOptions+'</select></div><div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_org">At<sup class="text-danger">*</sup></label>&nbsp;&nbsp;<input placeholder="Name of Institution/ Clinic/ Hospital/ Etc." type="text"  required name="prof_org_'+row+'" class="form-control"></div>';
            content+= '<div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_palce">Place<sup class="text-danger">*</sup></label>&nbsp;&nbsp;<input type="text" placeholder="Enter place" required name="prof_palce_'+row+'" class="form-control"></div>';
            content+= '<div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_since">Since<sup class="text-danger">*</sup></label>&nbsp;&nbsp;<input style="background-color:white" readOnly type="text" placeholder="dd-mm-yyyy" required name="prof_since_'+row+'" class="form-control"></div>';
            content+= '</div><div class="row"><div class="col-sm-3"><a style="margin-top:30px;" data-container="#prof_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div></div>';
        $("input[name='prof_rows']").val(row);
        $("#profDiv").append(content);

        $("input[name='prof_since_"+row+"']").datepicker({
            format : 'dd-mm-yyyy',
            autoclose : true,
            endDate: '+0d',
        });

    });

    $("#addExperience").on("click", function(e)
    {
        var row = parseInt($("input[name='exp_rows']").val());
        row++;                            
        var content = '<div id="exp_row_'+row+'"><div class="row"><div class="col-sm-12"><h5>Worked as:</h5></div><div class="col-sm-6"><div class="form-group"><label for="sector">Designation<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_desig_'+row+'" class="form-control"></div></div><div class="col-sm-6"><div class="form-group">';
            content +='<label for="prof_desig">Worked At<sup class="text-danger">*</sup></label><input type="text" placeholder="Name of Institution/ Clinic/ Hospital/ etc." required name="exp_wrkat_'+row+'" class="form-control">';
            content +='</div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="prof_palce">Place<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_place_'+row+'" class="form-control"></div></div><div class="col-sm-3"><div class="form-group">';
            content +='<label for="prof_since">From Year<sup class="text-danger">*</sup></label><select name="exp_fryr_'+row+'" data-ex="'+row+'" class="form-control expFr">'+yrs+'</select>';
            content +='</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_since">End Year<sup class="text-danger">*</sup></label>';
            content +='<select name="exp_toyr_'+row+'" data-ex="'+row+'" class="form-control expEd">'+yrs+'</select></div></div></div>';
            content +='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Mention<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required placeholder="Mention in years" name="exp_homoeo_'+row+'" class="form-control"></div></div><div class="col-sm-2">';
            content +='<a style="margin-top:30px;" data-container="#exp_row_'+row+'" class="btn removeContainer btn-danger" data-action="experience"><i class="fa fa-fw fa-minus"></i></a></div></div>';

        $("input[name='exp_rows']").val(row);
        $("#expDiv").append(content);
    });


    $("body").on("click",".addEducation", function(e)
    {
        var mainRow = $(this).data('id');
        var row = parseInt($("input[name='edu_rows_"+mainRow+"']").val());
        row++;

        var desigOptions = '<option value="">--select--</option>';
        @foreach($professionals as $brMedicine)
            desigOptions +='<option value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>';
        @endforeach

        var joinYearOptions ='<option value="">--select--</option>';
        @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
            joinYearOptions +='<option value="{{$year}}">{{$year}}</option>';
        @endforeach

        var brOptions ='<option value="">--select--</option>';
        @foreach($branchOfMedicine as $brMed)
            brOptions +='<option value="{{$brMed->id}}">{{$brMed->name}}</option>';
        @endforeach

        var content = '<div id="edu_row_'+mainRow+''+row+'"><hr><div class="row"><div class="col-sm-3"><div class="form-group"><label for="education">Additional Qualification<sup class="text-danger">*</sup></label><select required name="additional_qualification_'+mainRow+''+row+'" class="form-control">'+desigOptions+'</select></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_branch_'+mainRow+''+row+'">Branch<sup class="text-danger">*</sup></label><select required name="add_prof_branch_'+mainRow+''+row+'" class="form-control">'+brOptions+'</select></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_college_'+mainRow+''+row+'">College<sup class="text-danger">*</sup></label><input required type="text" name="add_prof_college_'+mainRow+''+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_joinyear_'+mainRow+''+row+'">Year<sup class="text-danger">*</sup></label><select required name="add_prof_joinyear_'+mainRow+''+row+'" class="form-control">'+joinYearOptions+'</select></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_place_'+mainRow+''+row+'">Place<sup class="text-danger">*</sup></label><input type="text" required name="add_prof_place_'+mainRow+''+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#edu_row_'+mainRow+''+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';

        $("input[name='edu_rows_"+mainRow+"']").val(row);
        $("body #eduDiv_"+mainRow).append(content);
    });



    $("body").on("click", ".removeContainer", function(e)
    {
        $("body "+$(this).data('container')).remove();
    });

});

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

    var brSelect = 1;
    $("body").on('click', ".crBr", function (e) {
        brSelect=$(this).data('option');
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
            $("#bBtn").prop('disabled',false);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
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

                    $('body').find("select[name='branch_of_medicine_"+brSelect+"']").html(options);

                    Swal.fire('Success!',result.message,'success').then(()=>{
                        createForm.resetForm();
                        $(form)[0].reset();
                        $("#bBtn").prop('disabled',false);
                        $("#addDynamicBranch").modal("hide");
                    });
                },
            });
        }
    });

    $("#addDynamicBranch").on('hide.bs.modal', function(){
        createForm . resetForm();
        $("#bBtn").prop('disabled',false);
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
