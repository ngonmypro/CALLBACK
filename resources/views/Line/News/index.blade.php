@extends('argon_layouts.app', ['title' => __('News')])



@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">News</h6>
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
                                <h3 class="mb-0">News</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{!! URL::to("Line/News/Create") !!}" class="btn btn-primary">Add News</a>
                            </div>
                        </div>
                    </div>

                    <div class="w-100">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="news_table" class="table table-flush dataTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Publish Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
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
        var table = $("#news_table").DataTable({
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
                url: '{!! URL::to("Line/News/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token            = "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'title',          name: 'title'  },
                { data: 'publish_date',   name: 'publish_date'  },
                { data: 'status',         name: 'status'  },
                { data: 'news_code',      name: 'news_code'  }
            ],
            aoColumnDefs: [
                {
                    "aTargets": [3],
      			        "mRender": function (data, type, full) {
      			            return '<a href="{{ url('News/Detail')}}/'+data+'"><i class="zmdi zmdi-eye"></i></a>';
      			        }
                }
            ]
        });

        $('#data_search').on( 'keyup', function (){
        	table.search( this.value ).draw();
    		});

        $("#status").change(function() {
          table.columns( 2 ).search( this.value ).draw();
        });

    });
</script>
@endsection
