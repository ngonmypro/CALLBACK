@extends('argon_layouts.app', ['title' => __('Recipient Bookstate')])

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <style type="text/css">
        a {
            text-decoration: none;
            color: inherit;
        }
        .tr-expand-detail {
            background-color: #F5F5F5;
        }
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
                            <h6 class="h2 text-white d-inline-block mb-0">Redeem</h6>
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
                                                <label class="form-control-label">Date</label>
                                                <input type="text" name="daterange" id="daterange" class="form-control input-no-border text-style-6 bg-white" autocomplete="off"
                                        readonly="readonly" value="" placeholder="Select date"/>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Recipient Code</label>
                                                <input class="form-control" name="recipient_code" type="text" value="" placeholder="Search Recipient Code">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Redeem Code</label>
                                                <input class="form-control" name="redeem_code" type="text" value="" placeholder="Search Reedeem Code">
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
                                            <h3 class="mb-0">Redeem</h3>
                                            <p class="text-sm mb-0"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="bookstate_table" class="table table-flush dataTable"></table>
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

        var table = $("#bookstate_table").DataTable({
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
      					url: '{{ action("BAAC\RecipientController@bookstate_objectData") }}',
      					method: 'POST',
      					data: function (d) {
                              d._token            = "{{ csrf_token() }}",
                  						d.daterange         = $('input[name="daterange"]').val() || '',
                  						d.recipient_code    = $('input[name="recipient_code"]').val() || '',
                              d.redeem_code       = $('input[name="redeem_code"]').val() || ''
      					}
    				},
    				columns: [
                { data: 'recipient_code',       name: 'recipient_code',       title: "Recipient_code",      className: "text-center"   },
                { data: 'type',                 name: 'type',                 title: "Type",                className: "text-center"   },
                { data: 'redeem_code',          name: 'redeem_code',          title: "Redeem Code",         className: "text-center"   },
                { data: 'book_state',           name: 'book_state',           title: "Bookstate",           className: "text-center"   },
                { data: 'product_code',         name: 'product_code',         title: "Product Code",        className: "text-center"   },
                { data: 'product_name',         name: 'product_name',         title: "Product Name",        className: "text-center"   },
                { data: 'redeemed_at',          name: 'redeemed_at',          title: "Redeemed At",         className: "text-center"   },
                { data: 'redeem_code',          name: 'redeem_code',          title: "Tracking",            className: "text-center"   },
    				],
            aoColumnDefs: [
                {
                    aTargets: [-1],
                    mRender: function (data, type, full) {
                      return '<a href="{!! URL::to("BAAC/Recipient/Bookstate/Tracking") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                    }
                }
            ]
        })
        
		});
	</script>
@endsection
