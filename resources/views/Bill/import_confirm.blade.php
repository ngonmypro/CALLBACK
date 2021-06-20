@extends('argon_layouts.app', ['title' => __('Bill')])
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker-v2/daterangepicker.css') }}"/>

<style>
    .ui-timepicker-standard{
        z-index: 9999 !important;
    }
    .carousel .carousel-inner .item .carousel-image {
        vertical-align: middle;
    }
</style>
@endsection
@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.confirm_bill.title')}}</h6>
                        
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('bill.confirm_bill.file')}}</h5>
                                        <span class="h2 font-weight-bold mb-0"><small style="font-size:9px;" id="name"></small></span>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('bill.confirm_bill.total_record')}}</h5>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('bill.confirm_bill.total_success')}}</h5>
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
                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('bill.confirm_bill.total_fail')}}</h5>
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
                                <h3 class="mb-0">{{__('bill.confirm_bill.bill_list')}}</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <button type="button" class="btn btn-warning" onclick="cancel()">
                                    {{__('common.cancel_all')}}
                                </button>
                                @if($total == $success && $fail == 0 && $total != 0)
                                    <button type="button" class="btn btn-success" id="submit" onclick="submit_bill()">
                                        {{__('bill.confirm_bill.confirm_invoice')}}
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="confirm-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="post" action="{{ URL::to('Bill/Import/CreateConfirm')}}" id="confirm">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center pt-4 pb-3">
                            <div class="">
                                <img src="{{ URL::asset('assets/images/graphic_confirm.png') }}" width="350">
                                <div class="float-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h5 style="color: #0065FF!important;">{{__('bill.confirm_bill.confirm_message')}}</h5>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="col-6">
                                <label class="text-aline-left">{{__('bill.confirm_bill.batch_name')}}</label>
                                <input type="text" class="form-control input-stream-key" id="batch_name" name="batch_name" required/>
                            </div>
                            <div class="col-6">
                                <label class="text-aline-left">{{__('bill.confirm_bill.batch_description')}}</label>
                                <input type="text" class="form-control input-stream-key" name="batch_description"/>
                                <input id="file_name" name="file_name" type="hidden"/>
                            </div>
                        </div>
                        @if(session('upload_template')['payment_type'] != 'recurring')
                        <div class="d-flex justify-content-center pt-3">
                            <div class="col-12 send_type">
                                <label class="form-control-label">{{__('bill.simple.send_bill_time')}}</label>
                                <select class="form-control" id="send_bill_type" name="send_bill_type">
                                    <option value="now">{{__('bill.simple.send_now')}}</option>
                                    <option value="schedule">{{__('bill.simple.send_schedule')}}</option>
                                </select>
                            </div>
                            <div class="col-6 d-none schedule_date">
                                <label class="form-control-label">{{__('bill.simple.select_date')}}</label>
                                <input class="form-control timepicker" name="send_bill_schedule" id="send_bill_schedule" type="text" value="{{ date('d/m/Y', strtotime(date('d-m-Y').'+1 days')) }}" placeholder="{{ date('d/m/Y', strtotime(date('d-m-Y').'+1 days')) }}" autocomplete="off" datepicker-popup="d/m/Y" ng-model="fromDate">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="modal-footer border-top-0 justify-content-center py-4">
                    <div class="row" id="loading">

                    </div>
                    <div class="row" id="btn">
                        <div class="col-6" >
                            <button type="button" class="btn btn-info" data-dismiss="modal" id="cancel-pass">
                                {{__('common.cancel')}}
                            </button>
                        </div>
                        <div class="col-6" >
                            <button type="submit" class="btn btn-success" id="confirm-pass">
                               {{__('common.confirm')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('timepicker/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/moment.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
<script type="text/javascript">

    $(document).ready(function() {
        var tomorrow = new Date(); // Or Date.today()
        tomorrow.setDate(tomorrow.getDate() + 1);
        $('input[name=transaction_date]').mask('00/00/0000', { placeholder: 'DD/MM/YYYY' });
        $('input[name=transaction_time]').mask('00:00', { placeholder: 'HH:MM' });
        $('input[name="send_bill_schedule"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            timePicker: true,
            startDate: moment().format("DD/MM/YYYY HH:mm"),
            locale: {
                format: 'DD/MM/YYYY HH:mm' ,
            },
            minuteStep: 30
        })

        // $('#payment_channel').on('change', function() {
        //     if($('#payment_channel').val() == 'recurring') {
        //         $('.send_bill_type').addClass("d-none")
        //         $('#schedule_date').addClass("d-none")
        //     }
        //     else {
        //         $('.send_bill_type').removeClass("d-none")
        //         if($('#send_bill_type').val() == 'schedule') {
        //             $('#schedule_date').removeClass("d-none")
        //         }
        //     }
        // })

        $('#send_bill_type').on('change', function() {
            if($('#send_bill_type').val() == 'schedule') {
                $('.send_type').removeClass("col-12")
                $('.send_type').addClass("col-6")
                $('.schedule_date').removeClass("d-none")
            }
            else if($('#send_bill_type').val() == 'now') {
                $('.send_type').removeClass("col-6")
                $('.send_type').addClass("col-12")
                $('.schedule_date').addClass("d-none")
            }
        })
    })

    $('#confirm_upload_table').DataTable({
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
            url: '{!! URL::to("Bill/Import/objectData") !!}',
            method: 'POST',
            data: function (d) {
                d._token = "{{ csrf_token() }}"
            }
        },
        createdRow: function( row, data, dataIndex ) {
            // Set the data-status attribute, and add a class
            // $(row).find('td:eq(1)').css('text-transform' , 'capitalize');
            // $(row).find('td:not(:first-child)').addClass("text-center");
            // $(row).find('td:first-child').addClass("text-left");
            $(row).addClass(data.status)
        },
        columns: [
            { data: 'invoice_number',       title: '{{__("bill.confirm_bill.invoice_number")}}'  },
            { data: 'customer_code',        title: '{{__("bill.confirm_bill.customer_code")}}'  },
            { data: 'item_name',            title: '{{__("bill.confirm_bill.item_name")}}'  },
            { data: 'item_quantity',        title: '{{__("bill.confirm_bill.item_quatity")}}'  },
            { data: 'item_total_amount',    title: '{{__("bill.confirm_bill.item_amount")}}'  },
            { data: 'total_amount',         title: '{{__("bill.confirm_bill.total_amount")}}'  },
            { data: 'status',               title: '{{__("common.status")}}'  },
            { data: 'remark',               title: '{{__("common.remark")}}'  },
        ],
        aoColumnDefs: [
            { className: "text-left", targets: [0]},
            { className: "text-center", targets: "_all" },
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
                mRender: function (data, type, full) {
                    if(data === 'PASS')
                    {
                        return '<span class="badge badge-success">{{__("common.success")}}</span>';
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

    function ViewRemark(_data)
    {
        var data = JSON.stringify(_data);
        var append_text = ''
        for (var text in _data) {
            text += ' : '+_data[text];
            append_text += text+'<br/>'
        }
        const wrapper = document.createElement('div');
        wrapper.innerHTML = append_text;

        Swal.fire({
            title: '{{__("bill.confirm_bill.remark_detail")}}',
            html: wrapper,
            type: 'info',
            confirmButtonText: 'OK'
        })
    }

    function cancel()
    {
        window.location = "{!! URL::to('Bill') !!}";
    }
    function submit_bill()
    {
        $("#confirm-modal").modal();
    }

    $("#confirm-pass").on("click" , function(){
        if($("#batch_name").val() != null && $("#batch_name").val() != "")
        {
            $("#batch_name").removeClass('border border-danger');
            $("#loading").removeClass('d-none');
            $("#loading").append(`<div class="text-primary" role="status">
                                <span class="text-center">{{__("common.loading")}}...</span>
                            </div>`);
            $("#btn").addClass('d-none');
            SubmitForm("#btn");
        }
    });

    function SubmitForm(elm){
        $.blockUI();
        $('#confirm').ajaxForm({
            success: function(responseData){
                console.log(responseData)
                if(responseData.success == false){
                    Swal.fire('Oops! Someting wrong.', responseData.message, 'error');
                    $("#loading").addClass('d-none');
                    $("#loading").empty();
                    $(elm).removeClass('d-none');
                    $.unblockUI();
                    return false;
                }
                else if(responseData.success == true){
                    console.log('true ' + responseData.message);
                    window.location = "{!! URL::to('/Bill') !!}";
                }
            },
            error: function(responseData){
                swal("เกิดข้อผิดพลาด", responseData.message, "warning");
                $("#loading").addClass('d-none');
                $("#loading").empty();
                $(elm).removeClass('d-none');
                $.unblockUI();
                return false;
            } 
        });
    }



    var getfilename = sessionStorage.getItem("filename");
    $("#name").text(getfilename);
    $("#file_name").val(getfilename);

    // function download_temp(){
    //       window.location="{!! URL::to('loadTemplate') !!}";
    // }
</script>
@endsection