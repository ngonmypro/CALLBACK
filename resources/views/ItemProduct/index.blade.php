@extends('argon_layouts.app', ['title' => __('Items Management')])

@section('style')
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('item.item_information')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ action('ItemProductSettingController@createItem') }}" class="btn btn-neutral">{{__('common.create')}}</a>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('item.item_name')}}</label>
                                            <input type="text" id="item_name" name="item_name" placeholder="{{__('common.search')}}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">{{__('common.status')}}</label>
                                            <select class="form-control custom-form-control" name="status" id="status">
                                                <option selected disabled>{{__('common.status')}}</option>
                                                <option value="">{{__('common.all')}}</option>
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
                                        <button type="button" id="search" class="btn btn-primary w-100">{{__('common.search')}}</button>
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
                                <h3 class="mb-0">{{__('item.item_information')}}</h3>
                                <p class="text-sm mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="w-100 table-responsive">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="items" class="table table-flush dataTable">
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
                <form class="form-horizontal" method="post" action="{{ action('ItemProductSettingController@manageItem') }}" id="confirm">
                    {!! csrf_field() !!}
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="float-right d-flex justify-content-center">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="text-center">
                                    <h3>{{ __('item.edit_item') }}</h3>
                                    <input type="hidden" class="form-control upload_type" name="upload_type" id="upload_type" value="update"/>
                                    <input type="hidden" class="form-control reference" name="reference" id="reference"/>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 mb-2 border rounded clonable">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_name') }}</label>
                                        <input type="text" class="form-control item_name" name="item_name" id="edit_item_name" placeholder="{{ __('item.item_name') }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-2 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_code') }}</label>
                                        <input type="text" class="form-control item_code" name="item_code" id="item_code" placeholder="{{ __('item.item_code') }}" />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_amount') }}</label>
                                        <input type="number" class="form-control item_amount" name="item_amount" id="item_amount" placeholder="0.00" />
                                    </div>
                                </div>
                                <!-- <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_vat') }}</label>
                                        <input type="number" class="form-control item_vat" name="item_vat" id="item_vat" placeholder="0.00" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.fee') }}</label>
                                        <input type="number" class="form-control item_fee" name="item_fee" id="item_fee" placeholder="0.00" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_discount')}}</label>
                                        <input type="number" class="form-control item_discount" name="item_discount" id="item_discount" placeholder="0.00" />
                                    </div>
                                </div> -->
                                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6 d-none">
                                    <div class="form-group my-2">
                                        <label class="form-control-label text-truncate">{{ __('item.item_net_amount') }}</label>
                                        <input readonly type="hidden" class="form-control item_net_amount" name="item_net_amount" id="item_net_amount" placeholder="0.00" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-2 col-sm-6 col-xs-6">
                                    <div class="form-group my-2">
                                        <label for="" class="form-control-label">{{__('common.status')}}</label>
                                        <div class="pl-2">
                                            <input type="radio" id="r_active" name="status" value="ACTIVE" class="r-status">
                                            <label for="r_active">{{__('common.active')}}</label>
                                            <input type="radio" id="r_inactive" name="status" value="INACTIVE" class="r-status">
                                            <label for="r_inactive">{{__('common.inactive')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 justify-content-center py-4">
                        <div class="row" id="btn">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-pass">{{ (__('common.cancel')) }}</button>
                            <button type="submit" class="btn btn-primary" id="confirm-pass">{{ (__('common.confirm')) }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#items").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            "deferLoading": 0, // here
            serverSide: true,
            order: [[ 0, "desc" ]],
            dom: '<"float-left pt-2 pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
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
                url: '{{ action("ItemProductSettingController@objectData") }}',
                method: 'POST',
                data: function (d) {
                    d._token    = "{{ csrf_token() }}",
                    d.item_name = $('input[name=item_name]').val(),
                    d.status    = $('select[name=status]').val()
                }
            },
            columns: [
                { data: 'item_name',            name: 'item_name',          title: '{{__('item.item_name')}}' },            
                { data: 'item_net_amount',      name: 'item_net_amount',    title: '{{__('item.item_net_amount')}}'  },
                { data: 'status',               name: 'status',             title: '{{__('common.status')}}'  },
                { data: 'reference',            name: 'reference',          title: '{{__('common.action')}}', orderable: false  }
            ],
            aoColumnDefs: [
                { className: "text-center", targets: "_all" },
                {
                    "aTargets": [-2],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        if(data != 'ACTIVE')
                        {
                            return '<span class="badge badge-danger">{{__('common.inactive')}}</span>';
                        }
                        else
                        {
                            return '<span class="badge badge-success">{{__('common.active')}}</span>';
                        }
                    }
                },
                {
                    "aTargets": [-1],
                    "mData": null,
                    "mRender": function (data, type, full) {
                        return '<button type="button" onClick="view_detail(\'' + data + '\')" class="btn btn-sm btn-default" title="View Detail">'+
                                    '<i class="ni ni-bold-right"></i>'+
                                '</button>'+
                                '<button type="button" onClick="delete_item(\'' + data + '\')" class="btn btn-sm btn-warning" title="Delete Item">'+
                                    '<i class="fa fa-trash" aria-hidden="true"></i>'+
                                '</button>';
                    }
                }
            ],
            createdRow: function( row, data, dataIndex ) {
                // Set the data-status attribute, and add a class
                $( row ).find('td:not(:first-child)').addClass("text-center")
                $( row ).find('td:first-child').addClass("text-left")

            }
        })

        table.draw()
        $('#search').on('click', function () {
            table.search( this.value ).draw()
        })
    })

    function delete_item(ref) {
        Swal.fire({
            title: `{{__('item.delete')}}`,
            text: `{{__('item.sure_delete')}}`,
            confirmButtonText: `{{__('common.confirm')}}`,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: `{{__('common.cancel')}}`,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `{{__('common.confirm')}}`,
        }).then((result) => {
            $.blockUI()
            if ( result.value ) {
                $.ajax({
                type: 'POST',
                url: '{{ action("ItemProductSettingController@deleteItem") }}',
                data : {
                        _token      : "{{ csrf_token() }}",
                        reference   : ref,
                        upload_type : "delete"
                },
            }).done(function(result) {
                $.unblockUI()
                if ( result.success ) {
                    Swal.fire({
                        type: 'success',
                        title: `{{ (__('common.success')) }}`, 
                        text: '', 
                    }).then(() => {
                        window.location.reload()
                    })
                } else {
                    Swal.fire(result.message || result.message, '', 'warning')
                }
            }).fail(function(err) {
                $.unblockUI()
                Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
            })
            } else {
                $.unblockUI()
            }
        })
    }

    function view_detail(ref) {
        $.blockUI()
        $.ajax({
            type: 'POST',
            url: '{{ action("ItemProductSettingController@itemDetail") }}',
            data : {
                    _token      : "{{ csrf_token() }}",
                    reference   : ref
            },
        }).done(function(result) {
            $.unblockUI()
            if ( result.success ) {
                console.log('result: ', result)
                data = result.data

                $('#reference').val(data.reference)
                $('#edit_item_name').val(data.item_name)
                $('#item_code').val(data.item_code)
                $('#item_amount').val(data.item_amount)
                $('#item_discount').val(data.item_discount)
                $('#item_vat').val(data.item_vat)
                $('#item_fee').val(data.item_fee)
                $('#item_net_amount').val(data.item_net_amount)

                if(data.status == 'ACTIVE') {
                    $('#r_active').prop('checked', true);
                }
                else {
                    $('#r_inactive').prop('checked', true);
                }

                $('#confirm-modal').modal()
            } else {
                console.error('Error: ', result.message)
                Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
            }
        }).fail(function(err) {
            $.unblockUI()
            console.error('Error: ', err)
            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
        })
    }

    $(document).on('change focusou', '.item_name, .item_amount, .item_qty, .item_vat, .item_discount, .item_fee', function() {
        const ppu       = itemCalulate.ppu(this)
        const qty       = itemCalulate.qty(this)
        const amount    = parseFloat(ppu) * parseFloat(qty)
        const discount  = itemCalulate.discount(this)
        const fee       = itemCalulate.fee(this)
        const vat       = itemCalulate.vat(this)
        const itemTotal = parseFloat(amount) + parseFloat(fee) + parseFloat(vat) - parseFloat(discount)

        // item update
        $(this).closest('.clonable').children().find('.item_amount').val( amount )
        $(this).closest('.clonable').children().find('.item_net_amount').val( itemTotal )
    })

    const itemCalulate = {
        qty: function (el, _default = 1) {
            const elemQty = $( el ).closest('.clonable').children().find('.item_qty')
            const qty = $( elemQty ).val()
            if ( isNaN( qty ) || _.isEmpty( qty ) ) {
                return _default
            } 
            $( elemQty ).val( qty )
            return qty
        },
        ppu: function (el, _default = 0.00) {
            const elemPPU = $( el ).closest('.clonable').children().find('.item_amount')
            const ppu = $( elemPPU ).val()
            if ( isNaN( ppu ) || _.isEmpty( ppu ) ) {
                return _default
            }
            $( elemPPU ).val( ppu )
            return ppu
        },
        discount: function (el, _default = 0.00) {
            const elemDiscount = $( el ).closest('.clonable').children().find('.item_discount')
            const discount = $( elemDiscount ).val()
            if ( isNaN( discount ) || _.isEmpty( discount ) ) {
                return _default
            }
            $( elemDiscount ).val( discount )
            return discount
        },
        vat: function (el, _default = 0.00) {
            const elemVat = $( el ).closest('.clonable').children().find('.item_vat')
            const vat = $( elemVat ).val()
            if ( isNaN( vat ) || _.isEmpty( vat ) ) {
                return _default
            }
            $( elemVat ).val( vat )
            return vat
        },
        fee: function (el, _default = 0.00) {
            const elemFee = $( el ).closest('.clonable').children().find('.item_fee')
            const fee = $( elemFee ).val()
            if ( isNaN( fee ) || _.isEmpty( fee ) ) {
                return _default
            }
            $( elemFee ).val( fee )
            return fee
        }
    }
</script>
@endsection
