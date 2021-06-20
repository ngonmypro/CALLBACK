@extends('argon_layouts.app', ['title' => __('User Management')])


@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">

    <style>
        
    </style>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.user_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right" id="btn-create">
                        <a href="{{ url('UserManagement/Create')}}" class="btn btn-neutral">{{__('userManagement.new_user')}}</a>
                    </div>
                </div> 
                <div class="row">
                    @if (isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type === 'SYSTEM')
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats active cursor-pointer">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('userManagement.admin')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="ni ni-folder-17"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (isset(Session::get('user_detail')->user_type) && in_array(Session::get('user_detail')->user_type, ['AGENT', 'SYSTEM']))
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats cursor-pointer" onclick="OpenUserTable(this)" data-user="no">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('userManagement.agent_user')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                            <i class="ni ni-single-02"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats cursor-pointer" onclick="OpenCorpUserTable(this)" data-user="yes">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('userManagement.corporate_user')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-single-02"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats cursor-pointer">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('userManagement.corporate_user')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-single-02"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
            
                                    <div class="col-md-4 search-user">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('userManagement.username')}}</label>
                                            <input type="text" id="username" name="username" placeholder="{{__('userManagement.place_holder_username')}}" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 search-user">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('userManagement.email')}}</label>
                                            <input type="text" id="email" name="email" placeholder="{{__('userManagement.place_holder_email')}}" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 search-user">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                            <select class="form-control custom-form-control" name="user_status" id="user_status">
                                                <option selected disabled>{{__('common.status')}}</option>
                                                <option value="">{{__('common.all')}}</option>
                                                <option value="ACTIVE">{{__('common.active')}}</option>
                                                <option value="INACTIVE">{{__('common.inactive')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 search-corp d-none">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('userManagement.corp_name')}}</label>
                                            <input type="text" id="corporate_name" name="corporate_name" placeholder="{{__('userManagement.place_holder_corp_name')}}" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 search-corp d-none">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                            <select class="form-control custom-form-control" name="corp_status" id="corp_status">
                                                <option selected disabled>{{__('common.status')}}</option>
                                                <option value="">{{__('common.all')}}</option>
                                                <option value="ACTIVE">{{__('common.active')}}</option>
                                                <option value="INACTIVE">{{__('common.inactive')}}</option>
                                            </select>
                                        </div>
                                    </div>
            
                                </div>
                            </div>
            
                            <div class="row px-3">
            
                                <div class="offset-md-10 col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="search" value="user" class="btn btn-primary w-100">{{__('common.search')}}</button>
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
                            <div class="col-8">
                                <h3 class="mb-0">{{__('userManagement.user_management')}}</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="users_detail_wrapper">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="users_detail" class="table table-flush dataTable" style="width:100%"></table>
                        </div>
                    </div>

                    <div class="table-responsive d-none" id="dt_corp_user_wrapper">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="dt_corp_user" class="table table-flush dataTable" style="width:100%"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- DATATABLE IN MODAL -->
<div id="filter_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div id="" class="modal-header">
                <h5 class="modal-title">
                    <ul class="list-inline">
                      <li class="list-inline-item" id="modal_dt_corp_name"></li>
                      <li class="list-inline-item"> / </li>
                      <li class="list-inline-item text-capitalize">{{__('userManagement.user_list')}}</li>
                    </ul>
                </h5>
                <span class="float-right">
                    @if(isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type !== 'SYSTEM')
                    <button type="button" class="btn btn-primary" id="btn_new_user">
                        {{__('userManagement.new_user')}}
                    </button>
                    @endif
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </span>
            </div>
            <div id="" class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">{{__('userManagement.username')}}</label>
                            <input type="text" id="modal_username" name="modal_username" placeholder="{{__('userManagement.place_holder_username')}}" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols1Input">{{__('userManagement.email')}}</label>
                            <input type="text" id="modal_email" name="modal_email" placeholder="{{__('userManagement.place_holder_email')}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                            <select class="form-control custom-form-control" name="modal_status" id="modal_status">
                                <option selected disabled>{{__('common.status')}}</option>
                                <option value="">{{__('common.all')}}</option>
                                <option value="ACTIVE">{{__('common.active')}}</option>
                                <option value="INACTIVE">{{__('common.inactive')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="offset-md-10 col-md-2">
                        <div class="form-group">
                            <button type="button" id="modal_search" class="btn btn-primary w-100">{{__('common.search')}}</button>
                        </div>
                    </div>
                        
                </div>
                <div class="col-12 px-0 table-responsive">
                    <table id="dt_filter_modal" class="table simple-table nowrap" style="width:100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript">
    $(document).on("click" , ".filter-user" , function(){
        $(".filter-user").not($(this)).find(".user_count").removeClass("template-border-box");
    })

    function FilterCorp(data, corp_name) {
        $('#filter_modal').data('corp', data)
        $('#filter_modal').data('name', corp_name)
        $("#filter_modal").modal("show")
        $("#modal_username").val('');
        $("#modal_email").val('');
        $("#modal_status").val('');
    }

    function OpenUserTable(elem_this) {
        //$(".user_count").not($(elem_this)).removeClass("template-border-box");
        $("#users_detail_wrapper").removeClass('d-none');
        $("#btn_user").removeClass("d-none");
        $("#btn-create").removeClass("d-none");
        
        $(".search-user").removeClass("d-none");
        $("#search").val("user");
        
        HideCorpUserTable()
    }

    function OpenCorpUserTable(elem_this) {
        //$(".user_count").not($(elem_this)).removeClass("template-border-box");
        $("#dt_corp_user_wrapper").removeClass('d-none');
        $("#btn_user").addClass("d-none");
        $("#btn-create").addClass("d-none");
        
        $(".search-corp").removeClass("d-none");
        $("#search").val("corp");
        
        HideUserTable()
    }

    function HideUserTable() {
        $("#users_detail_wrapper").addClass('d-none');
        $(".search-user").addClass("d-none");
    }

    function HideCorpUserTable() {
        $("#dt_corp_user_wrapper").addClass('d-none');
        $(".search-corp").addClass("d-none");
    }

    @Permission(USER_MANAGEMENT.CREATE_USERS)
        $('#btn_new_user').on('click', function() {
            const url = '{!! URL::to("/UserManagement/Create/%%CORP%%/Corporate") !!}'
            window.location.href = url.replace('%%CORP%%', $('#filter_modal').data('corp'))
        })
    @EndPermission

    @Permission(USER_MANAGEMENT.CREATE_USERS)
        $('#btn_user').on('click', function() {
            const url = '{!! URL::to("/UserManagement/Create") !!}'
            window.location.href = url
        })
    @EndPermission

    // USER DATATABLE
    var user_table = $("#users_detail").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            serverSide: true,
            order: [[ 0, 'asc' ], [ 1, 'asc' ]],
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
                url: '{!! URL::to("UserManagement/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token    = "{{ csrf_token() }}",
                    d.username  = $('input[name=username]').val(),
                    d.email     = $('input[name=email]').val(),
                    d.status    = $('select[name=user_status]').val()
                }
            },
            columns: [
                { data: 'username',             name: 'username', title: '{{__('userManagement.username')}}' , class: 'text-center'  },
                { data: 'role_name',            name: 'roles.name', title: '{{__('userManagement.role_user')}}' , class: 'text-center' },
                { data: 'status',               name: 'users.status', title: '{{__('userManagement.status')}}' , class: 'text-center'  },
                @Permission(USER_MANAGEMENT.EDIT_USERS)
                { data: 'id',                   name: 'id', title: '{{__('userManagement.action')}}' , class: 'text-center'  },
                @EndPermission
            ],
            aoColumnDefs: [
                {
                    "aTargets": [2],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if(data != 'ACTIVE')
                        {
                            return '<span class="badge badge-danger">{{__('common.inactive')}}</span>';
                        }
                        else
                        {
                            return '<span class="badge badge-success">{{__('common.active')}}</span>';
                        }
                    }
                },
                @Permission(USER_MANAGEMENT.EDIT_USERS)
                {
                    "aTargets": [3],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if(full.username != "{{session('user_detail')->username}}") {
                            const btn_view = '<a class="btn btn-sm btn-default" href="{{ url('/UserManagement/Detail')}}/'+data+'"><i class="ni ni-bold-right"></i></a>'
                            return btn_view;
                        }
                        else{
                            return '';
                        }
                    }
                }
                @EndPermission
            ],
            createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                $( row ).find('td:not(:first-child)').addClass("text-center");
                $( row ).find('td:first-child').addClass("text-left");
            }

        });

        @if (isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type !== 'USER')
        // CORP USER DATABLE
        var dt_corp_user = $("#dt_corp_user").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            serverSide: true,
            order: [[ 0, 'asc' ], [ 1, 'asc' ]],
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
                url: '{!! URL::to("UserManagement/Corps/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.corporate_name = $('input[name=corporate_name]').val(),
                    d.status = $('select[name=corp_status]').val()
                }
            },
            columns: [
                @if( app()->getLocale() == "th" )
                    { data: 'name_th',    name: 'name_th', title: '{{__('userManagement.corporate')}}' , class: 'text-center' },
                @else
                    { data: 'name_en',    name: 'name_en', title: '{{__('userManagement.corporate')}}' , class: 'text-center' },
                @endif
                { data: 'total_user',    name: 'total_user',    title: '{{__('userManagement.total_user')}}' , class: 'text-center'},
                // { data: 'user_type',     name: 'user_type',     title: '{{__('userManagement.user_type')}}'  , class: 'text-center'},
                { data: 'updated_at',    name: 'updated_at',    title: '{{__('userManagement.updated_date')}}' , class: 'text-center'},
                { data: 'corp_code',     name: 'corp_code',     title: '{{__('userManagement.action')}}' , class: 'text-center' }
            ],
            aoColumnDefs: [
                { className: "text-center", targets: "_all" },
                {
                    aTargets: [2],
                    mRender: function (data, type, full) {
                        return data || ' - '
                    }
                },
                {
                    aTargets: [3],
                    mRender: function (data, type, full) {
                        @if(app()->getLocale() == "th")
                        const corp_name = full.name_th
                        @else
                        const corp_name = full.name_en
                        @endif

                        return `<button class="btn btn-sm btn-default" onclick="FilterCorp('${data}', '${corp_name}')">
                                    <i class="ni ni-bold-right"></i>
                                </button>`;
                    }
                }
            ]
        });
        @endif

        //////////////////////////////////////////////////////
        $('#filter_modal').on('shown.bs.modal', function (e) {
            const url = ('{!! URL::to("UserManagement/Corp/%CORP%/objectData") !!}').replace('%CORP%', $(this).data('corp'))
            $('#modal_dt_corp_name').text($(this).data('name'))

            // prevent re-initialize datatable (reload)
            if ($.fn.DataTable.isDataTable('#dt_filter_modal')) {
                $('#dt_filter_modal').DataTable().ajax.url(url).load()
                return
            
            // load datatable if not exist
            } else {
                const dt_modal_user_corp = $("#dt_filter_modal").DataTable({
                    sPaginationType: "simple_numbers",
                    bFilter: false,
                    dataType: 'json',
                    processing: true,
                    serverSide: true,
                    order: [[ 0, 'asc' ], [ 1, 'asc' ]],
                    dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                    language: {
                        paginate: {
                            previous: "<i class='fas fa-angle-left'>",
                            next: "<i class='fas fa-angle-right'>"
                        }
                    },
                    ajax: {
                        url: url,
                        method: 'POST',
                        data: function (d) {
                            d._token    = "{{ csrf_token() }}",
                            d.username  = $('input[name=modal_username]').val(),
                            d.email     = $('input[name=modal_email]').val(),
                            d.status    = $('select[name=modal_status]').val()
                        }
                    },
                    columns: [
                        { data: 'username',             name: 'username',       title: '{{__('userManagement.username')}}' , class: 'text-center' },
                        { data: 'role_name',            name: 'roles.name',     title: '{{__('userManagement.roles')}}' , class: 'text-center' },
                        { data: 'created_at',           name: 'created_at',     title: '{{__('userManagement.created_date')}}'  , class: 'text-center'},
                        { data: 'status',               name: 'users.status',   title: '{{__('userManagement.status')}}'  , class: 'text-center'},
                        @Permission(USER_MANAGEMENT.EDIT_USERS)
                            { data: 'id',                   name: 'id', title: '{{__('userManagement.action')}}' , class: 'text-center'  }
                        @EndPermission
                    ],
                    aoColumnDefs: [
                        {
                            "aTargets": [3],
                            "mData": null,
                            "mRender": function (data, type, full) {
                                if(data != 'ACTIVE')
                                {
                                    return '<span class="badge badge-danger">{{__('common.inactive')}}</span>';
                                }
                                else
                                {
                                    return '<span class="badge badge-success">{{__('common.active')}}</span>';
                                }
                            }
                        },
                        @Permission(USER_MANAGEMENT.EDIT_USERS)
                        {
                            "aTargets": [4],
                            "mData": null,
                            "mRender": function (data, type, full) {
                                var btn_view =  '<a href="{{ url('/UserManagement/Detail')}}/'+data+'" class="btn btn-sm btn-default">'+
                                                    '<i class="ni ni-bold-right"></i>'+
                                                '</a>';

                                return btn_view;
                            }
                        }
                        @EndPermission
                    ],
                    createdRow: function( row, data, dataIndex ) {
                        // Set the data-status attribute, and add a class
                        $( row ).find('td:not(:first-child)').addClass("text-center");
                        $( row ).find('td:first-child').addClass("text-left");
                    }

                })
            }
        });
        
        $('#search').on('click', function() {
            if($('#search').val() == 'user') {
                user_table.ajax.reload();
            }
            if($('#search').val() == 'corp') {
                dt_corp_user.ajax.reload();
            }
        });
        
        $('#modal_search').on('click', function() {
            var dt_modal_user_corp = $("#dt_filter_modal").DataTable();
            dt_modal_user_corp.ajax.reload();
        });

</script>
@endsection
