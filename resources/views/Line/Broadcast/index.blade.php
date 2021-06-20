@extends('argon_layouts.app', ['title' => __('Line Broadcast')])

@section('content')
    
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Line Broadcast</h6>
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
                                <h3 class="mb-0">Line Broadcast</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{!! URL::to("Line/Broadcast/Create") !!}" class="btn btn-primary">Add New Broadcast</a>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                                <thead>
                                <tr>
                                    <th class="text-center">Message</th>
                                    <th class="text-center">Message Type</th>
                                    <th class="text-center">Broadcast Time</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
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



            $("#broadcast").DataTable({
                sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },
                ajax: {
                    url: '{!! URL::to("Line/Broadcast/objectData") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token            = "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'msg',       name: 'msg'  },
                    { data: 'msg_type',       name: 'msg_type'  },
                    { data: 'status',            name: 'status'  },
                    { data: 'publish_date',            name: 'publish_date'  },
                    { data: 'id',            name: 'id'  }
                ],
                columnDefs: [
                    { className: "text-center", targets: "_all" }
                ],
                aoColumnDefs: [
                    {
                        aTargets: [4],
                        mData: "id",
                        mRender: function (data, type, full) {
                            return '<a href="{!! URL::to("Line/Broadcast/Detail") !!}/'+data+'">VIEW</a>';
                        }
                    }
                ]
            });
        });

    </script>
@endsection