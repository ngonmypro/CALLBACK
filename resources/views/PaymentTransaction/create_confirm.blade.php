@extends('argon_layouts.app', ['title' => 'Upload Transaction'])

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__("payment_transaction.upload_transaction")}}</h6>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__("payment_transaction.file")}}</h5>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__("payment_transaction.total_record")}}</h5>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__("payment_transaction.total_success")}}</h5>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__("payment_transaction.total_fail")}}</h5>
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
                                <h3 class="mb-0">{{__("payment_transaction.upload_transaction")}}</h3>
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
                                    <h5 class="title">{{__("payment_transaction.confirm_message")}}</h5>
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
            { data: 'document_reference_number',    title: '{{__("payment_transaction.reference_number")}}'  },
            { data: 'account_number',               title: '{{__("payment_transaction.account_number")}}'  },
            { data: 'transaction_amount',           title: '{{__("common.amount")}}'  },
            { data: 'transaction_date',             title: '{{__("common.date")}}'  },
            { data: 'transaction_code_description', title: '{{__("common.channel")}}'  },
            { data: 'status',                       title: '{{__("common.status")}}'  },
        ],
        aoColumnDefs: [
            { className: "text-center", targets: "_all" },
            {
                aTargets: [5],
                mRender: function (data, type, full) {
                    if(data === 'success') {
                        return '<span class="badge badge-success">{{__("common.success")}}</span>';
                    } else {
                        return '<span class="badge badge-danger">{{__("common.fail")}}</span>';
                    }
                }
            }
        ]
    });

    function ViewRemark(_data) {
        var data = JSON.stringify(_data)
        Swal.fire('Remark Detail', data, 'error')
    }

    function cancel()
    {
        window.location = "{!! URL::to('PaymentTransaction') !!}";
    }
    function submit_bill()
    {
        $("#confirm-modal").modal()
    }

    $("#confirm-pass").on("click" , function(){
        $("#batch_name").removeClass('border border-danger')
        $("#btn").addClass('d-none')
        $("#confirm-modal").modal('hide')
        SubmitForm("#btn")
    })

    function SubmitForm(elm){
        $.blockUI()

        $('#confirm').ajaxForm({
            success: function(responseData){
                $.unblockUI()
                if (!responseData.success) {
                    var data = JSON.stringify(responseData.data)
                    Swal.fire('Oops! Someting wrong.', responseData.message, 'error')
                    $(elm).removeClass('d-none');
                    return false;
                }
                else if(responseData.success == true){
                    console.log('true ' + responseData.message);
                    window.location = "{!! URL::to('/PaymentTransaction') !!}";
                }
            },
            error: function(responseData){
                $.unblockUI()
                Swal.fire('Oops! Someting wrong.', responseData.message, 'error')
                $(elm).removeClass('d-none');
                return false;
            } 
        });
    }

    var getfilename = sessionStorage.getItem("filename")
    $("#file_name").text(getfilename)

    </script>
@endsection