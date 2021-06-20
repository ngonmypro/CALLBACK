@extends('argon_layouts.app', ['title' => __('Bill')])

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
                            <div class="col-8">
                                <h3 class="mb-0">{{__('bill.index.bill_information')}}</h3>
                                <p class="text-sm mb-0"></p>
                            </div>
                            <div class="col-4 text-right">
                        
                           
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
                                            <label for="" class=" form-control-label">{{ isset($data->reference_code) ? $data->reference_code : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.bill_type')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->bill_type) ? $data->bill_type : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{__('bill.index.recipient_name')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->first_name) ? $data->first_name : '' }} {{ isset($data->middle_name) ? $data->middle_name : '' }} {{ isset($data->last_name) ? $data->last_name : '' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('bill.index.telephone')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($data->telephone) ? $data->telephone : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_amount) ? number_format($data->bill_amount,2) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_vat) ? number_format($data->bill_vat,2) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_fee) ? number_format($data->bill_fee,2) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_discount) ? number_format($data->bill_discount,2) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_total_amount) ? number_format($data->bill_total_amount,2) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_due_date) ? $data->bill_due_date : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->bill_status) ? $data->bill_status : '-' }} <small>{{ isset($data->bill_status_reason) ? $data->bill_status_reason : '' }}</small></label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->payment_status) ? $data->payment_status : '-' }} <small>{{ isset($data->payment_status_reason) ? $data->payment_status_reason : '' }}</small></label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->payment_date_time) ? $data->payment_date_time : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->payment_channel) ? $data->payment_channel : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->ref_1) ? $data->ref_1 : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->ref_2) ? $data->ref_2 : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->ref_3) ? $data->ref_3 : '-' }} </label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->ref_4) ? $data->ref_4 : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ isset($data->ref_5) ? $data->ref_5 : '-' }}</label>
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
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($data->bill_type != "REFERENCE")
                            <div class="d-flex flex-wrap mb-3">
                                <div class="p-2 flex-fill w-50">
                                    <h4 class="mb-3 py-3 card-header-with-border">
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
                            <div class="d-flex flex-wrap mb-3">
                                <div class="p-2 flex-fill w-50">
                                    <h4 class="mb-3 py-3 card-header-with-border">
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
                                                                    <td class="text-center"><a href="{!! URL::to("Bill/Detail",$item->reference_code) !!}">GO</a></td>
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
                                                                <td class="text-center">{{ $log->created_at }}</td>
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
        <form id="repayment_form">
            <div class="container-fluid py-5">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="transaction_time">{{__('bill.detail.repayment.transaction_date')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="transaction_date" id="transaction_date" placeholder="{{__('bill.detail.repayment.required')}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="transaction_time">{{__('bill.detail.repayment.transaction_time')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="transaction_time" id="transaction_time" placeholder="{{__('bill.detail.repayment.required')}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="amount">{{__('bill.detail.repayment.amount')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="{{__('bill.detail.repayment.required')}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="from_name">{{__('bill.detail.repayment.from_name')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="from_name" id="from_name" placeholder="{{__('bill.detail.repayment.required')}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="transaction_id">{{__('bill.detail.repayment.transaction_id')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="transaction_id" id="transaction_id" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="from_bank">{{__('bill.detail.repayment.from_bank')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="from_bank" id="from_bank" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="account_no">{{__('bill.detail.repayment.account_no')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="account_no" id="account_no" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="ref_1">{{__('bill.detail.repayment.ref_1')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="ref_1" id="ref_1" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="ref_2">{{__('bill.detail.repayment.ref_2')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="ref_2" id="ref_2" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="ref_3">{{__('bill.detail.repayment.ref_3')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="ref_3" id="ref_3" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="row p-3">
                            <div class="col-3 text-left">
                                <label for="remarks">{{__('bill.detail.repayment.remarks')}}</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" name="remarks" id="remarks" placeholder="{{__('bill.detail.repayment.required')}}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </section>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
    {!! JsValidator::formRequest('App\Http\Requests\ManualRepaymentBillRequest','#repayment_form') !!}
    <script>

        $(document).ready(function() {

            $('input[name=transaction_date]').mask('0000-00-00', { placeholder: '____-__-__' });

            $('input[name=transaction_time]').mask('00:00:00', { placeholder: '__:__:__' });

            $('#resend').on('click', function() {

                const inputOptions = new Promise((resolve) => {
                    setTimeout(() => {
                        resolve({
                            'SMS': 'SMS',
                            'EMAIL': 'Email'
                        })
                    }, 100)
                })

                Swal.queue([{
                    title: 'Resend an invoice',
                    confirmButtonText: 'Next &rarr;',
                    text: 'Please select channel',
                    input: 'radio',
                    inputOptions,
                    inputValidator: (result) => {
                        return !result && 'Please select an option above'
                    },
                    preConfirm: (data) => {
                        return new Promise(function (resolve) {
                            const queue = {
                                title: 'Resend an invoice',
                                input: 'text',
                                inputValidator: (value) => {
                                    if (!value) {
                                        return 'Please fill out this field'
                                    }
                                }
                            }
                            if (data === 'SMS') {
                                queue.text = 'Please enter mobile number',
                                queue.inputValue = "{{ isset($data->telephone) ? $data->telephone : '' }}"
                            } else if ( data === 'EMAIL' ) {
                                queue.text = 'Please enter email',
                                queue.inputValue = "{{ isset($data->email) ? $data->email : '' }}"
                                queue.inputAttributes = {
                                    disabled: 'disabled'
                                }
                            }
                            Swal.insertQueueStep(queue)
                            resolve()
                        })
                    }
                }]).then((result) => {
                    $.blockUI()
                    console.log('Confirm', { result: result.value })

                    if ( result.value ) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ URL("Bill/request/notify-send") }}',
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
                            if (!!result.success) {
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Someting wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Someting wrong.', 'error')
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
                    width: '90%',
                    onOpen: (ev) => {
                        console.log('initial')

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
                    $.blockUI()
                    console.log('Input', { result: result.value })

                    if ( result.value ) {
                        const data = $('#repayment_form').serializeObject()
                        data._token = `{{ csrf_token() }}`
                        data.reference_code = $(__btn).data('bill')
                        data.customer_code = $(__btn).data('customer')

                        $.ajax({
                            type: 'POST',
                            url: '{{ URL("Bill/request/repayment") }}',
                            data
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
        
        })

    </script>
@endsection