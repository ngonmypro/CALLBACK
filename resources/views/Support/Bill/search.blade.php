@extends('argon_layouts.app', ['title' => __('Search Bill')])


@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection


@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('support.search_bill')}}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label">{{__('support.company_name')}}<span class="text-danger">*</span></label>
                                             <select name="tax_id" class="tax_id" id="tax_id"></select>
                                     
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label">{{__('support.invoice')}}</label>
                                            <input class="form-control" name="invoice_number" type="text" value="" placeholder="{{__('support.place_holder_invoice')}}">
                                        </div>
                                    </div>
                              
                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label">{{__('support.date')}}</label>
                                            <input type="text" name="date" class="form-control input-no-border text-style-6 bg-white rounded" autocomplete="off" value="" placeholder="{{__('support.place_holder_date')}}"/>
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
    
    <div id="table-div" class="container-fluid mt--6 d-none">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('support.search_result')}}</h3>
                                <p id="corp_group"></p>
                                <p id="corp_name"></p>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="table" class="table table-flush dataTable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $('input[name="date"]').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false
    }, function(chosen_date) {
        $('input[name="date"]').val(chosen_date.format('DD/MM/YYYY'));
    });

    $('#search').on('click', function() {
        
        var cos =  $('input[name="tax_id"]').val();
        var corporate_name1 = $('#tax_id').val()

        console.log('cos =>' +corporate_name1);

        if($('#tax_id').val().length == 13) {
          $('#tax_id').removeClass('is-invalid');
            $("#table-div").removeClass("d-none");
            if (!$.fn.DataTable.isDataTable('#table')) {
                var table = $("#table").DataTable({
                    sPaginationType: "simple_numbers",
                    bFilter: false,
                    dataType: 'json',
                    processing: true,
                    serverSide: true,
                    order: [[ 0, "desc" ]],
                    dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                     "language": {
                        // "emptyTable":     "{{__('common.datatable.emptyTable')}}",
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
                        url: '{!! URL::to("Support/objectDataBill") !!}',
                        method: 'POST',
                        data: function (d) {
                            d._token = "{{ csrf_token() }}",
                             d.tax_id = $('#tax_id').val(),
                            d.invoice_number = $('input[name="invoice_number"]').val(),
                            d.company_name_th = $('input[name="company_name_th"]').val(),
                            d.company_name_en = $('input[name="company_name_en"]').val(),
                            d.date = $('input[name="date"]').val()
                           
                        }
                    },
                    columns: [
                        { data: 'created_at',               name: 'created_at',         title: "{{__('support.tax_id')}}" , class: 'd-none'  },
                        { data: 'tax_id',                   name: 'tax_id',             title: "{{__('support.tax_id')}}"  },
                    @if( app()->getLocale() == "th" )
                        { data: 'name_th',           name: 'name_th',     title: "{{__('support.company_name')}}"  },
                    @else
                        { data: 'name_en',           name: 'name_en',     title: "{{__('support.company_name')}}"  },
                    @endif
                        { data: 'invoice_number',           name: 'invoice_number',     title: "{{__('support.invoice')}}"  },
                        { data: 'bill_status',              name: 'bill_status',        title: "{{__('support.bill_status')}}"  },
                        { data: 'created_at',               name: 'created_at',         title: "{{__('support.created_at')}}"  },
                        { data: 'payment_status',           name: 'payment_status',     title: "{{__('support.payment_status')}}"  },
                        { data: 'payment_channel',          name: 'payment_channel',    title: "{{__('support.payment_channel')}}"  },
                        { data: 'payment_date_time',        name: 'payment_date_time',  title: "{{__('support.payment_datetime')}}"  },
                        { title: '', orderable: false  },
                    ],
                    aoColumnDefs: [
                        { className: "text-center", targets: "_all" },
                        {
                            aTargets: [-1],
                            mRender: function (data, type, full) {
                                var btn_view =  '<a href="{{ url('/Support/Bill/Detail')}}/'+full.reference_code+'" class="btn btn-sm btn-default">'+
                                                    '<i class="ni ni-bold-right"></i>'+
                                                '</a>'
    
                                var setting_btn = ''
    
                                return btn_view+setting_btn
                            }
                        }
                    ],
                    "initComplete": function(settings, json) {
                        if(json.corp_info != null){
                            show_name(json)
                        }
                        else {
                            $('#corp_group').text('');
                            $('#corp_name').text('');
                        }
                    }
                })
            }
            else {
                var table = $("#table").DataTable();
                table.ajax.reload( function ( json ) {
                    if(json.corp_info != null){
                        show_name(json)
                    }
                    else {
                        $('#corp_group').text('');
                        $('#corp_name').text('');
                    }
                } );
            }
        }
        else {
            $('input[name="tax_id"]').addClass('is-invalid');
        }
    })
    
    function show_name(json) {
        @if( app()->getLocale() == "th" )
            $('#corp_group').text("{{__('support.corp_group')}} : " + json.corp_info.group_name_th);
            $('#corp_name').text("{{__('support.corp_name')}} : " + json.corp_info.corp_name_th);
        @else
            $('#corp_group').text("{{__('support.corp_group')}} : " + json.corp_info.group_name_en);
            $('#corp_name').text("{{__('support.corp_name')}} : " + json.corp_info.corp_name_en);
        @endif
    }






       const currentlang = `{{ app()->getLocale() }}`
            $('#tax_id').select2({
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
                                    return { id: item.tax_id, text: item.text_en+" ("+item.tax_id+")" }
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
                if (! _.isEmpty( $('#tax_id').val() ) ) {
                    dt.search( this.value ).draw()
                }
            })


    
    
</script>
@endsection
