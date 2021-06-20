@extends('argon_layouts.app', ['title' => __('Import Recipient Preview')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('recipient.confirm_title')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    </div>
                </div> 
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('common.confirm_upload.file')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"><small style="font-size:9px;" id="file_name"></small></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                            <i class="ni ni-folder-17"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('common.confirm_upload.total_record')}}</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $total }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-chart-bar-32"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('common.confirm_upload.total_success')}}</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $success }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                            <i class="ni ni-check-bold"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('common.confirm_upload.total_fail')}}</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $fail }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                            <i class="ni ni-fat-remove"></i>
                                        </div>
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
                                <h3 class="mb-0">{{__('recipient.detail')}}</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-warning" onclick="cancel()">
                                    {{__('common.cancel_all')}}
                                </button>
                                @if($total == $success && $fail == 0 && $total != 0)
                                    <button type="button" class="btn btn-success" id="submit" onclick="submit_recipient()">
                                        {{__('recipient.confirm_recipient')}}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="confirm_upload_table" class="table simple-table" style="width:100%">
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form class="form-horizontal" method="post" action="{{ URL::to('Recipient/Upload/Confirm')}}" id="confirm">
        {!! csrf_field() !!}
    </form>



@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script type="text/javascript">
    
    function cancel()
    {
        window.location = "{!! URL::to('Recipient/Upload/Cancel') !!}";
    }

    function submit_recipient()
    {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonClass: "btn btn-success",
            confirmButtonText: "Confirm",
            cancelButtonClass: "btn btn-secondary",
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $('#confirm').submit();
            }
        })
    }

    $(document).ready(function(){
        $('#confirm').ajaxForm({
            success: function(responseData){
                console.log(responseData)
                if(responseData.success == false) {
                    Swal.fire('เกิดข้อผิดพลาด', responseData.message, "error");

                    return false;
                }
                else {
                    window.location = "{!! URL::to('/Recipient') !!}";
                }
            }
        });

        $("#confirm_upload_table").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
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
                url: '{!! URL::to("Recipient/Upload/Obj") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}"
                }     
            },
            createdRow: function( row, data, dataIndex ) {  
                // Set the data-status attribute, and add a class
                $(row).find('td:eq(1)').css('text-transform' , 'capitalize');
                $(row).find('td:not(:first-child)').addClass("text-center");
                $(row).find('td:first-child').addClass("text-left");
                $(row).addClass(data.status)
            },
                columns: [
                    { data: 'customer_code',        title: '{{__("recipient.profile.customer_code")}}'  },
                    { data: 'first_name',           title: '{{__("recipient.profile.full_name")}}'  },  
                    // { data: 'last_name',             title: '{{__("recipient.profile.last_name")}}'  },  
                    { data: 'telephone',             title: '{{__("recipient.profile.mobile_no")}}'  },  
                    { data: 'email',                title: '{{__("common.email")}}'  },
                    { data: 'status',               title: '{{__("common.status")}}'  },
                    { data: 'remarks',              title: '{{__("common.remark")}}'  },
                ],
               
                    aoColumnDefs: 
                    [
                        { className: "text-left", targets: [0]},
                        { className: "text-center", targets: "_all" },
                        {
                            @if($type == 'new')
                                aTargets: [0],
                                mRender: function (data, type, full) {
                                    console.log('data ->'+data);
                                    console.log('type ->'+type);
                                    console.log('full ->'+full);
                                    if(data == '' || data == null)
                                    {
                                        return 'Customer code will be creating.';
                                    }
                                    else
                                    {
                                        return data;
                                    }
                                }
                            @elseif($type == 'replace')
                            aTargets: [0],
                                mRender: function (data, type, full) {
                                    console.log('data ->'+data);
                                    console.log('type ->'+type);
                                    console.log('full ->'+full);
                                    if(data == '' || data == null)
                                    {
                                        return 'Customer code not specified.';
                                    }
                                    else
                                    {
                                        return data;
                                    }
                                }
                            @endif
                        },
                        {
                            aTargets: [1],
                            mRender: function (data, type, full) {
                                return full.first_name + ' ' + full.middle_name + ' ' + full.last_name;
                            }
                        },
                        {
                            aTargets: [-2],
                            mRender: function (data, type, full) {
                                if(data == 'success')
                                {
                                    return '<span class="badge badge-success">{{__("common.success")}}</span>';
                                }
                                else
                                {
                                    return '<span class="badge badge-danger">{{__("common.fail")}}</span>';
                                }
                            }
                        },
                        {
                            aTargets: [-1],
                            mRender: function (data, type, full) 
                            {
                                console.log(data.type);
                                if(data === 'PASS')
                                {
                                    return  '<span class="badge badge-success">{{__("common.pass")}}</span>';
                                }
                                else
                                {
                                    var _data = JSON.stringify(data);

                                    var btn =   `<span onclick='ViewRemark(${_data})'>
                                                    <i title="View Remark" class="ni ni-bulb-61 text-warning pr-2 font30px"></i>
                                                </span>`;
                                    return btn;
                                }
                            }
                        },
                    ]
    });

    var getfilename = sessionStorage.getItem("filename");
        $("#file_name").text(getfilename);
    });
    
    function ViewRemark(_data)
    {
        var data = JSON.stringify(_data);
        console.log(data)
        var append_text = ''
        for (var text in _data) {
            text += ' : '+_data[text];
            append_text += '>> '+text+'<br/>'
        }
        const wrapper = document.createElement('div');
        wrapper.innerHTML = append_text;

        Swal.fire({
            title: 'Remark Detail.',
            html: wrapper,
            type: 'info',
            confirmButtonText: 'OK'
        })
    }

</script>
@endsection
