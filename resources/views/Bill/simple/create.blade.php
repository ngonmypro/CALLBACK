@extends('argon_layouts.app', ['title' => __('Bill Create')])

@section('style')
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/extensions/dropzone/4.3.0/dropzone.css') }}">
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
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.simple.create')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4"></nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="col-xl-12">
            <form id="form_bill_invoice" class="item-form" action="{{ action('Bill\SimpleCreateController@createSubmit', ['corporate_code' => $data->corp_code ?? '']) }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" class="form-control" name="recipient_search" value="none"/>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h4 class="card-title">{{__('bill.simple.recipient_information')}}</h4>

                                <div class="row">  

                                    <div class="col-12">
                                        <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_search_title') }}</label>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xs-8">
                                        <div class="form-group my-2">
                                            <select class="recipient_code" id="recipient_code" name="recipient_code" placeholder="{{ __('bill.simple.recipient_search_placeholder') }}"></select>
                                            <input disabled class="form-control d-none" name="recipient_code" onchange="checkCode(this)" placeholder="{{ __('bill.simple.new_recipient_placeholder') }}"></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xs-4">
                                        <div class="form-group my-2">
                                            <button id="reset-recipient" type="button" class="btn btn-outline-primary">{{ __('bill.simple.recipient_search_btn_cancel') }}</button>
                                        </div>
                                    </div>

                                </div>
            
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_name') }}</label>
                                            <input type="text" class="form-control" name="recipient_name" placeholder="{{ __('bill.simple.recipient_name_placeholder') }}" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_lastname') }}</label>
                                            <input type="text" class="form-control" name="recipient_lastname" placeholder="{{ __('bill.simple.recipient_lastname_placeholder') }}" />
                                        </div>
                                    </div>
                                    
                                </div>
                            
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_telephone') }}</label>
                                            <input type="text" class="form-control" name="recipient_telephone" placeholder="{{ __('bill.simple.recipient_telephone_placeholder') }}" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_email') }}</label>
                                            <input type="text" class="form-control" name="recipient_email" placeholder="{{ __('bill.simple.recipient_email_placeholder') }}" />
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row collapsible">

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_additional_telephone') }}</label>
                                            <i class="ni ni-air-baloon align-top" data-toggle="tooltip" data-placement="top" title="{{ (__('bill.simple.hint_mobile')) }}"></i>
                                            <input type="text" class="form-control" name="recipient_additional_telephone" placeholder="{{ __('bill.simple.recipient_additional_telephone_placeholder') }}" />
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.recipient_additional_email') }}</label>
                                            <i class="ni ni-air-baloon align-top" data-toggle="tooltip" data-placement="top" title="{{ (__('bill.simple.hint_email')) }}"></i>
                                            <input type="text" class="form-control" name="recipient_additional_email" placeholder="{{ __('bill.simple.recipient_additional_email_placeholder') }}" />
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div> 
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label">{{__('bill.simple.payment_section')}}</label>
                                            <select class="form-control" id="payment_channel" name="payment_channel">
                                                <option value="null">{{__('bill.import.general_payment')}}</option>
                                                @if(isset($payment_channel))
                                                    @foreach($payment_channel as $payment_channel)
                                                        <option value="{{ $payment_channel }}">{{ strtoupper(str_replace('_', ' ', $payment_channel)) }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 send_bill_type">
                                        <div class="form-group my-2">
                                            <label class="form-control-label">{{__('bill.simple.send_bill_time')}}</label>
                                            <select class="form-control" id="send_bill_type" name="send_bill_type">
                                                <option value="now">{{__('bill.simple.send_now')}}</option>
                                                <option value="schedule">{{__('bill.simple.send_schedule')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div  id="schedule_date" class="row d-none">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label">{{__('bill.simple.select_date')}}</label>
                                            <input class="form-control timepicker" name="send_bill_schedule" id="send_bill_schedule" type="text" value="{{ date('d/m/Y', strtotime(date('d-m-Y').'+1 days')) }}" placeholder="{{ date('d/m/Y', strtotime(date('d-m-Y').'+1 days')) }}" autocomplete="off" datepicker-popup="d/m/Y" ng-model="fromDate">
                                            <!-- <input type="hidden" name="schedule_date" id="schedule_date">
                                            <input type="hidden" name="schedule_time" id="schedule_time"> -->
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <div class="form-group my-2">
                                            <label class="form-control-label">{{__('bill.simple.select_time')}}</label>
                                            <input type="text" name="send_bill_time" id="send_bill_time" class="form-control" value="" placeholder="" autocomplete="off" datepicker-popup="d/m/Y" ng-model="fromDate" />
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h4 class="card-title">{{__('bill.simple.bill_information')}}</h4>
                            
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.invoice_number') }}</label>
                                            <input type="text" class="form-control" name="invoice_number" placeholder="{{ __('bill.simple.invoice_number_placeholder') }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.batch_name') }}</label>
                                            <input type="text" name="batch_name" id="batch_name" class="form-control" placeholder="{{__('bill.simple.batch_name_placeholder')}}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.bill_due_date') }}</label>
                                            <input type="text" name="bill_due_date" id="bill_due_date" class="form-control" autocomplete="off" placeholder="{{__('bill.simple.bill_due_date_placeholder')}}" datepicker-popup="d/m/Y" ng-model="fromDate" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.branch_name') }}</label>
                                            <select class="form-control" name="branch_name" id="branch_name"></select>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.currency') }}</label>
                                            <select class="form-control" name="currency" id="currency" placeholder="{{ __('bill.simple.currency_placeholder') }}" />
                                                <option value="THB" selected>THB</option>
                                                <option value="MYR">MYR</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>
                        </div> 
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">

                                <h4 class="card-title">{{__('bill.simple.bill_item_information')}}</h4>

                                <section class="product-wrapper">

                                    <div class="p-3 mb-2 border rounded clonable">
                                 
                                        <div class="row">

                                            <div class="col-lg-5 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.product_name') }}</label>
                                                    <select class="js-data-example-ajax" name="product_name[0]"></select>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.product_price_per_unit') }}</label>
                                                    <input type="text" class="form-control product_price_per_unit" name="product_price_per_unit[0]" placeholder="{{ __('bill.simple.product_price_per_unit_placeholder') }}" />
                                                    <input type="hidden" class="form-control product_type" name="product_type[0]" value="new"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-1 col-md-2 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.product_qty') }}</label>
                                                    <input type="text" class="form-control product_qty" name="product_qty[0]" placeholder="{{ __('bill.simple.product_qty_placeholder') }}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.product_amount') }}</label>
                                                    <input readonly class="form-control product_amount" name="product_amount[0]" placeholder="{{ __('bill.simple.product_amount_placeholder') }}" />
                                                </div>
                                            </div>     

                                            <div class="offset-lg-8 col-lg-4 offset-md-8 col-md-4 offset-xs-8 col-xs-4 text-right d-none">
                                                <span class="text-muted">
                                                    <button type="button" class="btn btn-link btn-collapse" data-toggle="collapse" data-target="#item-0" aria-expanded="false">
                                                        {{__('bill.simple.bill_item_information_collapse')}}
                                                    </button>
                                                </span>
                                            </div>                       

                                        </div>

                                        <div class="row collapse d-none" id="item-0">

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.item_discount') }}</label>
                                                    <input type="text" class="form-control item_discount" name="item_discount[0]" placeholder="{{ __('bill.simple.item_discount_placeholder') }}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.item_fee') }}</label>
                                                    <input type="text" class="form-control item_fee" name="item_fee[0]" placeholder="{{ __('bill.simple.item_fee_placeholder') }}" />
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                <div class="form-group my-2">
                                                    <label class="form-control-label text-truncate">{{ __('bill.simple.item_total_price') }}</label>
                                                    <input readonly type="text" class="form-control item_total_price" name="item_total_price[0]" placeholder="{{ __('bill.simple.item_total_price_placeholder') }}" />
                                                </div>
                                            </div>

                                        </div>
                                         
                                    </div>

                                </section>

                                <div class="col-3 px-0 my-3">
                                    <button type="button" id="add" class="btn btn-outline-primary">{{ __('bill.simple.bill_btn_add_item') }}</button>
                                </div>

                            </div>
                        </div> 
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">

                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="card-title">{{__('bill.simple.bill_summary')}}</h4>   
                                    </div>

                                    <div class="col-6 text-right">
                                        <span class="text-muted">
                                            <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#bill-summary" aria-expanded="true" aria-controls="bill-summary">
                                                {{__('bill.simple.bill_summary_collapse')}}
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-12 px-0">

                                        <div id="summary">

                                            <div id="bill-summary" class="col-12 collapse" aria-labelledby="headingOne" data-parent="#summary">

                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.total_price_before_fee_and_discount') }}</label>
                                                            <input readonly type="text" class="form-control" name="total_price_before_fee_and_discount" placeholder="{{ __('bill.simple.total_price_before_fee_and_discount_placeholder') }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.bill_discount') }}</label>
                                                            <input type="text" class="form-control" name="bill_discount" placeholder="{{ __('bill.simple.bill_discount_placeholder') }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.bill_fee') }}</label>
                                                            <input type="text" class="form-control" name="bill_fee" placeholder="{{ __('bill.simple.bill_fee_placeholder') }}" />
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.total_price_before_tax') }}</label>
                                                            <input readonly type="text" class="form-control" name="total_price_before_tax" placeholder="{{ __('bill.simple.total_price_before_tax_placeholder') }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.tax_percentage') }}</label>
                                                            <input type="text" class="form-control" name="tax_percentage" placeholder="{{ __('bill.simple.tax_percentage_placeholder') }}" />
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                                        <div class="form-group my-2">
                                                            <label class="form-control-label text-truncate">{{ __('bill.simple.tax_amount') }}</label>
                                                            <input readonly type="text" class="form-control" name="tax_amount" placeholder="{{ __('bill.simple.tax_amount_placeholder') }}" />
                                                        </div>.
                                                    </div>
                                                    <!-- .total_price_before_tax .tax_amount -->
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6"></div>

                                                </div>

                                            </div>

                                        </div>
                                        
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                        <div class="form-group my-2">
                                            <label class="form-control-label text-truncate">{{ __('bill.simple.bill_total_amount') }}</label>
                                            <input readonly type="text" class="form-control" name="bill_total_amount" placeholder="{{ __('bill.simple.bill_total_amount_placeholder') }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-6"></div>
                                    
                                </div>

                            </div>
                        </div> 
                    </div>
                </div>

                <div class="row mb-5">

                    <div class="col-6">
                        <div class="text-left">
                            <a href="{{ URL::to('/Bill')}}" id="btn_cancel" class="btn btn-outline-primary mt-3">{{__('common.cancel')}}</a>
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
<script src="{{ URL::asset('timepicker/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/moment.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
{!! JsValidator::formRequest('App\Http\Requests\SimpleCreateBillRequest','#form_bill_invoice') !!}

<script>
    function checkCode(elem) {
            var recipient_code = $(elem).val();
            $.ajax({
                    type: 'POST',
                    url: '{{ action("RecipientManageController@check_code") }}',
                    data: {
                        _token: `{{ csrf_token() }}`,
                        recipient_code: recipient_code,
                    }
                }).done(function(result) {
                    $.unblockUI()
                    if ( result.success ) {
                        Swal.fire({
                                title: 'recipient code  มีอยู่แล้ว'
                            })
                    }
                }).fail(function(err) {
                    $.unblockUI()
                    console.error('Error: ', err)
                    Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                })
        }
</script>

<script type="text/javascript">

    const currentlang = `{{ app()->getLocale() }}`
    const oldData = JSON.parse(`{!! json_encode(Session::getOldInput()) !!}`)

    // select2 option
    const optionRecipient = {
        placeholder: "{{__('bill.simple.search_customer_or_set_customer_code')}}",
        minimumInputLength: 2,
        minimumResultsForSearch: Infinity,
        ajax: {
            delay: 250,
            cache: true,
            url: '{{ action("RecipientManageController@select2_recipient") }}',
            dataType: 'json',
            type: 'post',
            data: function(params) {
                const query = {
                    search: params.term,
                    _token: '{{ csrf_token() }}'
                }
                return query
            },
            processResults: function(data, page) {
                return {
                    results: $.map(data.items, function(item) {
                        const fullName = item.full_name || ''
                        const _name = `${item.first_name || ''} ${item.middle_name || ''} ${item.last_name || ''}`
                        const custName = (fullName || _name)  + ` ( ${item.id} )`
                        return { id: item.id, text: custName, full: item }
                    })
                }
            }
        }
    }

    const select2Search = (select2, term) => {
        select2.select2('open')
        
        // Get the search box within the dropdown or the selection
        // Dropdown = single, Selection = multiple
        var search = select2.data('select2').dropdown.$search || select2.data('select2').selection.$search
        // This is undocumented and may change in the future
        
        search.val(term)
        search.trigger('keyup')
    }

    const init = (data = null) => {
        const oldData = data

        backData( oldData )
    }
    
    const backData = (oldData) => {

        if ( oldData === undefined || oldData.length === 0 ) {
            return
        }
        // array item
        const _array = ['product_name', 'product_price_per_unit', 'product_qty', 'product_amount', 'item_discount', 'item_fee', 'item_total_price']

        // exclude field list
        const _exclude = ['recipient_code']

        if ( oldData.recipient_search === 'search' ) {
            _exclude.push('recipient_name', 'recipient_lastname', 'recipient_telephone', 'recipient_email', 'recipient_additional_email', 'recipient_additional_telephone')
        } else if ( oldData.recipient_search === 'custom' ) {
            enableNewRecipient()
            const index = _exclude.indexOf('recipient_code')
            if (index > -1) {
                _exclude.splice(index, 1)
            }
        }

        Object.keys( oldData ).map(function(objectKey, index) {
            if ( _exclude.indexOf( objectKey ) !== -1 ) {
                // skip in exclude list
                return
            }

            const value = oldData[objectKey]
            if ( Array.isArray( value ) ) {
                if ( _array.indexOf( objectKey ) !== -1 ) {
                    value.forEach( (element, index) => {
                        if ( $(`*[name='${objectKey}[${index}]']`).length === 0  ) {
                            $('.product-wrapper').append( newItem() ) // appendItem
                        }
                        $(`*[name='${objectKey}[${index}]']`).val( element )
                    })
                } else {
                    //
                }
            } else {
                $(`*[name=${objectKey}]`).val( value )
            }
        })
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

    const itemCalulate = {
        qty: function (el, _default = 1) {
            const elemQty = $( el ).closest('.clonable').children().find('.product_qty')
            const qty = $( elemQty ).val()
            if ( isNaN( qty ) || _.isEmpty( qty ) ) {
                $( elemQty ).val( _default )
                return _default
            } 
            $( elemQty ).val( qty )
            return qty
        },
        ppu: function (el, _default = 0) {
            const elemPPU = $( el ).closest('.clonable').children().find('.product_price_per_unit')
            const ppu = $( elemPPU ).val()
            if ( isNaN( ppu ) || _.isEmpty( ppu ) ) {
                $( elemPPU ).val( _default )
                return _default
            }
            $( elemPPU ).val( ppu )
            return ppu
        },
        discount: function (el, _default = 0) {
            const elemDiscount = $( el ).closest('.clonable').children().find('.item_discount')
            const discount = $( elemDiscount ).val()
            if ( isNaN( discount ) || _.isEmpty( discount ) ) {
                $( elemDiscount ).val( _default )
                return _default
            }
            $( elemDiscount ).val( discount )
            return discount
        },
        fee: function (el, _default = 0) {
            const elemFee = $( el ).closest('.clonable').children().find('.item_fee')
            const fee = $( elemFee ).val()
            if ( isNaN( fee ) || _.isEmpty( fee ) ) {
                $( elemFee ).val( _default )
                return _default
            }
            $( elemFee ).val( fee )
            return fee
        }
    }
    
    const sumCalulate = {
        tax: function (_default = 0) {
            const elemTax = $( 'input[name=tax_percentage]' )
            const tax = $( elemTax ).val()
            if ( isNaN( tax ) || _.isEmpty( tax ) ) {
                $( elemTax ).val( _default )
                return _default
            }
            $( elemTax ).val( tax )
            return tax
        },
        discount: function (_default = 0) {
            const elemDiscount = $( 'input[name=bill_discount]' )
            const discount = $( elemDiscount ).val()
            if ( isNaN( discount ) || _.isEmpty( discount ) ) {
                $( elemDiscount ).val( _default )
                return _default
            }
            $( elemDiscount ).val( discount )
            return discount
        },
        fee: function (_default = 0) {
            const elemFee = $( 'input[name=bill_fee]' )
            const fee = $( elemFee ).val()
            if ( isNaN( fee ) || _.isEmpty( fee ) ) {
                $( elemFee ).val( _default )
                return _default
            }
            $( elemFee ).val( fee )
            return fee
        },
        amount_exclude_dtf: function () {
            // Exclude bill discount, fee, tax
            let sum = 0
            $('.item_total_price').each(function() {
                if ( isNaN( $(this).val() ) ) { return false }
                sum += parseFloat( $(this).val() )
            })
            return sum
        },
        update: function () {
            const _taxPer               = this.tax()
            const _fee                  = this.fee()
            const _discount             = this.discount()
            const _amountExcludeDTF     = this.amount_exclude_dtf()
            const _amountBeforeTax      = parseFloat(_amountExcludeDTF) + parseFloat(_fee) - parseFloat(_discount)
            const _taxAmount            = ( parseFloat(_amountBeforeTax) * parseFloat(_taxPer) ) / 100
            const _totalAmount          = parseFloat( _amountBeforeTax ) + parseFloat( _taxAmount )

            // update summary
            $('input[name=total_price_before_fee_and_discount]').val( _amountExcludeDTF )
            $('input[name=total_price_before_tax]').val( _amountBeforeTax )
            $('input[name=tax_amount]').val( _taxAmount )
            $('input[name=bill_total_amount]').val( _totalAmount )
        }
    }

    const productSelect2 = {
        tags: true,
        ajax: {
            delay: 250,
            cache: true,
            url: '{{ action("ItemProductSettingController@Search") }}',
            dataType: 'json',
            type: 'post',
            data: function(params) {
                const query = {
                    search: params.term,
                    _token: '{{ csrf_token() }}'
                }
                return query
            },
            processResults: function(data, page) {
                return {
                    results: $.map(data.items, function(item) {
                        const code = item.code != '' ? item.code + ' | ' : ''
                        const text = code + ` ${item.name || ''}`
                        return {
                            id: item.id, text: text ,full: item
                        }
                    })
                }
            }
        }
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

        newItem.find('select').each(function() {
            $(this).attr( 'name', this.name.replace('[0]', `[${count}]`) )
            $(this).attr( 'id', this.name.replace('[0]', `[${count}]`) )
            
            $(this).next().remove()
            $(this).select2(productSelect2)

            // $(this).parent().next().find('span .select2-selection__rendered').remove()
            console.log($(this).next().find('span .select2-selection__rendered'))
            $(this).next().find('span .select2-selection__rendered').attr('title', '').text('')

            $(this).on('select2:select', function (e) {
                const data = e.params.data
                if(data.hasOwnProperty('full')) {
                    $(this).removeClass('is-invalid').removeClass('is-valid')
                    $(this).parent().parent().next().find('.product_price_per_unit').val(data.full.amount || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
                    $(this).parent().parent().next().find('.product_price_per_unit').trigger('change')
                    $(this).parent().parent().next().find('.product_type').val('select')
                }
                else {
                    $(this).parent().parent().next().find('.product_price_per_unit').prop('readonly', false).removeClass('is-invalid').removeClass('is-valid')
                    $(this).parent().parent().next().find('.product_price_per_unit').val('').trigger('change')
                    $(this).parent().parent().next().find('.product_type').val('new')
                }
            })

            $(this).on("select2:opening", function(e) {
                console.log(`Opening [${count}]`);
            });
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

    $('.js-data-example-ajax').select2(productSelect2)

    $('.js-data-example-ajax').on('select2:select', function (e) {
        const data = e.params.data
        if(data.hasOwnProperty('full')) {
            $(this).removeClass('is-invalid').removeClass('is-valid')
            $(this).parent().parent().next().find('.product_price_per_unit').val(data.full.amount || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
            $(this).parent().parent().next().find('.product_price_per_unit').trigger('change')
            $(this).parent().parent().next().find('.product_type').val('select')
        }
        else {
            $(this).parent().parent().next().find('.product_price_per_unit').prop('readonly', false).removeClass('is-invalid').removeClass('is-valid')
            $(this).parent().parent().next().find('.product_price_per_unit').val('').trigger('change')
            $(this).parent().parent().next().find('.product_type').val('new')
        }
    })

    $('.js-data-example-ajax').on("select2:opening", function(e) {
        console.log('Opening');
    });


    const removeBtn = () => {
        return `
            <div class="col-12 text-right">
                <button type="button" class="btn btn-outline-danger removable px-1 pb-0 pt-1">
                    <i class="ni ni-fat-remove fa-2x"></i>
                </button>
            </div>
        `
    }

    const enableNewRecipient = () => {
        $('input[name=recipient_search]').val('custom')    // select2 search state 'recipient by custom'

        // disable & hide select2
        $('#recipient_code').prop('disabled', true).select2(optionRecipient).next().hide()

        // show input recipient code
        $('input[name=recipient_code]').removeAttr('disabled').removeClass('d-none')

        // reset input
        $('input[name=recipient_name]').val('').removeAttr('readonly')
        $('input[name=recipient_lastname]').val('').removeAttr('readonly')
        $('input[name=recipient_telephone]').val('').removeAttr('readonly')
        $('input[name=recipient_email]').val('').removeAttr('readonly')
        $('input[name=recipient_additional_telephone]').val('')
        $('input[name=recipient_additional_email]').val('')
    }

    $(document).ready(function() {

        init(oldData)

        // initial datepicker
        $('#bill_due_date').datepicker({
            todayBtn: "linked",
            language: "it",
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
        }) 

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

        $('#payment_channel').on('change', function() {
            if($('#payment_channel').val() == 'recurring') {
                $('.send_bill_type').addClass("d-none")
                $('#schedule_date').addClass("d-none")
            }
            else {
                $('.send_bill_type').removeClass("d-none")
                if($('#send_bill_type').val() == 'schedule') {
                    $('#schedule_date').removeClass("d-none")
                }
            }
        })

        $('#send_bill_type').on('change', function() {
            if($('#send_bill_type').val() == 'schedule') {
                $('#schedule_date').removeClass("d-none")
            }
            else if($('#send_bill_type').val() == 'now') {
                $('#schedule_date').addClass("d-none")
            }
        })

        // check if select2 is already initialized
        if ( !$('#recipient_code').hasClass('select2-hidden-accessible') ) {

            // initial select2 recipient code
            $('#recipient_code').select2(optionRecipient).on('select2:open', (ev) => {
                $(".select2-results:not(:has(a))")
                    .append(`<a href="#" id="new" class="text-muted" style="padding: 6px;height: 15px;display: inline-table;">{{ __('bill.simple.create_new_recipient_btn') }}</a>`)

                // check if previous recipient has been search
                if ( oldData.recipient_code && oldData.recipient_search === 'search' ) {
                    select2Search( $('#recipient_code'), oldData.recipient_code )
                    delete oldData.recipient_code
                }
            })
        }

        // event on select
        $('#recipient_code').on('select2:select', function (e) {
            $('input[name=recipient_search]').val('search')    // select2 search state 'recipient by search'

            const data = e.params.data
            $(this).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_name]').val(data.full.first_name || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_lastname]').val(data.full.last_name || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_telephone]').val(data.full.telephone || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_email]').val(data.full.email || '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_additional_telephone]').val( oldData.recipient_additional_telephone || '' ).removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_additional_email]').val( oldData.recipient_additional_email || '' ).removeClass('is-invalid').removeClass('is-valid')
        })

        // disable input recipient
        $(document).on('click', '#new', function(e) {            
            enableNewRecipient()

            e.preventDefault()
            return false
        })

        // reset input recipient code
        $('#reset-recipient').on('click', function() {
            $('input[name=recipient_search]').val('none')    // select2 search state 'recipient by custom'

            $('#recipient_code').removeAttr('disabled').val('').trigger('change').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_name]').val('').removeAttr('readonly').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_lastname]').val('').removeAttr('readonly').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_telephone]').val('').removeAttr('readonly').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_email]').val('').removeAttr('readonly').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_additional_telephone]').removeClass('is-invalid').removeClass('is-valid')
            $('input[name=recipient_additional_email]').removeClass('is-invalid').removeClass('is-valid')

            // disable & hide input
            $('input[name=recipient_code]').prop('disabled', true).addClass('d-none')

            // enable && show select2
            $('#recipient_code').removeAttr('disabled').select2(optionRecipient).next().show()
        })

        // initial select2 branch name
        $('#branch_name').select2({
            placeholder: "{{__('bill.simple.branch_name_placeholder')}}",
            minimumInputLength: 2,
            ajax: {
                delay: 250,
                cache: true,
                url: '{{ action("CorporateController@select2_branch") }}',
                dataType: 'json',
                type: 'post',
                data: function(params) {
                    const query = {
                        search: params.term,
                        _token: '{{ csrf_token() }}'
                    }
                    return query
                },
                processResults: function(data, page) {
                    if ( currentlang === 'en' ) {
                        return {
                            results: $.map(data.items, function(item) {
                                return { id: item.id, text: item.text_en }
                            })
                        }
                    } else {
                        return {
                            results: $.map(data.items, function(item) {
                                return { id: item.id, text: item.text_th }
                            })
                        }
                    }
                }
            }
        }).on('select2:open', (ev) => {
            if ( oldData.branch_name ) {
                select2Search( $('#branch_name'), oldData.branch_name )
                delete oldData.branch_name
            }
        })

        // add new item
        $('#add').on('click', function() {
            
            // append
            $('.product-wrapper').append( newItem() )

            removeBtnUpdate()
        })   

        $(document).on('change focusou', '.product_name, .product_price_per_unit, .product_qty, .item_discount, .item_fee', function() {
            const ppu       = itemCalulate.ppu(this)
            const qty       = itemCalulate.qty(this)
            const amount    = parseFloat(ppu) * parseFloat(qty)
            const discount  = itemCalulate.discount(this)
            const fee       = itemCalulate.fee(this)
            const itemTotal = parseFloat(amount) + parseFloat(fee) - parseFloat(discount)

            // item update
            $(this).closest('.clonable').children().find('.product_amount').val( amount )
            $(this).closest('.clonable').children().find('.item_total_price').val( itemTotal )

            // bill summary update
            sumCalulate.update()
        })

        $(document).on('change focusou', 'input[name=bill_discount], input[name=bill_fee], input[name=tax_percentage]', function() {
            // bill summary update
            sumCalulate.update()
        })

        $(document).on('click', '.removable', function(e) {
            if ( $(this).closest('.clonable').index() !== 0 ) {
                $(this).closest('.clonable').remove()
                removeBtnUpdate()
            } else {
                $(this).remove()
            }
        })

        $(document).on('keypress', 'form', function (e) {
            var code = e.keyCode || e.which
            if (code == 13) {
                e.preventDefault()
                return false
            }
        })

    }) 
</script>
@endsection