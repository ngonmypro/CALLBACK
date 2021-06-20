@extends('argon_layouts.app', ['title' => __('Bill')])

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <style type="text/css">
        a {
            text-decoration: none;
            color: inherit;
        },
    </style>
@endsection

@section('content')

    <form action="{{ url('Bill/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_excel">

        {{ csrf_field() }}

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.index.title')}}</h6>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-stats">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.index.date')}}</label>
                                                <input type="text" name="daterange" id="daterange" class="form-control input-no-border text-style-6 bg-white" autocomplete="off"
                                        readonly="readonly" value="" placeholder="Select date"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.index.customer_code')}}</label>
                                                <input class="form-control" name="customer_code" type="text" value="" placeholder="{{__('bill.index.search_code')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.index.batch_name')}}</label>
                                                <input class="form-control" name="batch_name" type="text" value="" placeholder="{{__('bill.index.search_batch_name')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.index.invoice_number')}}</label>
                                                <input class="form-control" name="inv_no" type="text" value="" placeholder="{{__('bill.index.search_invoice_number')}}">
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols2Input">{{__('bill.index.bill_status')}}</label>
                                                <select class="form-control custom-form-control" name="bill_status" id="bill_status">
                                                    <option selected disabled>{{__('bill.index.bill_status')}}</option>
                                                    <option value="">{{__('common.all')}}</option>
                                                    <option value="NEW">{{__('common.new')}}</option>
                                                    @if( isset(session('BANK_CURRENT')['name_en']) && session('BANK_CURRENT')['name_en'] != 'TMB')
                                                    <option value="PENDING">{{__('common.pending')}}</option>
                                                    <option value="UNPAID">{{__('common.unpaid')}}</option>
                                                    @endif
                                                    <option value="INACTIVE">{{__('common.inactive')}}</option>
                                                    <option value="PAID">{{__('common.paid')}}</option>
                                                    <option value="REJECT">Reject</option>
                                                    <option value="ISSUE">{{__('common.issue')}}</option>
                                                    <option value="UNMATCH">{{__('common.unmatch')}}</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols2Input">Bill type</label>
                                                <select class="form-control custom-form-control" name="bill_type" id="bill_type">
                                                    <option selected disabled>Bill type</option>
                                                    <option value="">ALL</option>
                                                    <option value="INVOICE">INVOICE</option>
                                                    <option value="RECURRING">RECURRING</option>
                                                </select>
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
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{__('bill.index.title')}}</h3>
                                            <p class="text-sm mb-0">

                                            </p>
                                        </div>
                                        <div>
                                            <ul class="list-inline">
                                                @Permission(BILL.UPLOAD_CONSUMER_BILL)
                                                <li class="list-inline-item">
                                                    <a href="{!! URL::to("Bill/Import") !!}" class="btn btn-primary w-100">{{__('bill.index.import')}}</a>
                                                </li>

                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        {{ __('bill.index.create') }}
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="{{ action('Bill\UploadController@create_post') }}" class="dropdown-item">{{ __('bill.index.create_full_btn') }}</a>
                                                        <a href="{{ action('Bill\SimpleCreateController@createNoCorporate') }}" class="dropdown-item">{{ __('bill.index.create_simple_btn') }}</a>
                                                    </div>
                                                </div>
                                                @EndPermission
                                                
                                                @Permission(BILL.EXPORT_BILL_REPORT)
                                                <li class="list-inline-item">
                                                    <button type="button" id="export" class="btn btn-primary w-100">{{__('bill.index.export_excel')}}</button>
                                                 </li>
                                                @EndPermission 
                                            </ul>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="bill_table" class="table table-flush dataTable"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>



