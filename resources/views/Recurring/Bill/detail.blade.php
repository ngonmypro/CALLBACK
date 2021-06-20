@extends('argon_layouts.app', ['title' => __('Bill')])

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/extensions/dropzone/4.3.0/dropzone.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker-v2/daterangepicker.css') }}"/>

<style type="text/css">
    .ui-timepicker-standard{
        z-index: 9999 !important;
    }
    .carousel .carousel-inner .item .carousel-image {
        vertical-align: middle;
    }
    .dropzone {
        border-radius: 5px;
        border-image: none;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
        border: none;
    }
</style>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.index.title')}}</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right d-none">
                        <a href="{{ url('Bill')}}" class="btn btn-secondary">{{ (__('common.back'))}}</a>
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
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <h3 class="mb-0">{{__('bill.index.bill_information')}}</h3>
                                <p class="text-sm mb-0"></p>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12 text-right">
                          
                                @if ( isset( $data->bill_status ) && isset( $data->payment_status ) )
                                    @if ( $data->bill_status !== 'INACTIVE' && !in_array( $data->payment_status, ['DUPLICATE_PAID', 'CANCELLED'] ) )

                                        <!-- INACTIVE BILL -->
                                        @if ( !in_array($data->payment_status, ['PAID', 'DUPLICATE_PAID']) ) 
                                            <button id="inactive_bill" class="btn btn-warning" 
                                                data-bill="{{ isset($data->reference_code) ? $data->reference_code : '' }}">
                                                <span>{{__('bill.index.btn-inactive-bill')}}</span>
                                            </button>
                                        @endif

                                        <!-- REPAYMENT -->
                                        @if ( in_array( $data->payment_status, ['NEW', 'PENDING', 'UNPAID'] ) ) 
                                            <button id="repayment" class="btn btn-primary" 
                                                data-bill="{{ isset($data->reference_code) ? $data->reference_code : '' }}" 
                                                data-customer="{{ isset($data->recipient_code) ? $data->recipient_code : '' }}">
                                                <span>{{__('bill.detail.repayment.btn')}}</span>
                                            </button>  
                                        @endif

                                        <!-- ************************************************ RESEND ************************************************ -->

                                        <!-- LOAN INVOICE RESEND -->
                                        @if ( isset( $data->bill_type ) && $data->bill_type === 'LOAN' && isset( $data->bill_status ) && !in_array($data->bill_status, ['PAID', 'CANCELLED']) )
                                            <button id="resend" class="btn btn-warning" 
                                                data-bill="{{ isset($data->reference_code) ? $data->reference_code : '' }}">
                                                <span>{{__('bill.index.btn-resend-bill')}}</span>
                                            </button>

                                        <!-- RESEND INVOICE -->
                                        @elseif ( !in_array($data->payment_status, ['PAID', 'DUPLICATE_PAID']) )
                                            <button id="resend" class="btn btn-info" 
                                                data-bill="{{ isset($data->reference_code) ? $data->reference_code : '' }}" 
                                                data-customer="{{ isset($data->recipient_code) ? $data->recipient_code : '' }}"
                                                data-telephone="{{ isset($data->telephone) ? $data->telephone : '' }}"
                                                data-branch="{{ isset($data->branch_code) ? $data->branch_code : '' }}">
                                                <span>{{__('bill.index.btn-resend-bill')}}</span>
                                            </button>

                                        <!-- RESEND RECEIPT -->
                                        @elseif ( $data->bill_status === 'PAID' && $data->payment_status === 'PAID' )
                                            <button id="resend-receipt" class="btn btn-info" 
                                                data-bill="{{ isset($data->reference_code) ? $data->reference_code : '' }}" 
                                                data-customer="{{ isset($data->recipient_code) ? $data->recipient_code : '' }}"
                                                data-telephone="{{ isset($data->telephone) ? $data->telephone : '' }}"
                                                data-branch="{{ isset($data->branch_code) ? $data->branch_code : '' }}">
                                                <span>{{__('bill.index.btn-resend-receipt')}}</span>
                                            </button>
                                        @endif
                                        
                                        <!-- ************************************************ RESEND ************************************************ -->


                                    @else

                                        <!-- BADGE FOR INACTIVE BILL STATUS -->
                                        @if ($data->bill_status === 'INACTIVE')
                                            <span class="badge badge-danger">
                                                <h4 class="label mb-0">{{__('bill.index.bill_is_inactive')}}</h4>
                                            </span>
                                        @endif

                                    @endif
                                @endif
                         
                                    <h4 class="label mb-0">{{__('bill.index.recipient_is_deleted')}}</h4>
                                </span>
                            
                                <span class="badge badge-warnig">
                                    <h4 class="label mb-0">{{__('bill.index.recipient_is_inactive')}}</h4>
                                </span>
                           
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.bill_reference')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->reference_code) && !blank($data->reference_code) ? $data->reference_code : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.invoice_number')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->invoice_number) && !blank($data->invoice_number) ? $data->invoice_number : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.bill_type')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_type) && !blank($data->bill_type) ? ucwords(strtolower($data->bill_type)) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.recipient_name')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->first_name) ? $data->first_name : '' }} {{ isset($data->middle_name) ? $data->middle_name : '' }} {{ isset($data->last_name) ? $data->last_name : '' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.telephone')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->telephone) && !blank($data->telephone) ? $data->telephone : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.amount')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_amount) && !blank($data->bill_amount) ? number_format($data->bill_amount,2) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.vat')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_vat) && !blank($data->bill_vat) ? number_format($data->bill_vat,2) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.fee')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_fee) && !blank($data->bill_fee) ? number_format($data->bill_fee,2) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.discount')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_discount) && !blank($data->bill_discount) ? number_format($data->bill_discount,2) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.total_amount')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_total_amount) && !blank($data->bill_total_amount) ? number_format($data->bill_total_amount,2) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.due_date')}}</label>
                                        </div>
                                        <div class="col-12">

                                            <label for="" class=" form-control-label">{{ isset($data->bill_due_date) && !blank($data->bill_due_date) ? date('d-m-Y', strtotime($data->bill_due_date)) : '-' }}</label>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.bill_status')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_status) && !blank($data->bill_status) ? ucwords(str_replace('_', ' ', strtolower($data->bill_status))) : '-' }} <small>{{ isset($data->bill_status_reason) ? $data->bill_status_reason : '' }}</small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.payment_status')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->payment_status) && !blank($data->payment_status) ? ucwords(str_replace('_', ' ', strtolower($data->payment_status))) : '-' }} <small>{{ isset($data->payment_status_reason) ? ucwords(str_replace('_', ' ', strtolower($data->payment_status_reason))) : '' }}</small></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.payment_date')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->payment_date_time) && !blank($data->payment_date_time) ? date('d-m-Y H:i:s', strtotime($data->payment_date_time)) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.payment_channel')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->payment_channel) && !blank($data->payment_channel) ? ucwords(str_replace('_', ' ', strtolower($data->payment_channel))) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.reference_1')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->ref_1) && !blank($data->ref_1) ? $data->ref_1 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.reference_2')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->ref_2) && !blank($data->ref_2) ? $data->ref_2 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.reference_3')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->ref_3) && !blank($data->ref_3) ? $data->ref_3 : '-' }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.reference_4')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->ref_4) && !blank($data->ref_4) ? $data->ref_4 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.reference_5')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->ref_5) && !blank($data->ref_5) ? $data->ref_5 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.more_detail')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> - </label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>

                        @if ( !blank($data->optional_data->slips ?? null) && is_array($data->optional_data->slips) && count($data->optional_data->slips) > 0 )
                            @if ( !blank($data->optional_data->slips ?? null) && is_array($data->optional_data->slips) )
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 w-100">
                                        <div class="form-group">        
                                            <div class="row">

                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{__('bill.index.payslip')}}</label>
                                                </div>

                                                <div class="col-12">
                                                    
                                                    @foreach ( $data->optional_data->slips as $key => $value )
                                                        <span class="px-1">
                                                            <img class="border rounded payslip" style="max-width: 100px;" src="{{ $value->image }}">
                                                        </span>
                                                    @endforeach
                                                        
                                                </div>

                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if($data->bill_type != "REFERENCE")
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <h4 class="py-3 card-header-with-border">
                                        {{__('bill.index.item')}}
                                    </h4>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">{{__('bill.index.item')}}</th>
                                                            <th class="text-center">{{__('bill.index.amount')}}</th>
                                                            <th class="text-center">{{__('bill.index.vat')}}</th>
                                                            <th class="text-center">{{__('bill.index.fee')}}</th>
                                                            <th class="text-center">{{__('bill.index.discount')}}</th>
                                                            <th class="text-center">{{__('bill.index.total_amount')}}</th>
                                                        </tr>
                                                    </thead>
                                                    @if( isset($data->items) && $data->items != null )
                                                        <tbody>
                                                            @foreach($data->items->list as $key => $item)
                                                                <tr>
                                                                    <td class="text-center">{{ $item->item_name }}</th>
                                                                    <td class="text-center">{{ $item->item_amount }}</td>
                                                                    <td class="text-center">{{ $item->item_vat }}</td>
                                                                    <td class="text-center">{{ $item->item_fee }}</td>
                                                                    <td class="text-center">{{ $item->item_discount }}</td>
                                                                    <td class="text-center">{{ $item->item_total_amount }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th class="text-center">{{ $data->items->total->amount }}</th>
                                                                <th class="text-center">{{ $data->items->total->vat }}</th>
                                                                <th class="text-center">{{ $data->items->total->fee }}</th>
                                                                <th class="text-center">{{ $data->items->total->discount }}</th>
                                                                <th class="text-center">{{ $data->items->total->total_amount }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($data->bill_type == "REFERENCE")
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <h4 class="py-3 card-header-with-border">
                                        {{__('bill.index.bill_reference')}}
                                    </h4>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">{{__('bill.index.reference_code')}}</th>
                                                            <th class="text-center">{{__('bill.index.amount')}}</th>
                                                            <th class="text-center">{{__('bill.index.vat')}}</th>
                                                            <th class="text-center">{{__('bill.index.fee')}}</th>
                                                            <th class="text-center">{{__('bill.index.discount')}}</th>
                                                            <th class="text-center">{{__('bill.index.total_amount')}}</th>
                                                            <th class="text-center">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    @if( isset($data->reference_bill) && $data->reference_bill != null )
                                                        <tbody>
                                                            @foreach($data->reference_bill->list as $key => $item)
                                                                <tr>
                                                                    <td class="text-center">{{ $item->reference_code }}</th>
                                                                    <td class="text-center">{{ $item->bill_amount }}</td>
                                                                    <td class="text-center">{{ $item->bill_vat }}</td>
                                                                    <td class="text-center">{{ $item->bill_fee }}</td>
                                                                    <td class="text-center">{{ $item->bill_discount }}</td>
                                                                    <td class="text-center">{{ $item->bill_total_amount }}</td>
                                                                    <td class="text-center"><a href="{{ action('Bill\UploadController@detail', ['reference' => $item->reference_code]) }}">GO</a></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th class="text-center">{{ $data->reference_bill->total->amount }}</th>
                                                                <th class="text-center">{{ $data->reference_bill->total->vat }}</th>
                                                                <th class="text-center">{{ $data->reference_bill->total->fee }}</th>
                                                                <th class="text-center">{{ $data->reference_bill->total->discount }}</th>
                                                                <th class="text-center">{{ $data->reference_bill->total->total_amount }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(isset($data->logs) && $data->logs != null)
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <h4 class="py-3 card-header-with-border">
                                        BILL PAYMENT LOGS
                                    </h4>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="p-2 flex-fill w-50">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">NO.</th>
                                                            <th class="text-center">STATE</th>
                                                            <th class="text-center">STATUS</th>
                                                            <th class="text-center">REASON</th>
                                                            <th class="text-center">CREATE BY</th>
                                                            <th class="text-center">DATE TIME</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($data->logs as $key => $log)
                                                            <tr>
                                                                <td class="text-center">{{ $key+1 }}</th>
                                                                <td class="text-center">{{ $log->state }}</td>
                                                                <td class="text-center">{{ $log->status }}</td>
                                                                <td class="text-center">{{ $log->status_reason != NULL ? $log->status_reason : '-' }}</td>
                                                                                         
                                                                <td class="text-center">{{ date('d-m-Y H:i:s', strtotime($log->created_at)) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="d-none" id="initForm">
        <form id="repayment_form" class="" method="POST" action="{{ action('BillController@Repayment') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}   
            <input type="hidden" name="reference_code" value="{{ $data->reference_code ?? '' }}">
            <input type="hidden" name="customer_code" value="{{ $data->recipient_code ?? '' }}">

            <div class="container-fluid py-5">

                <div class="row">
    
                    @php
                        $col = 12;
                    @endphp

                    @if ( !blank($data->optional_data->slips ?? null) && is_array($data->optional_data->slips) && count($data->optional_data->slips) > 0 )
                    
                        @php
                            $col = 6;
                        @endphp

                        <div class="col-xl-{{ $col }} col-lg-{{ $col }} col-md-12 col-sm-12 col-xs-12">


                            <div class="row p-3">

                                <div id="payslip" class="carousel slide border rounded col-12 p-0" data-ride="carousel" data-interval="false">
                                    <div class="carousel-inner">
                                        
                                        @if ( !blank($data->optional_data->slips ?? null) && is_array($data->optional_data->slips) )
                                            @foreach ( $data->optional_data->slips as $key => $value )
                                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                    <img class="d-block w-100" src="{{ $value->image }}">
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                    </div>

                                    <a class="carousel-control-prev" href="#payslip" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#payslip" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="col-xl-{{ $col }} col-lg-{{ $col }} col-md-12 col-sm-12 col-xs-12">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="transaction_time">{{__('bill.detail.repayment.transaction_date')}} </label><span class="text-danger"> *</span>
                                    
                                        <input class="form-control timepicker" name="transaction_datetime" id="transaction_datetime" type="text" placeholder="{{__('bill.detail.repayment.required')}}">
                                        <input type="hidden" name="transaction_date" id="transaction_date">
                                        <input type="hidden" name="transaction_time" id="transaction_time">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="from_name">{{__('bill.detail.repayment.from_name')}} </label><span class="text-danger"> *</span>
                                    
                                        <input type="text" class="form-control" name="from_name" id="from_name" placeholder="{{__('bill.detail.repayment.required')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="transaction_id">{{__('bill.detail.repayment.transaction_id')}} </label><span class="text-danger"> *</span>
                                    
                                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="{{__('bill.detail.repayment.required')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="from_bank">{{__('bill.detail.repayment.from_bank')}}</label>
                                    
                                        <input type="text" class="form-control" name="from_bank" id="from_bank" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="account_no">{{__('bill.detail.repayment.account_no')}}</label>
                                    
                                        <input type="text" class="form-control" name="account_no" id="account_no" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="payment_channel">{{__('bill.detail.repayment.payment_channel')}}</label><span class="text-danger"> *</span>
                                    
                                        @if ( !blank($data->payment_channel ?? null) ) 
                                            <input readonly type="text" class="form-control" name="payment_channel" id="payment_channel" placeholder="{{__('bill.detail.repayment.required')}}" value="{{ $data->payment_channel }}">
                                        @else
                                            <input type="text" class="form-control" name="payment_channel" id="payment_channel" placeholder="{{__('bill.detail.repayment.required')}}">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="ref_1">{{__('bill.detail.repayment.ref_1')}}</label>
                                    
                                        <input type="text" class="form-control" name="ref_1" id="ref_1" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="ref_2">{{__('bill.detail.repayment.ref_2')}}</label>
                                    
                                        <input type="text" class="form-control" name="ref_2" id="ref_2" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="ref_3">{{__('bill.detail.repayment.ref_3')}}</label>
                                    
                                        <input type="text" class="form-control" name="ref_3" id="ref_3" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="row p-3">
                                    <div class="col-12 text-left">
                                        <label for="remarks">{{__('bill.detail.repayment.remarks')}}</label>
                                    
                                        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-12 dropzone needsclick m-0">
                        <div id="preview-wrapper" class="dz-message needsclick">
                            <span id="dropzone-text">
                                <i class="fas fa-image"></i>
                                นำเข้ารูปภาพใบเสร็จ
                            </span>
                        </div>

                    </div>

                    <div id="preview-template" style="display: none;">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-image"><img data-dz-thumbnail="" /></div>
                            <div class="dz-details">
                            <div class="dz-size"><span data-dz-size=""></span></div>
                            <div class="dz-filename"><span data-dz-name=""></span></div>
                            </div>
                            <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress=""></span>
                            </div>
                            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                            <div class="dz-success-mark">
                            <svg
                                width="54px"
                                height="54px"
                                viewBox="0 0 54 54"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                            >
                                <title>Check</title>
                                <desc>Created with Sketch.</desc>
                                <defs></defs>
                                <g
                                id="Page-1"
                                stroke="none"
                                stroke-width="1"
                                fill="none"
                                fill-rule="evenodd"
                                sketch:type="MSPage"
                                >
                                <path
                                    d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                    id="Oval-2"
                                    stroke-opacity="0.198794158"
                                    stroke="#747474"
                                    fill-opacity="0.816519475"
                                    fill="#FFFFFF"
                                    sketch:type="MSShapeGroup"
                                ></path>
                                </g>
                            </svg>
                            </div>
                            <div class="dz-error-mark">
                            <svg
                                width="54px"
                                height="54px"
                                viewBox="0 0 54 54"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                            >
                                <title>error</title>
                                <desc>Created with Sketch.</desc>
                                <defs></defs>
                                <g
                                id="Page-1"
                                stroke="none"
                                stroke-width="1"
                                fill="none"
                                fill-rule="evenodd"
                                sketch:type="MSPage"
                                >
                                <g
                                    id="Check-+-Oval-2"
                                    sketch:type="MSLayerGroup"
                                    stroke="#747474"
                                    stroke-opacity="0.198794158"
                                    fill="#FFFFFF"
                                    fill-opacity="0.816519475"
                                >
                                    <path
                                    d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                    id="Oval-2"
                                    sketch:type="MSShapeGroup"
                                    ></path>
                                </g>
                                </g>
                            </svg>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>



    </section>

    

@endsection

@section('script')

    <!--- Daterange picker --->
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/moment.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
    <!-- <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script> -->
    <script src="{{ asset('assets/js/extensions/dropzone/4.3.0/dropzone.js') }}"></script>

    {!! JsValidator::formRequest('App\Http\Requests\ManualRepaymentBillRequest','#repayment_form') !!}
    <script>

        Dropzone.autoDiscover = false
        const dropzoneOptions = {
            url: "{{ action('BillController@Repayment') }}",
            acceptedFiles: 'image/*',
            paramName: 'file', // The name that will be used to transfer the file
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            previewsContainer: "#preview-wrapper",
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            uploadMultiple: false,
            autoProcessQueue: false,
            maxFiles:1,
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0])
                    }
                })
            },
            processing: function() {
                $.blockUI()
            },
            thumbnail: function(file, dataUrl) {
                $('#preview-wrapper').addClass('p-3 text-left')
                $('#dropzone-text').remove()

                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() { 
                        file.previewElement.classList.add("dz-image-preview"); 
                    }, 1);
                }
            },
            success: function(file, response) {
                $.unblockUI()

                if ( response.success ) {
                    Swal.fire({
                        type: 'success',
                        title: 'การชำระเงินสำเร็จ', 
                        text: 'ทำรายการสำเร็จ', 
                    }).then(() => {
                        if ( response.redirectTo ) window.location = response.redirectTo || ''

                        window.location.reload()
                    })
                } else {
                    dropzone.removeAllFiles(true)
                    Swal.fire({
                        type: 'error',
                        title: response.message, 
                        text: response.message || 'ไม่สามารถทำรายได้ กรุณาลองใหม่อีกครั้ง'
                    })
                    return false
                }
            },
            error: function(err) {
                $.unblockUI()

                dropzone.removeAllFiles(true)
                Swal.fire({
                    type: 'error',
                    title: '', 
                    text: err.message || 'ไม่สามารถทำรายได้ กรุณาลองใหม่อีกครั้ง'
                })
                return false
            }
        }
        var dropzone = new Dropzone('#repayment_form', dropzoneOptions)

        $(document).ready(function() {

            const billStatus = "{{ $data->bill_status }}"
            const paymentStatus = "{{ $data->payment_status }}"
            const billType = "{{ $data->bill_type }}"
            const notifyOption = {
                'SMS': `{{__('bill.detail.resend.ch_sms')}}`,
                'EMAIL': `{{__('bill.detail.resend.ch_email')}}`,
                'LINE': `{{__('bill.detail.resend.ch_line')}}`,
            }

            $('input[name=transaction_date]').mask('00/00/0000', { placeholder: 'DD/MM/YYYY' });

            $('input[name=transaction_time]').mask('00:00', { placeholder: 'HH:MM' });
        
            $('input[name="transaction_datetime"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                timePicker: true,
                //minDate: moment().format("DD/MM/YYYY HH:mm"),
                //maxDate: moment().format("DD/MM/YYYY HH:mm"),
                startDate: moment().format("DD/MM/YYYY HH:mm"),
                locale: {
                    format: 'DD/MM/YYYY HH:mm' 
                }
            }, function(start, end, label) {
                var getDate = start.format('DD/MM/YYYY');
                var splitTime = start.format('HH:mm');

                var getDate = start.format('DD/MM/YYYY');
                var splitTime = start.format('HH:mm');

                $("input[name='transaction_date']").val(getDate);
                $("input[name='transaction_time']").val(splitTime);
            })

            var getDate = $('input[name="transaction_datetime"]').val();
            var splitTime = getDate.split(" ");

            $("input[name='transaction_date']").val(splitTime[0]);
            $("input[name='transaction_time']").val(splitTime[1]);

            $('#resend').on('click', function() {

                if ( billStatus === 'PAID' && paymentStatus === 'PAID' ) {
                    delete notifyOption.SMS,
                    delete notifyOption.LINE
                }
                if ( billType !== 'LOAN' ) {
                    delete notifyOption.LINE
                }

                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve(notifyOption)
                    }, 100)
                })

                Swal.queue([{
                    title: `{{__('bill.detail.resend.title')}}`,
                    confirmButtonText: `{{__('common.next')}}`+' &rarr;',
                    text: `{{__('bill.detail.resend.heading')}}`,
                    input: 'radio',
                    inputOptions,
                    inputValidator: (result) => {
                        return !result && `{{__('bill.detail.resend.option-invalid')}}`
                    },
                    preConfirm: (data) => {
                        return new Promise(function (resolve) {
                            const queue = {
                                title: `{{__('bill.detail.resend.title')}}`,
                                input: 'text',
                                inputValidator: (value) => {
                                    if (!value) {
                                        return `{{__('bill.detail.resend.input-invalid')}}`
                                    }
                                },
                                confirmButtonText: `{{__('common.confirm')}}`
                            }
                            if ( data === 'SMS' ) {
                                queue.text = `{{__('bill.detail.resend.enter_mobile_no')}}`
                                queue.inputValue = "{{ isset($data->telephone) ? $data->telephone : '' }}"
                            } else if ( data === 'EMAIL' ) {
                                queue.text = `{{__('bill.detail.resend.enter_email')}}`
                                queue.inputValue = "{{ isset($data->email) ? $data->email : '' }}"
                                // queue.inputAttributes = {
                                //     disabled: 'disabled'
                                // }
                            } else if ( data === 'LINE' ) {
                                queue.text = `{{__('bill.detail.resend.confirm_send_line_message')}}`
                                delete(queue.input)
                            }
                            Swal.insertQueueStep(queue)
                            resolve()
                        })
                    }
                }]).then((result) => {
                    $.blockUI()

                    if ( result.value ) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ action("BillController@ResendNotifyBill") }}',
                            data: {
                                _token: `{{ csrf_token() }}`,
                                billReference: $('#resend').data('bill'),
                                customerNo: $('#resend').data('customer'),
                                channel: result.value[0] || '',
                                value: result.value[1] || '',
                                branchCode: $('#resend').data('branch'),
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                        })
                    } else {
                        $.unblockUI()
                    }
                })
            })

            $('#resend-receipt').on('click', function() {

                if ( billStatus === 'PAID' && paymentStatus === 'PAID' ) {
                    delete notifyOption.SMS,
                    delete notifyOption.LINE
                }
                if ( billType !== 'LOAN' ) {
                    delete notifyOption.LINE
                }

                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve(notifyOption)
                    }, 100)
                })

                Swal.queue([{
                    title: `{{__('bill.detail.resend-receipt.title')}}`,
                    confirmButtonText: `{{__('common.next')}}`+' &rarr;',
                    text: `{{__('bill.detail.resend-receipt.heading')}}`,
                    input: 'radio',
                    inputOptions,
                    inputValidator: (result) => {
                        return !result && `{{__('bill.detail.resend-receipt.option-invalid')}}`
                    },
                    preConfirm: (data) => {
                        return new Promise(function (resolve) {
                            const queue = {
                                title: `{{__('bill.detail.resend-receipt.title')}}`,
                                input: 'text',
                                inputValidator: (value) => {
                                    if (!value) {
                                        return `{{__('bill.detail.resend-receipt.input-invalid')}}`
                                    }
                                },
                                confirmButtonText: `{{__('common.confirm')}}`
                            }
                            if ( data === 'SMS' ) {
                                queue.text = `{{__('bill.detail.resend-receipt.enter_mobile_no')}}`
                                queue.inputValue = "{{ isset($data->telephone) ? $data->telephone : '' }}"
                            } else if ( data === 'EMAIL' ) {
                                queue.text = `{{__('bill.detail.resend-receipt.enter_email')}}`
                                queue.inputValue = "{{ isset($data->email) ? $data->email : '' }}"
                            } else if ( data === 'LINE' ) {
                                queue.text = `{{__('bill.detail.resend-receipt.confirm_send_line_message')}}`
                                delete(queue.input)
                            }
                            Swal.insertQueueStep(queue)
                            resolve()
                        })
                    }
                }]).then((result) => {
                    $.blockUI()

                    if ( result.value ) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ action("BillController@ResendNotifyBill") }}',
                            data: {
                                _token: `{{ csrf_token() }}`,
                                billReference: $('#resend-receipt').data('bill'),
                                customerNo: $('#resend-receipt').data('customer'),
                                channel: result.value[0] || '',
                                value: result.value[1] || '',
                                branchCode: $('#resend-receipt').data('branch'),
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                        })
                    } else {
                        $.unblockUI()
                    }
                })
            })

            $('#repayment').on('click', function() {
                const __btn = this

                const __domWrapper = `<section id="wrapper"></section>`

                Swal.fire({
                    title: `{{__('bill.detail.repayment.title')}}`,
                    confirmButtonText: `{{__('common.confirm')}}`,
                    text: `{{__('bill.detail.repayment.heading')}}`,
                    html: __domWrapper,
                    showCancelButton: true,
                    cancelButtonText: `{{__('common.cancel')}}`,
                    width: '80vw',
                    onOpen: (ev) => {
                        $( '#wrapper' ).append( $('#repayment_form') )
                    },
                    preConfirm: (value) => {
                        if ( !$('#repayment_form').valid() ) {
                            return false
                        }
                    },
                    onClose: () => {
                        $( '#initForm' ).append( $('#repayment_form') )
                    }
                }).then((result) => {
                    if ( result.value ) {
                        if (dropzone.getQueuedFiles().length > 0) {                        
                            dropzone.processQueue()
                        } else {                 
                            $.blockUI()      
                            $('#repayment_form').ajaxSubmit({
                                success: function(result) {
                                    $.unblockUI()
                                    if ( result.success ) {
                                        Swal.fire({
                                            type: 'success',
                                            title: '', 
                                            text: `{{ (__('common.success')) }}`, 
                                        }).then(() => {
                                            if ( result.redirectTo ) window.location = result.redirectTo || ''
                                            window.location.reload()
                                        })
                                    } else {
                                        console.error('Error: ', result.message)
                                        Swal.fire(`{{ (__('common.error')) }}`, result.message || 'Oops! Something wrong.', 'error')
                                    }
                                },
                                error: function(err) {
                                    $.unblockUI()
                                    console.error('Error: ', err)
                                    Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                                }
                            })
                                
                        }
                    }
                })
            })

            $('#inactive_bill').on('click', function() {
                const __btn = this

                Swal.fire({
                    title: `{{__('bill.index.sure')}}`,
                    text: `{{__('bill.index.comfirm_text')}}`,
                    confirmButtonText: `{{__('common.confirm')}}`,
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: `{{__('common.cancel')}}`,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `{{__('common.confirm')}}`,
                }).then((result) => {
                    $.blockUI()
                    console.log('Input', { result: result.value })

                    if ( result.value ) {
                        const data = $('#repayment_form').serializeObject()
                        data._token = `{{ csrf_token() }}`
                        data.reference_code = $(__btn).data('bill')

                        $.ajax({
                            type: 'POST',
                            url: '{{ action("BillController@InactiveBill") }}',
                            data
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success').then(() => {
                                    window.location.reload()
                                })
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                        })
                    } else {
                        $.unblockUI()
                    }
                })
            })

            $('.payslip').on('click', function() {
                const clone = $(this).clone().off().removeClass('payslip').removeAttr('style').addClass('w-100')

                Swal.fire({
                    html: clone,
                    showCloseButton: false,
                    showCancelButton: false,
                    width: '80vw'
                })
            })
        });
        
    </script>

@endsection