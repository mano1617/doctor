@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Clinic Lists</strong>
                    <div class="float-right">
                    <a href="{{ route('admin.physician.clinics.create',['physician' => request()->physician]) }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
                    @if(request()->physician)
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-danger">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
                    @endif
                    </div>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row row-cols-12">
                        <div class="col">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CONTACT</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!--card-body-->
            </div><!--card-->

            <div id="consultantContainer"></div>

        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')
<script>
$(function() {
    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.physician.clinics.index',['physician' => request()->physician]) }}",
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'contact', name: 'contact' },
                { data: 'actions', name: 'actions' }
            ]
    });

    $("body").on('click', '.viewConsultant', function(e)
    {
        $.ajax({
            method : 'post',
            url : "{{ route('admin.physician.clinics.listConsultants') }}",
            data : {clinicId : $(this).data('rowid'), _token:'{{ csrf_token() }}'},
            dataType:'json',
            beforeSend : function()
            {
                $("#consultantContainer").html('<div style="background-color: white; text-align: center;"><img src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif"></div>');
            },
            success:function(result)
            {
                $("#consultantContainer").html(result.html);
            },
        });
    });
});
</script>
@endpush