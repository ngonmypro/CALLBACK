@extends('argon_layouts.app', ['title' => 'Repayment Cash Preview'])

@section('style')
	<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all"> 
@endsection

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Repayment Cash Preview</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">FILE</h5>
                                        <span class="h2 font-weight-bold mb-0"><small style="font-size:9px;" id="file_name"></small></span>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Record</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $total }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-chart-bar-32"></i>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Success</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $success }}</span>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">Total Fail</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $fail }}</span>
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
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Repayment Cash Preview</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-warning" onclick="cancel()">{{ (__('common.cancel')) }}</button>
                                @if($total == $success && $fail == 0 && $total != 0)
                                    <button type="button" class="btn btn-success" id="submit" onclick="submit_bill()">{{ (__('common.confirm')) }}</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="confirm_upload_table" class="table simple-table" style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="confirm-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form-horizontal" method="post" action="{{ URL::to('PaymentTransaction/Import/CreateConfirm')}}" id="confirm">
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
                                    <h5 style="color: #0065FF!important;">Are you sure to upload the transactions?</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 justify-content-center py-4">
                        <div class="row" id="loading">

                        </div>
                        <div class="row" id="btn">
                            <div class="col-6" >
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-pass">{{ (__('common.cancel')) }}</button>
                            </div>
                            <div class="col-6" >
                                <button type="submit" class="btn btn-primary" id="confirm-pass">{{ (__('common.confirm')) }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
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
            url: '{!! URL::to("PaymentTransaction/Import/objectData") !!}',
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
        columns: [
            { data: 'invoice_number',               title: 'Invoice Number'  },
            { data: 'customer_code',                title: 'Customer Code'  },
            { data: 'payment_date',                 title: 'Payment Date'  },
            { data: 'ref_1',                        title: 'Ref 1'  },
            { data: 'status',                       title: 'status', orderable: false  },
            { data: 'status_reason',                title: 'message', orderable: false  },
        ],
        aoColumnDefs: [
            { className: "text-left", targets: [0]},
            { className: "text-center", targets: "_all" },
            {
                aTargets: [1],
                mRender: function (data, type, full) {
                    if (typeof data === 'object' || data === null || data === '') {
                        return '-';
                    } else {
                        return data;
                    }
                }
            },
            {
                aTargets: [4],
                mRender: function (data, type, full) {
                    if (data === 'success') {
                        return '<span class="badge badge-lg badge-pill badge-success">Success</span>';
                    } else {
                        return '<span class="badge badge-lg badge-pill badge-danger">Fail</span>';
                    }
                }
            },
            {
                aTargets: [5],
                mRender: function (data, type, full) {
                    if (data === '') {
                        return '<span class="badge badge-lg badge-pill badge-success">PASS</span>';
                    } else {
                        var _data = JSON.stringify(data)
                        var btn = `
                            <span onclick='ViewRemark(${_data})'>`+
                                '<i title="View Remark" class="ni ni-bulb-61 text-warning pr-2 font21px"></i>'+
                            '</span>'
                        return btn
                    }
                }
            }
        ]
    })

    function ViewRemark(_data) {
        try {
            var append_text = ''
            var data = JSON.stringify(_data)
            for (var text in _data) {
                text = _data[text]
                append_text += '<li>'+text+'</li>'
            }

            Swal.fire({
                title: 'Remark Detail',
                html: append_text,
                type: 'warning',
                confirmButtonText: 'OK'
            })

        } catch (e) {
            console.error('error: ', e)
            Swal.fire({
                title: 'Remark Detail',
                text: 'validation fail',
                type: 'warning',
                confirmButtonText: 'OK'
            })
        }
        
    }

    function cancel()
    {
        window.location = "{!! URL::to('PaymentTransaction') !!}";
    }

    function submit_bill()
    {
        $('#confirm-modal').modal()
    }

    $('#confirm-pass').on('click' , function(){
        $('#batch_name').removeClass('border border-danger')
        $('#loading').removeClass('d-none')
        $('#loading').append(`
            <div class="text-primary" role="status">
                <span class="text-center">Loading...</span>
            </div>
        `)
        $('#btn').addClass('d-none')
        SubmitForm('#btn')
    })

    function SubmitForm(elm){
        $('#confirm').ajaxForm({
            success: function(response){
                console.log('response: ', response)
                if( !response.success ){
                    Swal.fire(`{{ __('common.error') }}`, response.message, 'warning');
                    $("#loading").addClass('d-none')
                    $("#loading").empty()
                    $(elm).removeClass('d-none')
                    return false
                } else {
                    window.location = "{!! URL::to('/PaymentTransaction') !!}"
                }
            },
            error: function(err){
                Swal.fire(`{{ __('common.error') }}`, err.message || '', 'error')
                $("#loading").addClass('d-none')
                $("#loading").empty()
                $(elm).removeClass('d-none')
                return false
            } 
        });
    }

    var getfilename = sessionStorage.getItem("filename")
    $("#file_name").text(getfilename)
    
    </script>
@endsection