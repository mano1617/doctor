@extends('backend.layouts.app')

@section('title', app_name() . ' | Users | Physicians | Update Physician')

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

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Physician</strong>
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.update',$userData->id) }}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                        <div>
                            <h3>Account</h3>
                            <section>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required value="{{$userData->first_name}}" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Last Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required value="{{$userData->last_name}}" name="lastname" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address">Email Address<sup class="text-danger">*</sup></label><br>
                                        <b>{{$userData->email}}</b>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" autocomplete="off" id="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="image">Image</label><br>
                                        <input type="file" name="image">
                                    </div>
                                    @if(trim($userData->physicianProfile->avatar)!='')
                                    <a href="{{ url('storage/app/avatars/'.$userData->physicianProfile->avatar) }}" target="new">
                                        <img src="{{ url('storage/app/avatars/'.$userData->physicianProfile->avatar) }}" width="65" height="65">
                                    </a>
                                    <br>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="gener">Gender<sup class="text-danger">*</sup></label>
                                        <select name="gender" class="form-control">
                                            <option @if($userData->physicianProfile->gender=='male') selected @endif value="male">Male</option>
                                            <option @if($userData->physicianProfile->gender=='female') selected @endif value="female">Female</option>
                                            <option @if($userData->physicianProfile->gender=='transgender') selected @endif value="transgender">Transgender</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{ \Carbon\carbon::parse($userData->physicianProfile->dob)->format('d-m-Y') }}" required name="dob" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" value="{{ $userData->physicianProfile->mobile_no }}" name="mobile_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="landno">Landline Number</label>
                                        <input type="text" data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="15" value="{{ $userData->physicianProfile->landline }}" name="landno" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="address" required class="form-control" >{{ $userData->physicianProfile->address }}</textarea>
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
                                            <option @if($country->id == $userData->physicianProfile->country) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <select required name="state" id="state" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($states as $stk => $state)
                                            <option @if($state->id == $userData->physicianProfile->state) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">City<sup class="text-danger">*</sup></label>
                                        <select required name="district" class="form-control">
                                            @foreach($cities as $ck)
                                            <option @if($userData->physicianProfile->district==$ck->id) selected @endif value="{{ $ck->id }}">{{ $ck->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" data-rule-digits="true" data-rule-minlength="5" data-rule-maxlength="7" value="{{ $userData->physicianProfile->pincode }}" required name="pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <textarea name="landmark" class="form-control" >{{ $userData->physicianProfile->landmark }}</textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="loc_image">Location Image</label><br>
                                        <input type="file" name="loc_image">
                                    </div>
                                    @if(trim($userData->physicianProfile->map_image)!='')
                                    <a href="{{ url('storage/app/location_images/'.$userData->physicianProfile->map_image) }}" target="new">
                                        <img src="{{ url('storage/app/location_images/'.$userData->physicianProfile->map_image) }}" width="65" height="65">
                                    </a>
                                    @endif
                                </div> -->
                                @php
                                    /*$latitude = $longitude = '';
                                    if(trim($userData->physicianProfile->latitude_longitude)!='')
                                    {
                                        $latlong = explode('*', trim($userData->physicianProfile->latitude_longitude));
                                        $latitude = $latlong[0];
                                        $longitude = $latlong[1];
                                    }*/
                                @endphp
                                <!-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label><br>
                                        <input type="text" value="" class="form-control" name="latitude">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label><br>
                                        <input type="text" value="" class="form-control" name="longitude">
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
                                        <textarea name="about_me" required class="form-control" >{{ $userData->physicianProfile->about_me }}</textarea>
                                    </div>
                                </div>
                            </div>
                            </section>

                            <h3>Education</h3>
                            <section>
                                <br>
                            @php
                                $educations = $userData->physicianEducation()->where('status','1')->get();
                            @endphp
                            <input type="hidden" name="main_row" value="{{ count($educations) > 1 ? count($educations) : 1 }}">
                            <div id="eduDiv">
                            @if(count($educations)>0)
                                @foreach($educations as $ek => $eval)
                                <div id="dyMainRow_{{ $ek+1 }}" style="border:2px solid #A5846A;padding:10px;">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{ $eval->branch_of_medicine }}" name="branch_of_medicine_{{ ($ek+1) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Medical Registration Number<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{ $eval->registration_no }}" name="registration_no_{{ ($ek+1) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Medical Council<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{ $eval->medical_council }}" name="medical_council_{{ ($ek+1) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Professional Qualification<sup class="text-danger">*</sup></label>
                                                <select name="professional_qualification_{{ ($ek+1) }}" required class="form-control">
                                                    <option value="">--select--</option>
                                                    @foreach($brMedicines as $brMedicine)
                                                    <option @if($eval->professional_qualification==$brMedicine->id) selected @endif value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">College<sup class="text-danger">*</sup></label>
                                                <input type="text" value="{{ $eval->college_name }}" required name="prof_college_{{ ($ek+1) }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Joining Year
                                                <sup class="text-danger">*</sup></label>
                                                <select name="prof_joinyear_{{ ($ek+1) }}" required class="form-control">
                                                    <option value="">--select--</option>
                                                    @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                    <option @if($eval->join_year==$year) selected @endif value="{{$year}}">{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="prof_desig">Place<sup class="text-danger">*</sup></label>
                                                <input type="text" value="{{ $eval->place }}" required name="prof_place_{{ ($ek+1) }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $addEducations = $eval->additionalEdu()->where('status','1')->get();
                                    @endphp
                                    <input type="hidden" name="edu_rows_{{ ($ek+1) }}" value="{{ (count($addEducations) > 0 ? count($addEducations) : 0) }}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a style="margin-top:30px;" data-id="{{ ($ek+1) }}" class="btn btn-success addEducation">
                                                <i class="fa fa-fw fa-plus"></i> Additional Education
                                            </a>
                                        </div>
                                    </div>
                                    @if(count($addEducations)>0)
                                @foreach($addEducations as $adk => $addEdu)
                                <div id="edu_row_{{ $ek+1 }}{{ $adk+1 }}">
                                    <hr>
                                    <div class="row" >
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="additional_qualification_{{ $ek+1 }}{{ $adk+1 }}">Additional Qualification</label>
                                                <select name="additional_qualification_{{ $ek+1 }}{{ $adk+1 }}" required class="form-control">
                                                    <option value="">--select--</option>
                                                    @foreach($brMedicines as $brMedicine)
                                                    <option @if($addEdu->professional_qualification==$brMedicine->id) selected @endif value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="add_prof_branch_{{ $ek+1 }}{{ $adk+1 }}">Branch<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{$addEdu->branch}}" name="add_prof_branch_{{ $ek+1 }}{{ $adk+1 }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="add_prof_college_{{ $ek+1 }}{{ $adk+1 }}">College<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{$addEdu->college}}" name="add_prof_college_{{ $ek+1 }}{{ $adk+1 }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="add_prof_joinyear_{{ $ek+1 }}{{ $adk+1 }}">Year<sup class="text-danger">*</sup></label>
                                                <select name="add_prof_joinyear_{{ $ek+1 }}{{ $adk+1 }}" required class="form-control">
                                                    <option value="">--select--</option>
                                                    @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                    <option @if($addEdu->join_year==$year) selected @endif value="{{$year}}">{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="add_prof_place_{{ $ek+1 }}{{ $adk+1 }}">Place<sup class="text-danger">*</sup></label>
                                                <input type="text" required value="{{$addEdu->place}}" name="add_prof_place_{{ $ek+1 }}{{ $adk+1 }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <a style="margin-top:30px;" data-container="#edu_row_{{ $ek+1 }}{{ $adk+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                <div id="eduDiv_{{ $ek+1 }}"></div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <hr>
                                        @if($ek==0)
                                            <a id="addMainRow" class="btn btn-success float-right"><i class="fa fa-fw fa-plus"></i></a>
                                        @else
                                            <a style="float:right;" data-container="#dyMainRow_{{ $ek+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                                <br>
                                @endforeach
                            @endif
							</div>

                            <div id="mainRowCnt"></div>

                            </section>
                            <h3>Work</h3>
                            @php
                                $professions = $userData->physicianProfession()->get();
                            @endphp
                            <section>
                            <br>
                            <input type="hidden" name="prof_rows" value="{{ count($professions) }}">
                            <div id="profDiv">
                            @if(count($professions))
                                @foreach($professions as $ppk => $pProf)
                                @php
                                $description = unserialize($pProf['description']);
                                @endphp
                                    <div id="prof_row_{{$ppk+1}}">
                            <div class="row">
                            <div class="col-sm-12"><h5>Working as:</h5></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sector">Sector<sup class="text-danger">*</sup></label>
                                        <div class="col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($pProf['sector']==1) checked @endif name="sector_{{$ppk+1}}" id="inline-radio1{{$ppk+1}}" type="radio" value="1">
                                                <label class="form-check-label" for="inline-radio{{$ppk+1}}">Private</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($pProf['sector']==2) checked @endif name="sector_{{$ppk+1}}" id="inline-radio2{{$ppk+1}}" type="radio" value="2">
                                                <label class="form-check-label" for="inline-radio2{{$ppk+1}}">Government</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="sector">Details of Clinic<sup class="text-danger">*</sup></label>
                                        <div class="col-form-label">
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($pProf['clinic_type']==1) checked @endif name="clinic_detail_{{$ppk+1}}" id="inline-radio11{{$ppk+1}}" type="radio" value="1">
                                                <label class="form-check-label" for="inline-radio11{{$ppk+1}}">Own Clinic</label>
                                            </div>
                                            <div class="form-check form-check-inline mr-1">
                                                <input class="form-check-input" @if($pProf['clinic_type']==2) checked @endif name="clinic_detail_{{$ppk+1}}" id="inline-radio22{{$ppk+1}}" type="radio" value="2" >
                                                <label class="form-check-label" for="inline-radio22{{$ppk+1}}">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="prof_desig">Designation<sup class="text-danger">*</sup></label>&nbsp;&nbsp;
                                    <select required name="prof_desig_{{$ppk+1}}" class="form-control">
                                        <option value="">--select--</option>
                                        @foreach($designations as $desig)
                                        <option @if($description['designation']==$desig->id) selected @endif value="{{$desig->id}}">{{$desig->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label for="prof_org">At<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="{{ $description['organization'] }}" required name="prof_org_{{$ppk+1}}" class="form-control">
                                </div>
                                <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label for="prof_palce">Place<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="{{ $description['place'] }}" required name="prof_palce_{{$ppk+1}}" class="form-control">
                                </div>
                                <div class="form-group">&nbsp;&nbsp;&nbsp;
                                    <label for="prof_since">Since<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;
                                    <input type="text"value="{{ $description['since'] }}" required name="prof_since_{{$ppk+1}}" class="form-control monthYear">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                 @if($ppk==0)
                                    <a style="margin-top:30px;" id="addProfession" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                @else
                                <a style="margin-top:30px;" data-container="#prof_row_{{$ppk+1}}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                @endif
                                </div>
                            </div>
                            <hr>
                                    </div>
                                @endforeach
                            @else
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
                                        <input type="text" required name="prof_since_1" class="form-control monthYear">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a style="margin-top:30px;" id="addProfession" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                            </div>
                            <hr>
                            @endif

</div>

                            </section>

                        <h3>Experience</h3>
                         @php
                                $experience = $userData->physicianExperience()->get();
                            @endphp
                            <section>
                            <br>
                            <input type="hidden" name="exp_rows" value="{{ count($experience) }}">
                            <div id="expDiv">
                            @if(count($experience))
                                @foreach($experience as $pexk => $pExp)
                                @php
                                    $pExpYear = explode('*',$pExp['working_years']);
                                @endphp
                                <div id="exp_row_{{$pexk+1}}">
                                <div class="row">
                                <div class="col-sm-12"><h5>Worked as:</h5></div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Designation<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{$pExp['designation']}}" required name="exp_desig_{{$pexk+1}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prof_desig">Worked At<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{$pExp['institution']}}" placeholder="Name of Institution/ Clinic/ Hospital/ etc." required name="exp_wrkat_{{$pexk+1}}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                             <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="prof_palce">Place<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{$pExp['place']}}" required name="exp_place_{{$pexk+1}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">From Year<sup class="text-danger">*</sup></label>
                                        <input type="text"  value="{{$pExpYear[0]}}" readOnly required style="background-color:white" name="exp_fryr_{{$pexk+1}}" class="form-control monthYear">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">End Year<sup class="text-danger">*</sup></label>
                                        <input type="text"  value="{{$pExpYear[1]}}" readOnly required style="background-color:white" name="exp_toyr_{{$pexk+1}}" class="form-control monthYear">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>
                                        <input type="text" placeholder="Mention in years" value="{{$pExp['homoeo_experience_years']}}" required name="exp_homoeo_{{$pexk+1}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                @if($pexk==0)
                                    <a style="margin-top:30px;" id="addExperience" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                @else
                                    <a style="margin-top:30px;" data-container="#exp_row_{{$pexk+1}}" class="btn removeContainer btn-danger" data-action="experience"><i class="fa fa-fw fa-minus"></i></a>
                                @endif
                                </div>
                            </div>

                            <hr>
                                </div>
                                @endforeach
                            @else
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
                                        <input type="text" required name="exp_wrkat_1" placeholder="Name of Institution/ Clinic/ Hospital/ etc." class="form-control">
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
                                        <input type="text"  readOnly required style="background-color:white" name="exp_fryr_1" class="form-control monthYear">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="prof_since">End Year<sup class="text-danger">*</sup></label>
                                        <input type="text"  readOnly required style="background-color:white" name="exp_toyr_1" class="form-control monthYear">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>
                                        <input type="text" placeholder="Mention in years" required name="exp_homoeo_1" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a style="margin-top:30px;" id="addExperience" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                </div>
                            </div>

                            <hr>
                            @endif

</div>
                            </section>

                            <h3>Memberships</h3>
                            <section>
                            @php
                                $membershipsEdit = $userData->physicianMembAchives()->where('record_type','membership')->get();
                            @endphp
                            <br>
                            <input type="hidden" name="mem_rows" value="{{ count($membershipsEdit) }}">
                            <div id="memDiv">
                            @if(count($membershipsEdit)>0)
                                @foreach($membershipsEdit as $pmk => $pMemb)
                                <div id="mem_row_{{$pmk+1}}">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">Membership Title</label>
                                            <select name="mem_{{$pmk+1}}" class="form-control">
                                            <option value="">--select--</option>
                                            @foreach($memberships as $member)
                                            <option @if($pMemb['description'] == $member->id) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        @if($pmk==0)
                                    <a style="margin-top:30px;" id="addMembership" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                    @else
<a style="margin-top:30px;" data-container="#mem_row_{{$pmk+1}}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                    @endif
                                </div>
                                </div>
                                <hr>
                                </div>

                                @endforeach
                            @else
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
                                <hr>
                            @endif

                            </div>
                            </section>

                            <h3>Achievements / Designations</h3>
                            @php
                                $achievementsEdit = $userData->physicianMembAchives()->where('record_type','achievement')->get();
                            @endphp
                            <section>
                            <br>
                            <input type="hidden" name="ach_rows" value="{{count($achievementsEdit)}}">
                            <div id="achDiv">
                            @if(count($achievementsEdit)>0)
                                @foreach($achievementsEdit as $pahk => $pAch)
                                    <div id="ach_row_{{$pahk+1}}">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <textarea name="ach_{{$pahk+1}}" placeholder="About Achievements / Designations" cols="30" rows="5" class="form-control">{{$pAch['description']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    @if($pahk==0)
                                    <a style="margin-top:30px;" id="addAchiev" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                    @else
<a style="margin-top:30px;" data-container="#ach_row_{{$pahk+1}}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>                                    @endif
                                </div>
                                </div>
                                    </div>
                                @endforeach
                            @else
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
                                                    <input class="form-check-input" @if($userData->physicianProfile->has_branches=='1') checked @endif name="clinic_br_detail" id="inline_br_radio11" type="radio" value="1">
                                                    <label class="form-check-label" for="inline_br_radio11">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline mr-1">
                                                    <input class="form-check-input" @if($userData->physicianProfile->has_branches=='0') checked @endif name="clinic_br_detail" id="inline_br_radio22" type="radio" value="0" >
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

        var desigOptions = '<option value="">--select--</option>';
        @foreach($brMedicines as $brMedicine)
            desigOptions +='<option value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>';
        @endforeach

        var joinYearOptions ='<option value="">--select--</option>';
        @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
            joinYearOptions +='<option value="{{$year}}">{{$year}}</option>';
        @endforeach


        var content = '<div style="border:2px solid #A5846A;padding:10px;" id="dyMainRow_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="prof_desig">Branch of Medicine<sup class="text-danger">*</sup></label><input type="text" required name="branch_of_medicine_'+row+'" class="form-control">';
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

    $("body").on("click",".addEducation", function(e)
    {
        var mainRow = $(this).data('id');
        var row = parseInt($("input[name='edu_rows_"+mainRow+"']").val());
        row++;

        var desigOptions = '<option value="">--select--</option>';
        @foreach($brMedicines as $brMedicine)
            desigOptions +='<option value="{{$brMedicine->id}}">{{$brMedicine->name}}</option>';
        @endforeach

        var joinYearOptions ='<option value="">--select--</option>';
        @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
            joinYearOptions +='<option value="{{$year}}">{{$year}}</option>';
        @endforeach

        var content = '<div id="edu_row_'+mainRow+''+row+'"><hr><div class="row"><div class="col-sm-3"><div class="form-group"><label for="education">Additional Qualification<sup class="text-danger">*</sup></label><select required name="additional_qualification_'+mainRow+''+row+'" class="form-control">'+desigOptions+'</select></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_branch_'+mainRow+''+row+'">Branch<sup class="text-danger">*</sup></label><input required type="text" name="add_prof_branch_'+mainRow+''+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_college_'+mainRow+''+row+'">College<sup class="text-danger">*</sup></label><input required type="text" name="add_prof_college_'+mainRow+''+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_joinyear_'+mainRow+''+row+'">Year<sup class="text-danger">*</sup></label><select required name="add_prof_joinyear_'+mainRow+''+row+'" class="form-control">'+joinYearOptions+'</select></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="add_prof_place_'+mainRow+''+row+'">Place<sup class="text-danger">*</sup></label><input type="text" required name="add_prof_place_'+mainRow+''+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#edu_row_'+mainRow+''+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';

        $("input[name='edu_rows_"+mainRow+"']").val(row);
        $("body #eduDiv_"+mainRow).append(content);
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
        var content = '<div id="ach_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group">';
            content+= '<textarea name="ach_'+row+'" cols="30" rows="5" placeholder="About Achievements / Designations" class="form-control"></textarea></div></div>';
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
            content+= '<div class="form-inline"><div class="form-group">&nbsp;&nbsp;<label for="prof_desig">Designation<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;<select name="prof_desig_'+row+'" required class="form-control">'+desigOptions+'</select>';
            content+= '</div><div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_org">At<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;<input type="text"  required name="prof_org_'+row+'" class="form-control">';
            content+= '</div><div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_palce">Place<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;<input type="text" required name="prof_palce_'+row+'" class="form-control">';
            content+= '</div><div class="form-group">&nbsp;&nbsp;&nbsp;<label for="prof_since">Since<sup class="text-danger">*</sup></label>&nbsp;&nbsp;&nbsp;<input type="text" required name="prof_since_'+row+'" class="form-control monthYear">';
            content+= '</div></div><div class="row"><div class="col-sm-3"><a style="margin-top:30px;" data-container="#prof_row_'+row+'" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div><hr></div>';

        $("input[name='prof_rows']").val(row);
        $("#profDiv").append(content);

        $("input[name='prof_since_"+row+"']").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
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
            content +='<input type="text" required name="exp_place_'+row+'" class="form-control"></div></div><div class="col-sm-2"><div class="form-group">';
            content +='<label for="prof_since">From Year<sup class="text-danger">*</sup></label><input type="text" readOnly required style="background-color:white" name="exp_fryr_'+row+'" class="form-control">';
            content +='</div></div><div class="col-sm-2"><div class="form-group"><label for="prof_since">End Year<sup class="text-danger">*</sup></label>';
            content +='<input type="text" readOnly required style="background-color:white" name="exp_toyr_'+row+'" class="form-control"></div></div></div>';
            content +='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required placeholder="Mention in years" name="exp_homoeo_'+row+'" class="form-control"></div></div><div class="col-sm-2">';
            content +='<a style="margin-top:30px;" data-container="#exp_row_'+row+'" class="btn removeContainer btn-danger" data-action="experience"><i class="fa fa-fw fa-minus"></i></a></div></div>';

        $("input[name='exp_rows']").val(row);
        $("#expDiv").append(content);

        $("input[name='exp_fryr_"+row+"'], input[name='exp_toyr_"+row+"']").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose : true,
            endDate: '+0d',
        });

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
