@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@push('after-styles')
<link rel="stylesheet" href="{{ asset('backend/jquery.steps/jquery.steps.css') }}">
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
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-outline-danger float-right">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                </div><!--card-header-->
                <div class="card-body">
                <br>
                    <form id="createPhysician" enctype="multipart/form-data" method="post" action="{{ route('admin.physician.store') }}">
                    {{csrf_field()}}
                        <div>
                            <h3>Account</h3>
                            <section>
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
                                Edu
                            </section>
                        </div>
                    </form>
                     
                    
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
@push('after-scripts')
    <script src="{{ asset('backend/jquery.steps/jquery.steps.min.js') }}"></script>
<script>
$(function()
{
    $("input[name='dob']").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true,
        endDate: '-18y'
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
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    enableAllSteps : true,
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
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