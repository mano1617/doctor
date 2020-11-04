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

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Medical Student</strong>
                    <a href="{{ route('admin.medical-student.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.medical-student.update',$userData->id) }}">
                    {{csrf_field()}}
                    {{ method_field('PUT') }}
                        <div>
                            <h3>Profile</h3>
                            <section>
                            <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Name<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{ $userData->first_name }}" required placeholder="Dr./Mr./Mrs./Ms" name="firstname" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="image">Profile Photo</label><br>
                                        <input type="file" name="image">
                                    </div>
                                    <img src="{{ url('storage/app/avatars/' . $userData->physicianProfile->avatar) }}" width="65" height="65" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email_address">Email Address</label>
                                        <br>
                                        <b>{{ $userData->email }}</b>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{ $userData->physicianProfile->mobile_no }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mobile_no" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Age<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{ $userData->physicianProfile->age }}" required  name="age" data-rule-digits="true" data-rule-min="18" data-rule-max="60" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dob">Date Of Birth<sup class="text-danger">*</sup></label>
                                        <input type="text" value="{{ \Carbon\Carbon::parse($userData->physicianProfile->dob)->format('d-m-Y') }}" required name="dob" autocomplete="off" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="gener">Sex<sup class="text-danger">*</sup></label>
                                        <select name="gender" class="form-control">
                                            <option @if($userData->physicianProfile->gender=='male') selected @endif value="male">Male</option>
                                            <option @if($userData->physicianProfile->gender=='female') selected @endif value="female">Female</option>
                                            <option @if($userData->physicianProfile->gender=='transgender') selected @endif value="transgender">Transgender</option>
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
                                            <option @if($userData->physicianProfile->country==$country->id) selected @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="state">State<sup class="text-danger">*</sup></label>
                                        <select required name="state" id="state" class="form-control">
                                            @foreach($states as $ck => $state)
                                            <option @if($userData->physicianProfile->state==$state->id) selected @endif value="{{ $state->id }}">{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="district">District<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="district" value="{{ $userData->physicianProfile->district }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pincode">Pincode<sup class="text-danger">*</sup></label>
                                        <input type="text" data-rule-digits="true" value="{{ $userData->physicianProfile->pincode }}" data-rule-minlength="5" data-rule-maxlength="7" required name="pincode" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">Address<sup class="text-danger">*</sup></label>
                                        <textarea name="address" required class="form-control" >{{ $userData->physicianProfile->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="about_me">About Me<sup class="text-danger">*</sup></label>
                                        <textarea name="about_me" required class="form-control" >{{ $userData->physicianProfile->about_me }}</textarea>
                                    </div>
                                </div>
                            </div>
                            </section>

                            <h3>Achievements / Designations</h3>
                            <section>
                            <br>
                            @php
                                $achievs = $userData->physicianMembAchives()->where([
                                ['record_type','=','achievement']
                                ])->get();
                            @endphp
                            <input type="hidden" name="ach_rows" value="{{ count($achievs) > 1 ? count($achievs) : 1 }}">
                            <div id="achDiv">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="sector">About Achievment</label>
                                            <textarea placeholder="About Achievements / Designations" name="ach_1" cols="30" rows="5" class="form-control">{{ (count($achievs) > 0 ? trim($achievs[0]->description) : '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <a style="margin-top:30px;" id="addAchiev" class="btn btn-success "><i class="fa fa-fw fa-plus"></i></a>
                                    </div>
                                </div>
                                @if(count($achievs)>1)
                                    @foreach($achievs as $uk => $value)
                                        @php
                                            if($uk==0)
                                            {
                                                continue;
                                            }
                                        @endphp
                                        <div class="row" id="ach_row_{{ $uk+1 }}">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="sector">About Achievment</label>
                                                    <textarea placeholder="About Achievements / Designations" name="ach_{{ $uk+1 }}" cols="30" rows="5" class="form-control">{{ $value->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <a style="margin-top:30px;" data-container="#ach_row_{{ $uk+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            </section>

                            <h3>Education</h3>
                            <section>
                            @php
                                $educat = $userData->physicianEducation()->get();
                                    $membs = count($educat)>0 ? unserialize($educat[0]->registration_no) : [];
                                    $eduAchievs = count($educat)>0 ? unserialize($educat[0]->medical_council) : [];
                            @endphp
                                <br>
                            <input type="hidden" name="main_row" value="{{ count($educat) >0 ? count($educat) : 1 }}">
                            <div style="border:2px solid #A5846A;padding:10px;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_branch_of_medicine_1">Branch of Medicine<sup class="text-danger">*</sup></label>
                                            <select required name="edu_branch_of_medicine_1" class="form-control">
                                                <option @if(count($educat)>0) @if($educat[0]['branch_of_medicine']=='homoeopathy') selected @endif @endif value="homoeopathy">Homoeopathy</option>
                                                <option @if(count($educat)>0) @if($educat[0]['branch_of_medicine']=='allopathy') selected @endif @endif value="allopathy">Allopathy</option>
                                                <option @if(count($educat)>0) @if($educat[0]['branch_of_medicine']=='ayurveda') selected @endif @endif value="ayurveda">Ayurveda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_college_1">Name of College<sup class="text-danger">*</sup></label>
                                            <input type="text" value="{{ count($educat) >0 ? $educat[0]['college_name'] : '' }}" required name="edu_college_1" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_place_1">Place<sup class="text-danger">*</sup></label>
                                            <input type="text" value="{{ count($educat) >0 ? $educat[0]['place'] : '' }}" required name="edu_place_1" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="edu_joinyear_1">Year of Admission
                                            <sup class="text-danger">*</sup></label>
                                            <select name="edu_joinyear_1" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                <option @if(count($educat)>0 && $educat[0]['join_year'] == $year) selected @endif value="{{$year}}">{{$year}}</option>
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
                                                <option @if(count($educat)>0 && $educat[0]['professional_qualification'] == $eYear['id']) selected @endif value="{{$eYear['id']}}">{{$eYear['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_mem_rows_1" value="{{ count($membs)>0 ? count($membs) : 1 }}">
                                            <div id="edu_memDiv_1">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">Membership Title</label>
                                                            <select name="edu_mem_1_1" class="form-control">
                                                            <option value="">--select--</option>
                                                            @foreach($memberships as $member)
                                                            <option @if(count($membs)>0 && $member->id==$membs[0]) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a style="margin-top:30px;" data-edu="1" class="btn btn-success addMembership"><i class="fa fa-fw fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @if(count($membs)>0)
                                                    @foreach($membs as $mk => $mvalue)
                                                    @php
                                                        if($mk==0)
                                                        {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <div id="edu_mem_row_1_{{ $mk+1 }}">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <label for="sector">Membership Title</label>
                                                                    <select name="edu_mem_1_{{ $mk+1 }}" class="form-control">
                                                                    <option value="">--select--</option>
                                                                    @foreach($memberships as $member)
                                                                    <option @if($mvalue==$member->id) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a style="margin-top:30px;" data-container="#edu_mem_row_1_{{ $mk+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_ach_rows_1" value="{{ count($eduAchievs)>0 ? count($eduAchievs) : 1 }}">
                                            <div id="edu_achDiv_1">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">About Achievment</label>
                                                            <textarea placeholder="About Achievements / Designations" name="edu_ach_1_1" cols="30" rows="5" class="form-control">{{(count($eduAchievs)>0 ? $eduAchievs[0] : '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a style="margin-top:30px;" data-edu="1" class="btn btn-success eduAddAchiev"><i class="fa fa-fw fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @if(count($eduAchievs)>0)
                                                    @foreach($eduAchievs as $eak => $avalue)
                                                    @php
                                                        if($eak==0)
                                                        {
                                                            continue;
                                                        }
                                                    @endphp
                                                        <div class="row" id="edu_ach_row_1_{{ $eak+1 }}">
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <label for="sector">About Achievment</label>
                                                                    <textarea placeholder="About Achievements / Designations" name="edu_ach_1_{{ $eak+1 }}" cols="30" rows="5" class="form-control">{{ $avalue }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a style="margin-top:30px;" data-container="#edu_ach_row_1_{{ $eak+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
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
                            <div id="mainRowCnt">
                            @if(count($educat)>0)
                                @foreach($educat as $ek => $value)
                                @php
                                    if($ek==0)
                                    {
                                        continue;
                                    }
                                @endphp
                                @php
                                    $membs = trim($value->registration_no)!='' ? unserialize($value->registration_no) : [];
                                    $eduAchievs = trim($value->medical_council)!='' ? unserialize($value->medical_council) : [];
                                @endphp
                                <br><div style="border:2px solid #A5846A;padding:10px;" id="dyMainRow_{{ $ek+1 }}">
                                <div class="row"><div class="col-sm-12"><hr><a style="float:right;" data-container="#dyMainRow_{{ $ek+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a></div></div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_branch_of_medicine_{{ $ek+1 }}">Branch of Medicine<sup class="text-danger">*</sup></label>
                                            <select required name="edu_branch_of_medicine_{{ $ek+1 }}" class="form-control">
                                                <option @if($value->branch_of_medicine=='homoeopathy') selected @endif value="homoeopathy">Homoeopathy</option>
                                                <option @if($value->branch_of_medicine=='allopathy') selected @endif value="allopathy">Allopathy</option>
                                                <option @if($value->branch_of_medicine=='ayurveda') selected @endif value="ayurveda">Ayurveda</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_college_{{ $ek+1 }}">Name of College<sup class="text-danger">*</sup></label>
                                            <input type="text" value="{{ $value->college_name }}" required name="edu_college_{{ $ek+1 }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="edu_place_{{ $ek+1 }}">Place<sup class="text-danger">*</sup></label>
                                            <input type="text" value="{{ $value->place }}" required name="edu_place_{{ $ek+1 }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="edu_joinyear_{{ $ek+1 }}">Year of Admission
                                            <sup class="text-danger">*</sup></label>
                                            <select name="edu_joinyear_{{ $ek+1 }}" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach(range(\Carbon\Carbon::now()->format('Y'),\Carbon\Carbon::parse('-60 years')->format('Y')) as $year)
                                                <option @if($value->join_year==$year) selected @endif value="{{$year}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="edu_year_{{ $ek+1 }}">Year<sup class="text-danger">*</sup></label>
                                            <select name="edu_year_{{ $ek+1 }}" required class="form-control">
                                                <option value="">--select--</option>
                                                @foreach($eduYears as $eYear)
                                                <option @if($value->professional_qualification==$eYear['id']) selected @endif value="{{$eYear['id']}}">{{$eYear['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_mem_rows_{{ $ek+1 }}" value="{{ count($membs) > 0 ? count($membs) : 1 }}">
                                            <div id="edu_memDiv_{{ $ek+1 }}">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">Membership Title</label>
                                                            <select name="edu_mem_{{ $ek+1 }}_1" class="form-control">
                                                            <option value="">--select--</option>
                                                            @foreach($memberships as $member)
                                                            <option @if(count($membs)>0 && $membs[0]==$member->id) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a style="margin-top:30px;" data-edu="{{ $ek+1 }}" class="btn btn-success addMembership"><i class="fa fa-fw fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @if(count($membs)>0)
                                                    @foreach($membs as $mk => $mvalue)
                                                    @php
                                                        if($mk==0)
                                                        {
                                                            continue;
                                                        }
                                                    @endphp
                                                    <div id="edu_mem_row_{{ $ek+1 }}_{{ $mk+1 }}">
                                                        <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <label for="sector">Membership Title</label>
                                                                    <select name="edu_mem_{{ $ek+1 }}_{{ $mk+1 }}" class="form-control">
                                                                    <option value="">--select--</option>
                                                                    @foreach($memberships as $member)
                                                                    <option @if($mvalue==$member->id) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a style="margin-top:30px;" data-container="#edu_mem_row_{{ $ek+1 }}_{{ $mk+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="hidden" name="edu_ach_rows_{{ $ek+1 }}" value="{{ count($eduAchievs) >0 ? count($eduAchievs) : 1 }}">
                                            <div id="edu_achDiv_{{ $ek+1 }}">
                                                <div class="row">
                                                    <div class="col-sm-10">
                                                        <div class="form-group">
                                                            <label for="sector">About Achievment</label>
                                                            <textarea placeholder="About Achievements / Designations" name="edu_ach_{{ $ek+1 }}_1" cols="30" rows="5" class="form-control">{{ (count($eduAchievs)>0 ? $eduAchievs[0] : '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                    <a style="margin-top:30px;" data-edu="{{ $ek+1 }}" class="btn btn-success eduAddAchiev"><i class="fa fa-fw fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @if(count($eduAchievs)>0)
                                                    @foreach($eduAchievs as $ak => $avalue)
                                                    @php
                                                        if($ak==0)
                                                        {
                                                            continue;
                                                        }
                                                    @endphp
                                                        <div id="edu_ach_row_{{ $ek+1 }}_{{ $ak+1 }}" class="achcl">
                                                            <div class="row">
                                                            <div class="col-sm-10">
                                                                <div class="form-group">
                                                                    <label for="sector">About Achievment</label>
                                                                    <textarea placeholder="About Achievements / Designations" name="edu_ach_{{ $ek+1 }}_{{ $ak+1 }}" cols="30" rows="5" class="form-control">{{$avalue}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a style="margin-top:30px;" data-container="#edu_ach_row_{{ $ek+1 }}_{{ $ak+1 }}" class="btn removeContainer btn-danger"><i class="fa fa-fw fa-minus"></i></a>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                                @endforeach
                            @endif
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


    $("#addExperience").on("click", function(e)
    {
        var row = parseInt($("input[name='exp_rows']").val());
        row++;
        var content = '<div id="exp_row_'+row+'"><div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Designation<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_desig_'+row+'" class="form-control"></div></div><div class="col-sm-6"><div class="form-group">';
            content +='<label for="prof_desig">Worked At<sup class="text-danger">*</sup></label><input type="text" required name="exp_wrkat_'+row+'" class="form-control">';
            content +='</div></div></div><div class="row"><div class="col-sm-6"><div class="form-group"><label for="prof_palce">Place<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_place_'+row+'" class="form-control"></div></div><div class="col-sm-3"><div class="form-group">';
            content +='<label for="prof_since">From Year<sup class="text-danger">*</sup></label><input type="text" readOnly required style="background-color:white" name="exp_fryr_'+row+'" class="form-control">';
            content +='</div></div><div class="col-sm-3"><div class="form-group"><label for="prof_since">End Year<sup class="text-danger">*</sup></label>';
            content +='<input type="text" readOnly required style="background-color:white" name="exp_toyr_'+row+'" class="form-control monthYear"></div></div></div>';
            content +='<div class="row"><div class="col-sm-6"><div class="form-group"><label for="sector">Exp in field of Homoeopathy<sup class="text-danger">*</sup></label>';
            content +='<input type="text" required name="exp_homoeo_'+row+'" class="form-control"></div></div><div class="col-sm-2">';
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
    },
    messages : {
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
        //return form.valid();
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
