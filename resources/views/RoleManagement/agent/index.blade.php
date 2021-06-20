@extends('argon_layouts.app', ['title' => __('Role Management')])

@section('style')
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('role.role_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    @Permission(AGENT_ROLE_MANAGEMENT.CREATE_ROLE)
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ action('Agent\RoleManagementController@CreateRole') }}" class="btn btn-neutral">{{__('role.add_new_role')}}</a>
                    </div>
                    @EndPermission
                </div> 

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('role.role_name')}}</label>
                                            <input type="text" id="role_name" name="role_name" placeholder="{{__('role.search')}}" class="form-control">
                                        </div>
                                    </div>

                                    @if ( isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type === 'SYSTEM' )
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('role.agent')}}</label>
                                            <select class="agent" id="agent" name="agent" placeholder="{{__('role.agent_search')}}"></select>
                                        </div>
                                    </div>

                                    @endif


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                            <select class="form-control custom-form-control" name="status" id="status">
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

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('role.role_management')}}</h3>
                                <p class="text-sm mb-0"></p>
                            </div>
                        </div>
                    </div>

                    <div class="w-100 table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="roles" class="table table-flush dataTable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
      
        var table = $("#roles").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            "deferLoading": 0, // here
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
                url: '{{ action("Agent\RoleManagementController@objectData_agent_role") }}',
                method: 'POST',
                data: function (d) {
                    d._token    = "{{ csrf_token() }}",
                    d.role_name = $('input[name=role_name]').val(),
                    d.agent     = $('#agent').val(),
                    d.status    = $('select[name=status]').val()
                }
            },
            columns: [
                { data: 'name',           name: 'roles.name',           title: '{{__('role.role_name')}}' },
                { data: 'description',    name: 'roles.description',    title: '{{__('role.role_description')}}'  },
                { data: 'status',    name: 'status',    title: '{{__('role.status')}}'  },
                
                @Permission(AGENT_ROLE_MANAGEMENT.VIEW_ROLE_DETAIL)
                    { data: 'code',    name: 'code',    title: '{{__('role.action')}}', orderable: false  },
                @EndPermission
            ],
            aoColumnDefs: [
                { className: "text-center", targets: "_all" },
                {
                    "aTargets": [2],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if(data != 'ACTIVE')
                        {
                            return '<span class="badge badge-danger">{{__('role.inactive')}}</span>';
                        }
                        else
                        {
                            return '<span class="badge badge-success">{{__('role.active')}}</span>';
                        }
                    }
                },
                @Permission(AGENT_ROLE_MANAGEMENT.VIEW_ROLE_DETAIL)
                {
                    "aTargets": [-1],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        let path = `{{ action('Agent\RoleManagementController@RoleAndPermission', ['code' => '%%CODE%%']) }}`
                        return `<a class="btn btn-sm btn-default" href="${path.replace('%%CODE%%', data)}"><i class="ni ni-bold-right"></i></a>`
                    }
                },
                @EndPermission
            ],
            createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                $( row ).find('td:not(:first-child)').addClass("text-center")
                $( row ).find('td:first-child').addClass("text-left")

            }
        })

        @if ( isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type !== 'SYSTEM' )
            table.draw()

            $('#search').on('click', function () {
                table.search( this.value ).draw()
            })

        @else
            const currentlang = `{{ app()->getLocale() }}`
            $('#agent').select2({
                placeholder: "{{__('role.agent_search')}}",
                minimumInputLength: 2,
                language: {
                    inputTooShort: function() {
                        return "{{__('role.agent_search_validate')}}";
                    }
                },
                ajax: {
                    delay: 250,
                    cache: true,
                    url: '{{ action("AgentManageController@select2_agent") }}',
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
                                    return { id: item.id, text: item.text_en }
                                })
                            }
                        }else{
                            return {
                                results: $.map(data.items, function(item) {
                                    return { id: item.id, text: item.text_th }
                                })
                            }
                        }
                    }
                }
            })

            $('#search').on('click', function () {
                if (! _.isEmpty( $('#agent').val() ) ) {
                    table.search( this.value ).draw()
                }
            })
        @endif

    })
</script>
@endsection
