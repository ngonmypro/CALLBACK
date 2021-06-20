@extends('argon_layouts.app', ['title' => __('Bill Logs')])

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

    <form>

        {{ csrf_field() }}

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">

                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.manage.logs.title')}}</h6>
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
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.index.invoice_number')}}</label>
                                                <input class="form-control" name="inv_no" type="text" value="" placeholder="{{__('bill.index.search_invoice_number')}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.manage.logs.state')}}</label>
                                                <input class="form-control" name="action_state" type="text" value="" placeholder="{{__('bill.manage.logs.search_state')}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('bill.manage.logs.tax_id')}}</label>
                                                <input class="form-control" name="tax_id" type="text" value="" placeholder="{{__('bill.manage.logs.search_tax_id')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label" for="example3cols1Input">{{__('common.status')}}</label>
                                                <select name="status" class="form-control custom-form-control">
                                                    <option value="" selected>{{__('common.all')}}</option>
                                                    <option value="SUCCESS">{{__('common.success')}}</option>
                                                    <option value="FAIL">{{__('common.fail')}}</option>
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
                                            <h3 class="mb-0">{{__('bill.manage.logs.title')}}</h3>
                                            <p class="text-sm mb-0"></p>
                                        </div>
                                        <div>
                                            <ul class="list-inline">
                                                {{-- // --}}
                                            </ul>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="dt" class="table table-flush dataTable"></table>
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
    <script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>

	<script type="text/javascript">
		$(document).ready(function() {

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

			var table = $("#dt").DataTable({
				sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
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
					url: '{{ action("Bill\LogsController@objectData") }}',
					method: 'POST',
					data: function (d) {
                        d._token        = "{{ csrf_token() }}"
            						d.daterange     = $('input[name="daterange"]').val() || '',
            						d.customer_code = $('input[name="customer_code"]').val() || '',
                        d.inv_no        = $('input[name="inv_no"]').val() || '',
                        d.action_state  = $('input[name="action_state"]').val() || '',
                        d.tax_id        = $('input[name="tax_id"]').val() || '',
                        d.status        = $('select[name=status] option:selected').val() || null
					}
				},
				columns: [
                    { data: 'created_at',           name: 'created_at',                 className: "d-none"  },
                    { data: 'invoice_number',       name: 'invoice_number',             title: "{{__('bill.manage.logs.invoice_number')}}", className: "text-center"  },
                    { data: 'tax_id',               name: 'corp_tax_id',                title: "{{__('bill.manage.logs.tax_id')}}",         className: "text-center"  },
					{ data: 'status',               name: 'status',                     title: "{{__('bill.manage.logs.status')}}",         className: "text-center"  },
                    { data: 'state',                name: 'state',                      title: "{{__('bill.manage.logs.state')}}"  },
                    { data: 'status_reason',        name: 'status_reason',              title: "{{__('bill.manage.logs.status_reason')}}"  },
                    { data: 'recipient_code',       name: 'customer_code',              title: "{{__('bill.manage.logs.customer_code')}}", className: "text-center"   },
                    { data: 'created_at',           name: 'created_at',                 title: "{{__('bill.manage.logs.created_at')}}",     className: "text-center"   },
				],
				aoColumnDefs: [
                    {
    					aTargets: [3],
    					mData: null,
    					mRender: function (data, type, full) {
    						if (data === 'SUCCESS') {
                                return '<span class="badge badge-success">{{__("common.success")}}</span>';
                            } else if (data === 'FAIL') {
                                return '<span class="badge badge-danger">{{__("common.fail")}}</span>';
                            } else {
                                return `<span class="badge badge-secondary">${_.ucwords(data || '')}</span>`;
                            }
    					}
    				},
                    {
                        aTargets: [3],
                        mData: null,
                        mRender: function (data, type, full) {
                            return `<span class="badge badge-secondary">${_.ucwords(data || '')}</span>`
                        }
                    },
				]
            })

		});

	</script>
@endsection
