<div class="card">
    <div class="card-header">{{ $data->name }}<small> Total {{ count($consultants).' Entries'.(count($consultants)>1 ? 's' : '') }} are available.</small>
        <div class="float-right">
            <a href="javascript:void(0);" id="addGallery" data-clinic="{{ $data->id }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
            <a href="javascript:void(0);" onClick="$('body div#galleryContainer').empty();" class="btn btn-outline-danger"><i class="fa fa-fw fa-close"></i>CANCEL</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($consultants)>0)
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TITLE</th>
                            <th>FILE</th>
                            <th>DESCRIPTION</th>
                            <th>SORTING</th>
                            <th>UPLOADED ON</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultants as $ck => $cval)
                        <tr>
                            <td>{{ $ck+1 }}</td>
                            <td>{{ $cval->title }}</td>
                            <td><a href="{{ url('storage/app/hospital_gallery/'.$cval->file_path) }}" target="new">View</a></td>
                            <td>{{ $cval->description }}</td>
                            <td>{{ $cval->sorting }}</td>
                            <td>{{ dateConvert($cval->uploaded_at) }}</td>
                            <td>
                                <a id="changeBtn_{{ ($ck+1).'0'.$cval->id }}" data-id="changeBtn_{{ ($ck+1).'1'.$cval->id }}" href="javascript:void(0);" @if($cval->status == '0') style="display:none" @endif class="btn btn-outline-dark changeStatus" data-rowurl="{{route('admin.'.$route_name.'.galleries.updateStatus', [$cval->id, 0])}}" data-row="{{$cval->id}}"><i class="fa fa-fw fa-lock"></i></a>
                                <a id="changeBtn_{{ ($ck+1).'1'.$cval->id }}" data-id="changeBtn_{{ ($ck+1).'0'.$cval->id }}" href="javascript:void(0);" @if($cval->status == '1') style="display:none" @endif class="btn btn-outline-success changeStatus" data-rowurl="{{route('admin.'.$route_name.'.galleries.updateStatus', [$cval->id, 1])}}" data-row="{{$cval->id}}"><i class="fa fa-fw fa-unlock-alt"></i></a>
                                <a href="javascript:void(0);" data-row="{{$cval->id}}" class="btn btn-outline-info editGalRow"><i class="fa fa-fw fa-pencil"></i></a> 
                                <a id="list_show_{{ $cval->id }}" data-id="show_{{ $cval->id }}" data-clinic="{{ $cval->clinic_id }}" href="javascript:void(0);" data-rowurl="{{route('admin.'.$route_name.'.galleries.updateStatus', [$cval->id, 2])}}" data-row="{{$cval->id}}" class="btn removeGalleryRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <h6 class="text-danger text-center">No records found...</h6>
    @endif
</div>
</div>
<script>
var OnchangeFunction = 12;
</script>
