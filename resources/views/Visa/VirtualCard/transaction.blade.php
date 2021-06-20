@extends('argon_layouts.app', ['title' => __('Virtual Card')])

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

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Visa Transaction</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    </div>
                </div>

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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                   

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">{{__('payment_transaction.transaction_id')}}</label>
                                                <input class="form-control" name="txn_id" id="txn_id" type="text" value="" placeholder="{{__('payment_transaction.search_transaction_id')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">Customer Code</label>
                                                <input class="form-control" name="customer_code" id="customer_code" type="text" value="" placeholder="customer code">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label" for="example3cols2Input">Name</label>
                                                <input class="form-control" name="full_name" id="full_name" type="text" value="" placeholder="Full Name">
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
                                            <h3 class="mb-0">Virtual Card List</h3>
                                            <p class="text-sm mb-0">

                                            </p>
                                        </div>
                                        <div>
                                            <ul class="list-inline"> 

                                                <li class="list-inline-item">
                                                   <a href="{!! URL::to('Visa/VirtualCard/setting') !!}" class="btn btn-primary w-100 text-uppercase">Setting</a>
                                                </li>
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
    		    }

    		}, function (start, end) {
    		    $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
    		})

			var table = $("#bill_table").DataTable({
				sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ],[ 1, "desc" ]],
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
					url: '{!! URL::to("Visa/VirtualCard/Object_Transaction") !!}',
					method: 'POST',
						data: function (d) {
                        d._token        = "{{ csrf_token() }}"
                        d.txn_id     = $('input[name="txn_id"]').val() || '',
                        d.customer_code     = $('input[name="customer_code"]').val() || '',
                        d.full_name     = $('input[name="full_name"]').val() || '',
                        d.daterange = $('input[name="daterange"]').val()
					}
                },
				columns: [
                    { data: 'auth_date',            name: 'auth_date',              title: "Auth Date"   },
                    { data: 'auth_time',            name: 'auth_time',              title: "Auth Time"   },
                    { data: 'auth_status',          name: 'auth_status',            title: "Auth Status"   },
                    { data: 'account_number_mask',  name: 'account_number_mask',    title: "Account Number"   },
                    { data: 'transaction_id',       name: 'transaction_id',         title: "Transaction id"  },
                    { data: 'transaction_amount',   name: 'transaction_amount',     title: "Transaction Amount"   },
                    { data: 'recipient_code',       name: 'recipient_code',         title: "Customer Code"   },
                    { data: 'full_name',            name: 'full_name',              title: "Customer Name"   },
                ],
				columnDefs: [
				],
				aoColumnDefs: [
				]
            })

		});

	</script>
@endsection
