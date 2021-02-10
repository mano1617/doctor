@extends('backend.layouts.app')

@section('title', app_name() . ' | Homoeopathic Association | Edit')

@push('after-styles')

@endpush

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <strong>Edit Association</strong>
                <a href="{{ route('admin.homeopathic-associate.index') }}" class="btn btn-danger float-right">
                    <i class="fa fa-fw fa-close"></i>Cancel
                </a>
            </div>
            <form id="createPhysician" class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.homeopathic-associate.update',$data->id) }}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Name of Association<sup class="text-danger">*</sup></label>
                            <input type="text" name="name" value="{{ $data->name }}" required class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="address">Region/Circle<sup class="text-danger">*</sup></label>
                            <input type="text" name="region" value="{{ $data->region_circle }}" required class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landmark">Moto</label>
                            <input type="text" name="moto" value="{{ $data->moto }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Established Since<sup class="text-danger">*</sup></label>
                            <select name="since" class="form-control">
                            @for($i=0;$i<=100;$i++)
                                <option @if($data->since==(date('Y')-$i)) selected="selected" @endif value="{{ date('Y')-$i }}">{{ date('Y')-$i }}</option>
                            @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="cli_email">Email Id<sup class="text-danger">*</sup></label>
                            <input type="email" required value="{{ $data->email_address }}" name="cli_email" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Website</label>
                            <input type="text" data-rule-url="true" value="{{ $data->website }}" name="cli_website" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pincode">About Us</label>
                            <textarea name="about_us" class="form-control" >{{ $data->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="cli_email">Name of Admin<sup class="text-danger">*</sup></label>
                            <input type="text" name="admin_name" value="{{ $data->admin_name }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="mobile_no">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" required value="{{ $data->mobile_no }}" onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cli_mobile_no" class="form-control">
                        </div>
                    </div>
                </div>
                        <hr>
            @php
                $bearers = [];
                $members = [];
                if(trim($data->bearers))
                {
                    try{
                        $bearers = unserialize($data->bearers);
                    }catch(\Exception $e){
                        $bearers = [];
                    }
                }

                if(trim($data->members))
                {
                    try{
                        $members = unserialize($data->members);
                    }catch(\Exception $e){
                        $members = [];
                    }
                }
            @endphp
                <h6>Office Bearers:</h6>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Designation<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($bearers)>0) value="{{ $bearers[0]['designation'] }}" @endif required name="cnt_dsg_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Name<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($bearers)>0) value="{{ $bearers[0]['name'] }}" @endif required name="cnt_name_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Contact No<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($bearers)>0) value="{{ $bearers[0]['number'] }}" @endif required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="hidden" name="rows" value="{{ count($bearers) }}">
                            <a href="javascript:void(0);" id="addRow" class="btn btn-sm btn-success" style="margin-top:30px;"><i class="fa fa-fw fa-plus"></i>ADD</a>
                        </div>
                    </div>
                </div>
                <div id="cnt_divs">
                @if(count($bearers)>1)
                    @foreach($bearers as $bk => $bval)
                    @php
                    if($bk==0)
                    {
                        continue;
                    }
                    @endphp
                <div class="row" id="cnt_row_{{ $bk+1 }}">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Designation<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['designation'] }}" required name="cnt_dsg_{{ $bk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Name<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['name'] }}" required name="cnt_name_{{ $bk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Contact No<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['number'] }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_{{ $bk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <a style="margin-top:30px;" data-container="#cnt_row_{{ $bk+1 }}" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a>
                        </div>
                    </div>
                </div>
                    @endforeach
                @endif
                </div>
                        <hr>

                <h6>Members:</h6>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Name<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($members)>0) value="{{ $members[0]['name'] }}" @endif required name="mem_name_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Place<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($members)>0) value="{{ $members[0]['place'] }}" @endif required name="mem_plc_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Contact No<sup class="text-danger">*</sup></label>
                            <input type="text" @if(count($members)>0) value="{{ $members[0]['number'] }}" @endif required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mem_number_1" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="hidden" name="mem_rows" value="{{ count($members) }}">
                            <a href="javascript:void(0);" id="addRowMem" class="btn btn-sm btn-success" style="margin-top:30px;"><i class="fa fa-fw fa-plus"></i>ADD</a>
                        </div>
                    </div>
                </div>
                <div id="mem_divs">
                @if(count($members)>1)
                    @foreach($members as $mk => $bval)
                        @php
                    if($mk==0)
                    {
                        continue;
                    }
                    @endphp
                <div class="row" id="mem_row_{{ $mk+1 }}">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Place<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['name'] }}" required name="mem_name_{{ $mk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Place<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['place'] }}" required name="mem_plc_{{ $mk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="landno">Contact No<sup class="text-danger">*</sup></label>
                            <input type="text" value="{{ $bval['number'] }}" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mem_number_{{ $mk+1 }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <a style="margin-top:30px;" data-container="#mem_row_{{ $mk+1 }}" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a>
                        </div>
                    </div>
                </div>
                    @endforeach
                @endif
                </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Latest NEWS</label>
                                    <textarea class="form-control" name="lat_nws" cols="30" rows="5">{{ $data->latest_news }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>New Events</label>
                                    <textarea class="form-control" name="new_evnts" cols="30" rows="5">{{ $data->new_events }}</textarea>
                                </div>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Posts</label>
                                    <textarea class="form-control" name="posts" cols="30" rows="5">{{ $data->posts }}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Notifications</label>
                                    <textarea class="form-control" name="notifications" cols="30" rows="5">{{ $data->notifications }}</textarea>
                                </div>
                            </div>
                        </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i>Submit</button>
                <a href="{{ route('admin.homeopathic-associate.index') }}" class="btn btn-danger"><i class="fa fa-fw fa-close"></i>Cancel</a>
            </div>
                </form>

        </div><!--card-->
    </div><!--col-->
</div><!--row-->
@endsection
@push('after-scripts')
<script>
$(function()
{
    $("#addRow").on("click", function(e)
    {
        var row = parseInt($("input[name='rows']").val());
        row++;
        var content = '<div id="cnt_row_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="cnt_dsg_'+row+'">Designation</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required name="cnt_dsg_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="cnt_name_'+row+'">Name</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required name="cnt_name_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="mob_no_'+row+'">Mobile Number</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cnt_number_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#cnt_row_'+row+'" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='rows']").val(row);
        $("#cnt_divs").append(content);
    });

    $("#addRowMem").on("click", function(e)
    {
        var row = parseInt($("input[name='mem_rows']").val());
        row++;
        var content = '<div id="mem_row_'+row+'"><div class="row"><div class="col-sm-3"><div class="form-group"><label for="mem_name_'+row+'">Name</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required name="mem_name_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="mem_name_'+row+'">Place</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required name="mem_plc_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><div class="form-group"><label for="mem_mob_no_'+row+'">Mobile Number</label><sup class="text-danger">*</sup>';
            content+= '<input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="mem_number_'+row+'" class="form-control"></div></div>';
            content+= '<div class="col-sm-3"><a style="margin-top:30px;" data-container="#mem_row_'+row+'" class="btn removeContainer btn-danger btn-sm"><i class="fa fa-fw fa-minus"></i></a></div></div></div>';
        $("input[name='mem_rows']").val(row);
        $("#mem_divs").append(content);
    });

    $("body").on("click", ".removeContainer", function(e)
    {
        $("body "+$(this).data('container')).remove();
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
function Validate(event) {
    var regex = new RegExp("^(?:(?:\+|0{0,2})91(\s*[\ -]\s*)?|[0]?)?[789]\d{9}|(\d[ -]?){10}\d$");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}


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

</script>

@endpush
