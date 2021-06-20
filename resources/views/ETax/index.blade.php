@extends('argon_layouts.app', ['title' => __('E-Tax')])


@section('style')
{{-- <link rel="stylesheet" href="{{ URL::asset('assets/css/style.css') }}"  media="all"> --}}

<style>
    .filter-active{
      box-shadow: 0 0 0pt 2pt #FFA500;
    }
</style>
@endsection

@section('content')

<input type="hidden" name="breadcrumb-title" value="{{__('etax.e_tax')}}">


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats active cursor-pointer filter-active">
                            <div class="card-body" data-status="CURRENT" onclick="filterStatus(this)">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('etax.current_document')}}</h5>
                                        <span id="current_record_total" class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="ni ni-folder-17"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats active cursor-pointer">
                            <div class="card-body" data-status="DONE" onclick="filterStatus(this)">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('etax.old_document')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="ni ni-folder-17"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="filter_status" id="filter_status" value="CURRENT">

                    <div class="card-body col-6 test-right">
                        <div class="d-flex justify-content-end">
                            <div class="" id="btn-create">
                                <a href="{{ url('/ETax/Create')}}" class="btn btn-neutral">{{__('etax.import_file')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
          
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
            
                                    <div class="col-4 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.document_number')}}</label>
                                            <input type="text" id="inv_search" name="inv_search" placeholder="{{__('etax.placeholder_search.document_number')}}" class="form-control">
                                        </div>
                                    </div>
    
                                    <div class="col-4 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.batch_name')}}</label>
                                            <input type="text" id="batch_search" name="batch_search" placeholder="{{__('etax.placeholder_search.batch_name')}}" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-4 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.buyer_name')}}</label>
                                            <input type="text" id="recipient_search" name="recipient_search" placeholder="{{__('etax.placeholder_search.buyer_name')}}" class="form-control">
                                        </div>
                                    </div>
            
                                </div>
                                <div class="row">
                                    <div class="col-4 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.imported_date')}}</label>
                                            <input type="text" id="daterange_search" name="daterange_search" placeholder="{{__('etax.placeholder_search.imported_date')}}" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    
                                    <div class="col-2 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.document_type')}}</label>
                                            <select class="form-control custom-form-control" name="doc_type_search" id="doc_type_search">
                                                <option selected disabled>{{__('etax.placeholder_search.document_type')}}</option>
                                                <option value="">All</option>
                                                <option value="tax_invoice">Tax invoice</option>
                                                <option value="credit_note">Credit Note</option>
                                                <option value="debit_note">Debit Note</option>
                                                <option value="invoice">Invoice</option>
                                                <option value="receipt">Receipt</option>
                                                <option value="cancel_notice">Cancel Notice</option>
                                                <option value="tax_invoice_minimal">Tax Invoice Mininal</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-2 px-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('etax.filter_document')}}</label>
                                            <select class="form-control custom-form-control" name="doc_status_search" id="doc_status_search">
                                                <option selected disabled>{{__('etax.placeholder_search.document_type')}}</option>
                                                <option value="">All</option>
                                                <option value="NEW">NEW</option>
                                                <option value="PROCESSING">PROCESSING</option>
                                                <option value="SUCCESS">SUCCESS</option>
                                                <option value="FAIL">FAIL</option>
                                                <option value="SEND TO RD">SEND TO RD</option>
                                                <option value="SEND TO TDID">SEND TO TDID</option>
                                                <option value="GEN PDF SUCCESS">GEN PDF SUCCESS</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="offset-md-2 col-md-2 mt-4">
                                        <div class="form-group">
                                            <button type="button" id="search" value="user" class="btn btn-primary w-100">{{__('common.search')}}</button>
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

   

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h3 class="mb-0">{{__('etax.document_list')}}</h3>
                        </div>
                        <div>
                            <button type="button" value="" onclick="choose_cert_modal()" class="btn btn-primary">{{__('etax.sign_document')}}</button>
                            <button type="button" value="" class="btn btn-primary">{{__('etax.send_to_buyer')}}</button>
                            <button type="button" value="" class="btn btn-primary">{{__('etax.send_to_rd')}}</button>
                        </div>
                      </div>
                        
                    </div>
                    
                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <form id="form_etax" action="{{ url('Etax/ConfirmSign') }}" method="POST" enctype="multipart/form-data" >
                                      {{ csrf_field() }}

                                <table id="etax_table" class="table simple-table table-with-icon no-spacing" style="width:100%"></table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{--Modal choose cert --}}
