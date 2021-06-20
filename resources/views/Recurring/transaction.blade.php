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
    <link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
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
                                                    <option value="REJECT">Reject</option>
                                                    <option value="UNMATCH">Unmatch</option>
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
                                                <label class="form-control-label" for="example3cols2Input">Reference code</label>
                                                <input class="form-control" name="reference_code" type="text" value="" placeholder="reference_code">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">{{__('payment_transaction.transaction_id')}}</label>
                                                <input class="form-control" name="txn_id"  id="txn_id" type="text" value="" placeholder="{{__('payment_transaction.search_transaction_id')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label">Company Name</label>
                                                <select name="company_name" class="company_name" id="company_name"></select>
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
                            <div class="col-2"></div>
                            <div class="col-2">
                                <a href="{!! URL::to("Recurring/Payment/import") !!}" class="btn btn-primary w-100">Import txt</a>
                            </div>

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
    <script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
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
    		    dateLimit: {
    		        "months": 1
    		    },
    	
    		    locale: {
    		        format: 'DD/MM/YYYY'
    		    }

    		}, function (start, end) {

                var getDate =start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY');

                $('input[name="daterange"]').val(getDate);
            })
            
            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
            })

            $('input[name="transaction_time"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
            })

            const currentlang = `{{ app()->getLocale() }}`

  

            $('#company_name').select2({
                placeholder: "{{__('role.corp_search')}}",
                 minimumInputLength: 2,
                language: {
                    inputTooShort: function() {
                        return "{{__('role.corp_search_validate')}}";
                    }
                },
                ajax: {
                    delay: 250,
                    cache: true,
                    url: '{{ action("CorporateController@select2_textid") }}',
                    dataType: 'json',
                    type: 'post',
                    data: function(params) {
                        const query = {
                            search: params.term,
                            _token: '{{ csrf_token() }}'
                        }
                        return query
                    },
                    processResults: function(data, page) {
                        if(currentlang == 'en'){
                            return {
                                results: $.map(data.items, function(item) {
                                    return { id: item.text_en, text: item.text_en+" ("+item.tax_id+")" }
                                })
                            }
                        }else{
                            return {
                                results: $.map(data.items, function(item) {
                                    return { id: item.tax_id, text: item.text_th+" ("+item.tax_id+")" }
                                })
                            }
                        }
                    }
                }
            })

         
            $('#search').on('click', function () {
                // if (! _.isEmpty( $('#company_name').val() ) ) {
                    table.search( this.value ).draw()
                // }
            })



    		var table = $("#report_list").DataTable({
    			sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, 'desc' ] , [ 9 , 'desc']],
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
    				url: '{!! URL::to("Recurring/Transaction/ObjectData") !!}',
    				method: 'POST',
    				data: function (d) {
    					d._token = "{{ csrf_token() }}",
                        d.currentlang = currentlang,
    					d.daterange = $('input[name="daterange"]').val()
                        d.transaction_time = $('input[name="transaction_time"]').val()
                        d.status = $('#status').val()
                        d.company_name = $('#company_name').val()
    					d.inv_no = $('input[name="inv_no"]').val()
                        d.reference_code = $('input[name="reference_code"]').val()
                        d.txn_id = $('input[name="txn_id"]').val()
    				}
    			},
    			columns: [
                    { data: 'transaction_date',         name: 'transaction_date',           title: '{{__("payment_transaction.payment_datetime")}}',        class: 'text-center' },
                    { data: 'ref_3',           name: 'ref_3',             title: '{{__("payment_transaction.invoice_number")}}',          class: 'text-center' },
                    { data: 'reference_code',           name: 'reference_code',             title: 'reference_code',          class: 'text-center' },
                    { data: 'recipient_code',           name: 'recipient_code',             title: '{{__("payment_transaction.customer_code")}}',          class: 'text-center' },
                    { data: 'transaction_id',	        name: 'transaction_id',             title: '{{__("payment_transaction.transaction_id")}}',          class: 'text-center' },
                    { data: 'amount',			        name: 'amount',                     title: '{{__("common.total_amount")}}',                         class: 'text-center' },
                    @if( app()->getLocale() == "en" )
                    { data: 'name_en',                  name: 'name_en',                    title: 'company name',                                               class: 'text-center' },
                    @else
                    { data: 'name_th',                  name: 'name_th',                    title: 'company name',                                               class: 'text-center' },
                    @endif
                    { data: 'status',                   name: 'status',                     title: '{{__("common.status")}}',                               class: 'text-center' },
                    { data: 'status_reason',            name: 'status_reason',              title: '{{__("common.reason")}}',                               class: 'text-center' },
                    { data: 'transaction_time',               name: 'transaction_time',                 title: '{{__("payment_transaction.transaction_time")}}',              class: 'd-none' },
                    // { data: 'created_at',         name: 'created_at',           title: '{{__("payment_transaction.created_at")}}',        class: 'd-none' },
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
                        aTargets: [7],
    					mData: null,
    					mRender: function (data, type, full) {
    						if (data === "PAID") {
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                            }
                            else if(data === "UNMATCH") {
                                return `<span class="badge badge-secondary">UNMATCH</span>`;
                            }else if(data === "REJECT"){
                                return `<span class="badge badge-danger">REJECT</span>`;
                            }
    					}
                    }
    					
                ]
    		
    		})

    	})

</script>
@endsection
