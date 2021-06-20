@extends('argon_layouts.app', ['title' => __('Corporate Management')])

@section('style')
    
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">

                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('corporate.corporate_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    @Permission('CORPORATE_MANAGEMENT.CREATE')
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ url('/Corporate/Create')}}" class="btn btn-neutral" robot-test="corporate-index-create-corporate-button">{{__('corporate.addmorecorp')}}</a>
                    </div>
                    @EndPermission
                </div> 

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label" for="example3cols2Input">{{__('corporateManagement.company_name')}}</label>
                                            <input class="form-control" name="company_name" type="text" value="" placeholder="{{__('corporate.search_corp_name')}}" robot-test="corporate-index-companyname-search">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label" for="example3cols2Input">{{__('corporateManagement.taxid')}}</label>
                                            <input class="form-control" name="tax_id" type="text" value="" placeholder="{{__('corporate.search_taxid')}}" robot-test="corporate-index-taxid-search">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-0">
                                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                            <select class="form-control custom-form-control" name="status" id="status" robot-test="corporate-index-status-search">
                                                <option disabled>{{__('common.status')}}</option>
                                                <option selected value="">{{__('common.all')}}</option>
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
                            <div class="col-8">
                                <h3 class="mb-0">{{__('corporate.corporate_management')}}</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="table" class="table table-flush dataTable"></table>
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
    <!--- Daterange picker --->
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            var table = $("#table").DataTable({
                sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "asc" ], [ 1, "asc" ]],
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
                    url: '{!! URL::to("Corporate/objectData") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token = "{{ csrf_token() }}"
                        d.status = $('select[name="status"]').val()
                        d.tax_id = $('input[name="tax_id"]').val()
    					d.company_name = $('input[name="company_name"]').val()                        
                    }
                },
                columns: [
                    @if( app()->getLocale() == "th" )
                        { data: 'group_name_th',        name: 'group_name_th',      title: "{{__('corporate.group')}}" },
                    @else
                        { data: 'group_name_en',        name: 'group_name_en',      title: "{{__('corporate.group')}}" },
                    @endif
                    @if( app()->getLocale() == "th" )
                        { data: 'corp_name_th',         name: 'corp_name_th',       title: "{{__('corporate.name')}}" },
                    @else
                        { data: 'corp_name_en',         name: 'corp_name_en',       title: "{{__('corporate.name')}}" },
                    @endif
                    { data: 'tax_id',                   name: 'tax_id',             title: "{{__('corporate.taxid')}}"  },
                    { data: 'status',                   name: 'status',             title: "{{__('corporate.status')}}" },
                    { title: '', orderable: false  },
                ],
                aoColumnDefs: [
                    { className: "text-center", targets: "_all" },
                    {
                        aTargets: [4],
                        mRender: function (data, type, full) {
                            var btn_view =  '<a href="{{ url('/Corporate/Detail')}}/'+full.corp_code+'" class="btn btn-sm btn-default" robot-test="corporate-index-view-corporateinfo">'+
                                                '<i class="ni ni-bold-right"></i>'+
                                            '</a>'

                            var setting_btn = ''

                            @Permission(CORPORATE_MANAGEMENT.CORPORATE_SETTING|CORPORATE_MANAGEMENT.FEE|CORPORATE_MANAGEMENT.PAYMENT_ACC|CORPORATE_MANAGEMENT.RD_SCHEDULE|CORPORATE_MANAGEMENT.ETAX_JOB|CORPORATE_MANAGEMENT.BILL_CUSTOMER_FEE|CORPORATE_MANAGEMENT.LOAN_SCHEDULE|CORPORATE_MANAGEMENT.PAYMENT_SETTING|CORPORATE_MANAGEMENT.BRANCH_CONFIG)
                            setting_btn =   `
                                                <a href="{!! URL::to("Corporate") !!}/${full.corp_code}/Setting" class="btn btn-sm btn-default" robot-test="corporate-index-view-corporatesetting">
                                                    <i class="ni ni-settings"></i>
                                                </a>
                                            `
                            @EndPermission

                            return btn_view+setting_btn
                        }
                    },
                    {
                        aTargets: [3],
                        mRender: function (data, type, full) {
                            if(data == "ACTIVE"){
                                return '<span class="badge badge-success">{{__("common.active")}}</span>';
                            }
                            else if(data == "INACTIVE"){
                                return '<span class="badge badge-danger">{{__("common.inactive")}}</span>';
                            }
                            
                        }
                    },
                ]
            })

            $('#search').on('click', function () {
                table.search( this.value ).draw()
            })

        })

    </script>
@endsection