<div id="cert_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div id="" class="modal-body border-0">
                <div class="row">
                    <div class="col-12 text-center mb-3 pt-4">
                        <h3 class="template-text text-capitalize">
                            {{__('etax.please_select_ca')}}
                        </h3>
                    </div>
                    <div class="col-12">
                        <label class="form-control-label" for="example3cols1Input">Certificate</label>
                        <select class="form-control custom-form-control" name="cert" id="cert">
                            <option selected disabled>Choose certifacate</option>
                            @if(isset($corp_job_setting))
                                @if($corp_job_setting != null)
                                    @foreach($corp_job_setting as $index)
                                        <option value="{{$index->name}}">{{$index->name}}</option>
                                    @endforeach
                                @endif
                            @endif
                            
                        </select>
                    </div>
                    <div class="col-12 d-flex align-items-end flex-column mb-3 pt-4">
                        <div class="d-flex justify-content-end">
                            <button type="button" value="" onclick="submitJob(this)" class="btn btn-primary">ตกลง</button>
                            <button type="button" value="" data-dismiss="modal" class="btn btn-secondary">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/js/jquery.form.min.js')}}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">

    $(document).ready(function(){

        var etax_table = $("#etax_table").DataTable({
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
                url: '{!! URL::to("Etax/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.status = $('#filter_status').val(),
                    d.inv_search = $('#inv_search').val(),
                    d.batch_search = $('#batch_search').val(),
                    d.recipient_search = $('#recipient_search').val(),
                    d.daterange_search = $('#daterange_search').val(),
                    d.doc_type_search = $('#doc_type_search').val(),
                    d.doc_status_search = $('#doc_status_search').val()
                }
            },
            createdRow : function( row, data, dataIndex ) {
                $(row).addClass('state-unlock');
            },
            columns: [
                { data: 'reference_code',   name: 'reference_code',   title: '<input type="checkbox" onclick="checkedAll(this)">' },
                { data: 'etax_batch_name',  name: 'etax_batch_name',  title: '{{__('etax.batch')}}' , class: 'text-center' },
                { data: 'invoice_number',   name: 'invoice_number',   title: '{{__('etax.document_number')}}' , class: 'text-center' },
                { data: 'created_date',     name: 'created_date',     title: '{{__('etax.imported_date')}}' , class: 'text-center' },
                { data: 'buyer_name',       name: 'buyer_name',       title: '{{__('etax.buyer')}}' , class: 'text-center' },
                { data: 'total_amount',     name: 'total_amount',     title: '{{__('etax.amount_baht')}}' , class: 'text-center' },
                { data: 'document_name_en', name: 'document_name_en', title: '{{__('etax.document_type')}}' , class: 'text-center' },
                { data: 'invoice_number',   name: 'download',         title: '{{__('etax.download')}}' , class: 'text-center' },
                { data: 'is_send_rd',       name: 'is_send_rd',       title: '{{__('etax.send_rd_status')}}' , class: 'text-center' },
                { data: 'status',           name: 'status',           title: '{{__('etax.document_status')}}' , class: 'text-center' },
                { data: 'id',               name: 'action',           title: '{{__('etax.action')}}' , class: 'text-center' },
            ],
            aoColumnDefs: [
                {
                    "bSortable": false,
                    "aTargets": [0],
                    "mRender": function (data, type, full) {
                        var checkbox =  '<input id="'+data+'" class="magic-checkbox magic-tbody" type="checkbox" name="etax_reference[]" value="'+data+'">'+
                                        '<label for="'+data+'"></label>';

                        return checkbox;
                    }
                },
                {
                    "aTargets": [6],
                    "mRender": function (data, type, full) {
                        var text = data+'/'+full.document_name_th
                        return text;
                    }
                },
                {
                    "aTargets": [7],
                    "mRender": function (data, type, full) {
                        if((full.is_xml == true || full.is_xml == "1" || full.is_xml == 1) && (full.is_pdf == true || full.is_pdf == "1" || full.is_pdf == 1))
                        {
                            $('.callProcess').removeClass('d-none');
                            var btn =   '<ul class="list-inline">'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" onClick="downloadPDF(\'' + data + '\')" class="btn p-0">'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size"></i>'+
                                                    '<span class="d-block">{{__('etax.pdf')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" onclick="downloadXML(\''+ data +'\')" class="btn p-0">'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size"></i>'+
                                                    '<span class="d-block">{{__('etax.xml')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                        '<ul>';
                        }
                        else if((full.is_xml == true || full.is_xml == "1" || full.is_xml == 1) && (full.is_pdf != true || full.is_pdf != "1" || full.is_pdf != 1))
                        {
                            $('.callProcess').addClass('d-none');
                            var btn =   '<ul class="list-inline">'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" class="btn p-0" disabled>'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size grey"></i>'+
                                                    '<span class="d-block grey">{{__('etax.pdf')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" onclick="downloadXML(\''+ data +'\')" class="btn p-0">'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size"></i>'+
                                                    '<span class="d-block">{{__('etax.xml')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                        '</ul>';
                        }
                        else if((full.is_xml != true || full.is_xml != "1" || full.is_xml != 1) && (full.is_pdf == true || full.is_pdf == "1" || full.is_pdf == 1))
                        {
                            $('.callProcess').removeClass('d-none');
                            var btn =   '<ul class="list-inline">'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" onClick="downloadPDF(\'' + data + '\')" class="btn p-0">'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size"></i>'+
                                                    '<span class="d-block">{{__('etax.pdf')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                            '<li class="list-inline-item">'+
                                                '<button type="button" class="btn p-0" disabled >'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size grey"></i>'+
                                                    '<span class="d-block grey">{{__('etax.xml')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                        '</ul>';
                        }
                        else
                        {
                            $('.callProcess').addClass('d-none');
                            var btn =   '<ul class="list-inline">'+
                                            '<li class="list-inline-item">'+
                                                '<button  type="button" class="btn p-0" disabled >'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size grey"></i>'+
                                                    '<span class="d-block grey">{{__('etax.pdf')}}</span>'+
                                                '</button>'+
                                            '</li>'+
                                            '<span class="d-inline-block">'+
                                                '<button type="button" class="btn p-0" disabled >'+
                                                    '<i class="zmdi zmdi-download download-zmdi-icon zmdi-size grey"></i>'+
                                                    '<span class="d-block grey">{{__('etax.xml')}}</span>'+
                                                '</button>'+
                                            '<li>'
                                        '</ul>';
                        }
                
                
                        return btn;
                    }
                },
                {
                    "aTargets": [8],
                    "mRender": function (data, type, full) {
                        if(data == 1 && data == true)
                        {
                            var text = ` <label class="text-success">SEND</label>`
                           
                        }
                        else
                        {
                            var text = ` <label class="text-danger">NOT SEND</label>`
                        }
                        
                        return text;
                    }
                },
                {
                    "aTargets": [9],
                    "mRender": function (data, type, full) {
                        if(data == "NEW") {
                            return '<span class=""><i class="zmdi zmdi-notifications-active check-zmdi-icon zmdi-size unlock text-primary"></i><span class="new text-primary"> {{__('etax.new')}}</span></span>';
                        } else if(data == "PROCESSING") {
                            return '<span class=""><i class="zmdi zmdi-spinner check-zmdi-icon zmdi-size unlock text-warning"></i><span class="processing text-warning"> {{__('etax.process')}}</span></span>';
                        } else if(data == "SUCCESS") {
                            return '<span class=""><i class="zmdi zmdi-check-circle check-zmdi-icon zmdi-size unlock text-success"></i><span class="success text-success"> {{__('etax.success')}}</span></span>';
                        } else if(data == "FAIL") {
                            return '<span class=""><i class="zmdi zmdi-close-circle-o check-zmdi-icon zmdi-size unlock text-danger"></i><span class="fail text-danger"> {{__('etax.fail')}}</span></span>';
                        } else if(data == "SEND TO RD") {
                            return '<span class=""><i class="zmdi zmdi-mail-send check-zmdi-icon zmdi-size unlock text-success"></i><span class="success text-success">  {{__('etax.send_to_rd')}}</span></span>';
                        } else if(data == "SEND TO TDID") {
                            return '<span class=""><i class="zmdi zmdi-mail-send check-zmdi-icon zmdi-size unlock text-success"></i><span class="success text-success"> {{__('etax.send_to_tdid')}}</span></span>';
                        } else if(data == "GEN PDF SUCCESS") {
                            return '<span class=""><i class="zmdi zmdi-chart-donut check-zmdi-icon zmdi-size unlock text-primary"></i><span class="success text-uppercase text-primary"> {{__('etax.new')}}</span></span>';
                        } else if(data == "SIGN PENDING") {
                            return '<span class=""><i class="zmdi zmdi-chart-donut check-zmdi-icon zmdi-size unlock text-warning"></i><span class="success text-uppercase text-warning"> {{__('etax.pending')}}</span></span>';
                        } else {
                            return data;
                        }
                    }
                },
                {
                    "aTargets": [10],
                    "mRender": function (data, type, full) {
                            return  `<a class="btn btn-sm btn-default">
                                        <i class="ni ni-bold-right"></i>
                                    </a>`
                    }
                },
                
            ],
        });
        
    });
    
    $('input[name="daterange_search"]').daterangepicker({
    autoUpdateInput: false,
    timePicker: true,
    dateLimit: {
        "months": 1
    },
    timePickerIncrement: 30,
    timePicker24Hour: true,
    locale: {
        format: 'DD/MM/YYYY'
    },
    }, function (start, end) {
        $('input[name="daterange_search"]').val(start.format('DD/MM/YYYY HH:mm') + '-' + end.format('DD/MM/YYYY HH:mm'))
    })

    $('input[name="daterange_search"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('')
    })
    
    function submitJob(elem) {
        const ref = $('input[name="etax_reference[]"]:checked').map(function() {
            return $(this).val()
        }).toArray()
       
        const cert = $('#cert').val();

        if(cert != null && cert != undefined && cert != "")
        {
            bootbox.confirm({
                title: '<h2 class="template-text">Confirm to sign</h2>',
                message: "Please confirm to send file.",
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
                    $('.modal').modal('hide')
                    $('.bootbox.modal').modal('hide')
                    if (result == true) {
                        $('#form_etax').ajaxSubmit({
                            data: {
                                cert: cert
                            },
                            success:  function(response) {
                                $.unblockUI()
                                console.log('response: ', response)
                                if (response.success === true) {
                                    // $('.modal').modal('hide')
                                    Swal.fire('ส่งคำร้องขอสำเร็จ', '', 'success')
                                    window.location.reload()
                                } else {
                                    bootbox.alert(response.message || '{{__('etax.error_message_2')}}')
                                }
                            },
                            error: function(err) {
                                $.unblockUI()
                                console.error('error: ', err)
                                bootbox.alert('{{__('etax.error_message_2')}}')
                            }
                        });
                    }
                    else
                    {
                        $.unblockUI()
                    }
                }
            })
        }
        else
        {
            Swal.fire('{{__('etax.please_select_ca')}}!', '', 'error')
        }
    }
    
    function filterStatus(elem){
        $('#filter_status').val($(elem).data('status'));

        $($(elem).parents()[2]).find('.filter-active').removeClass('filter-active');
        $(elem).parent().addClass('filter-active');

        $("#etax_table").DataTable().ajax.reload();
    }

    function choose_cert_modal(){
        const ref = $('input[name="etax_reference[]"]:checked').map(function() {
            return $(this).val()
        }).toArray()

        if(ref != "" && ref != null && ref != undefined)
        {
            $('#cert_modal').modal('show');
        }
        else
        {
            Swal.fire('Please select Invoice!', '', 'error')
        }

    }

    function checkedAll(elem){
        if($(elem).is(':checked')) {
            $('#etax_table tbody tr.state-unlock').find('input[type="checkbox"]').prop("checked" , true);
        } else {
            $('#etax_table tbody tr').find('input[type="checkbox"]').prop("checked" , false);
        }
    }

    function downloadPDF(invoice_number)
    {
        window.open('{{ url('ETax/Download/PDF')}}/'+invoice_number, '_blank');
    }
    
    function downloadXML(invoice_number)
    {
        window.open('{{ url('ETax/Download/XML')}}/'+invoice_number, '_blank');
    }
    
    $('#search').on('click', function() {
        var etax_table = $("#etax_table").DataTable();
        etax_table.ajax.reload();
    });
</script>
@endsection
