@extends('layouts.master')
@section('title', 'Bill Report')
@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/export_report/buttons.bootstrap4.min.css') }}" rel="stylesheet" media="all">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Bill Report">
<form action="{{ url('Loan/RecipientReport/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_recipient_excel">
  {{ csrf_field() }}
    <div class="col-12">
        <div class="d-flex flex-wrap">
            <div class="px-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <input type="text" name="daterange" id="daterange" class="form-control input-no-border text-style-6 bg-white" autocomplete="off"
                                   readonly="readonly" value="" placeholder="Select date"/>
                        <span class="oi oi-calendar icon-inline text-style-6" name="daterange"></span>
                        {{-- <input type="hidden" id="export_type" name="export_type" value=""> --}}
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
            <div class="col-12 px-0">
              <input type="text" id="data_search" name="data_search" placeholder="Search" class="form-control custom-form-control">
              <span class="fas fa-search inline-icon"></span>
            </div>
          </div>
            <div class="ml-auto">
                <button id="export_excel" name="export_excel" type="button" value="1" class="btn btn-print form-control" onclick="SubmitForm()">
                    <span class="">Export Excel</span>
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
      							<th class="text-left">Recipient Name</th>
      							<th class="text-center">Bill Reference Code</th>
      							<th class="text-center">Bill Amount</th>
      							<th class="text-center">Bill Status</th>
      							<th class="text-center">Bill Payment Status</th>
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
		var table = $("#report_list").DataTable({
			sPaginationType: "custom_numbers",
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
				url: '{!! URL::to("Loan/RecipientReport/objectData") !!}',
				method: 'POST',
				data: function (d) {
          d._token = "{{ csrf_token() }}",
					d.daterange = $('input[name="daterange"]').val(),
					d.status = $('#status').val()
				}
			},
      columns: [
				    { data: 'full_name_th',			     name: 'firstname_th' },
		        { data: 'reference_code',			   name: 'loan_contract_bill.reference_code' },
		        { data: 'bill_amount',			     name: 'loan_contract_bill.bill_amount' },
		        { data: 'bill_status',			     name: 'loan_contract_bill.bill_status' },
		        { data: 'payment_status',			   name: 'loan_contract_bill.payment_status' },
            { data: 'surname_th',			       name: 'surname_th' }
			],
			aoColumnDefs: [
			    {
			        "aTargets": [3],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	if(data == "ACTIVE"){
			        		return '<span class="role badge-success text-capitalize">'+data+'</span>';
			        	}
			        	else if(data == "NEW"){
			        		return '<span class="role badge-primary text-capitalize">'+data+'</span>';
			        	}
			        	else if(data == "APPROVAL"){
			        		return '<span class="role badge-info text-capitalize">'+data+'</span>';
			        	}
			        	else if(data == "pending"){
			        		return '<span class="role badge-secondary text-capitalize">'+data+'</span>';
			        	}
			        	else {
			        		return '<span class="text-capitalize">'+data+'</span>';
			        	}

			        }
			    },
          {
              "aTargets": [5],
              "sName": 'surname_th',
              "bVisible": false
          }
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
      $('#export_recipient_excel').submit();
  }

  $('#export_recipient_excel').submit(function() {
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
