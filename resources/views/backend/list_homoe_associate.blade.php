@extends('backend.layouts.app')

@section('title', app_name() . ' | Hospitals')

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Homoeopathic Association</strong>
                    <div class="float-right">
                    <a href="{{ route('admin.homeopathic-associate.create') }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
                    </div>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row row-cols-12">
                        <div class="col">
                            <table class="table table-hover table-bordered" id="userTable">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th >NAME</th>
                                        <th width="20%">REGION/CIRCLE</th>
                                        <th width="30%">CONTACT</th>
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
        ajax: "{{ route('admin.homeopathic-associate.index') }}",
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'photo', name: 'photo' },
                { data: 'contact', name: 'contact' },
                { data: 'actions', name: 'actions' }
            ]
    });
});
</script>
@endpush
