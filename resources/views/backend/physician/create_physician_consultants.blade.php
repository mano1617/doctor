@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@push('after-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>CREATE NEW CONSULTANT</strong>
                    <a href="{{ url()->previous() }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.consultants.store') }}">
                    {{csrf_field()}}
                <div class="card-body">
                    <input type="hidden" value="{{ request()->clinic }}" name="clinic">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_cons_doc_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Speciality</label>
                                        <input type="text" name="cli_cons_doc_spec" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Mobile<sup class="text-danger">*</sup></label>
                                        <input type="text" required data-rule-digits="true" data-rule-minlength="10" data-rule-maxlength="11" name="cli_cons_doc_mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID<sup class="text-danger">*</sup></label>
                                        <input type="email" required name="cli_cons_doc_email" class="form-control">
                                    </div>
                                </div>
                            </div> 
                             <p>Consulting On:</p>
                             <h6 class="text-danger">Note:</h6>
                            <p>If no day selection, leave as blank all inputs.</p>
                            @foreach($days as $kday => $day)
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label style="margin-top:17px;"> <input type="checkbox"  value="{{ $kday }}" name="cons_day_{{ $kday }}" class="cons_day"> {{$day}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_mst"></label>
                                        <input type="text" placeholder="00:00"  name="cli_cons_{{ $kday }}_mst" class="timeFormats form-control">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_mst_ap"></label>
                                        <select name="cli_cons_{{ $kday }}_mst_ap" class="form-control">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_med"></label>
                                        <input type="text" placeholder="00:00" name="cli_cons_{{ $kday }}_med" class="timeFormats form-control">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="border-right: 1px solid #000;">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_med_ap"></label>
                                        <select name="cli_cons_{{ $kday }}_med_ap" class="form-control">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_nst"></label>
                                        <input type="text" placeholder="00:00"  name="cli_cons_{{ $kday }}_nst" class="timeFormats form-control">
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_nst_ap"></label>
                                        <select name="cli_cons_{{ $kday }}_nst_ap" class="form-control">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="landno"></label>
                                        <input type="text" placeholder="00:00"  name="cli_cons_{{ $kday }}_ned" class="timeFormats form-control">
                                    </div>
                                </div> 
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label for="mobile_no"></label>
                                        <select name="cli_cons_{{ $kday }}_ned_ap" class="form-control">
                                            <option value="am">AM</option>
                                            <option value="pm">PM</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            @endforeach
                            <div class="row">
                             <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Monthy Visit</label>
                                        <textarea class="form-control" name="cli_cons_month_visit" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Others</label>
                                        <textarea class="form-control" name="cli_cons_wrk_others" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">About Us</label>
                                                <textarea class="form-control" name="cli_cons_aboutus" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('assets/backend/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

<script>
$(function()
{
    $('.timeFormats').mask('99:99');
    
    var form = $("#createPhysician").validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {  
        cli_name : {
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