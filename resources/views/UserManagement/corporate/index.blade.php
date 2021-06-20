@extends('argon_layouts.app', ['title' => __('User Management')])

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
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.user_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        </nav>
                    </div>

                    @Permission(CORPORATE_USER_MANAGEMENT.CREATE_USER)
                    <div class="col-lg-6 col-5 text-right">
                        <button id="btn-create" class="btn btn-neutral d-none">{{__('userManagement.new_user')}}</button>
                    </div>
                    @EndPermission

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

                                    @if ( isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type !== 'USER' )
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('role.corporate')}}</label>
                                            <select name="corporate" class="corporate" id="corporate"></select>
                                        </div>
                                    </div>

                                    @endif
                                    
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
                                <p class="text-sm mb-0"></p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive" id="users_detail_wrapper">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="users_detail" class="table table-flush dataTable" style="width:100%"></table>
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
<script type="text/javascript">

    $(document).ready(function() {

        // USER DATATABLE
        var dt = $("#users_detail").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            "deferLoading": 0, // here
            processing: true,
            serverSide: true,
            order: [[ 5, "desc" ]],
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
                url: "{{ action('Corporate\UserManagementController@objectData') }}",
                method: 'POST',
                data: function (d) {
                    d._token    = "{{ csrf_token() }}",
                    d.username  = $('input[name=username]').val(),
                    d.email     = $('input[name=email]').val(),
                    d.status    = $('select[name=user_status]').val(),
                    d.expired_at    = $('select[name=expired_at]').val(),
                    d.corporate = $('#corporate').val()
                }
            },
            columns: [
              
                { data: 'username',             name: 'username', title: '{{__('userManagement.username')}}' , class: 'text-center'  },
                { data: 'role_name',            name: 'roles.name', title: '{{__('userManagement.role_user')}}' , class: 'text-center' },
                { data: 'status',               name: 'users.status', title: '{{__('userManagement.status')}}' , class: 'text-center'  },
                { data: 'expired_at',           name: 'users.expired_at', title: '{{__('userManagement.expired')}}' , class: 'text-center'  },
                @Permission(CORPORATE_USER_MANAGEMENT.VIEW_USER_DETAIL)
                { data: 'id',                   name: 'id', title: '{{__('userManagement.action')}}' , class: 'text-center'  },
                @EndPermission
                { data: 'created_at',           name: 'created_at',  className: "d-none" },
                 
            ],
            aoColumnDefs: [
                {
                    "aTargets": [2],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if ( data != 'ACTIVE' ) {
                            return '<span class="badge badge-danger">{{__('common.inactive')}}</span>';
                        } else {
                            return '<span class="badge badge-success">{{__('common.active')}}</span>';
                        }
                    }
                },
                {
                    "aTargets": [3],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        let today = new Date().toISOString().slice(0, 10);
                        if ( data <= today ) {
                            return '<span class="badge badge-danger">{{__('common.expired')}}</span>';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "aTargets": [4],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        let url = ''

                        @Permission(CORPORATE_USER_MANAGEMENT.VIEW_USER_DETAIL)
                        if ( full.username != "{{ session('user_detail')->username }}" ) {
                            let path = "{{ action('Corporate\UserManagementController@detail', ['user_code' => '%CODE%']) }}"
                            url = `<a class="btn btn-sm btn-default" href="${path.replace('%CODE%', data)}"><i class="ni ni-bold-right"></i></a>`
                        }
                        @EndPermission
                        
                        return url
                    }
                }
            ],
            createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                $( row ).find('td:not(:first-child)').addClass("text-center");
                $( row ).find('td:first-child').addClass("text-left");
            }

        })

        @if ( isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type === 'USER' )
            dt.draw()

            $('#search').on('click', function () {
                dt.search( this.value ).draw()
            })

            // remove hidden class
            $('#btn-create').removeClass('d-none')

            $(document).on('click', '#btn-create', function() {
                window.location = "{{ action('Corporate\UserManagementController@default_create') }}"
            })

        @else

            let corp_code = `{{ isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : null }}`   
            $(document).on('click', '#btn-create', function() {
                const urlTo = "{{ action('Corporate\UserManagementController@create', ['corp_code' => '%CORP_CODE%']) }}"
                if (! _.isEmpty(corp_code) ) {
                    window.location = urlTo.replace('%CORP_CODE%', corp_code)
                } else {
                    swal.fire('The Corporate?', 'Please select corporate', 'info')
                }
            })

            $(document).on('select2:selecting', '#corporate', function(e) {
                corp_code = e.params.args.data.id
                $('#btn-create').removeClass('d-none')
            })

            const currentlang = `{{ app()->getLocale() }}`
            $('#corporate').select2({
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
                    url: '{{ action("CorporateController@select2_corporate") }}',
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
                if (! _.isEmpty( $('#corporate').val() ) ) {
                    dt.search( this.value ).draw()
                }
            })

        @endif

    });
    

</script>
@endsection
