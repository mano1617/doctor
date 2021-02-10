@extends('backend.layouts.app')

@section('title', app_name() . ' | Hospitals')

@section('content')

@include('backend.includes.alert')

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Pharmacy Branch Lists</strong>
                    <div class="float-right">
                    <a href="{{ route('admin.homeopathic-pharmacy.create',['pharmacy' => request()->parentId]) }}" class="btn btn-outline-success"><i class="fa fa-fw fa-plus"></i>CREATE</a>
                    <a href="{{ route('admin.homeopathic-pharmacy.index') }}" class="btn btn-outline-danger"><i class="fa fa-fw fa-arrow-left"></i>BACK</a>
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
                                        <th width="20%">PROFILE IMAGE</th>
                                        <th width="30%">ADDRESS</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!--card-body-->
            </div><!--card-->

            <div id="galleryContainer"></div>

            <div id="consultantContainer"></div>

            <div class="modal fade" id="edit_consults" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Consultant</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="editConsultant" enctype="multipart/form-data" method="post" action="">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                        <div class="modal-body">
                            <input type="hidden" name="clinic" id="clinic">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="cli_cons_doc_name" id="cli_cons_doc_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Speciality</label>
                                        <input type="text" id="cli_cons_doc_spec" name="cli_cons_doc_spec" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Mobile<sup class="text-danger">*</sup></label>
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cli_cons_doc_mobile" id="cli_cons_doc_mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID<sup class="text-danger">*</sup></label>
                                        <input type="email" required data-rule-email="true" id="cli_cons_doc_email" name="cli_cons_doc_email" class="form-control">
                                    </div>
                                </div>
                            </div>
                             <p>Consulting On:</p>
                             <h6 class="text-danger">Note:</h6>
                            <p>If no day selection, leave as blank all inputs.</p>
                            @php
                                $clRow = 1;
                                $kdays = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                            @endphp
                            @foreach($days as $kday => $day)
                            @php
                                    $kd = ($clRow-2);
                                @endphp
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label style="margin-top:17px;">
                                        <input type="checkbox" data-ex="{{ $clRow }}" data-day="{{ $kdays[$kd] ?? '' }}"  value="{{ $kday }}" name="cons_day_{{ $kday }}" id="cons_day_{{ $kday }}" class="cons_day ewrk_day removeCheck"> {{$day}}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_mst"></label>
                                        <select name="cli_cons_{{ $kday }}_mst" id="ecli_{{ $kday }}_mst_{{ $clRow }}" class="form-control removeSel">
                                            <option value="">--select--</option>
                                            @for($i=0;$i<=11;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="border-right: 1px solid #000;">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_med"></label>
                                        <select name="cli_cons_{{ $kday }}_med" id="ecli_{{ $kday }}_med_{{ $clRow }}" class="form-control removeSel">
                                            <option value="">--select--</option>
                                            @for($i=1;$i<=12;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_nst"></label>
                                        <select name="cli_cons_{{ $kday }}_nst" id="ecli_{{ $kday }}_nst_{{ $clRow }}" class="form-control removeSel">
                                            <option value="">--select--</option>
                                            @for($i=12;$i<=23;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="landno"></label>
                                        <select name="cli_cons_{{ $kday }}_ned" id="ecli_{{ $kday }}_ned_{{ $clRow }}" class="form-control removeSel">
                                            <option value="">--select--</option>
                                            @for($i=13;$i<=24;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                                $clRow++;
                            @endphp
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Monthy Visit</label>
                                        <textarea class="form-control" name="cli_cons_month_visit" id="cli_cons_month_visit" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Others</label>
                                        <textarea class="form-control" name="cli_cons_wrk_others" id="cli_cons_wrk_others" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success submit">Submit</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Upload new content</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="createGallery" enctype="multipart/form-data" method="post" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" name="clinic_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type<sup class="text-danger">*</sup></label>
                                        <select name="gall_type" class="form-control">
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Title<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="title" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>File<sup class="text-danger">*</sup></label>
                                        <input type="file" required name="fileinput" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date<sup class="text-danger">*</sup></label>
                                        <input type="text" readOnly required value="{{ date('d-m-Y') }}" name="dateinput" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="cli_cons_month_visit" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sorting</label>
                                        <input type="text" data-rule-min="0" data-rule-integer="true" name="sorting" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success submit">Submit</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="edit_gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit content</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="editGallery" enctype="multipart/form-data" method="post" >
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" id="erow" name="egallrow">
                    <input type="hidden" name="_method" value="PUT">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type<sup class="text-danger">*</sup></label>
                                        <select name="gall_type" id="egall_type" class="form-control">
                                            <option value="image">Image</option>
                                            <option value="video">Video</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Title<sup class="text-danger">*</sup></label>
                                        <input type="text" required name="title" id="etitle" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" name="fileinput" class="form-control">
                                    </div>
                                    <a href="" target="new" id="efimg" >View</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Date<sup class="text-danger">*</sup></label>
                                        <input type="text" readOnly required value="{{ date('d-m-Y') }}" name="dateinput" id="edateinput" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="cli_cons_month_visit" id="ecli_cons_month_visit" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sorting</label>
                                        <input type="text" data-rule-min="0" data-rule-integer="true" id="esorting" name="sorting" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success submit">Submit</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="add_consults" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create new Consultant</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="createConsultant" enctype="multipart/form-data" method="post" action="{{ route('admin.hospitals.consultants.store') }}">
                    {{csrf_field()}}
                        <div class="modal-body">
                            <input type="hidden" name="clinic">
                            <input type="hidden" name="clinic_user">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Name<sup class="text-danger">*</sup></label>
                                        <select name="add_self_reg" id="add_self_reg" class="form-control"></select>
                                        <input type="text" style="display:none;" name="cli_cons_doc_name" id="add_cli_cons_doc_name" class="form-control">
                                        <a style="display:none;" href="javascript:void(0);" title="Clear" id="clearPhyData" class="text-danger"><i class="fa fa-arrow-left"></i>Go Back</a>
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
                                        <input type="text" required onkeypress="return Validate(event);" data-rule-minlength="10" data-rule-maxlength="14" name="cli_cons_doc_mobile" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID<sup class="text-danger">*</sup></label>
                                        <input type="email" required data-rule-email="true" name="cli_cons_doc_email" class="form-control">
                                    </div>
                                </div>
                            </div>
                             <p>Consulting On:</p>
                             <h6 class="text-danger">Note:</h6>
                            @php
                                $clRow = 1;
                            @endphp
                            <p>If no day selection, leave as blank all inputs.</p>
                            @foreach($days as $kday => $day)
                                @php
                                    $kd = ($clRow-2);
                                @endphp
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label style="margin-top:17px;">
                                        <input type="checkbox" data-ex="{{ $clRow }}" data-day="{{ $kdays[$kd] ?? '' }}" value="{{ $kday }}" name="cons_day_{{ $kday }}" class="cons_day wrk_day"> {{$day}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_mst"></label>
                                        <select name="cli_cons_{{ $kday }}_mst" id="cli_{{ $kday }}_mst_{{ $clRow }}" class="form-control">
                                            <option value="">--select--</option>
                                            @for($i=0;$i<=11;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="border-right: 1px solid #000;">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_med"></label>
                                        <select name="cli_cons_{{ $kday }}_med" id="cli_{{ $kday }}_med_{{ $clRow }}" class="form-control">
                                            <option value="">--select--</option>
                                            @for($i=1;$i<=12;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cli_cons_{{ $kday }}_nst"></label>
                                        <select name="cli_cons_{{ $kday }}_nst" id="cli_{{ $kday }}_nst_{{ $clRow }}" class="form-control">
                                            <option value="">--select--</option>
                                            @for($i=12;$i<=23;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="landno"></label>
                                        <select name="cli_cons_{{ $kday }}_ned" id="cli_{{ $kday }}_ned_{{ $clRow }}" class="form-control">
                                            <option value="">--select--</option>
                                            @for($i=13;$i<=24;$i++)
                                            <option value="{{ \Carbon\Carbon::parse($i.':00')->format('H:i:s') }}">{{ \Carbon\Carbon::parse($i.':00')->format('h:i A') }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                                $clRow++;
                            @endphp
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Monthy Visit</label>
                                        <textarea class="form-control" name="cli_cons_month_visit" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Others</label>
                                        <textarea class="form-control" name="cli_cons_wrk_others" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success submit">Submit</button>
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')
<script>
$(function() {

    $(".wrk_day").on("change", function(e)
    {
        var row = parseInt($(this).data('ex'));
        var cday = $(this).val();
        var dday = $(this).data('day');

        if(row!=1)
        {
            if($(this).is(':checked'))
            {
                if($.trim($("#cli_"+cday+"_mst_"+row).val())=='' && $.trim($("#cli_"+cday+"_med_"+row).val())=='')
                {
                    $("#cli_"+cday+"_mst_"+row).val($("#cli_"+dday+"_mst_"+(row-1)).val());
                    $("#cli_"+cday+"_med_"+row).val($("#cli_"+dday+"_med_"+(row-1)).val());
                }

                if($.trim($("#cli_"+cday+"_nst_"+row).val())=='' && $.trim($("#cli_"+cday+"_ned_"+row).val())=='')
                {
                    $("#cli_"+cday+"_nst_"+row).val($("#cli_"+dday+"_nst_"+(row-1)).val());
                    $("#cli_"+cday+"_ned_"+row).val($("#cli_"+dday+"_ned_"+(row-1)).val());
                }
            }
        }
    });

    $(".ewrk_day").on("change", function(e)
    {
        var row = parseInt($(this).data('ex'));
        var cday = $(this).val();
        var dday = $(this).data('day');

        if(row!=1)
        {
            if($(this).is(':checked'))
            {
                if($.trim($("#ecli_"+cday+"_mst_"+row).val())=='' && $.trim($("#ecli_"+cday+"_med_"+row).val())=='')
                {
                    $("#ecli_"+cday+"_mst_"+row).val($("#ecli_"+dday+"_mst_"+(row-1)).val());
                    $("#ecli_"+cday+"_med_"+row).val($("#ecli_"+dday+"_med_"+(row-1)).val());
                }

                if($.trim($("#ecli_"+cday+"_nst_"+row).val())=='' && $.trim($("#ecli_"+cday+"_ned_"+row).val())=='')
                {
                    $("#ecli_"+cday+"_nst_"+row).val($("#ecli_"+dday+"_nst_"+(row-1)).val());
                    $("#ecli_"+cday+"_ned_"+row).val($("#ecli_"+dday+"_ned_"+(row-1)).val());
                }
            }
        }

    });

    $("input[name='dateinput']").datepicker({
        format : 'dd-mm-yyyy',
        autoclose : true
    });

    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.homeopathic-pharmacy.viewBranchs',request()->parentId) }}",
        columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'name', name: 'name' },
                { data: 'photo', name: 'photo' },
                { data: 'contact', name: 'contact' },
                { data: 'actions', name: 'actions' }
            ]
    });

    $("select[name='add_self_reg']").on("change",function(e)
    {
        var dataSelf = $(this).find(':selected').data('self');

        if(dataSelf==2)
        {
            $("input[name='clinic_user']").val('');
            $("#clearPhyData").show();
            $(this).val($(this).find("option:first").val());
            $(this).removeAttr('required').hide();
            $("#add_cli_cons_doc_name").show().attr('required',true);
            $("input[name='cli_cons_doc_email'], input[name='cli_cons_doc_mobile']").val('');

        }else{
            $("#clearPhyData").hide();
            $("input[name='clinic_user']").val($(this).val());
            $("input[name='cli_cons_doc_email']").val($(this).data('email'));
            $("input[name='cli_cons_doc_mobile']").val($(this).data('mobile'));
            $("#add_cli_cons_doc_name").val().removeAttr('required').hide();
        }
    });

    $("#clearPhyData").on("click", function(e)
    {
        $(this).hide();
        $("#add_cli_cons_doc_name").val('').removeAttr('required').hide();
        $("#add_self_reg").attr("required",true).show();
        $("input[name='clinic_user']").val('');
        $("input[name='cli_cons_doc_email'], input[name='cli_cons_doc_mobile']").val('');

    });

    $("body").on('click', '#addConsults', function(e)
    {
        $("#add_consults").modal("show");
    });

    $("body").on('click', '#addGallery', function(e)
    {
        $("#add_gallery").modal("show");
    });

    $("body").on('click', '.editGalRow', function(e)
    {
        $("#erow").val($(this).data('row'));
        $("#editGallery").attr('action',"{{ route('admin.homeopathic-pharmacy.galleries.index') }}/"+$(this).data('row'));

        $.ajax({
            method : 'get',
            url : "{{ route('admin.homeopathic-pharmacy.galleries.index') }}/"+$(this).data('row'),
            data : {id : $(this).data('row')},
            dataType:'json',
            success:function(result)
            {
                $("#egall_type").val($.trim(result['data']['file_type']));
                $("#etitle").val($.trim(result['data']['title']));
                $("#efimg").attr('href','{{ url("/") }}/storage/app/hospital_gallery/'+$.trim(result['data']['file_path']));
                $("#esorting").val($.trim(result['data']['sorting']));
                $("#ecli_cons_month_visit").val($.trim(result['data']['description']));
                $("#edateinput").val($.trim(result['data']['uploaded_at']));

                $("#edit_gallery").modal("show");
            },
        });
    });

    $("body").on('click', '.editRow', function(e)
    {
        $("#clinic").val($(this).data('row'));
        $(".removeSel").val('');
        $(".removeCheck").prop('checked',false);
        $("#editConsultant").attr('action',"{{ route('admin.hospitals.consultants.index') }}/"+$(this).data('row'));

        $.ajax({
            method : 'get',
            url : "{{ route('admin.hospitals.consultants.index') }}/"+$(this).data('row'),
            data : {id : $(this).data('row')},
            dataType:'json',
            success:function(result)
            {
                $("#cli_cons_doc_name").val($.trim(result['data']['name']));
                $("#cli_cons_doc_spec").val($.trim(result['data']['speciality']));
                $("#cli_cons_doc_mobile").val($.trim(result['data']['mobile_no']));
                $("#cli_cons_doc_email").val($.trim(result['data']['email_address']));
                $("#cli_cons_month_visit").val($.trim(result['data']['monthly_visit']));
                $("#cli_cons_wrk_others").val($.trim(result['data']['others']));

                if((result['times']).length>0)
                {
                    $(result['times']).each(function(ind,val)
                    {
                        $("#cons_day_"+val['day_name']).prop('checked',true);

                        if($.trim(val['morning_session_time'])!='')
                        {
                            var mTime = (val['morning_session_time']).split('-');

                            $("#cli_cons_"+val['day_name']+"_mst").val(mTime[0]);
                            $("#cli_cons_"+val['day_name']+"_med").val(mTime[1]);
                        }

                        if($.trim(val['evening_session_time'])!='')
                        {
                            var eTime = (val['evening_session_time']).split('-');
                            $("#cli_cons_"+val['day_name']+"_nst").val(eTime[0]);
                            $("#cli_cons_"+val['day_name']+"_ned").val(eTime[1]);
                        }

                    });
                }
                $("#edit_consults").modal("show");
            },
        });
    });

    $("body").on('click', '.viewGallery', function(e)
    {
        window . scrollTo(0, document . body . scrollHeight);
        $("input[name='clinic_id']").val($(this).data('rowid'));
        $.ajax({
            type : 'post',
            url : "{{ route('admin.homeopathic-pharmacy.listGalleries') }}",
            data : {clinicId : $(this).data('rowid'), _token:'{{ csrf_token() }}',hospital:1},
            dataType:'json',
            beforeSend : function()
            {
                $("#consultantContainer").empty();
                $("#galleryContainer").html('<div style="background-color: white; text-align: center;"><img src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif"></div>');
            },
            success:function(result)
            {
                $("#galleryContainer").html(result.html);
            },
        });
    });

    $("body").on('click', '.viewConsultant', function(e)
    {
        $("input[name='clinic']").val($(this).data('rowid'));
        $.ajax({
            type : 'post',
            url : "{{ route('admin.hospitals.listConsultants') }}",
            data : {clinicId : $(this).data('rowid'), _token:'{{ csrf_token() }}',hospital:1},
            dataType:'json',
            beforeSend : function()
            {
                $("#galleryContainer").empty();
                $("#consultantContainer").html('<div style="background-color: white; text-align: center;"><img src="https://miro.medium.com/max/882/1*9EBHIOzhE1XfMYoKz1JcsQ.gif"></div>');
            },
            success:function(result)
            {
                if(Object.keys(result.clinicData).length>0)
                {
                    var selfContent  = '<option value="">--select--</option>';
                        selfContent += '<option value="'+result.clinicData.id+'" data-self="1">'+result.clinicData.name+'</option>'
                        selfContent += '<option value="new" data-self="2">New</option>'
                    $("#add_self_reg").show().html(selfContent);

                    $("#add_self_reg").attr("required",true);
                    $("#add_self_reg").attr("data-mobile",result.clinicData.mobile);
                    $("#add_self_reg").attr("data-email",result.clinicData.email);
                    $("#add_cli_cons_doc_name").removeAttr('required').val('').hide();

                }else{
                    $("#clearPhyData").hide();
                    $("#add_self_reg").removeAttr('required').html('').hide();
                    $("#add_cli_cons_doc_name").attr('required',true).show();
                }

                $("#consultantContainer").html(result.html);
            },
        });
    });

    var editGallery = $("#editGallery").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
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
        submitHandler: function(form) {

            $(".submit").attr("disabled", true);
            var clinicId = $("#addGallery").data('clinic');
            var formData = new FormData($(form)[0]);

            $.ajax({
                method : 'post',
                url : "{{ route('admin.homeopathic-pharmacy.galleries.index') }}/"+$("#erow").val(),
                data : formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(result)
                {
                    Swal.fire('Success!',result.message,'success').then(()=>{
                        editGallery.resetForm();
                        $(form)[0].reset();
                        $("#edit_gallery").modal("hide");
                        $('body #viewGallery_btn_'+clinicId).trigger('click');
                    });
                },
            });
        }
    });

    var createGallery = $("#createGallery").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
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
        submitHandler: function(form) {

            $(".submit").attr("disabled", true);
            var clinicId = $("#addGallery").data('clinic');
            var formData = new FormData($(form)[0]);
            $.ajax({
                method : 'post',
                url : "{{ route('admin.homeopathic-pharmacy.galleries.store') }}",
                data : formData,
                dataType:'json',
                cache: false,
                contentType: false,
                processData: false,
                success:function(result)
                {
                    Swal.fire('Success!',result.message,'success').then(()=>{
                        createGallery.resetForm();
                        $(form)[0].reset();
                        $("#add_gallery").modal("hide");
                        $('body #viewGallery_btn_'+clinicId).trigger('click');
                    });
                },
            });
        }
    });

    var editConsultantJS = $("#editConsultant").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
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
        submitHandler: function(form) {

            $(".submit").attr("disabled", true);
            var clinicId = $("#addConsults").data('clinic');

            $.ajax({
                method : 'post',
                url : $(form).attr('action'),
                data : $(form).serialize(),
                dataType:'json',
                success:function(result)
                {
                    Swal.fire('Success!',result.message,'success').then(()=>{
                        editConsultantJS.resetForm();
                        $(form)[0].reset();
                        $("#edit_consults").modal("hide");
                        $('body #viewConsult_btn_'+clinicId).trigger('click');
                    });
                },
            });
        }
    });

    var createConsultantJS = $("#createConsultant").validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
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
        submitHandler: function(form) {

            $(".submit").attr("disabled", true);
            var clinicId = $("#addConsults").data('clinic');

            $.ajax({
                method : 'post',
                url : "{{ route('admin.hospitals.consultants.store') }}",
                data : $(form).serialize(),
                dataType:'json',
                success:function(result)
                {
                    Swal.fire('Success!',result.message,'success').then(()=>{
                        createConsultantJS.resetForm();
                        $(form)[0].reset();
                        $("#add_consults").modal("hide");
                        $('body #viewConsult_btn_'+clinicId).trigger('click');
                    });
                },
            });
        }
    });
});
</script>
@endpush
