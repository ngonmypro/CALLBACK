@extends('argon_layouts.app', ['title' => __('Payment Transaction')])

@section('style')

    <style type="text/css">
        .check-zmdi-icon.new{
            color: #0ce2b0;
        }
        .check-zmdi-icon.paid{
            color: #0ce2b0;
        }
        .check-zmdi-icon.unpaid{
            color: #0ce2b0;
        }
        .check-zmdi-icon.payment_success{
            color: #0ce2b0;
        }
    </style>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('payment_transaction.title')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    </div>
                </div>

                <form action="{{ url('PaymentTransaction/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_transaction_excel">

                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols1Input">{{__('payment_transaction.payment_datetime')}}</label>
                                                <div class="input-daterange  row align-items-center">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                                </div>
                                                                <input class="form-control daterange" name="daterange" placeholder="Start date - End date" type="text" value="">
                                                                <!-- <input class="form-control transaction_time" name="transaction_time" type="hidden" value=""> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                                <select class="form-control custom-form-control" name="status" id="status">
                                                    <option disabled>{{__('common.status')}}</option>
                                                    <option selected value="all">{{__('common.all')}}</option>
                                                    <option value="PAID">{{__('common.paid')}}</option>
                                                    <option value="UNPAID">{{__('common.unpaid')}}</option>
                                                    <option value="DUPLICATE_PAID">{{__('common.duplicate_paid')}}</option>
                                                    <option value="UNMATCH">{{__('common.unmatch')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">{{__('payment_transaction.invoice_number')}}</label>
                                                <input class="form-control" name="inv_no" type="text" value="" placeholder="{{__('payment_transaction.search_invoice_number')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">{{__('payment_transaction.transaction_id')}}</label>
                                                <input class="form-control" name="txn_id" type="text" value="" placeholder="{{__('payment_transaction.search_transaction_id')}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row px-3">

                                    <div class="offset-md-10 col-md-2">
                                        <div class="form-group">
                                            <button type="button" id="search" class="btn btn-primary w-100">{{__('common.search')}}</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </form>

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
                                <h3 class="mb-0">{{__('payment_transaction.title')}}</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                            @Permission(PAYMENT_TRANSACTION.IMPORT)
                            <div class="col-2">
                                <a href="{!! URL::to("PaymentTransaction/Import") !!}" class="btn btn-primary w-100">{{__('payment_transaction.import_txn')}}</a>
                            </div>
                            @EndPermission
                            @Permission(PAYMENT_TRANSACTION.EXPORT)
                            <div class="col-2">
                                <button id="export" class="btn btn-primary w-100">{{__('payment_transaction.export_excel')}}</button>
                            </div>
                            @EndPermission  

                        </div>
                    </div>

                    <div class="w-100 table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="report_list" class="table table-flush dataTable" style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!-- <script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script> -->
	<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>

    <!--- Daterange picker --->
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>

    <script type="text/javascript">


    	$(document).ready(function() {

            $('#export').on('click', function() {
                $.blockUI()
                $('#export_transaction_excel').ajaxSubmit({
                    error: function(err) {
                        $.unblockUI()
                        console.error('error: ', err)
                        Swal.fire('Oops! Someting wrong.', err.message || "{{__('common.system_error_1')}}", 'error')
                    },
                    success:function(response){
                        $.unblockUI()
                        if (!!response.success) {
                            Swal.fire("{{__('common.export_report_success')}}", "{{__('common.message_send')}}", 'success')
                        } else {
                            Swal.fire("Oops! Someting wrong.", "{{__('common.system_error_1')}}", 'error')
                        }
                    }
                })
                return false
            })

    		$('input[name="daterange"]').daterangepicker({
      			startDate: moment().subtract(7, 'days'),
      			endDate: moment(),
    		    // timePicker: true, //time
    		    dateLimit: {
    		        "months": 1
    		    },
    		    // timePickerIncrement: 30, //time
    		    // timePicker24Hour: true, //time
    		    locale: {
                    // format: 'HH:mm:ss',
    		        format: 'DD/MM/YYYY'

    		    }

    		}, function (start, end) {

                var getDate =start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY');
                // var splitTime = start.format('HH:mm:ss') + ' - ' + end.format('HH:mm:ss')

                $('input[name="daterange"]').val(getDate);
                // $('input[name="transaction_time"]').val(splitTime)                
            })

       


            
            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
            })

            $('input[name="transaction_time"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
            })


    		var table = $("#report_list").DataTable({
    			sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, 'desc' ], [ 10, 'desc' ]],
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
    				url: '{!! URL::to("PaymentTransaction/objectData") !!}',
    				method: 'POST',
    				data: function (d) {
    					d._token = "{{ csrf_token() }}",
    					d.daterange = $('input[name="daterange"]').val()
                        d.transaction_time = $('input[name="transaction_time"]').val()
                        d.status = $('#status').val()
    					d.txn_id = $('input[name="txn_id"]').val()
    					d.inv_no = $('input[name="inv_no"]').val()
    				}
    			},
    			columns: [
                    { data: 'transaction_date',         name: 'transaction_date',           title: '{{__("payment_transaction.payment_datetime")}}',        class: 'text-center' },
                    { data: 'invoice_number',           name: 'invoice_number',             title: '{{__("payment_transaction.invoice_number")}}',          class: 'text-center' },
                    { data: 'recipient_code',           name: 'recipient_code',             title: '{{__("payment_transaction.customer_code")}}',           class: 'text-center' },
                    { data: 'full_name',                name: 'full_name',                  title: '{{__("payment_transaction.customer_name")}}',           class: 'text-center' },
    				{ data: 'from_name',	            name: 'from_name',                  title: '{{__("payment_transaction.payer")}}',                   class: 'text-center' },
                    { data: 'transaction_id',	        name: 'transaction_id',             title: '{{__("payment_transaction.transaction_id")}}',          class: 'text-center' },
                    { data: 'payment_channel',          name: 'payment_channel',            title: '{{__("payment_transaction.payment_channel")}}',         class: 'text-center' },
                    { data: 'amount',			        name: 'amount',                     title: '{{__("common.total_amount")}}',                         class: 'text-center' },
                    { data: 'status',                   name: 'status',                     title: '{{__("common.status")}}',                               class: 'text-center' },
                    { data: 'status_reason',            name: 'status_reason',              title: '{{__("common.reason")}}',                               class: 'text-center' },
                    { data: 'transaction_time',         name: 'transaction_time',           title: '{{__("payment_transaction.transaction_time")}}',        class: 'd-none' },
                ],
    			aoColumnDefs: [
                    {
    					aTargets: [0],
    					mData: null,
    					mRender: function (data, type, full) {
                            return `${full.transaction_date || ''} ${full.transaction_time || ''}`
    					}
                    },
                    {
                        aTargets: [3],
                        mData: null,
                        mRender: function (data, type, full) {
                            if (full.full_name !== '' && full.full_name !== null) {
                                return full.full_name
                            } else {
                                return `${full.first_name || ''} ${full.middle_name || ''} ${full.last_name || ''}`
                            }
                        }
                    },
                    {
                        aTargets: [6],
                        mData: null,
                        mRender: function (data, type, full) {
                            return _.ucwords(full.payment_channel || '')
                        }
                    },
    				{
    					aTargets: [8],
    					mData: null,
    					mRender: function (data, type, full) {
    						if (data === "PAID") {
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                            } else if(data === "UNPAID") {
                                return '<span class="badge badge-warning">{{__("common.unpaid")}}</span>';
                            } else if(data === "DUPLICATE_PAID") {
                                return '<span class="badge badge-danger">{{__("common.duplicate_paid")}}</span>';
                            }
                            else if(data === "REJECT"){
                                return `<span class="badge badge-danger">REJECT</span>`;
                            } else {
                                return `<span class="badge badge-secondary">${_.ucwords(data || '')}</span>`;
                            }
    					}
    				},
                    {
                        aTargets: '_all',
                        mData: "id",
                        mRender: function (data, type, full) {
                            return data == null || data == '' ? '-' : data;
                        }
                    },
    			],
    		})

            $('#search').on('click', function () {
                table.search( this.value ).draw()
            })

    	})

</script>
@endsection
