@extends('argon_layouts.app', ['title' => __('loan_contract.title')])

@section('style')
    <link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>

    <style type="text/css">
        .icon-inline{
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
@endsection

@section('content')

<input type="hidden" name="breadcrumb-title" value="{{__('loan_contract.title')}}">

@Permission(LOAN_MANAGEMENT.EXPORT_CONTRACT)
<form action="{{ url('Loan/ContractReport/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_contract_excel">
@EndPermission

    {{ csrf_field() }}
    
    @Permission(LOAN_MANAGEMENT.UPLOAD_APPLICATION)
    <div class="col-12">
        <div class="d-flex flex-wrap mb-3">
            <div class="ml-auto p-2">
                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ url('Loan/Upload')}}'">
                    <span>{{__('loan_contract.upload_cotract_btn')}}</span>
                </button>
            </div>
        </div>
    </div>
    @EndPermission

    @Permission(LOAN_MANAGEMENT.EXPORT_CONTRACT)
    <div class="col-12 py-2 my-3 border-bottom">
        <div class="d-flex flex-wrap">
            <div class="px-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" name="daterange" placeholder="Start date - End date" type="text" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-2 w-25">
                <button id="btn-contract-export" type="button" class="btn btn-secondary">
                    <span class="">{{__('loan_contract.export_contract_btn')}}</span>
                </button>
            </div>
        </div>
    </div>
    @EndPermission

    <div class="row px-4" id="contract-count"></div>

    <div class="col-12">
        <div class="d-flex flex-wrap">
            <div class="p-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <input type="text" id="data_search" name="contract_code" placeholder="{{__('loan_contract.dt-application-search')}}" class="form-control pl-5">
                        <i class="fas fa-search icon-inline"></i>
                    </div>
                </div>
            </div>
            <div class="p-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <select name="status" class="form-control custom-form-control">
                            <option value="" selected>{{__('loan_contract.filter-default')}}</option>
                            <option value="NEW">{{__('loan_contract.filter-new')}}</option>
                            <option value="ACTIVE">{{__('loan_contract.filter-active')}}</option>
                            <option value="REJECTED">{{__('loan_contract.filter-rejected')}}</option>
                            <option value="APPROVAL">{{__('loan_contract.filter-approval')}}</option>
                            <option value="BAD_DEBT">{{__('loan_contract.filter-baddebt')}}</option>
                            <option value="CLOSED">{{__('loan_contract.filter-closed')}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-2 w-25">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <select name="payment_status" class="form-control custom-form-control">
                            <option value="" selected>{{__('loan_contract.filter-payment_status')}}</option>
                            <option value="PAID">{{__('loan_contract.filter-paid')}}</option>
                            <option value="UNPAID">{{__('loan_contract.filter-unpaid')}}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="p-2 w-25 row m-0">
                <div class="col-12 px-0">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input type="text" name="payment_daterange" id="payment_daterange" class="form-control input-no-border text-style-6 bg-white rounded" autocomplete="off"
                        readonly="readonly" value="" placeholder="{{__('loan_contract.dt-delivery_date')}}"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <div class="dataTables_wrapper dt-bootstrap4">
                <table id="contracts_detail" class="table simple-table" style="width:100%"></table>
                <input type="hidden" name="statistic" value="">
            </div>
        </div>
    </div>

</form>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/extensions/jquery.form.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>

<script type="text/javascript">

    function init() {
        //
    }

    function countHandler (err, result) {
        if (err) {
            console.error('error: ', err)
        } else if (!result.success) {
            console.error('error: ', result.message)
        } else {
            const data = result.data

            const _block = (name, value) => {
                let status_name = _.ucwords(name);
                if (status_name == 'Active' ) {
                    status_name = "{{__('common.active')}}"
                }
                else if (status_name == 'Rejected' ) {
                    status_name = "{{__('common.rejected')}}"
                }
                else if ( status_name == 'New' ){
                    status_name = "{{__('common.new')}}"
                }
                else if ( status_name == 'Approval' ) {
                    status_name = "{{__('common.approval')}}"
                }   
                else if ( status_name == 'Bad debt' ) {
                        status_name = "{{__('common.bad_debt')}}"
                } else if ( status_name == 'Closed' ) {
                    status_name = "{{__('common.closed')}}"
                }

                return `
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats btn-filter-click" data-value="${name}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-muted mb-0">${status_name}</h5>
                                        <span class="h2 font-weight-bold mb-0">${value}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle">
                                            <i class="ni ni-folder-17"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }

            Object.keys(data).forEach(function (item) {

                if (item === 'total') { 
                    return
                } else {
                    $('#contract-count').append(_block(item, data[item]))
                }         
            })
            
        }
    }

	$(document).ready(function() {

        init()

        $(document).on('click', '.btn-filter-click', function() {
            if ($(this).data('value') !== $('select[name=status]').val()) {
                const data = $(this).data('value')
                $('select[name=status]').val(data).trigger('change')
                
                // div effect set here
                $(this).addClass('focus-border shadow')
                $('.btn-filter-click').not(this).each(function() {
                    $(this).removeClass('focus-border shadow')
                })
            }
            return
        })

        // datepicker event on click Clear
        $('input[name="payment_daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            //do something, like clearing an input
            $('input[name="payment_daterange"]').val('')
        })

        $('input[name="payment_daterange"] , [name="payment_daterange"]').daterangepicker({
            startDate: moment(),
            timePicker: true,
            singleDatePicker: true,
            showDropdowns: true,
            timePickerIncrement: 30,
            timePicker24Hour: true,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            },
            autoUpdateInput: false,
        }, function (date) {
            $('input[name="payment_daterange"]').val(date.format('YYYY-MM-DD'))
            $('#contracts_detail').DataTable().ajax.reload()
        })

        @Permission(LOAN_MANAGEMENT.EXPORT_CONTRACT)
        $('input[name="daterange"] , [name="daterange"]').daterangepicker({
            startDate: moment() ,
            endDate: moment() ,
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
            $('#report_list').DataTable().ajax.reload()
                // table.draw();
        })

        //change the selected date range of that picker
        $('input[name="daterange"]').data('daterangepicker').setStartDate(moment().subtract(6, 'days'));
        $('input[name="daterange"]').data('daterangepicker').setEndDate(moment());
        @EndPermission

        $.ajax({
            url: '{{ url("Loan/Contract/Get/Status") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            }, 
            success: function (response) {
                countHandler(null, response)
            },
            error: function (err) {
                countHandler(err, null)
            },
        })

		var table = $("#contracts_detail").DataTable({
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
				url: '{!! URL::to("Loan/Contract/objectData") !!}',
				method: 'POST',
				data: function (d) {
					d._token = "{{ csrf_token() }}",
                    d.contract_code = $('input[name=contract_code]').val() || null,
                    d.status = $('select[name=status] option:selected').val() || null,
                    d.payment_daterange = $('input[name="payment_daterange"]').val() || null,
                    d.payment_status = $('select[name="payment_status"] option:selected').val() || null
				}
			},
			columns: [
                { data: 'created_at',               name: 'created_at',             title: "{{__('loan_contract.dt-date')}}" , class: "text-center"},
                { data: 'contract_code',            name: 'contract_code',          title: "{{__('loan_contract.dt-contract_code')}}" , class: "text-center" },
                { data: 'contract_name',            name: 'contract_name',          title: "{{__('loan_contract.dt-contract_name')}}" , class: "text-center" },
                { data: 'total_bill',               name: 'total_bill',             title: "{{__('loan_contract.dt-total_bill')}}" , class: "text-center" },
		        { data: 'payment_status',           name: 'payment_status',         title: "{{__('loan_contract.dt-payment_status')}}" , class: "text-center" },
		        { data: 'bill_due_date',            name: 'bill_due_date',          title: "{{__('loan_contract.dt-due_date')}}" , class: "text-center"},
		        { data: 'delivery_date',            name: 'delivery_date',          title: "{{__('loan_contract.dt-delivery_date')}}" , class: "text-center" },
		        { data: 'status',                   name: 'status',                 title: "{{__('loan_contract.dt-status')}}" , class: "text-center" },
		        { data: 'contract_code',                                            title: "{{__('loan_contract.dt-options')}}" , class: "text-center" }
            ],
			aoColumnDefs: [
                {
			        "aTargets": [0],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        const dt = (new Date(data).getTime() / 1000).toFixed(0)
                        if (data === null || data === '') {
                            return data
                        } else if (!moment(data).isValid()) {
                            console.error(`invalid date: appNo.${full.contract_code}`, data)
                            return ''
                        } else {
                            return moment.unix(dt).format('YYYY-MM-DD')
                        }
			        }
                },
                {
			        "aTargets": [3],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        if ( !isNaN(data) || !isNaN(full.period || '-') ) {
                            return `${data} of ${parseInt(full.period)}`
                        } else {
                            return data
                        }
			        }
                },
                {
			        "aTargets": [4],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        if (data === 'NEW' || data === null) {
                            return `<span class="role badge badge-warning text-capitalize">{{__('common.unpaid')}}</span>`
                        } else if (data === 'PAID') {
                            return `<span class="role badge badge-success text-capitalize">{{__('common.paid')}}</span>`
                        } else {
                            return `<span class="role badge badge-warning text-capitalize">{{__('common.unpaid')}}</span>`
                        }
			        }
                },
                {
			        "aTargets": [5],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        return data || '-'
			        }
                },
                {
			        "aTargets": [6],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        const dt = (new Date(data).getTime() / 1000).toFixed(0)
                        if (data === null || data === '') {
                            return '-'
                        } else if (!moment(data).isValid()) {
                            console.error(`invalid date: appNo.${full.contract_code}`, data)
                            return '-'
                        } else {
                            return moment.unix(dt).format('YYYY-MM-DD, HHmm')
                        }
			        }
                },
                {
			        "aTargets": [7],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	// console.log(data)
			        	if (data === "ACTIVE") {
                            return `<span class="role badge badge-success text-capitalize">{{__('common.active')}}</span>`
                        } else if (data === "NEW") {
                            return `<span class="role badge badge-primary text-capitalize">{{__('common.new')}}</span>`
                        } else if (data === "APPROVAL") {
                            return `<span class="role badge badge-info text-capitalize">{{__('common.approval')}}</span>`
                        } else if (data === "REJECTED") {
                            return `<span class="role badge badge-danger text-capitalize">{{__('common.rejected')}}</span>`
                        }  else {
			        		return `<span class="role badge badge-secondary text-capitalize">${_.ucwords(data)}</span>`
			        	}
			        }
			    },
                
                @Permission(LOAN_MANAGEMENT.DETAIL)
		    	{
			        "aTargets": [8],
			        "mData": 0,
			        "mRender": function (data, type, full) {
                        const invlist = `<button type="button" class="btn btn-sm btn-default btn-invoices-list" data-contract_code="${full.contract_code}"><i class="fa fa-list-alt" aria-hidden="true"></i></button>`
                        const info = `<a href="{{ url('Loan/Contract/Info')}}/${data}" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>`
                        return `${invlist}${info}`
			        }
                },
                @EndPermission
			],
			createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:not(:first-child)').addClass("text-center");
                $( row ).find('td:first-child').addClass("text-center");
            }
		});

		table.on('xhr', function(){
	    var json = table.ajax.json();
			var count_active = json.data.filter(item => item.status === "ACTIVE").length;
			var count_inactive = json.data.filter(item => item.status != "ACTIVE").length;
			$(".contract-active").text(count_active);
			$(".contract-inactive").text(count_inactive);
			$(".total").text(json.data.length);
		});

		$(document).on('keyup change', '#data_search, select[name=status], select[name=payment_status]', function () {
    	    table.search( this.value ).draw();
        })
        
        @Permission(LOAN_MANAGEMENT.EXPORT_CONTRACT)
        $('#btn-contract-export').click(function() {
            $.blockUI()
            $('#export_contract_excel').ajaxSubmit({
                error: function(err) {
                    $.unblockUI()
                    console.error('error: ', err)
                    Swal.fire("Oops! Someting wrong.", "{{__('loan_contract.error-message-1')}}", 'error')
                },
                success:function(response) {
                    $.unblockUI()
                    if (!!response.success) {
                        Swal.fire("{{__('common.export_report_success')}}", "{{__('common.message_send')}}", 'success')
                    } else {
                        console.error('error: ', response.message || '')
                        Swal.fire("Oops! Someting wrong.", "{{__('loan_contract.error-message-1')}}", 'error')
                    }
                }
            })
            return false
        })
        @EndPermission

        $(document).on('click', '.btn-invoices-list', function(){
            const elem = this
            Swal.fire({
                width: '90%',
                html: `
                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="dt-invoices" class="table simple-table" style="width:100%"></table>
                        </div>
                    </div>
                `
            })

            $("#dt-invoices").DataTable({
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
                    url: '{!! URL::to("Bill/objectData") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token            = "{{ csrf_token() }}",
                        d.contract_code     = $(elem).data('contract_code') || ''
                    }
                },
                columns: [
                    { data: 'recipient_code',       name: 'recipient_code',             title: "{{__('bill.index.customer_code')}}"  },
                    { data: 'invoice_number',       name: 'invoice_number',             title: "{{__('bill.index.invoice_number')}}"  },
                    { data: 'bill_total_amount',    name: 'bill_total_amount',          title: "{{__('bill.index.total_amount')}}"   },
                    { data: 'bill_due_date',        name: 'bill_due_date',              title: "{{__('bill.index.due_date')}}"   },
                    { data: 'bill_status',          name: 'bill_status',                title: "{{__('bill.index.bill_status')}}"   },
                    { data: 'created_at',           name: 'created_at',                 title: "{{__('bill.index.created_at')}}"   },
                    { data: 'payment_status',       name: 'payment_status',             title: "{{__('bill.index.payment_status')}}"   },
                    { data: 'reference_code',       name: 'reference_code',             title: "{{__('bill.index.action')}}"   }
                ],
                aoColumnDefs: [
                    {
                        aTargets: [4],
                        mData: "id",
                        mRender: function (data, type, full) {
                            if(data == "NEW"){
                                return '<span class="badge badge-primary">{{__("common.new")}}</span>';
                            } else if(data == "PENDING"){
                                return '<span class="badge badge-warning">{{__("common.pending")}}</span>';
                            } else if(data == "UNPAID"){
                                return '<span class="badge badge-danger">{{__("common.unpaid")}}</span>';
                            }
                            else if(data == "PAID"){
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                            }else {
                                return '<span class="badge badge-secondary">'+data+'</span>';
                            }
                        }
                    },
                    {
                        aTargets: [5],
                        mData: "id",
                        mRender: function (data, type, full) {
                            if ( !data ) {
                                return '-'
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        aTargets: [6],
                        mData: "id",
                        mRender: function (data, type, full) {
                            if ( !data ) {
                                return '-'
                            } else if ( data === 'UNPAID' ) {
                                return '<span class="badge badge-danger">{{__("common.unpaid")}}</span>'
                            } else if ( data == 'PAID' ) {
                                return '<span class="badge badge-success">{{__("common.paid")}}</span>'
                            } else {
                                return `<span class="badge badge-secondary">${data}</span>`
                            }
                        }
                    },
                    {
                        aTargets: [7],
                        mData: "id",
                        mRender: function (data, type, full) {
                            return `<a href="{!! URL::to("Bill/Detail") !!}/${data}" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>`
                        }
                    }
                ]
            })
            
        })

	})
</script>
@endsection
