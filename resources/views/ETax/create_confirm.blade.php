@extends('argon_layouts.app', ['title' => __('E-Tax')])

@section('style')
	<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all"> 
    <style>
        ul {
            position: relative;
            list-style: none;
            margin-left: 0;
            padding-left: 1.2em;
        }
        ul li:before {
            position: absolute;
            left: 0;
        }
    </style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Upload ETax Preview">
<div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('etax.upload')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('etaxt.create_confirm')}}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="d-flex flex-wrap">
                                <div class="col-12">
                                    <div class="w-50">
                                        <div class="card border-0 mb-0" style="background-color: #F1F1F1;">
                                            <div class="card-body py-1 px-1">
                                                <div class="text-left">
                                                    <i class="zmdi zmdi-file pl-4 pt-1 d-inline-block" style="font-size:45px;vertical-align:sub;"></i>
                                                    <p id="file_name" class="text-left pl-4 text-dark d-inline-block" style="vertical-align:super;"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mt-3">
                                <div class="col-12">
                                    <div class="row mx-auto">
                                        <!-- <div class="w-25 inquery-block mr-2">
                                            <div class="card text-white bg-primary">
                                                <div class="card-body">
                                                    <div class="primary-active">
                                                        <h2 class="number">
                                                            <span class="current comma title-primary">{{$total}}</span>
                                                        </h2>
                                                        <span class="desc">{{__('create_confirm.total')}}</span>
                                                        <div class="icon">
                                                            <i class="zmdi zmdi-upload title-primary"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-25 inquery-block mx-2">
                                            <div class="card text-white bg-success">
                                                <div class="card-body">
                                                    <div class="success-active">
                                                        <h2 class="number">
                                                            <span class="current comma title-success">{{$success}}</span>
                                                            <span class="divide">/</span>
                                                            <span class="total comma">{{$total}}</span>
                                                        </h2>
                                                        <span class="desc">{{__('create_confirm.success')}}</span>
                                                        <div class="icon">
                                                            <i class="zmdi zmdi-check-circle title-success"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-25 inquery-block mx-2">
                                            <div class="card text-white bg-danger">
                                                <div class="card-body">
                                                    <div class="danger-active">
                                                        <h2 class="number">
                                                            <span class="current comma title-danger">{{$fail}}</span>
                                                            <span class="divide">/</span>
                                                            <span class="total comma">{{$total}}</span>
                                                        </h2>
                                                        <span class="desc">{{__('create_confirm.fails')}}</span>
                                                        <div class="icon">
                                                            <i class="zmdi zmdi-close-circle-o title-danger"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card card-stats">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h2 class="number">
                                                                <span class="current comma title-primary">{{$total}}</span>
                                                            </h2>
                                                            <span class="desc">{{__('create_confirm.total')}}</span>
                                                            <div class="icon">
                                                                <i class="zmdi zmdi-upload title-primary"></i>
                                                            </div>
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
                                            <div class="card card-stats">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h2 class="number">
                                                                <span class="current comma title-success">{{$success}}</span>
                                                                <span class="divide">/</span>
                                                                <span class="total comma">{{$total}}</span>
                                                            </h2>
                                                            <span class="desc">{{__('create_confirm.success')}}</span>
                                                            <div class="icon">
                                                                <i class="zmdi zmdi-check-circle title-success"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                                <i class="ni ni-check-bold"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card card-stats">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h2 class="number">
                                                                <span class="current comma title-danger">{{$fail}}</span>
                                                                <span class="divide">/</span>
                                                                <span class="total comma">{{$total}}</span>
                                                            </h2>
                                                            <span class="desc">{{__('create_confirm.fails')}}</span>
                                                            <div class="icon">
                                                                <i class="zmdi zmdi-close-circle-o title-danger"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                                                <i class="ni ni-fat-remove"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" style="padding-right: 1.75rem;">
                                <div class="px-1 pt-4 float-right">
                                    <button type="button" class="btn btn-outline-info" onclick="cancel()">
                                    {{__('create_confirm.cancel_all')}}
                                    </button>
                                </div>
                                @if($total != $success && $fail > 0 && $total != 0)
                                    <div class="px-1 pt-4 float-right">
                                        <button type="button" class="btn btn-outline-warning" id="download-fail" onclick="download_error_file()">
                                        {{__('create_confirm.download_error')}}
                                        </button>
                                    </div>
                                @else
                                    <div class="px-1 pt-4 float-right">
                                        <button type="button" class="btn btn-primary" id="submit" onclick="submit_bill()">
                                        {{__('create_confirm.confirm')}}
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="col-12 table-responsive">
                                    <table id="confirm_upload_table" class="table simple-table" style="width:100%">
                                        
                                    </table>
                                    <div class="d-flex justify-content-between mt-3 col-12">
                                        <div class="">
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


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="confirm-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="post" action="{{ URL::to('ETax/Upload/CreateConfirm')}}" id="confirm">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="container-fluid py-3">
                        <div class="d-flex justify-content-center pt-4 pb-3">
                            <div class="">
                                <img src="{{ URL::asset('assets/images/graphic_confirm.png') }}" width="350">
                                <div class="float-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h5 style="color: #0065FF!important;">{{__('create_confirm.press_confirm')}}</h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="col-6">
                                <label class="text-aline-left">{{__('create_confirm.name_upload')}}</label>
                                <input type="text" class="form-control input-stream-key" id="batch_name" name="batch_name" value="WEB-{{date('Ymd')}}" required/>
                            </div>
                            <div class="col-6">
                                <label class="text-aline-left">{{__('create_confirm.description')}}</label>
                                <input type="text" class="form-control input-stream-key" name="batch_description"/>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 justify-content-center py-4">
                    <div class="row" id="loading">

                    </div>
                    <div class="row" id="btn">
                        <div class="col-6" >
                            <button type="button" class="btn btn-view" data-dismiss="modal" id="cancel-pass">
                            {{__('create_confirm.cancel')}}
                            </button>
                        </div>
                        <div class="col-6" >
                            <button type="submit" class="btn btn-primary" id="confirm-pass">
                            {{__('create_confirm.confirm')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script type="text/javascript">

    $('#confirm_upload_table').DataTable({
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
            url: '{!! URL::to("ETax/Upload/objectDataUpload") !!}',
            method: 'POST',
            data: function (d) {
                d._token = "{{ csrf_token() }}"
            }
        },
        createdRow: function( row, data, dataIndex ) {
            // Set the data-status attribute, and add a class
            $(row).find('td:eq(1)').css('text-transform' , 'capitalize');
            $(row).find('td:not(:first-child)').addClass("text-center");
            $(row).find('td:first-child').addClass("text-left");
            $(row).addClass(data.status)
        },
        @if($template === 'tax_invoice')
            columns: [
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'buyer_type',               title: '{{__('create_confirm.buyer_type')}}'  },
                { data: 'buyer_tax_id',             title: '{{__('create_confirm.buyer_tax_id')}}'  },
                { data: 'buyer_name',               title: '{{__('create_confirm.buyer_name')}}'  },
                // { data: 'product_description',      title: 'Product Name'  },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  }                
            ],
        @elseif($template === 'credit_note' || $template === 'debit_note')
            columns: [
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'buyer_type',               title: '{{__('create_confirm.buyer_type')}}'  },
                { data: 'buyer_tax_id',             title: '{{__('create_confirm.buyer_tax_id')}}'  },
                { data: 'buyer_name',               title: '{{__('create_confirm.buyer_name')}}'  },
                { data: 'total_amount_diff',        title: '{{__('create_confirm.total_amount_diff')}}'   },
                { data: 'product_description',      title: '{{__('create_confirm.product_description')}}'  },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  } 
            ],
        @elseif($template === 'receipt')
            columns: [
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'buyer_type',               title: '{{__('create_confirm.buyer_type')}}'  },
                { data: 'buyer_tax_id',             title: '{{__('create_confirm.buyer_tax_id')}}'  },
                { data: 'buyer_name',               title: '{{__('create_confirm.buyer_name')}}'  },
                { data: 'product_description',      title: '{{__('create_confirm.product_description')}}'  },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  } 
            ],
        @elseif($template === 'invoice')
            columns: [
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'export_date',              title: '{{__('create_confirm.export_date')}}'  },
                { data: 'product_description',      title: '{{__('create_confirm.product_description')}}'  },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  } 
            ],
        @elseif($template === 'cancel_notice')
            columns: [
                // { data: 'reference',                title: '{{__('create_confirm.reference')}}'  },
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'save_date',                title: '{{__('create_confirm.save_date')}}'  },
                { data: 'document_reference',       title: '{{__('create_confirm.document_reference')}}'  },
                { data: 'document_reference_date',  title: '{{__('create_confirm.document_reference_date')}}'  },
                { data: 'document_reference_code',  title: '{{__('create_confirm.document_reference_code')}}'  },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  } 
            ],
        @elseif($template === 'tax_invoice_minimal')
            columns: [
                { data: 'invoice_number',           title: '{{__('create_confirm.invoice_number')}}'  },
                { data: 'currency',                 title: '{{__('create_confirm.currency')}}'  },
                { data: 'product_description',      title: '{{__('create_confirm.product_description')}}'  },
                { data: 'total_amount',             title: '{{__('create_confirm.total_amount')}}'   },
                { data: 'buyer_mail',               title: '{{__('create_confirm.buyer_mail')}}'  },
                { data: 'buyer_mail_cc',            title: '{{__('create_confirm.buyer_mail_cc')}}'  },
                { data: 'status',                   title: '{{__('create_confirm.status')}}'  },
                { data: 'remark',                   title: '{{__('create_confirm.remark')}}'  } 
            ],
        @endif
        aoColumnDefs: [
            { className: "text-left", targets: [0]},
            { className: "text-center", targets: "_all" },
            {
                aTargets: [-2],
                mRender: function (data, type, full) {
                    if(data == 'success')
                    {
                        return '<i class="ni ni-check-bold text-success pr-2 font21px"></i><span class="text-success">{{__('create_confirm.success')}}</span>';
                    }
                    else
                    {
                        return '<i class="ni ni-fat-remove text-danger pr-2 font21px"></i><span class="text-danger">{{__('create_confirm.fails')}}</span>';
                    }
                }
            },
            {
                aTargets: [-1],
                mRender: function (data, type, full) {
                    if(data === 'PASS')
                    {
                        return '<span class="text-success">{{__('create_confirm.pass')}}</span>';
                    }
                    else
                    {
                        var _data = JSON.stringify(data);
                        var btn = `<span class="text-warning" onclick='ViewRemark(${_data})'>`+
                                        '<i class="ni ni-bulb-61"></i>'+
                                    '</span>';
                        return btn;
                    }
                }
            },
            {
                aTargets: [-3],
                mRender: function (data, type, full) {
                    if(full.buyer_email_cc !== "")
                    {
                        return '<i title="Have Email" class="ni ni-check-bold text-success pr-2 font21px"></i>';
                    }
                    else
                    {
                        return '<i title="No Email" class="fat-delete text-warning pr-2 font21px"></i>';
                    }
                }
            },
            {
                aTargets: [-4],
                mRender: function (data, type, full) {
                    if(full.buyer_email !== "")
                    {
                        return '<i title="Have Email" class="ni ni-check-bold text-success pr-2 font21px"></i>';
                    }
                    else
                    {
                        return '<i title="No Email" class="fat-delete text-warning pr-2 font21px"></i>';
                    }
                }
            },
        ]
    });

    function download_error_file()
    {
        window.open(' {{ url("ETax/Download/Error/File") }} ');
    }

    function ViewRemark(_data)
    {
        var data = JSON.stringify(_data);
        var append_text = ''
        for (var text in _data) {
            text += ' : '+_data[text];
            append_text += text+'<br/>'
        }
        const wrapper = document.createElement('div');
        wrapper.innerHTML = append_text;

        Swal.fire({
            title: '{{__("bill.confirm_bill.remark_detail")}}',
            html: wrapper,
            type: 'info',
            confirmButtonText: 'OK'
        });
    }

    function cancel()
    {
        window.location = "{!! URL::to('ETax/Create') !!}";
    }
    function submit_bill()
    {   
        $("#confirm-modal").modal();
    }

    $("#confirm-pass").on("click" , function(){
        if($("#batch_name").val() != '' && $("#batch_name").val() != null)
        {
            $("#batch_name").removeClass('border border-danger');
            $("#loading").removeClass('d-none');
            $("#loading").append(`<div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`);
            $("#btn").addClass('d-none');
            SubmitForm("#btn");
        }
       else
       {
            $("#batch_name").addClass('border-danger');
       }
        
    });

    function SubmitForm(elm){
        $('#confirm').ajaxForm({
            success: function(responseData){
                if(responseData.success == false){
                    // OpenAlertModal('{{__('create_confirm.fail')}}', responseData.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'));
                    Swal.fire({
                        title: '{{__("create_confirm.fail")}}',
                        html: responseData.message,
                        type: 'error',
                        confirmButtonText: 'OK'
                    });

                    $("#loading").addClass('d-none');
                    $("#loading").empty();
                    $(elm).removeClass('d-none');
                    return false;
                }
                else{
                    console.log('true ' + responseData.message);
                    window.location = "{!! URL::to('/ETax') !!}";
                }
            },
            error: function(responseData){
                // OpenAlertModal('{{__('create_confirm.fail')}}', responseData.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'));
                Swal.fire({
                    title: '{{__("create_confirm.fail")}}',
                    html: responseData.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
                
                $("#loading").addClass('d-none');
                $("#loading").empty();
                $(elm).removeClass('d-none');
                return false;
            } 
        });
    }



    var getfilename = sessionStorage.getItem("filename");
    $("#file_name").text(getfilename);

    // function download_temp(){
    //       window.location="{!! URL::to('loadTemplate') !!}";
    // }
    </script>
@endsection