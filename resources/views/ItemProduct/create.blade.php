@extends('argon_layouts.app', ['title' => __('Create Item Product')])

@section('style')
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">

<style>
</style>
@endsection

@section('content')
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('item.create')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4"></nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="container-fluid mt--6">
        <div class="col-xl-12">
            <form id="form_item_setting" class="item-form" action="{{ action('ItemProductSettingController@manageItem') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h4 class="card-title">{{__('item.item_information')}}</h4>
                                <input type="hidden" class="form-control upload_type" name="upload_type" id="upload_type" value="create"/>
                                <section class="item-wrapper">
                                    <div class="p-3 mb-2 border rounded clonable">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_name') }}</label>
                                                    <input type="text" class="form-control item_name" name="item_name[0]" placeholder="{{ __('item.item_name') }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_code') }}</label>
                                                    <input type="text" class="form-control item_code" name="item_code[0]" id="item_code[0]" placeholder="{{ __('item.item_code') }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_amount') }}</label>
                                                    <input type="number" class="form-control item_amount" name="item_amount[0]" placeholder="0.00" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_vat') }}</label>
                                                    <input type="number" class="form-control item_vat" name="item_vat[0]" placeholder="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.fee') }}</label>
                                                    <input type="number" class="form-control item_fee" name="item_fee[0]" id="item_fee[0]" placeholder="0.00" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_discount')}}</label>
                                                    <input type="number" class="form-control item_discount" name="item_discount[0]" id="item_discount[0]" placeholder="0.00" />
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6 d-none">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('item.item_net_amount') }}</label>
                                                    <input readonly type="hidden" class="form-control item_net_amount" name="item_net_amount[0]" id="item_net_amount[0]" placeholder="0.00" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="text-right col-lg-12">
                                    <div class="form-group  my-3">
                                        <button type="button" id="add" class="btn btn-outline-primary"><i class="ni ni-fat-add"></i> {{ __('item.add_item') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-6">
                        <div class="text-left">
                            <a href="{{ URL::to('/Item/Setting')}}" id="btn_cancel" class="btn btn-outline-primary mt-3">{{__('common.cancel')}}</a>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mt-3">{{__('common.create')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
<script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
{!! JsValidator::formRequest('App\Http\Requests\ItemSettingRequest','#form_item_setting') !!}

<script type="text/javascript">
    const oldData = JSON.parse(`{!! json_encode(Session::getOldInput()) !!}`)
    $(document).ready(function() {
        init(oldData)
        $('#add').on('click', function() {
            $('.item-wrapper').append( newItem() )
            removeBtnUpdate()
        })
    });

    const init = (data = null) => {
        const oldData = data

        backData( oldData )
    }
    
    const backData = (oldData) => {

        if ( oldData === undefined || oldData.length === 0 ) {
            return
        }
        // array item
        const _array = ['item_name', 'item_amount', 'item_vat', 'item_discount', 'item_fee', 'item_net_amount']

        Object.keys( oldData ).map(function(objectKey, index) {
            const value = oldData[objectKey]
            if ( Array.isArray( value ) ) {
                if ( _array.indexOf( objectKey ) !== -1 ) {
                    value.forEach( (element, index) => {
                        if ( $(`*[name='${objectKey}[${index}]']`).length === 0  ) {
                            $('.item-wrapper').append( newItem() ) // appendItem
                        }
                        $(`*[name='${objectKey}[${index}]']`).val( element )
                    })
                } else {
                    //
                }
                console.log(objectKey + ' <> ' + value);
            } else {
                $(`*[name=${objectKey}]`).val( value )
            }
        })
    }

    const newItem = () => {
        // count whole element
        const count = $('.clonable').length

        // clone the element
        const newItem = $('.clonable').first().clone().off()

        // adding remove button
        newItem.find('.row').first().prepend( removeBtn() )

        // change input name
        newItem.find('input').each(function() {
            $(this).attr( 'name', this.name.replace('[0]', `[${count}]`) )
            $(this).val( $(this).data('default') || '' )
            $(this).removeClass('is-valid').removeClass('is-invalid')
        })

        // change toggle wrapper id
        newItem.find('div#item-0').each(function() {
            $(this).attr('id', `item-${count}`)
        })

        // change data-target of toggle button
        newItem.find('*[data-target]').each(function() {
            $(this).attr('data-target', `#item-${count}`)
        })

        newItem.find('*[data-parent]').each(function() {
            $(this).attr('data-parent', `#parent-item-${count}`)
        })

        newItem.find('div.collable-row').each(function() {
            $(this).attr('id', `parent-item-${count}`)
        })

        return newItem
    }

    const removeBtn = () => {
        return `
            <div class="col-12 text-right">
                <button type="button" class="btn btn-outline-danger removable px-1 pb-0 pt-1">
                    <i class="ni ni-fat-remove fa-2x"></i>
                </button>
            </div>
        `
    }

    const removeBtnUpdate = () => {
        const count = $('.clonable').length - 1
        $('.clonable').each(function() {
            if ( $(this).index() === 0 ) {
                return
            } else if ( $(this).index() === count ) {
                if ( $(this).find('.removable').first().length === 0 ) {
                    $(this).find('.row').first().prepend( removeBtn() )
                }
            } else {
                $(this).find('.removable').first().remove()
            }
        })
    }

    $(document).on('click', '.removable', function(e) {
        if ( $(this).closest('.clonable').index() !== 0 ) {
            $(this).closest('.clonable').remove()
            removeBtnUpdate()
        } else {
            $(this).remove()
        }
    })

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
                // $( elemQty ).val( _default )
                return _default
            } 
            $( elemQty ).val( qty )
            return qty
        },
        ppu: function (el, _default = 0.00) {
            const elemPPU = $( el ).closest('.clonable').children().find('.item_amount')
            const ppu = $( elemPPU ).val()
            if ( isNaN( ppu ) || _.isEmpty( ppu ) ) {
                // $( elemPPU ).val( _default )
                return _default
            }
            $( elemPPU ).val( ppu )
            return ppu
        },
        discount: function (el, _default = 0.00) {
            const elemDiscount = $( el ).closest('.clonable').children().find('.item_discount')
            const discount = $( elemDiscount ).val()
            if ( isNaN( discount ) || _.isEmpty( discount ) ) {
                // $( elemDiscount ).val( _default )
                return _default
            }
            $( elemDiscount ).val( discount )
            return discount
        },
        vat: function (el, _default = 0.00) {
            const elemVat = $( el ).closest('.clonable').children().find('.item_vat')
            const vat = $( elemVat ).val()
            if ( isNaN( vat ) || _.isEmpty( vat ) ) {
                // $( elemVat ).val( _default )
                return _default
            }
            $( elemVat ).val( vat )
            return vat
        },
        fee: function (el, _default = 0.00) {
            const elemFee = $( el ).closest('.clonable').children().find('.item_fee')
            const fee = $( elemFee ).val()
            if ( isNaN( fee ) || _.isEmpty( fee ) ) {
                // $( elemFee ).val( _default )
                return _default
            }
            $( elemFee ).val( fee )
            return fee
        }
    }
</script>
@endsection