@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){

            $('#search').on('click', function () {
                table.search( this.value ).draw()
            })

            $('input[name="daterange"]').daterangepicker({
      			startDate: moment().subtract(7, 'days'),
      			endDate: moment(),
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
    		    $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
    		})

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
            })

			var table = $("#bill_table").DataTable({
				sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 6, 'desc' ]],
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
					url: '{!! URL::to("Bill/objectData") !!}',
					method: 'POST',
					data: function (d) {
                        d._token        = "{{ csrf_token() }}"
						d.daterange     = $('input[name="daterange"]').val() || '',
						d.customer_code = $('input[name="customer_code"]').val() || '',
                        d.batch_name    = $('input[name="batch_name"]').val() || '',
						d.inv_no        = $('input[name="inv_no"]').val() || ''
                        d.bill_status   = $('select[name="bill_status"]').val() || ''
                        d.bill_type     = $('select[name="bill_type"]').val() || ''
					}
				},
				columns: [
					{ data: 'batch_name',           name: 'batch_name',                 title: "{{__('bill.index.batch_name')}}"  },
					{ data: 'recipient_code',       name: 'recipient_code',             title: "{{__('bill.index.customer_code')}}"  },
                    { data: 'invoice_number',       name: 'invoice_number',             title: "{{__('bill.index.invoice_number')}}"  },
					{ data: 'bill_total_amount',    name: 'bill_total_amount',          title: "{{__('bill.index.total_amount')}}"   },
					{ data: 'bill_due_date',        name: 'bill_due_date',              title: "{{__('bill.index.due_date')}}"   },
					{ data: 'bill_status',          name: 'bill_status',                title: "{{__('bill.index.bill_status')}}"   },
                    { data: 'created_at',           name: 'created_at',                 title: "{{__('bill.index.created_at')}}"   },
                    { data: 'payment_status',       name: 'payment_status',             title: "{{__('bill.index.payment_status')}}"   },
                    { data: 'payment_status_reason',name: 'payment_status_reason',      title: "REASON"   },
                    { data: 'reference_code',       name: 'reference_code',             title: "{{__('bill.index.action')}}"   }
				],
				columnDefs: [
					// { className: "text-center", targets: "_all" }
				],
				aoColumnDefs: [
					{
						aTargets: [5],
						mData: "id",
						mRender: function (data, type, full) {
							if(data == "NEW"){
								return '<span class="badge badge-primary">{{__("common.new")}}</span>';
							} else if(data == "PENDING"){
                                return '<span class="badge badge-secondary">{{__("common.pending")}}</span>';
                            } else if(data == "UNPAID"){
                                return '<span class="text-light badge badge-dark">{{__("common.unpaid")}}</span>';
                            } else if(data == "INACTIVE"){
                                return '<span class="badge badge-danger">{{__("common.inactive")}}</span>';
                            } else if(data == "REJECT"){
                                return '<span class="badge badge-warning">REJECT</span>';
                            } else if(data == "PAID"){
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                            } else if(data == "EXPORTED"){
                                return '<span class="badge badge-info">EXPORTED</span>';
                            } else if(data == "ISSUE"){
                                return '<span class="badge badge-secondary">{{__("common.issue")}}</span>';
                            } else {
								return '<span class="badge badge-secondary">'+data+'</span>';
							}
						}
					},
					{
						aTargets: [6],
						mData: "id",
						mRender: function (data, type, full) {
							if(data == null || data == ''){
								return '-';
							} else {
								return data;
							}
						}
					},
					{
						aTargets: [7],
						mData: "id",
						mRender: function (data, type, full) {
							if(data == null){
								return '-';
							} else if(data == "UNPAID"){
                                return '<span class="text-light badge badge-dark">{{__("common.unpaid")}}</span>';
                            } else if(data == "PAID"){
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                            } else if(data == "REJECT"){
                                return '<span class="badge badge-warning">REJECT</span>';
                            }else {
                                return '<span class="badge badge-secondary">'+data+'</span>';
                            }
						}
					},
                    {
                        aTargets: [8],
                        mData: "id",
                        mRender: function (data, type, full) {
                            if(data == null){
                                return '-';
                            } else {
                                return data;
                            }
                        }
                    },
					{
						aTargets: [9],
						mData: "id",
						mRender: function (data, type, full) {
                            let btn_detail = ''
                            let btn_verify = ''

                            let inv = ''
                            let receipt_url =''

                            @Permission(BILL.VIEW)
                                // btn_detail = '<a href="{!! URL::to("Bill/Detail") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                                btn_detail = '<a onclick="bill_detail('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                            @EndPermission
                            
                            if(full.url != null){
                                inv = '<a href="#" onclick="download_invoice('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Download Invoice" ><i class="ni ni-cloud-download-95">I</i></a>'
                            }else{
                                 inv = '<a href="#" class="btn btn-sm btn-default disabled" title="Download Invoice" ><i class="ni ni-cloud-download-95">I</i></a>';
                            }
                            if(full.receipt_url != null){
                                receipt_url = '<a href="#" onclick="download_receipt('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Download Receipt"><i class="ni ni-cloud-download-95">R</i></a>';
                            }else{
                                receipt_url = '<a href="#" class="btn btn-sm btn-default disabled" title="Download Receipt" ><i class="ni ni-cloud-download-95">R</i></a>';
                            }
                            btn_verify = '<a href="#" onclick="manual_verify('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Manual Verify"><i class="ni ni-check-bold"></i></a>'                            
							return inv+receipt_url+btn_detail+btn_verify;
						}
					}
				]
            })



            $('#export').on('click', function(e) {
                $.blockUI()
                $('#export_excel').ajaxSubmit({
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

		});

        function bill_detail(data) {
            const url = '{!! URL::to("/Bill/Detail") !!}'
            window.location.href = url+'/'+data
        }

        function download_invoice(data){
    
           $.blockUI()
            $.ajax({
                        type: 'POST',
                        url: '{{ URL("Bill/Get/download_invoice") }}',
                        data: {
                            _token: `{{ csrf_token() }}`,
                            data: data
                        }
                    }).done(function(result) {
                        $.unblockUI()
                       console.log('result: '+ result)
                        if (result.success) {
                            console.log('result: ', result.data)
                            window.open(result.data, '_blank');
                        } else {
                            console.log('Error: ', result.message)
                            Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                        }
                    }).fail(function(err) {
                        $.unblockUI()
                        console.error('Error: ', err)
                        Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                    })
        }

        function download_receipt(data){
    
            $.blockUI()
            $.ajax({
              type: 'POST',
                 url: '{{ URL("Bill/Get/download_receipt") }}',
                 data: {
                     _token: `{{ csrf_token() }}`,
                     data: data
                 }
             }).done(function(result) {
                 $.unblockUI()
                console.log('result: '+ result)
                 if (result.success) {
                     console.log('result: ', result.data)
                     window.open(result.data, '_blank');
                 } else {
                     console.log('Error: ', result.message)
                     Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                 }
             }).fail(function(err) {
                 $.unblockUI()
                 console.error('Error: ', err)
                 Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
             })
        }

        function manual_verify(reference_code)
        {
            console.log(reference_code)

            const __html = `
                <form id="verify_form">
                    <div class="container-fluid py-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group my-0 text-left">
                                    <label class=""> Payment Channel </label>
                                    <select id="payment_channel" class="form-control">
                                        @if($data != NULL)
                                            @foreach($data as $v)
                                                <option value="{{ $v->channel_name}}">{{ $v->channel_type }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            `

            Swal.fire({
                title: `Verify Payment`,
                confirmButtonText: `{{__('common.confirm')}}`,
                text: `{{__('bill.detail.repayment.heading')}}`,
                html: __html,
                showCancelButton: true,
                cancelButtonText: `{{__('common.cancel')}}`,
                // width: '30%',
                onOpen: (ev) => {
                    console.log('initial')
                },
                inputValidator: (result) => {
                    console.log('validation')
                    return true
                }
            }).then((result) => {
                $.blockUI()
                console.log('Input', { result: result.value })

                if ( result.value ) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ URL("Bill/Verify") }}',
                        data: {
                            _token: `{{ csrf_token() }}`,
                            payment_channel: $('#payment_channel').val(),
                            reference_code: reference_code
                        }
                    }).done(function(result) {
                        $.unblockUI()
                        if (!!result.success) {
                            Swal.fire(`{{ (__('common.success')) }}`, 'Please wait for precessing.', 'success')
                        } else {
                            console.error('Error: ', result.message)
                            Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                        }
                    }).fail(function(err) {
                        $.unblockUI()
                        console.error('Error: ', err)
                        Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                    })
                } else {
                    
                    $.unblockUI()
                }
            })

        }

	</script>
@endsection
