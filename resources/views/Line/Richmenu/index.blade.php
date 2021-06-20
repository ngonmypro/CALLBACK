@extends('argon_layouts.app', ['title' => __('News')])



@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Rich Menu</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
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
                            <div class="col-8">
                                <h3 class="mb-0">Rich Menu</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{!! URL::to("Line/Richmenu/Create") !!}" class="btn btn-primary">Add Richmenu</a>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="richmenu_table" class="table table-flush dataTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">App Name</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center" width="100">Auth</th>
                                        <th class="text-center" width="100">App</th>
                                        <th class="text-center" width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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


    });

    var table = $("#richmenu_table").DataTable({
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
            url: '{!! URL::to("Line/Richmenu/objectData") !!}',
            method: 'POST',
            data: function (d) {
                d._token        = "{{ csrf_token() }}"
                // d.daterange     = $('input[name="daterange"]').val() || '',
                // d.customer_code = $('input[name="customer_code"]').val() || '',
//                   d.batch_name    = $('input[name="batch_name"]').val() || '',
                // d.inv_no        = $('input[name="inv_no"]').val() || ''
            }
        },
        columns: [
            { data: 'app_name',    name: 'app_name',  title: "App Name"  },
            { data: 'richmenu_name',    name: 'richmenu_name',  title: "Name"  },
            { data: 'image_path',       name: 'image_path',     title: "Image", class: 'text-center'},
            { data: 'is_default_auth',           name: 'is_default_auth',         title: "Status", class: 'text-center'},
            { data: 'is_default_app',           name: 'is_default_app',         title: "Status", class: 'text-center'},
            { data: 'reference',        name: 'reference',      title: "{{__('bill.index.action')}}", class: 'text-center'}
        ],
        columnDefs: [
            { className: "text-center", targets: "_all" }
        ],
        aoColumnDefs: [
            {
                aTargets: [2],
                mRender: function (data, type, full) {
                    return '<img class="img-thumbnail" src="'+data+'" />';
                }
            },
            {
                aTargets: [3],
                mRender: function (data, type, full) {
                    if (data == true) {
                        return '<span class="badge badge-success">ACTIVE</span>';
                    } else {
                        return '<span class="badge badge-danger">INACTIVE</span>';
                    }
                }
            },
            {
                aTargets: [4],
                mRender: function (data, type, full) {
                    if (data == true) {
                        return '<span class="badge badge-success">ACTIVE</span>';
                    } else {
                        return '<span class="badge badge-danger">INACTIVE</span>';
                    }
                }
            },
            {
                aTargets: [5],
                mRender: function (data, type, full) {
                    return '<a href="{!! URL::to("Line/Richmenu/Update") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                }
            }
        ]
    })

</script>
@endsection
