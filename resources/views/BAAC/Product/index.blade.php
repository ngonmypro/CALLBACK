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
                    <h6 class="h2 text-white d-inline-block mb-0">BAAC Product</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        
                    </nav>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card">
                        @if(Session::get('user_detail')->user_type == 'AGENT')
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Company Name</label>
                                        <input type="text" name="company_name" class="form-control" placeholder="Search Company Name">
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="example3cols2Input">{{__('recipient.profile.status')}}</label>
                                        <select class="form-control custom-form-control" name="status" id="status">
                                            <option selected disabled>{{__('recipient.profile.status')}}</option>
                                            <option value="">{{__('common.all')}}</option>
                                            <option value="ACTIVE">{{__('common.active')}}</option>
                                            <option value="INACTIVE">{{__('common.inactive')}}</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>

                            <div class="row px-3">
                                <div class="offset-md-10 col-md-2">
                                    <div class="form-group">
                                        <button type="button" id="search" class="btn btn-primary w-100" robot-test="corporate-index-submit-search">{{__('common.search')}}</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @endif
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
                                    <h3 class="mb-0">Product</h3>
                                    <p class="text-sm mb-0"></p>
                                </div>
                                <div>
                                    <ul class="list-inline"> 
                                        {{-- <li class="list-inline-item">
                                            <a href="{!! URL::to('BAAC/Product/Create') !!}" class="btn btn-primary w-100 text-uppercase">Create</a>
                                        </li> --}}
                                        <li class="list-inline-item">
                                            <a href="{{ url('BAAC/Product/Upload')}}" class="btn btn-primary w-100 text-uppercase">Import File</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="dataTables_wrapper dt-bootstrap4">
                        <table id="product" class="table simple-table" style="width:100%"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script>
$(document).ready(function() {
    var table = $("#product").DataTable({
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
            url: '{!! URL::to("/BAAC/Product/objectData") !!}',
            method: 'POST',
            data: function(d) {
                d._token = "{{ csrf_token() }}",
                @if(Session::get('user_detail')->user_type == 'USER')
                    d.corp_code = '{{Session::get('CORP_CURRENT')['corp_code']}}'
                @else
                    d.company_name = $('input[name="company_name"]').val() || null
                @endif
                // d.status = $('select[name="status"]').val() || null
            }
        },
        columns: [
            @if( app()->getLocale() == "th" )
                { data: 'corp_name_th',         name: 'corp_name_th',       title: "Corporate Name" },
            @else
                { data: 'corp_name_en',         name: 'corp_name_en',       title: "Corporate Name" },
            @endif
            { data: 'catalogue_name',		 name: 'catalogue_name',      title: 'Catalogue Name',    class: 'text-center' },
            { data: 'product_name',		   name: 'product_name',        title: 'Product Name',      class: 'text-center' },
            { data: 'product_type',		   name: 'product_type',        title: 'Product Type',      class: 'text-center' },
            { data: 'product_code',      name: 'product_code',        title: 'Action'   }
        ],
        aoColumnDefs: [
            {
                aTargets: [-1],
                mRender: function (data, type, full) {
                  return '<a href="{!! URL::to("BAAC/Product/Detail") !!}/'+data+'" class="btn btn-sm btn-default" title="View Detail"><i class="ni ni-bold-right"></i></a>';
                }
            }
        ]
    })

    $('#search').on('click', function() {
        table.search(this.value).draw()
    })
});
</script>

@endsection