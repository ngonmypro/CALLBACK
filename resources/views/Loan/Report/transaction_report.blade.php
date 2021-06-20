@extends('layouts.master')
@section('title', 'Transaction Report')
@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/export_report/buttons.bootstrap4.min.css') }}" rel="stylesheet" media="all">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('loan_contract.payment.title')}}">

@Permission(LOAN_MANAGEMENT.EXPORT_PAYMENT_TXN)
<form action="{{ url('Loan/Report/Transaction/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_transaction_excel">
@EndPermission 
    
    {{ csrf_field() }}
    <div class="col-12 mt-4">
        <div class="d-flex flex-wrap">
            <div class="px-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <input type="text" name="daterange" id="daterange" class="form-control input-no-border text-style-6 bg-white" autocomplete="off"
                                   readonly="readonly" value="" placeholder="Select date"/>
                        <span class="oi oi-calendar icon-inline text-style-6" name="daterange"></span>
                    </div>
                </div>
            </div>
            <div class="px-2 w-25">
              <div class="col-12 px-0">
                  <select class="form-control custom-form-control" name="status" id="status">
	                    <option disabled>{{__('loan_contract.payment.status')}}</option>
	                    <option selected value="all">{{__('loan_contract.payment.all')}}</option>
	                    <option value="1">{{__('loan_contract.payment.active')}}</option>
	                    <option value="2">{{__('loan_contract.payment.pending')}}</option>
	                </select>
              </div>
            </div>
            <div class="px-2 w-25">
              <div class="col-12 px-0">
                <input type="text" id="data_search" name="data_search" placeholder="Search" class="form-control pl-5">
                <span class="oi oi-magnifying-glass inline-icon text-style-6"></span>
              </div>
            </div>
            <div class="ml-auto">
                <button id="export_excel" name="export_excel" type="button" value="1" class="btn btn-print form-control" onclick="SubmitForm()">
                    <span class="">{{__('loan_contract.payment.export_excel')}}</span>
                </button>
            </div>
        </div>
    </div>
</form>
<div class="col-12">
    <div class="d-flex flex-wrap">
        <div class="flex-fill px-2">
            <div id="table-block" class="table-responsive">
            	<table id="report_list" class="table simple-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">{{__('loan_contract.payment.bill_reference')}}</th>
                            <th class="text-center">{{__('loan_contract.payment.from')}}</th>
                            <th class="text-center">{{__('loan_contract.payment.transaction_id')}}</th>
                            <th class="text-center">{{__('loan_contract.payment.amount')}}</th>
                            <th class="text-center">{{__('loan_contract.payment.date')}}</th>
                            <th class="text-center">{{__('loan_contract.payment.status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            {{--  //datatable  --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
	<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <!--- Daterange picker --->
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
    //daterange
		$('input[name="daterange"] , [name="daterange"]').daterangepicker({
  			startDate: moment() ,
  			endDate: moment() ,
		    // autoUpdateInput: false,
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
		    $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
			$('#report_list').DataTable().ajax.reload();
				// table.draw();
		});

		//change the selected date range of that picker
		$('input[name="daterange"]').data('daterangepicker').setStartDate(moment().subtract(6, 'days'));
		$('input[name="daterange"]').data('daterangepicker').setEndDate(moment());

		//'copy', 'csv', 'excel', 'pdf', 'print'
		//B = Button
		var table = $("#report_list").DataTable({
			// sPaginationType: "custom_numbers",
			sDom: '<"top float-right"B>rt<"bottom"l ip><"clear">',
			processing: true,
			serverSide: true,
			pageLength: 5,
			order: [],
			lengthMenu: [[5, 10, 15, 20, 25 , 30, -1], [5, 10, 15, 20, 25 , 30, "All"]],
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
				url: '{!! URL::to("Loan/Report/Transaction/objectData") !!}',
				method: 'POST',
				data: function (d) {
					d._token = "{{ csrf_token() }}",
					d.daterange = $('input[name="daterange"]').val(),
					d.status = $('#status').val()
				}
			},
			columns: [
				{ data: 'ref_2',			            name: 'ref_2' },
				{ data: 'from_name',			        name: 'from_name' },
				{ data: 'transaction_id',			    name: 'transaction_id' },
                { data: 'amount',			            name: 'amount' },
				{ data: 'transaction_date',			    name: 'transaction_date' },
				{ data: 'status',			            name: 'status' }
			],
			aoColumnDefs: [
				{
					"aTargets": [5],
					"mData": null,
					"mRender": function (data, type, full) {
						console.log(data)
						if (data == "ACTIVE") {
							return '<span class="role badge-success text-capitalize">'+data+'</span>';
						}
						else if (data == "NEW") {
							return '<span class="role badge-primary text-capitalize">'+data+'</span>';
						}
						else if (data == "APPROVAL") {
							return '<span class="role badge-info text-capitalize">'+data+'</span>';
						}
						else if (data == "PENDING") {
							return '<span class="role badge-secondary text-capitalize">'+data+'</span>';
						}
						else {
							return '<span class="text-capitalize">'+data+'</span>';
						}

					}
				},
			],
			createdRow: function( row, data, dataIndex ) {
				$( row ).find('td:not(:first-child)').addClass("text-center");
				$( row ).find('td:first-child').addClass("text-left");
			}
		});

        $('#data_search').on( 'keyup', function (){
            table.search( this.value ).draw();
        });

	});

    function SubmitForm(){
        $('#export_transaction_excel').submit()
        $(this).attr('disabled', 'disabled')
    }

    $('#export_transaction_excel').submit(function() {
        const btn = ModalCloseButtonTemplate('Close')
        $(this).ajaxSubmit({
            error: function(data) {
                OpenAlertModal(GetModalHeader('Error'), 'ไม่สามารถทำรายการได้ในขณะนี้', `<div class="text-center">${btn}</div>`);
            },
            success:function(response){
                if (response.success == true)
                {
                    OpenAlertModal('<p>Export Report Success</p>', 'ระบบได้ทำการส่งไฟล์ Report ไปยัง Email ของท่านแล้ว', `<div class="text-center">${btn}</div>`);
                }
                else
                {
                    OpenAlertModal(GetModalHeader('Error'), 'ไม่สามารถทำรายการได้ในขณะนี้', `<div class="text-center">${btn}</div>`);
                }
            }
        });
        return false;
    });

	$("#status").change(function() {
  	    $('#report_list').DataTable().ajax.reload()
    })
    
</script>
@endsection
