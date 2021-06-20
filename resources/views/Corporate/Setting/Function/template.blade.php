<div id="" class="row mx-auto mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header theme-style">
                <h4 class="mb-0 py-3">
                    <span class="template-text">{{__('corpsetting.pdf_template')}}</span>
                    <div class="float-right p-1">
                        <button type="button" class="btn btn-primary text-uppercase theme-style p-2" onclick="create_template('pdf')">
                            <i class="ni ni-fat-add"></i>
                            {{__('common.create')}}
                        </button>
                    </div>
                </h4> 
            </div>
            <div class="card-body">
                <div class="col-12 px-0 table-responsive">
                    <table id="template" class="table simple-table nowrap theme-style dataTable no-footer" style="width: 100%;" role="grid" aria-describedby="table_info">
                            
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="corp_code" name="corp_code" value="{{ $corp_code }}">
@section('script.eipp.corp-setting.template')
<script type="text/javascript">
    $(document).ready(function() {
        $("#template").DataTable({
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
                url: '{!! URL::to("Corporate/Setting/PDF/Object") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.corp_code = $("#corp_code").val()
                }
            },
            columns: [
                { data: 'document_type',            title: '{{__('corpsetting.document_type')}}' , class:"text-left" },
                { data: 'template_name',            title: '{{__('corpsetting.template_name')}}' , class:"text-left" },
                // { data: 'preview',                  title: '{{__('corpsetting.preview')}}'  , class:"text-center"},
                { data: 'status',                   title: '{{__('corpsetting.status')}}'  , class:"text-center"},
                { title: '{{__('common.action')}}', class: 'text-center', orderable: false  },
            ],
            columnDefs: [
                // {
                //     "aTargets": [2],
                //     "mData": null,
                //     "mRender": function (data, type, full) {
                //         if(data == 'SUCCESS') {
                //             return '<i class="ni ni-check-bold text-success pr-2 font21px"></i><span class="text-success align-top">{{__('corpsetting.ready')}}</span>';
                //         } 
                //         else if (data == 'PROCESSING'){
                //             return '<i class="ni ni-fat-remove text-warning pr-2 font21px"></i><span class="text-warning align-top">'+ data +'</span>';
                //         }
                //         else {
                //             return '<i class="ni ni-fat-remove text-danger pr-2 font21px"></i><span class="text-danger align-top">'+ data +'</span>';
                //         }
                //     }
                // },
                {
                    "aTargets": [-2],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if(data != 'ACTIVE') {
                            return '<i class="font21px"></i><span class="text-danger align-top">{{__('common.inactive')}}</span>';
                        } else {
                            return '<i class="font21px"></i><span class="text-success align-top">{{__('common.active')}}</span>';
                        }
                    }
                },
                {
                    "aTargets": [-1],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<a href="{{ url('Corporate/Setting/PDF/View')}}/'+document.getElementById("corp_code").value+'/'+full.reference+'" class="view-detail">'+
                                    '<i class="ni ni-bold-right"></i>'+
                                '</a>';
                    }
                },
                { 
                    "aTargets": "_all",
                    "mRender": function (data, type, full) {
                        return data === "" || data === null ? "-" : data;
                    }
                },
            ]
        });
    });

    function create_template(type)
    {
        var url = ''
        if(type == 'pdf') {
            url = '{!! URL::to("/Corporate/Setting/PDF/Create") !!}/'+document.getElementById("corp_code").value
        } else if(type == 'mail') {
            url = '{!! URL::to("/Corporate/Setting/Email/Create") !!}/'+document.getElementById("corp_code").value
        }
        window.location.href = url
    }
</script>
@endsection