@extends('backend.layouts.app')

@section('title', app_name() . ' | Master Pages | Courses')

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Courses List</strong>
                    <a href="#create_desig" data-toggle="modal" class="btn btn-outline-success float-right"><i class="fa fa-fw fa-plus"></i>CREATE</a>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row row-cols-12">
                        <div class="col">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>NAME</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->

    <div class="modal fade" id="create_desig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create New Course</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="post" action="{{ route('admin.mstr.course.store') }}" id="add_desg">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="add_desig_name" name="desig_name" placeholder="Enter course name" class="form-control">
                                    <input type="hidden" name="desig_id">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_desig" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Course</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form method="post" action="" id="edit_desg">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="desig_name" id="desig_name" placeholder="Enter course name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Submit</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('after-scripts')
<script>
$(function() {
    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.mstr.course.index') }}",
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'actions', name: 'actions' }
            ]
    });

    $("body").on("click", ".editRow", function(e)
    {
        $.ajax({
            type : 'GET',
            url : $(this).data('href'),
            dataType : 'JSON',
            success: function(result)
            {
                $("#edit_desg").attr('action',"{{ route('admin.mstr.course.index') }}/"+result['data']['id']);
                $("input[name='desig_id']").val(result['data']['id']);
                $("#desig_name").val(result['data']['name']);
                $("#edit_desig").modal("show");
            }
        });
    });

    $("#desig_name").on("blur", function(){
        if($("#edit_desg").valid())
        {
            $("#edit_desg button[type='submit']").removeAttr("disabled");
        }
    });

    $("#add_desig_name").on("blur", function(){
        if($("#add_desg").valid())
        {
            $("#add_desg button[type='submit']").removeAttr("disabled");
        }
    });

    $("#edit_desg").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            desig_name : {
                required : true,
                remote: {
                    url: "{{ route('admin.mstr.course.checkDuplicate') }}",
                    type: "post",
                    data : {
                        '_token' : function() { return '{{ csrf_token() }}' },
                        'rowId' : function() { return $.trim($("input[name='desig_id']").val()) }
                    }
                }
            }
        },
        messages : {
            desig_name : {
                remote : 'The course is already exists'
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
        // submitHandler: function() { alert("Submitted!") }
    });

    $("#add_desg").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            desig_name : {
                required : true,
                remote: {
                    url: "{{ route('admin.mstr.course.checkDuplicate') }}",
                    type: "post",
                    data : {
                        '_token' : function() { return '{{ csrf_token() }}' }
                    }
                }
            }
        },
        messages : {
            desig_name : {
                remote : 'The course is already exists'
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
});
</script>
@endpush
