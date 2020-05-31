@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Lists</strong>
                    <div class="float-right">
                    <a href="{{ route('admin.physician.branches.create',['physician' => request()->physician]) }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
                    <a href="{{ route('admin.physician.index') }}" class="btn btn-danger">
                    <i class="fa fa-fw fa-arrow-left"></i>GO BACK</a>
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
                                        <th>PHOTO</th>
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
        ajax: "{{ route('admin.physician.branches.index',['physician' => request()->physician]) }}",
        columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'contact', name: 'contact' },
                { data: 'actions', name: 'actions' }
            ]
    });
});
</script>
@endpush