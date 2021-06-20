@extends('argon_layouts.app', ['title' => __('Function Management')])

@section('style')
<link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{__('function.function')}}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right d-none">
                    <a href="" class="btn btn-neutral">{{__('common.back')}}</a>
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
                            <div class="col-8">
                                <h3 class="mb-0">{{__('function.function_management')}}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('function.app_name')}}</label>
                                    <input type="text" name="app_name" class="form-control" placeholder="{{__('function.search_app')}}">
                                </div>
                            </div>
                          
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('function.function_name')}}</label>
                                    <input type="text" name="function_name" class="form-control" placeholder="{{__('function.search_function_name')}}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">{{__('function.function_type')}}</label>
                                    <select class="form-control custom-form-control" name="function_type" id="function_type">
                                        <option selected disabled>{{__('function.search_function_type')}}</option>
                                        <option value="">{{__('common.all')}}</option>
                                        <option value="AGENT">{{__('function.agent')}}</option>
                                        <option value="USER">{{__('function.corporate')}}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="example3cols2Input">{{__('recipient.profile.status')}}</label>
                                    <select class="form-control custom-form-control" name="status" id="status">
                                        <option selected disabled>{{__('recipient.profile.status')}}</option>
                                        <option value="">{{__('common.all')}}</option>
                                        <option value="ACTIVE">{{__('common.active')}}</option>
                                        <option value="INACTIVE">{{__('common.inactive')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="offset-md-10 col-md-2">
                                <div class="form-group">
                                    <button type="button" id="search" class="btn btn-primary w-100" robot-test="corporate-index-submit-search">{{__('common.search')}}</button>
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
                                    <h3 class="mb-0">{{__('function.function_management')}}</h3>
                                    <p class="text-sm mb-0"></p>
                                </div>
                                <div>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{!! URL::to('Function/Create') !!}" class="btn btn-primary w-100 text-uppercase">{{__('common.create')}}</a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <table id="function_detail" class="table simple-table" style="width:100%"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{{-- {!! JsValidator::formRequest('App\Http\Requests\CreateUserRole','#create_role') !!} --}}

<script>
$(document).ready(function() {

    $('#search').on('click', function() {
        table.search(this.value).draw()
    })

    var table = $("#function_detail").DataTable({
        sPaginationType: "simple_numbers",
        bFilter: false,
        dataType: 'json',
        processing: true,
        serverSide: true,
        order: [
            [1, 'asc'],
            [2, 'asc']
        ],
        dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
        language: {
            paginate: {
                previous: "<i class='fas fa-angle-left'>",
                next: "<i class='fas fa-angle-right'>"
            }
        },
        ajax: {
            url: '{!! URL::to("/Function/objectData") !!}',
            method: 'POST',
            data: function(d) {
                    d._token = "{{ csrf_token() }}",
                    d.app_name = $('input[name="app_name"]').val() || null,
                    d.function_name = $('input[name="function_name"]').val() || null,
                    d.function_type = $('select[name="function_type"]').val() || null,
                    d.status = $('select[name="status"]').val() || null
            }
        },
        columns: [
            { data: 'app_name',		       name: 'app_name',            title: 'App',               class: 'text-center' },
    				{ data: 'function_name',		 name: 'function_name',       title: 'Function Name',     class: 'text-center' },
    				{ data: 'function_type',     name: 'function_type',       title: 'Function Type',     class: 'text-center' },
    				{ data: 'status',            name: 'status',              title: 'Status',            class: 'text-center' },
            { data: 'function_code',     name: 'reference_code',      title: "{{__('bill.index.action')}}"   }
        ],
        aoColumnDefs: [
            {
                aTargets: [2],
                mRender: function (data, type, full) {
                    if(data == 'USER') {
                        return 'CORPORATE';
                    }
                    else {
                        return data;
                    }
                }
            },
            {
                aTargets: [-1],
                mRender: function (data, type, full) {
                  return '<a href="{!! URL::to("Function/Edit") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                }
            }
        ]
    })

});
</script>

@endsection