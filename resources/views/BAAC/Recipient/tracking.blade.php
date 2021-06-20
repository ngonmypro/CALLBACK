@extends('argon_layouts.app', ['title' => __('BAAC Bookstate Tracking')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">BAAC Bookstate Tracking</h6>
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
                            <div class="col-8">
                                <h3 class="mb-0">Bookstate Detail</h3>
                            </div>
                        </div>
                    </div>
                    {{-- {{dd($product)}} --}}
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="col-12">
                                    <label for="" class=" form-control-label">Bookstate Status</label>
                                </div>
                                <div class="col-12">
                                    <label for="" class=" form-control-label"> {{ isset($bookstate->status) ? $bookstate->status : '-' }} </label>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="col-12">
                                    <label for="" class=" form-control-label">Revoke</label>
                                </div>
                                <div class="col-12">
                                @if(isset($bookstate->revoke) && $bookstate->revoke == 1)
                                    <label for="" class=" form-control-label"> YES </label>
                                @elseif(isset($bookstate->revoke) && $bookstate->revoke == 0)
                                    <label for="" class=" form-control-label"> NO </label>
                                @else
                                    <label for="" class=" form-control-label">-</label>
                                @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="col-12">
                                    <label for="" class=" form-control-label">Model</label>
                                </div>
                                <div class="col-12">
                                    <label for="" class=" form-control-label"> {{ isset($bookstate->model) ? $bookstate->model : '-' }} </label>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="col-12">
                                    <label for="" class=" form-control-label">Redeemed At</label>
                                </div>
                                <div class="col-12">
                                    <label for="" class=" form-control-label"> {{ isset($bookstate->created_at) ? $bookstate->created_at : '-' }} </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h3 class="mb-0">Tracking</h3>
                                        <p class="text-sm mb-0"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="tracking" class="table table-flush dataTable"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#btn_submit', function() {
            $('form').submit()
        })
        
        var table = $("#tracking").DataTable({
    				sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
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
      					url: '{{ action("BAAC\RecipientController@tracking_objectData") }}',
      					method: 'POST',
      					data: function (d) {
                    d._token            = "{{ csrf_token() }}",
        						d.code              = "{{$code}}"
      					}
    				},
    				columns: [
                { data: 'txn_datetime',         name: 'txn_datetime',         title: "Transaction Datetime",    className: "text-center"   },
                { data: 'description',          name: 'description',          title: "Description",             className: "text-center"   },
                { data: 'image',                name: 'image',                title: "Image",                   className: "text-center"   },
    				],
            aoColumnDefs: [
                {
                    aTargets: [-1],
                    mRender: function (data, type, full) {
                      if(data) {
                          return '<a target="_blank" href="'+data+'" ><i class="fa fa-eye"></i></a>';
                      }
                      else {
                          return '-';
                      }
                    }
                }
            ]
        })
    })
</script>
@endsection