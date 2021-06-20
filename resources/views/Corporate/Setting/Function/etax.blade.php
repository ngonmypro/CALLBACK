<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-1 index-jobs">
        <form id="etax" action="{{ url('Corporate/Setting/ETax/RD') }}" method="POST" class="form">
            {{ csrf_field() }}
            <div class="d-flex justify-content-center py-3">
                <div class="d-flex flex-column w-100">
                    <div class="card-header" style="border: none;">
                        <h4 class="mb-0 py-1">
                            <span class="template-text">{{__('corpsetting.etax_setting')}}</span>
                        </h4>
                        <h5 class="px-2">
                            <span class="template-text">{{__('corpsetting.etax_detail_1')}}</span>
                            <p class="template-text mb-0">{{__('corpsetting.etax_detail_2')}}</p>
                        </h5>
                        <div class="col-12 text-right">
                            <div class="form-group">
                                <button type="button" onclick="create_jobs(this)" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.create')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                    @if(isset($etax_job['etaxjob']))
                        <div class="card border-0">
                            {{-- <div class="card-header">
                                <h5 class="card-title template-text">{{__('corpsetting.revenue')}}123134134</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                        <input type="hidden" name="corp_code" value="{{$corp_code}}">
                                            @if(isset($etax_job['data_rd']['username_rd']))
                                                @if($etax_job['data_rd']['username_rd'] == "" && $etax_job['data_rd']['username_rd'] == null)
                                                    <label class="template-text">{{__('initialSetup.username')}}</label><span class="text-danger">*</span>
                                                    <input type="text" id="username" name="username_rd" class="form-control username-rd" value="" >
                                                @else
                                                    <label class="template-text">{{__('initialSetup.username')}}</label><span class="text-danger">*</span>
                                                    <input type="text" id="username" name="username_rd" class="form-control username-rd" value="{{isset($etax_job['data_rd']['username_rd']) ? $etax_job['data_rd']['username_rd'] : '' }}" disabled>
                                                @endif
                                            @else
                                                <label class="template-text">{{__('initialSetup.username')}}</label><span class="text-danger">*</span>
                                                <input type="text" id="username" name="username_rd" class="form-control username-rd" value="{{isset($etax_job['data_rd']['username_rd']) ? $etax_job['data_rd']['username_rd'] : '' }}" >
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            @if(isset($etax_job['data_rd']['password_rd']))
                                                @if($etax_job['data_rd']['password_rd'] == "" && $etax_job['data_rd']['username_rd'] == null)
                                                    <label class="template-text">{{__('initialSetup.password')}}</label><span class="text-danger">*</span>
                                                    <input type="password" id="password" name="password_rd" class="form-control password-rd">
                                                @else
                                                    <label style="color:#fff;">{{__('initialSetup.password')}}</label>
                                                    <button type="button" onclick="change_password(this)"  class="form-control btn btn-outline-primary theme-style" ><i class="zmdi zmdi-settings"></i> {{__('initialSetup.change_password')}}</button>
                                                @endif
                                            @else
                                                <label class="template-text">{{__('initialSetup.password')}}</label><span class="text-danger">*</span>
                                                <input type="password" id="password" name="password_rd" class="form-control password-rd">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($etax_job['data_rd']['username_rd'] == "" && $etax_job['data_rd']['username_rd'] == null)
                                    <div class="row">
                                        <div class="col-12 text-right username-rd-save">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-12 text-right username-rd-save d-none">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div> --}}
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </form>

        <div class="card-header">
            <h4 class="mb-0 py-1">
                <span class="template-text">{{__('corpsetting.job_detail')}}</span>
            </h4>
        </div>
        <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4">
                <table id="jobs_table" class="table table-flush dataTable"></table>
            </div>
        </div>

                   
    </div>

    <!-- create jobs -->
    <div class="col-12 p-1 create-jobs d-none">
        <div class="mb-1">
            <div class="card border-0">
                <div class="card-header">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">Initial Setup - Job Setting</span>
                    </h4>
                </div>
                <div class="card-body job_body">
                    <form id="create_jobs" action="{{ url('Corporate/Setting/ETax/Create') }}" method="POST" class="form">
                    {{ csrf_field() }}
                    <input type="hidden" name="corp_code" value="{{$corp_code}}">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="template-text">{{__('initialSetup.job_name')}}</label><span class="text-danger">*</span>
                                    <input type="text" id="job_name" name="job_name" class="form-control" value="">
                                    <label id="validate_job_name" class="text-danger d-none" style="font-size: 13px"></label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="template-text">{{__('initialSetup.select_certificate')}}</label><span class="text-danger">*</span>
                                    <select id="certificate_serial" name="certificate_serial" class="form-control">
                                    @if(isset($cer_data) && $cer_data != null)
                                        <option value="">{{__('initialSetup.select_certificate')}}</option>
                                        @for($i=0; $i < count($cer_data); $i++)
                                                <option value="{{ $cer_data[$i]['certificate_code'] }}">{{ $cer_data[$i]['certificate_code'] }}</option>
                                        @endfor
                                    @else
                                        <option selected disabled>{{__("common.no_data")}}</option>
                                    @endif
                                    </select>
                                    <label id="validate_cer" class="text-danger d-none" style="font-size: 13px"></label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12 pl-2 main-option-block">
                            <div class="form-group pl-3">
                                <p class="template-text">Sign Digital Signature to PDF</p>
                                <div class="form-group pl-4">
                                    <div class="row">
                                        <div class="col-12 function-section">
                                            <p class="template-text">Signature visibility status</p>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="pr-4">
                                                                <input id="dsVisibility-true" type="radio" name="ds_visibility" value="true" class="magic-radio green-check" checked="" onchange="SignatureVisible(this);">
                                                                <label for="dsVisibility-true">Show</label>
                                                            </div>
                                                            <div class="pr-4">
                                                                <input id="dsVisibility" type="radio" name="ds_visibility" value="false" class="magic-radio green-check" onchange="SignatureVisible(this);">
                                                                <label for="dsVisibility">Hidden</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-12 function-section">
                                        <p class="template-text">Signature position</p>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="pr-4">
                                                            <input id="page-true" type="radio" name="page" value="first" class="magic-radio green-check" checked="">
                                                            <label for="page-true">First page</label>
                                                        </div>
                                                        <div class="pr-4">
                                                            <input id="page" type="radio" name="page" value="last" class="magic-radio green-check">
                                                            <label for="page">Last page</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pl-5">
                                                    <div class="d-flex flex-column">
                                                        <div class="mb-2">
                                                            <div class="w-50 pr-4">
                                                                <label class="template-text" for="signature_x">X-axis</label>
                                                            </div>
                                                            <div class="w-50 pr-4">
                                                                <input type="signature_x" name="ulx" onkeypress="return isNumber(event)" value="372" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <div class="w-50 pr-4">
                                                                <label class="template-text" for="signature_y">Y-axis</label>
                                                            </div>
                                                            <div class="w-50 pr-4">
                                                                <input type="signature_y" name="uly" onkeypress="return isNumber(event)" value="765" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-12 function-section">
                                        <p class="template-text">Signature type</p>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="pr-4">
                                                            <input id="signature_sign_text" type="radio" class="magic-radio green-check" name="ds_type" value="text" data-disabled="true" checked="" onchange="SignatureType(this)" data-check="checked" data-type="text" data-input="old" data-index="0">
                                                            <label for="signature_sign_text">Text</label>
                                                        </div>
                                                        <div class="pr-4">
                                                            <input id="signature_sign_picture" type="radio" class="magic-radio green-check" name="ds_type" value="image" onchange="SignatureType(this)" data-input="old" data-check="" data-type="image" data-index="0">
                                                            <label for="signature_sign_picture">Image</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 pl-4">
                                                    <div class="d-flex flex-column section-signature_type">
                                                        <div class="pr-4 pb-3">
                                                            <div class="col-12 pl-4">
                                                                <div class="d-flex flex-column">
                                                                    <div class="mb-2">
                                                                        <div class="w-50 pr-4">
                                                                            <label class="template-text">Fonts</label>
                                                                        </div>
                                                                        <div class="w-50 pr-4">
                                                                            <select name="font" id="font_txt" class="form-control">
                                                                                <option value="Angsana New">Angsana New</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2">
                                                                        <div class="w-50 pr-4">
                                                                            <label class="template-text">Size</label>
                                                                        </div>
                                                                        <div class="w-50 pr-4">
                                                                            <select name="font_size" id="size_txt" class="form-control">
                                                                                <option value="10">10</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pl-3 main-option-block">
                            <div class="form-group pl-4">
                                <p class="template-text">Select your template</p>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="pr-4">
                                                                <select name="template_id" id="template_id" class="form-control">
                                                                    <option value="1" selected="">XML RD Format</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-12 text-right">
                                <div class="form-group">
                                    <button type="button" onclick="cancel_jobs(this)" class="btn btn-outline-danger"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.cancel')}}</button>
                                    <button type="button" onclick="create_job()" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>         
        </div>
    </div>

</div>


@section('script.eipp.corp-setting.etax')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">

     $(document).ready(function(){

            var table = $("#jobs_table").DataTable({
                sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                 "language": {
                    "emptyTable":     "{{__('common.datatable.emptyTable')}}",
                    "info":           "{{__('common.datatable.info_1')}} _START_ {{__('common.datatable.info_2')}} _END_ {{__('common.datatable.info_3')}} _TOTAL_ ",
                    "infoEmpty":      "{{__('common.datatable.infoEmpty')}}",
                    "lengthMenu":     "{{__('common.datatable.lengthMenu_1')}} _MENU_ {{__('common.datatable.lengthMenu_2')}}",
                    "loadingRecords": "{{__('common.datatable.loadingRecords')}}",
                    "processing":     "{{__('common.datatable.processing')}}",
                    "zeroRecords":    "{{__('common.datatable.zeroRecords')}}",
                    "paginate": {
                        "next":       "<i class='fas fa-angle-right'>",
                        "previous":   "<i class='fas fa-angle-left'>"
                    },
                    "infoFiltered":   "",

                },
                ajax: {
                    url: '{!! URL::to("Etax/objectJobs") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token = "{{ csrf_token() }}",
                        d.corp_code =  $("#corp_code").val()                 
                    }
                },
                columns: [
                        { data: 'name',                 name: 'name',               title: "{{__('corpsetting.job_name')}}" },
                        { data: 'ref_ca',               name: 'ref_ca',             title: "{{__('corpsetting.ca')}}" },
                        { data: 'status',               name: 'status',             title: "{{__('corpsetting.status')}}" },
                        { data: 'reference', title: '', orderable: false  },
                ],
                aoColumnDefs: [
                    { className: "text-center", targets: "_all" },
                    {
                        aTargets: [3],
                        mRender: function (data, type, full) {
                            var btn_view =  `<button onclick="show_detail('${data}')" class="btn btn-sm btn-default">
                                                    <i class="ni ni-bold-right"></i>
                                                </button>`

                            var setting_btn = ''

                            setting_btn =   `<button onclick="inactive_job('${data}')" class="btn btn-sm btn-default">
                                                    <i class="ni ni-settings"></i>
                                                </button>`

                                                
                            return btn_view+setting_btn
                        }
                    },
                    {
                        aTargets: [2],
                        mRender: function (data, type, full) {
                            if(data == "ACTIVE"){
                                return '<span class="badge badge-success">{{__("common.active")}}</span>';
                            }
                            else if(data == "INACTIVE"){
                                return '<span class="badge badge-danger">{{__("common.inactive")}}</span>';
                            }
                            
                        }
                    },
                ]
            })
        });


    function create_job()
    {
        var job_name = document.getElementsByName('job_name')[0].value;
        var cer = document.getElementById('certificate_serial').value;
        let set_error_job = document.getElementById('validate_job_name');
        let set_error_cer = document.getElementById('validate_cer');

        $("#job_name").removeClass("border border-danger");
        $("#certificate_serial").removeClass("border border-danger");
        $("#validate_job_name").addClass('d-none');
        $("#validate_cer").addClass('d-none');

        if(job_name == '')
        {
            $("#job_name").addClass("border border-danger");
            $("#validate_job_name").removeClass('d-none');
            set_error_job.innerHTML = '{{__('corpsetting.job_name_error1')}}';
        }
        else if(cer == '' || cer == 'No Data' || cer == 'ยังไม่มีข้อมูล')
        {
            $("#certificate_serial").addClass("border border-danger");
            $("#validate_cer").removeClass('d-none');
            set_error_cer.innerHTML = '{{__('corpsetting.cer_error1')}}';
        }
        else
        {
            var RGEX = /^(?!.{16})[a-zA-Z0-9]{1,15}$/;
            var VALID = RGEX.test(job_name);
            if(VALID == false)
            {
                $("#job_name").addClass("border border-danger");
                $("#validate_job_name").removeClass('d-none');
                set_error_job.innerHTML = '{{__('corpsetting.job_name_error2')}}';
            }
            else
            {
                $("#create_jobs").submit();
            }
        }
    }

    function change_password(elem)
    {
        $('.username-rd-save').removeClass('d-none');
        let usernameRD = $(elem).closest(".card-body").find(".username-rd");
        $(usernameRD).prop("disabled", false);
        $(usernameRD).removeAttr("disabled");
        
        let passwordRD = ` <label class="template-text">{{__('initialSetup.password')}}</label><span class="text-danger">*</span>
                                                    <input type="password" id="password" name="password_rd" class="form-control password-rd">`;
        $(elem).closest(".form-group").append(passwordRD);

        $(elem).closest(".form-group").children(":nth-child(1)").remove();
        $(elem).remove();

        
    }

    function validate_job_code(elem)
    {
        var data_check = elem.value;
        var RGEX = /^(?!.{51})(([A-Za-z0-9]{1,50}))$/;
        var VALID = RGEX.test(data_check);
        if(VALID == false)
        {
            $(elem).removeClass('is-valid');
            $(elem).addClass('is-invalid');
            
            var del = $(elem).parent('.form-group').find('.check')
            $(del).find('.text-danger').remove()
            $(elem).parent('.form-group').find('.check').append('<label class="text-danger">{{__("initialSetup.request_english")}}</label>')
        }
        else
        {
            $(elem).removeClass('is-invalid');
            $(elem).addClass('is-valid');
            var del = $(elem).parent('.form-group').find('.check')
            $(del).find('.text-danger').remove()
        }
    }

    function SignatureVisible(elem_this){
        let getValue = $(elem_this).val();
        let Main = $(elem_this).closest(".function-section").index();
        let findParent = $(elem_this).closest(".function-section").parent();
        let getIndexParent = $(elem_this).closest(".job_block").index();

        if(getValue == "true"){
            GetElementVisible(findParent , getIndexParent)
        }
        else if(getValue == "false"){
            $(elem_this).closest(".function-section").parent().children().not(":eq("+Main+")").remove();
        }
    }

    function create_jobs(elem)
    {
        $('.index-jobs').addClass('d-none');
        $('.create-jobs').removeClass('d-none');
    }
    function cancel_jobs(elem)
    {
        $('.index-jobs').removeClass('d-none');
        $('.create-jobs').addClass('d-none');
    }
    function show_detail(ref)
    {
       
        $.ajax({
                url: '{{ url("Corporate/Setting/ETax/Detail") }}',
                type: 'POST',
                data: {
                    _token : "{{ csrf_token() }}",
                    reference : ref                    
                },
                success: function (response) {
                    console.log(response)
                    var data = JSON.stringify(response.job_detail);
                    var detail = `
                    <div class="col-12 justify-content-center">
                        <div class="pl-5 justify-content-center">
                            <div class="d-flex bd-highlight">
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >Certificate Serial :</div>
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >${response.job_detail[0].ref_ca}</div>
                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >JOB CODE   :</div>
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" > ${response.job_detail[0].name}</div>
                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >Sign PDF   :</div>
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >${response.job_detail[0].job_code}</div>
                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >Sign XML   :</div>
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >${response.job_detail[1].job_code}</div>
                            </div>
                            <div class="d-flex bd-highlight">
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >Send to RD :</div>
                                <div class="p-2 col-6 flex-fill bd-highlight text-left" >${response.job_detail[2].job_code}</div>
                            </div>
                        </div>
                    </div>
                                `  
                    Swal.fire('Job Detail', detail)
                }
            })
    }
    function inactive_job(ref)
    {
        bootbox.confirm({
            title: '<h2 class="template-text">Confirm to Change status</h2>',
            message: "Please confirm to Change status Job.",
            buttons: {
                confirm: {
                    label: 'OK',
                    className: 'btn-primary'
                },
                cancel: {
                    label: 'Cancel',
                    className: 'btn-secondary'
                }
            },
            callback: function (result) {
                $.blockUI()
                console.log(result)

                $('.bootbox.modal').modal('hide')
                // $('.modal').modal('hide')
                
                if ( result == true ) {
                   
                    $.ajax({
                        url: '{{ url("Corporate/Setting/ETax/Inactive") }}',
                        type: 'POST',
                        data: {
                            _token : "{{ csrf_token() }}",
                            reference : ref                    
                        },
                        success: function (response) {
                          window.location.reload()
                        }
                    })
                }
                else
                {
                    $.unblockUI()
                }
            }
        });
    }

</script>
@endsection