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
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('recurring.index.recipient_card')}}</h6>
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
                                            <div id="tax-id-valid" class="form-group mb-0">
                                                <label class="form-control-label">{{__('recurring.index.company_name')}}</label>
                                                <select name="corp_code" class="corp_code" id="corp_code"></select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label">{{__('recurring.index.customer_code')}}</label>
                                                <input class="form-control" name="customer_code" id="customer_code" type="text" value="" placeholder="{{__('recurring.index.customer_code')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-0">
                                                <label class="form-control-label">{{__('recurring.index.daterange')}}</label>
                                                <input class="form-control daterange" name="daterange" id="daterange" placeholder="{{__('recurring.index.place_daterange')}}" type="text" value="">
                                                <input type="hidden" class="form-control" id="export_type" name="export_type" value="download">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <div class="row px-2 offset-md-8">
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <button type="button" id="search" class="btn btn-primary w-100">{{__('common.search')}}</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group my-2">
                                                    <button type="button" id="delete" class="btn btn-warning w-100" onclick="delete_card('all')">{{__('recurring.index.delete_all')}}</button>
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
                            <div class="col-2">
                                <button type="button" id="export" class="btn btn-primary w-100">{{__('recurring.index.export_card')}}</button>
                            </div>
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

        $('input[name="daterange"]').daterangepicker({
            startDate: moment().subtract(7, 'days'),
            endDate: moment(),
            dateLimit: {
                "months": 1
            },
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end) {
            var getDate =start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY');
            $('input[name="daterange"]').val(getDate);
        })
        
        $('input[name="daterange"]').val('')

        $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('')
        })

        var table = $("#credit-score-table").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            serverSide: true,
            paging: false,
            order: [[ 1, 'asc' ], [ 2, 'asc' ]],
            dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            ajax: {
                url: '{!! URL::to("Recurring/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.corp_code = $('#corp_code').val() || null,
                    d.customer_code = $('input[name="customer_code"]').val() || null,
                    d.daterange = $('input[name="daterange"]').val()
                }
            },
            columns: [
                { data: 'recipient_code',		name: 'recipient_code',         title: '{{__("recipient.index.customer_code")}}',   class: 'text-center' },
                { data: 'full_name',			name: 'full_name',              title: '{{__("recipient.profile.full_name")}}',     class: 'text-center' },
                { data: 'telephone',            name: 'telephone',              title: '{{__("recipient.index.telephone")}}',       class: 'text-center' },
                { data: 'card_no',              name: 'card_no',                title: '{{__("common.card_no")}}',                   class: 'text-center' },
                { data: 'status',               name: 'status',                 title: '{{__("common.status")}}',                   class: 'text-center' },
                { data: 'reference_id',         name: 'reference_id',           title: '{{__("common.action")}}',                   class: 'text-center' },
            ],
            aoColumnDefs: [
                { 
                    className: "text-center", 
                    targets: [1, 2, 3] 
                },
                {
			        "aTargets": [4],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	// console.log(data)
			        	if(data === "ACTIVE"){
			        		return '<span class="badge badge-success">{{__('common.active')}}</span>';
                        }
                        else if(data === "REMOVED"){
			        		return '<span class="badge badge-danger">{{__('recurring.index.remove')}}</span>';
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
                        return inv = '<a href="#" onclick="delete_card('+"'"+data+"'"+')" class="btn btn-sm btn-danger" title="Delete Card"><i class="fa fa-trash"></i></a>';
			        }
			    }
            ]
        })
        $('#search').on('click', function () {
            table.search(this.value).draw()
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
