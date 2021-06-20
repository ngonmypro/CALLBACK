@extends('layouts.master')
@section('title', 'Contract Report')
@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/export_report/buttons.bootstrap4.min.css') }}" rel="stylesheet" media="all">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Contract Report">
<form action="{{ url('Loan/ContractReport/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_contract_excel">
  {{ csrf_field() }}
    <div class="col-12">
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
	                    <option disabled>Status</option>
	                    <option selected value="all">All</option>
	                    <option value="1">New</option>
	                    <option value="2">Issued</option>
	                    <option value="3">Overdue</option>
	                    <option value="4">Pending</option>
	                </select>
	            </div>
	        </div>
          <div class="px-2 w-25">
            <!-- <div class="col-12 px-0">
              <input type="text" id="data_search" name="data_search" placeholder="Search" class="form-control pl-5">
              <span class="oi oi-magnifying-glass inline-icon text-style-6"></span>
            </div> -->
          </div>
            <div class="ml-auto">
                <button id="export_excel" name="export_excel" type="button" value="1" class="btn btn-print form-control" onclick="SubmitForm()">
                    <span class="">Export Excel</span>
                </button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
	<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
	{{-- <script src="{{ asset('assets/js/extensions/export_report/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/buttons.flash.min.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/jszip.min.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/pdfmake.min.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/vfs_fonts.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('assets/js/extensions/export_report/buttons.print.min.js') }}"></script> --}}
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
	// 	var table = $("#report_list").DataTable({
	// 		sPaginationType: "custom_numbers",
	// 		sDom: '<"top float-right"B>rt<"bottom"l ip><"clear">',
	// 		processing: true,
	// 		serverSide: true,
	// 		pageLength: 5,
	// 		order: [],
	// 		lengthMenu: [[5, 10, 15, 20, 25 , 30, -1], [5, 10, 15, 20, 25 , 30, "All"]],
    //   ajax: {
	// 			url: '{!! URL::to("Loan/ContractReport/objectData") !!}',
	// 			method: 'POST',
	// 			data: function (d) {
    //       d._token = "{{ csrf_token() }}",
	// 				d.daterange = $('input[name="daterange"]').val(),
	// 				d.status = $('#status').val()
	// 			}
	// 		},
    //   columns: [
    //         { data: 'contract_code',			       name: 'contract_code' },
    //         { data: 'contract_name',			       name: 'contract_name' },
    //         { data: 'contract_signed_date',			 name: 'contract_signed_date' },
    //         { data: 'total_amount',			         name: 'total_amount' },
    //         { data: 'paid_sum',			             name: 'loan_contract_bill.transaction_amount' },
    //         { data: 'outstanding_balance',			 name: 'outstanding_balance' },
    //         { data: 'status',			               name: 'status' }
	// 		],
	// 		aoColumnDefs: [
	// 		    {
	// 		        "aTargets": [3],
	// 		        "mData": null,
	// 		        "mRender": function (data, type, full) {
	// 		        	console.log(data)
	// 		        	if(data == "ACTIVE"){
	// 		        		return '<span class="role badge-success text-capitalize">'+data+'</span>';
	// 		        	}
	// 		        	else if(data == "NEW"){
	// 		        		return '<span class="role badge-primary text-capitalize">'+data+'</span>';
	// 		        	}
	// 		        	else if(data == "APPROVAL"){
	// 		        		return '<span class="role badge-info text-capitalize">'+data+'</span>';
	// 		        	}
	// 		        	else if(data == "pending"){
	// 		        		return '<span class="role badge-secondary text-capitalize">'+data+'</span>';
	// 		        	}
	// 		        	else {
	// 		        		return '<span class="text-capitalize">'+data+'</span>';
	// 		        	}

	// 		        }
	// 		    },
	// 		],
	// 		createdRow: function( row, data, dataIndex ) {
    //             // Set the data-status attribute, and add a class
    //             $( row ).find('td:not(:first-child)').addClass("text-center");
    //             $( row ).find('td:first-child').addClass("text-left");
    //             // console.log(data)
    //             // $( row ).find('td:eq(4)').append('<span class="role badge-warning">'+data.status+'</span>')
    //         }
	// 	});

    $('#data_search').on( 'keyup', function (){
      table.search( this.value ).draw();
    });

	});

  function SubmitForm(){
      $('#export_contract_excel').submit();
  }

  $('#export_contract_excel').submit(function() {
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
    $('#report_list').DataTable().ajax.reload();
  });
</script>
@endsection
