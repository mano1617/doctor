@extends('backend.layouts.app')

@section('title', app_name() . ' | Users | Medical Student')

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Medical Student Lists</strong>
                    <a href="{{ route('admin.medical-student.create') }}" class="btn btn-outline-success float-right">
                    <i class="fa fa-fw fa-plus"></i>CREATE</a>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row row-cols-12">
                        <div class="col">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th>NAME</th>
                                        <th>BRANCH OF MEDICINE</th>
                                        <th>PHOTO</th>
                                        <th>GENDER</th>
                                        <th>CONTACT</th>
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
@endsection

@push('after-scripts')
<script>
$(function() {
    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.medical-student.index') }}",
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'first_name', name: 'first_name' },
                { data: 'medicine', name: 'medicine' },
                { data: 'photo', name: 'photo' },
                { data: 'gender', name: 'gender' },
                { data: 'contact', name: 'contact' },
                { data: 'actions', name: 'actions' }
            ]
    });
});
</script>
@endpush
