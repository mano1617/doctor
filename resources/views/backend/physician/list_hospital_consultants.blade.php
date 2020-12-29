@php

    $consultants = $data->consultants()->get();

@endphp
<div class="card">
    <div class="card-header">{{ $data->name }}<small> Total {{ count($consultants).' Consultant'.(count($consultants)>1 ? 's' : '') }} are available.</small>
        <div class="float-right">
            <a href="javascript:void(0);" id="addConsults" data-clinic="{{ $data->id }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
            <a href="javascript:void(0);" onClick="$('body div#consultantContainer').empty();" class="btn btn-outline-danger"><i class="fa fa-fw fa-close"></i>CANCEL</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($consultants)>0)
        <div class="row">
            <div class="col-4">
                <div class="list-group" id="list-tab" role="tablist" style="overflow-y: auto;height: 450px;">
                    @foreach($consultants as $ctk => $cval)
                    <a class="list-group-item list-group-item-action @if($ctk==0) active @endif" id="list_show_{{ $cval->id }}" data-toggle="tab" href="#show_{{ $cval->id }}" role="tab" aria-controls="show_{{ $cval->id }}" aria-selected="false">
                        {{ $cval->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="col-8">
                <div class="tab-content" id="nav-tabContent">
                    @foreach($consultants as $ck => $cval)
                        @php

                            $wrkTime = $cval->workingDays()->get();

                        @endphp
                    <div class="tab-pane fade @if($ck==0) active show @endif" id="show_{{ $cval->id }}" role="tabpanel" aria-labelledby="list_show_{{ $cval->id }}">

                        <div class="row">
                            <div class="col-sm-8">
                                <h6>{{ $cval->name }}</h6>
                                @if(trim($cval->speciality)!='')
                                <div><strong>Speciality:</strong> {{ ucwords($cval->speciality) }}</div>
                                @endif
                                <div><strong>Email:</strong> {{ $cval->email_address }}</div>
                                <div><strong>Phone:</strong> {{ $cval->mobile_no }}</div>
                            </div>
                            <div class="col-sm-4">
                                <h6>ACTIONS</h6>
                                <a id="changeBtn_{{ ($ck+1).'0'.$cval->id }}" data-id="changeBtn_{{ ($ck+1).'1'.$cval->id }}" href="javascript:void(0);" @if($cval->status == '0') style="display:none" @endif class="btn btn-outline-dark changeStatus" data-rowurl="{{route('admin.hospitals.consultants.updateStatus', [$cval->id, 0])}}" data-row="{{$cval->id}}"><i class="fa fa-fw fa-lock"></i></a>
                                <a id="changeBtn_{{ ($ck+1).'1'.$cval->id }}" data-id="changeBtn_{{ ($ck+1).'0'.$cval->id }}" href="javascript:void(0);" @if($cval->status == '1') style="display:none" @endif class="btn btn-outline-success changeStatus" data-rowurl="{{route('admin.hospitals.consultants.updateStatus', [$cval->id, 1])}}" data-row="{{$cval->id}}"><i class="fa fa-fw fa-unlock-alt"></i></a>
                                <a href="javascript:void(0);" data-row="{{$cval->id}}" class="btn btn-outline-info editRow"><i class="fa fa-fw fa-pencil"></i></a>
                                <a id="list_show_{{ $cval->id }}" data-id="show_{{ $cval->id }}" data-clinic="{{ $cval->clinic_id }}" href="javascript:void(0);" data-rowurl="{{route('admin.hospitals.consultants.updateStatus', [$cval->id, 2])}}" data-row="{{$cval->id}}" class="btn removeRow btn-outline-danger"><i class="fa fa-fw fa-trash"></i></a>
                            </div>
                        </div>

                        <br /><br />
                         <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>DAY</th>
                                            <th>FORENOON</th>
                                            <th>AFTERNOON</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($wrkTime)>0)
                                        @foreach($wrkTime as $wk => $wval)
                                        @php
                                            $mornTime = trim($wval->morning_session_time)!='' ? explode('-',$wval->morning_session_time) : [];
                                            $evenTime = trim($wval->evening_session_time)!='' ? explode('-',$wval->evening_session_time) : [];
                                        @endphp
                                        <tr>
                                            <td>{{ ucwords($wval->day_name) }}</td>
                                            <td>
                                            @if(count($mornTime)>0)
                                            {{ \Carbon\Carbon::parse($mornTime[0])->format('h:i A').' - '.\Carbon\Carbon::parse($mornTime[1])->format('h:i A') }}
                                            @endif
                                            </td>
                                            <td>
                                            @if(count($evenTime)>0)
                                            {{ \Carbon\Carbon::parse($evenTime[0])->format('h:i A').' - '.\Carbon\Carbon::parse($evenTime[1])->format('h:i A') }}
                                            @endif
                                            </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3" class="text-danger text-center">No results found...</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(trim($cval->monthly_visit)!='')
                        <div class="row">
                            <div class="col-sm-12">
                                <div><strong>MONTHLY VISIT</strong></div>
                                <div>{{ $cval->monthly_visit }}</div>
                            </div>
                        </div>
                        @endif
                        @if(trim($cval->others)!='')
                        <div class="row">
                            <div class="col-sm-12">
                                <div><strong>OTHERS</strong></div>
                                <div>{{ $cval->others }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
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
