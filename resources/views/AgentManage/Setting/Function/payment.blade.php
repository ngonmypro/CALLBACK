    <div class="col-12 p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> 
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h3 class="mb-0">Payment Agents</h3>

                                <div class="row align-items-center">
                                    <div class="col-10">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-neutral" onclick="create()">
                                            <i class="zmdi zmdi-plus pr-2"></i>
                                            Create
                                        </button>
                                    </div>
                                </div>
                                    <input type="hidden" class="form-control" name="bank_id" value="{{$bank_data->id}}"> 
                                    <input type="hidden" class="form-control" name="bank_code" value="{{$bank_data->bank_id}}"> 
                            </div>
                        </div>
                    </div> 

                    <div class="table-responsive ">
                        <div class="dataTables_wrapper dt-bootstrap4 col-md-12">
                            <table id="bank_table" class="table table-flush dataTable"  style="width: 100%" ></table>
                        </div>
                    </div>
                    

                </div>
            </div> 
        </div>
    </div> 

@section('script.eipp.agent-setting.payment')

@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var bank_id = $('input[name="bank_id"]').val();

            console.log('bank_id')
            console.log(bank_id)
            $("#bank_table").DataTable({
                sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                dom: '<"float-left pt-2"l>rt<"row"<"col-sm-12"i><"col-sm-12"p>>',
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
                    url: '{!! URL::to("Manage/Agents/Payment/objectData") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token = "{{ csrf_token() }}",
                        d.bank_id = $('input[name="bank_id"]').val()
                    }
                },
                columns: [
                    { data: 'channel_name',     name: 'channel_name'  , title: 'channel_name' },
                    { data: 'channel_type',     name: 'channel_type'  , title: 'channel_type' },
                    { data: 'channel_name',            name: 'channel_name',              title: 'action',       class: 'text-center' },
                ],
                aoColumnDefs: [
                    {
                        "aTargets": [-1],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            return inv = '<a href="#" onclick="edit('+"'"+data+"'"+')" class="btn btn-sm btn-default" title="Delete Card"><i class="ni ni-bold-right"></i></a>';
                        }
                    },
                ],
                
            });
        });

        function edit(channel_name) {
            var bank_code = $('input[name="bank_code"]').val();
            const url = '{!! URL::to("Manage/Agents/Setting/Update/Payment2") !!}'
            window.location.href = url+'/'+channel_name+'/'+bank_code
        }
        function create() {
            var bank_code = $('input[name="bank_code"]').val();
            const url = '{!! URL::to("Manage/Agents/Payment/Create") !!}'

            window.location.href = url+'/'+bank_code
            
        }
    </script>


@endsection