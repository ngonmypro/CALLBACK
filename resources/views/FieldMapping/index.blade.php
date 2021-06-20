@extends('argon_layouts.app', ['title' => __('E-Tax')])

@section('style')
	<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all"> 
    <style>
        
    </style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('fieldmapping.field_mapping')}}">
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{__('fieldmapping.field_mapping')}}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <div class="ml-auto p-2 pull-rigth">
                        <button type="button" class="btn btn-print text-capitalize" onclick="window.location.href='{{ url('/FieldMapping/Import')}}'">
                            <i class="zmdi zmdi-plus pr-2"></i>
                            {{__('fieldmapping.add_new')}}
                        </button>
                    </div>
                    <!-- <div class="p-2">
                        <button type="button" class="btn btn-print text-capitalize" onclick="window.location.href='{{ url('/FieldMapping/New/Default')}}'">
                            <i class="zmdi zmdi-plus pr-2"></i>
                            New All Default
                        </button>
                    </div> -->
                </div>
            </div> 
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <div class="d-flex flex-wrap flex-column">
                                <div class="p-2">
                                    <div class="col-12 px-0 table-responsive">
                                        <table id="field_mapping_table" class="table simple-table nowrap theme-style dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_info">
                        
                                        </table>
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
</div>

@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $("#field_mapping_table").DataTable({
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
                url: '{!! URL::to("FieldMapping/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token            = "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'name',             name: 'name',           title:  '{{__('fieldmapping.name')}}'  },
                { data: 'doc_type',         name: 'doc_type',       title:  '{{__('fieldmapping.doc_type')}}', class: 'text-center'  },
                { data: 'code_name',        name: 'code_name',      title:  '{{__('fieldmapping.dir')}}', class: 'text-center'  },
                { data: 'status',           name: 'status',         title:  '{{__('fieldmapping.status')}}', class: 'text-center'  },
                { data: 'reference_code',   name: 'action',         title:  '{{__('fieldmapping.action')}}', class: 'text-center' }
            ],
            createdRow : function( row, data, dataIndex ) {
                $(row).addClass('state-unlock');
            },
            aoColumnDefs: [
                {
                    "aTargets": [1],
                        "mRender": function (data, type, full) {
                            // return ucwords(str_replace('_', ' ', strtolower(data)))
                            data = data.toLowerCase().replace('_', ' ');
                            return data.replace(/(^([a-zA-Z\p{M}]))|([ _-][a-zA-Z\p{M}])/g,
                                function(s){
                                    return s.replace('_', ' ').toUpperCase();
                                });
                        }
                },
                {
                    "aTargets": [2],
                        "mRender": function (data, type, full) {
                            return full['doc_type']+'/'+data;
                        }
                },
                {
                    "aTargets": [3],
                        "mRender": function (data, type, full) {
                            if(data == "ACTIVE") {
                                return '<span class=""><i class="text-success"></i><span class="success text-success"> {{__('common.active')}}</span></span>';
                            } else if(data == "INACTIVE") {
                                return '<span class=""><i class="text-danger"></i><span class="fail text-danger"> {{__('common.inactive')}}</span></span>';
                            } else {
                                return data;
                            }
                        }
                },
                {
                    "aTargets": [4],
      			        "mRender": function (data, type, full) {
      			            return  '<a  href="{{ url('/FieldMapping/Detail')}}/'+data+'" class="view-detail">'+
                                        '<i class="ni ni-bold-right"></i>'+
                                    '</a>';
      			        }
                },
            ]
        });
    });
</script>
@endsection
