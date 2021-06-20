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

    <form action="#" method="post" enctype="multipart/form-data" id="export_excel">

        {{ csrf_field() }}

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Virtual Card</h6>
                            
                        </div>
                        <div class="col-lg-6 col-5 text-right">
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
                                            <p class="text-sm mb-0"></p>
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
					url: '{!! URL::to("Visa/VirtualCard/objectData") !!}',
					method: 'POST',
					data: function (d) {
                        d._token        = "{{ csrf_token() }}"
						// d.daterange     = $('input[name="daterange"]').val() || '',
						// d.customer_code = $('input[name="customer_code"]').val() || '',
      //                   d.batch_name    = $('input[name="batch_name"]').val() || '',
						// d.inv_no        = $('input[name="inv_no"]').val() || ''
					}
				},
				columns: [
					{ data: 'recipient_code',  name: 'recipient_code', title: "Owner"  },
					{ data: 'credit_request',  name: 'credit_request', title: "Credit Request"  },
                    { data: 'start_date',      name: 'start_date',     title: "Start Date"  },
					{ data: 'end_date',        name: 'end_date',       title: "Expire Date"   },
                    { data: 'request_reason',  name: 'request_reason', title: "Reason"   },
                    { data: 'status',          name: 'status', title: "Status"   },
                    { data: 'reference_code',  name: 'reference_code', title: "{{__('bill.index.action')}}"   }
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
                                return '<span class="badge badge-primary">NEW</span>';
                            } else if(data == "PENDING"){
                                return '<span class="badge badge-warning">PENDING</span>';
                            } else if(data == "APPROVE"){
                                return '<span class="badge badge-success">APPROVE</span>';
                            } else if(data == "REJECT"){
                                return '<span class="badge badge-daner">REJECT</span>';
                            } else {
                                return '<span class="badge badge-secondary">'+data+'</span>';
                            }
                        }
                    },
					{
						aTargets: [6],
						mData: "id",
						mRender: function (data, type, full) {
							return '<a href="{!! URL::to("Visa/VirtualCard/request") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
						}
					}
				]
            })

		});

	</script>
@endsection
