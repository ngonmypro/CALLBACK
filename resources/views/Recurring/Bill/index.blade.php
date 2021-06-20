@extends('argon_layouts.app', ['title' => __('Recurring Payments')])


@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">

<style>
.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
}

div:invalid {
    border: 5px solid #ffdddd !important;
}
</style>

@endsection


@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Recurring bill</h6>
                    </div>
                </div>
                <form action="{{ url('Recurring/Export/Excel') }}" method="post" enctype="multipart/form-data" id="export_card">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card card-stats">
                                <div class="card-body">
                                
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label">{{__('recurring.index.daterange')}}</label>
                                                <input class="form-control daterange" name="daterange" id="daterange" placeholder="{{__('recurring.index.place_daterange')}}" type="text" value="">
                                                <input type="hidden" class="form-control" id="export_type" name="export_type" value="download">
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
                                                <label class="form-control-label" for="example3cols2Input">{{__('bill.index.bill_status')}}</label>
                                                <select class="form-control custom-form-control" name="bill_status" id="bill_status">
                                                    <option selected disabled>{{__('bill.index.bill_status')}}</option>
                                                    <option value="">{{__('common.all')}}</option>
                                                    <option value="PAID">{{__('common.paid')}}</option>
                                                    <option value="REJECT">Reject</option>
                                                    <option value="ISSUE">Issue</option>
                                                    <option value="PENDING">Pending</option>
                                                    <option value="INACTIVE">Inactive</option>
                                                    
                                                    
                                                    <!-- <option value="UNMATCH">{{__('common.unmatch')}}</option> -->
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label">Company Name</label>
                                                <select name="company_name" class="company_name" id="company_name"></select>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-4">
                                            <label class="form-control-label">{{__('support.company_name')}}</label>
                                            <input class="form-control company_name" name="company_name" type="text" id="company_name" value="" placeholder="Company Name"> 
                                        </div> -->

                                    </div>

                                    <div class="pt-2">
                                        <div class="row px-2 offset-md-8">
                                            <div class="col-md-6">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <button type="button" id="search" class="btn btn-primary w-100">{{__('common.search')}}</button>
                                                </div>
                                            </div>
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
    
    <div id="table-div" class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-10">
                                <h3 class="mb-0">{{__('recurring.index.search_result')}}</h3>
                            </div>
                            <!-- <div class="col-2">
                                <button type="button" id="export" class="btn btn-primary w-100">{{__('recurring.index.export_card')}}</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="credit-score-table" class="table table-flush dataTable"></table>
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
<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript">



    $(document).ready(function() {
        var inputOptions = new Promise(function(resolve) {
            resolve({
                'email': '{{__('recurring.send_to_email')}}',
                'download': '{{__('recurring.download_now')}}'
            });
        });


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
            //     if (! _.isEmpty( $('#company_name').val() ) ) {
                    table.search( this.value ).draw()
            //     }
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

        const currentlang = `{{ app()->getLocale() }}`

        var table = $("#credit-score-table").DataTable({
            sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 9, 'desc' ] , [1 , 'desc']],
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
                url: '{!! URL::to("Recurring/Bill/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.reference_code = $('input[name="reference_code"]').val() || null,
                    d.customer_code = $('input[name="customer_code"]').val() || null,
                    d.inv_no = $('input[name="inv_no"]').val() || null,
                    d.bill_status = $('select[name="bill_status"]').val() || null,
                    // d.company_name = $('input[name="company_name"]').val() || null,
                    d.company_name = $('#company_name').val()
                    d.currentlang = currentlang,
                    d.daterange = $('input[name="daterange"]').val()
                    // d.daterange    = $('input[name="daterange"]').val(),
                    
                }
            },
            columns: [
                { data: 'export_date',		name: 'export_date',         title: 'export_date',   class: 'text-center' },
                { data: 'invoice_number',		name: 'invoice_number',         title: 'invoice_number',   class: 'text-center' },
                { data: 'reference_code',			name: 'reference_code',              title: 'reference_code',     class: 'text-center' },
                { data: 'bill_total_amount',            name: 'bill_total_amount',              title: 'bill_total_amount',       class: 'text-center' },
                { data: 'bill_status',            name: 'bill_status',              title: 'bill_status',       class: 'text-center' },
                { data: 'recipient_code',            name: 'recipient_code',              title: 'recipient_code',       class: 'text-center' },
                { data: 'payment_channel',            name: 'payment_channel',              title: 'payment_channel',       class: 'text-center' },
                { data: 'payment_status',            name: 'payment_status',              title: 'payment_status',       class: 'text-center' },
                @if( app()->getLocale() == "en" )
                    { data: 'name_en',                  name: 'name_en',                    title: 'company name',                                               class: 'text-center' },
                    @else
                    { data: 'name_th',                  name: 'name_th',                    title: 'company name',                                               class: 'text-center' },
                    @endif
                { data: 'updated_at',            name: 'updated_at',              title: 'updated_at',       class: 'text-center' },
                { data: 'reference_code',            name: 'reference_code',              title: 'action',       class: 'text-center' },
               
            ],
            aoColumnDefs: [
                {
			        "aTargets": [4],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	// console.log(data)
			        	if(data == "NEW"){
                            return '<span class="badge badge-primary">{{__("common.new")}}</span>';
                        } else if(data == "PENDING"){
                            return '<span class="badge badge-secondary">{{__("common.pending")}}</span>';
                        } else if(data == "UNPAID"){
                            return '<span class="text-light badge badge-dark">{{__("common.unpaid")}}</span>';
                        } else if(data == "INACTIVE"){
                            return '<span class="badge badge-danger">{{__("common.inactive")}}</span>';
                        } else if(data == "REJECT"){
                            return '<span class="badge badge-warning">REJECT</span>';
                        } else if(data == "PAID"){
                            return '<span class="badge badge-success">{{__("common.paid")}}</span>';
                        } else if(data == "EXPORTED"){
                            return '<span class="badge badge-info">EXPORTED</span>';
                        } else if(data == "ISSUE"){
                            return '<span class="badge badge-secondary">{{__("common.issue")}}</span>';
                        } else {
                            return '<span class="badge badge-secondary">'+data+'</span>';
                        }
			        }
                },
                {
			        "aTargets": [-4],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	// console.log(data)
			        	if(data === "PAID"){
			        		return '<span class="badge badge-success">PAID</span>';
                        }
                        else if(data === "UNPAID"){
			        		return `<span class="badge badge-secondary">UNPAID</span>`;
                        }
                        else if(data === "EXPORTED"){
			        		return `<span class="badge badge-info">EXPORTED</span>`;
			        	}
                        else {
			        		return '<span class="badge badge-warning">'+data+'</span>';
			        	}
			        }
                },
                {
			        "aTargets": [-1],
			        "mData": null,
			        "mRender": function (data, type, full) {
                        // return '<a href="{{ url('Recurring/Delete')}}/'+data+'" class="btn btn-sm btn-danger" title="Delete Card">'+
                        //                 '<i class="fa fa-trash"></i>'+
                        //             '</a>';
                        return inv = '<a href="#" onclick="bill_detail('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Delete Card"><i class="ni ni-bold-right"></i></a>';
			        }
			    }
            ]
        })
        $('#search').on('click', function () {
            // table.search(this.value).draw()
            if (! _.isEmpty( $('#company_name').val() ) ) 
            {
                table.search( this.value ).draw()
            }
        })

        $('#export').on('click', function() {
            var corp_code = '{"corp_code":"' + $('#corp_code').val() + '"' ?? '""'
            var daterange = ',"daterange":"' + $('#daterange').val() + '"' ?? '""'
            var customer_code = ',"customer_code":"' + $('#customer_code').val() + '"' ?? '""'

            var data = btoa(corp_code+daterange+customer_code+'}')
            window.open(' {{ url("Recurring/Download") }}/'+data );
        })

        

        $(document).on("click",".swal2-container input[name='swal2-radio']", function() {
            $("#export_type").val($('input[name="swal2-radio"]:checked').val())
        });
    });

    
    function bill_detail(reference_code) {
        

        // const url = '{!! URL::to("/Bill/Detail") !!}'
        //     window.location.href = url+'/'+reference_code
        const url = '{!! URL::to("Recurring/Bill/Detail") !!}'
            window.location.href = url+'/'+reference_code
    }

    // $('#delete').on('click', function() {
        function delete_card(type) {
            let corp_code, daterange, customer_code, code
            if (type == 'all') {
                corp_code = $('#corp_code').val()
                daterange = $('#daterange').val()
                customer_code = $('#customer_code').val()
            }
            else {
                code = type
            }

            Swal.fire({
                title: "{{ (__('recurring.index.remove_confirm')) }}",
                text: "{{ (__('recurring.index.remove_detail')) }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ (__('common.confirm')) }}",
                cancelButtonText: "{{ (__('common.cancel')) }}",
                }).then((result) => {
                if (result.value) {
                    $.blockUI()
                    $.ajax({
                        type: 'POST',
                        url: "{{ action('RecurringController@DeleteCard') }}",
                        data: {
                            _token: `{{ csrf_token() }}`, 
                            corp_code: corp_code,
                            daterange: daterange,
                            customer_code: customer_code,
                            code: code
                        }
                    }).done(function(result) {
                        $.unblockUI()
                        if ( result.success ) {
                            $('#credit-score-table').DataTable().ajax.reload()  // datatable ajax reload
                            Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                        } else {
                            console.error('Error: ', result.message)
                            Swal.fire(result.message || 'Oops! Someting wrong.', '', 'warning')
                        }
                    }).fail(function(err) {
                        $.unblockUI()
                        console.error('Error: ', err)
                        Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Someting wrong.', 'error')
                    })
                }
            })
        }

    const currentlang = `{{ app()->getLocale() }}`
    $('#corp_code').select2({
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
                            return { id: item.id, text: item.text_en+" ("+item.tax_id+")" }
                        })
                    }
                }else{
                    return {
                        results: $.map(data.items, function(item) {
                            return { id: item.id, text: item.text_th+" ("+item.tax_id+")" }
                        })
                    }
                }
            }
        }
    })
</script>
@endsection
