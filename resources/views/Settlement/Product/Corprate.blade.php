@extends('argon_layouts.app', ['title' => __('Settlement')])


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
                        <h6 class="h2 text-white d-inline-block mb-0">Fee Setting</h6>
                    </div>
                </div>
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
                            </div>
                            <div class="col-2">
                            <button class="btn btn-primary w-100"  onclick="create('{{$channel_name}}')" data-target="#demo-modal-2">{{__('settlement.create')}}</button>
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
    <input  type="hidden" id="channel_name" name="channel_name" value="{{$channel_name}}">

    <div class="modal" id="demo-modal-2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="m-progress">
                    <div class="modal-body " >
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="form-control-label">Fee</label>
                                <input type="number" id="fee" class="form-control" name="fee" value="" >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="form-control-label">mdr</label>
                                <input type="number" id="mdr" class="form-control" name="mdr" value=""  >
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class="form-control-label">time</label>
                                <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
                            </div>
                        </div>

                        <div class="text-center">
                            <a  class="btn btn-warning mt-3" data-menu="Dashboard"  onclick="cancel()">Cancel</a>
                            <button class="btn btn-success mt-3">Save</button>
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



    $(document).ready(function() 
    {
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
                order: [[ 1, 'desc' ] ,[2 , 'desc']],
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
                url: '{!! URL::to("Settlement/Product/corporate/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.channel_name = $('#channel_name').val()
                }
            },
          
            columns: [
                { data: 'updated_at',     name: 'updated_at',         title: 'updated_at',       class: 'text-center' },
                { data: 'corp_code',		name: 'corp_code',         title: 'corp_code',   class: 'text-center' },
                @if( app()->getLocale() == "th" )
                { data: 'name_th',		name: 'name_th',         title: 'name_th',   class: 'text-center' },
                @else
                { data: 'name_en',		name: 'name_en',         title: 'name_en',   class: 'text-center' },
                @endif
                { data: 'status',     name: 'status',         title: 'status',       class: 'text-center' },
                { data: 'corp_code',     name: 'corp_code',         title: 'action',       class: 'text-center' },
            ],
            aoColumnDefs: [
                {
			        "aTargets": [-1],
			        "mData": null,
			        "mRender": function (data, type, full) {
                        return inv = '<a href="#" onclick="edit('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Delete Card"><i class="ni ni-bold-right"></i></a>';
                    }
			    },
                {
			        "aTargets": [3],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	if(data == "ACTIVE"){
                            return '<span class="badge badge-success">ACTIVE</span>';
                        } else if(data == "INACTIVE"){
                            return '<span class="badge badge-danger">{{__("common.inactive")}}</span>';
                        } 
			        }
                },
            ]
        })
        $('#search').on('click', function () {
            if (! _.isEmpty( $('#company_name').val() ) ) 
            {
                table.search( this.value ).draw()
            }
        })
    });

    function create(channel_name) {
        const url = '{!! URL::to("Settlement/Product/corporate/create") !!}'
        window.location.href = url+'/'+channel_name
    }
 
    function edit(corp_code) {
        var channel_name = $('#channel_name').val();
        const url = '{!! URL::to("Settlement/Product/edit/") !!}'
        window.location.href = url+'/'+corp_code+'/'+channel_name
    }

    const currentlang = `{{ app()->getLocale() }}`
   
</script>
@endsection
