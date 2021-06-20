@extends('argon_layouts.app', ['title' => __('Bill Create')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.index.create')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="col-xl-12">
            <form id="form_bill_invoice" class="item-form" action="{{ url('Bill/Create')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h4 class="card-title">{{__('bill.index.information')}}</h4>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>{{__('bill.import.corporate_branch')}}</label>
                                                    </div>
                                                    <div class="col-6">
                                                        <select class="form-control" name="branch_code" id="branch_code">
                                                            @if(isset($branch))
                                                                @foreach($branch as $list)
                                                                    @if(app()->getLocale() == 'th')
                                                                    <option value="{{ $list->branch_code }}">{{ $list->name_th }}</option>
                                                                    @else
                                                                    <option value="{{ $list->branch_code }}">{{ $list->name_en }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h4 class="mb-3 card-header-with-border">{{__('bill.index.bill_information')}}</h4>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.batch_name')}} </label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="batch_name" placeholder="" class="form-control select-append" value="{{ old('batch_name') != null ? old('batch_name') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.batch_description')}} </label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="batch_description" placeholder="" class="form-control select-append" value="{{ old('batch_description') != null ? old('batch_description') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.invoice_number')}} <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="invoice_number" placeholder="" class="form-control select-append" value="{{ old('invoice_number') != null ? old('invoice_number') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.customer_code')}} <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="recipient_code" placeholder="" class="form-control select-append" value="{{ old('recipient_code') != null ? old('recipient_code') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.currency')}} <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="currency" placeholder="" class="form-control select-append" value="{{ old('currency') != null ? old('currency') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.amount')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_amount" placeholder="" class="form-control select-append" value="{{ old('bill_amount') != null ? old('bill_amount') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.discount')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_discount" placeholder="" class="form-control select-append" value="{{ old('bill_discount') != null ? old('bill_discount') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.fee')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_fee" placeholder="" class="form-control select-append" value="{{ old('bill_fee') != null ? old('bill_fee') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.net_amount')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="net_amount" placeholder="" class="form-control select-append" value="{{ old('net_amount') != null ? old('net_amount') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.vat')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_vat" placeholder="" class="form-control select-append" value="{{ old('bill_vat') != null ? old('bill_vat') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.total_amont_vat')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_total_vat_amount" placeholder="" class="form-control select-append" value="{{ old('bill_total_vat_amount') != null ? old('bill_total_vat_amount') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.total_amount')}} <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="bill_total_amount" placeholder="" class="form-control select-append" value="{{ old('bill_total_amount') != null ? old('bill_total_amount') : '' }}">
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.due_date')}} <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" name="bill_due_date" id="bill_due_date" class="form-control" autocomplete="off" placeholder="{{__('bill.confirm_bill.select_date')}}" datepicker-popup="d/m/Y" ng-model="fromDate" value="{{ old('bill_due_date') != null ? old('bill_due_date') : '' }}"/>
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
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.ref_1')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_1" placeholder="" class="form-control select-append" value="{{ old('ref_1') != null ? old('ref_1') : ''}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.ref_2')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_2" placeholder="" class="form-control select-append" value="{{ old('ref_2') != null ? old('ref_2') : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12 no-item">
                                                        <label for="" class="form-control-label">{{__('bill.confirm_bill.item')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(null !== old('bill_payment_item'))
                                        @php $i = 0; @endphp
                                        @foreach(old('bill_payment_item') as $bill_item)
                                            <div class="new-item">
                                                @if($i != 0)
                                                    <div class="d-flex flex-wrap">
                                                        <div class="p-2 flex-fill w-50">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-12 no-item d-flex justify-content-between">
                                                                        <label id="item-no" for="" class="form-control-label">{{__('bill.confirm_bill.item')}}</label>
                                                                        <button onclick="removeItem(this)" type="button" class="list-inline btn btn-danger text-uppercase">
                                                                            <i class="ni ni-fat-remove font21px"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="d-flex flex-wrap">
                                                    <div class="p-2 flex-fill w-50">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_name')}} <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_name]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_name'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 flex-fill w-50">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_quatity')}} <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_qty]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_qty'] ?? '' }}">
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
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_vat')}}</label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_vat]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_vat'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 flex-fill w-50">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_fee')}}</label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_fee]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_fee'] ?? '' }}">
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
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_amount')}} </label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_amount]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_amount'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-2 flex-fill w-50">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12">                        
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_discount')}}</label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_discount]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_discount'] ?? '' }}">
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
                                                                    <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_amount')}}<span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input type="text" id="" name="bill_payment_item[{{$i}}][item_total_amount]" placeholder="" class="form-control select-append" value="{{ $bill_item['item_total_amount'] ?? ''}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                            @php $i++ @endphp
                                        @endforeach
                                    @else
                                        <div class="d-flex flex-wrap">
                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_name')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_name]" placeholder="" class="form-control select-append" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_quatity')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_qty]" placeholder="" class="form-control select-append" value="">
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
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_vat')}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_vat]" placeholder="" class="form-control select-append" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_fee')}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_fee]" placeholder="" class="form-control select-append" value="">
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
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_amount')}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_amount]" placeholder="" class="form-control select-append" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_discount')}}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input type="text" id="" name="bill_payment_item[0][item_discount]" placeholder="" class="form-control select-append" value="">
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
                                                            <label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_amount')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" id="" name="bill_payment_item[0][item_total_amount]" placeholder="" class="form-control select-append" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <hr/>
                                    <div class="extend-item">
                                        
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50 text-center">
                                            <button onclick="addItem()" type="button" class="btn btn-success text-uppercase form-control" style="text-decoration: none;">
                                                <i class="ni ni-fat-add pr-2 font21px align-top"></i><span>{{__('bill.confirm_bill.add_item')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                <div class="text-center">
                                    <a href="{{ URL::to('/Bill')}}" id="btn_cancel" class="btn btn-warning mt-3">{{__('common.cancel')}}</a>
                                    <button type="submit" id="btn_submit" class="btn btn-success mt-3">{{__('common.create')}}</button>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
<script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

<script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

{!! JsValidator::formRequest('App\Http\Requests\BillInvoiceCreate','#form_bill_invoice') !!}
<script type="text/javascript">
    $(document).ready(function(){
        $("#bill_due_date").datepicker({
            todayBtn: "linked",
            language: "it",
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy' 
        });
    });
    
    $.validator.addMethod("regx", function(value, element, regexpr) {
        return this.optional(element) || regexpr.test(value);
    });

    function addItem()
    {
        var index = parseInt($(".no-item").length);
        // var next  = index+1;

        var html = '<div class="new-item"><div class="d-flex flex-wrap">'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12 no-item d-flex justify-content-between">'+
                                        '<label id="item-no" for="" class="form-control-label">{{__('bill.confirm_bill.item')}}</label>'+
                                        '<button onclick="removeItem(this)" type="button" class="list-inline btn btn-danger text-uppercase">'+
                                            '<i class="ni ni-fat-remove font21px"></i>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="d-flex flex-wrap">'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_name')}} <span class="text-danger">*</span></label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_name]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_quatity')}} <span class="text-danger">*</span></label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_qty]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="d-flex flex-wrap">'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_vat')}}</label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_vat]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_fee')}}</label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_fee]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="d-flex flex-wrap">'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_amount')}}</label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_amount]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_discount')}}</label>'+
                                    '</div>'+
                                    '<div class="col-12">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_discount]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="d-flex flex-wrap">'+
                        '<div class="p-2 flex-fill w-50">'+
                            '<div class="form-group">'+
                                '<div class="row">'+
                                    '<div class="col-12">'+
                                        '<label for="" class="form-control-label">{{__('bill.confirm_bill.item_total_amount')}} <span class="text-danger">*</span></label>'+
                                    '</div>'+
                                    '<div class="col-6">'+
                                        '<input type="text" id="" name="bill_payment_item['+index+'][item_total_amount]" placeholder="" class="form-control select-append">'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<hr/>'+
                    '</div>';

        $(".extend-item").append(html);
        
        var bill_payment = $('input[name^="bill_payment_item"]');
        
        bill_payment.filter('input[name$="[item_name]"]').each(function() {
            $(this).rules("add", {
                required: true,
                maxlength: 100,
                messages: {
                    required: "{{__('validation.required',['attribute' => 'Item Name'])}}",
                    maxlength: "{{__('validation.max.string',['attribute' => 'Item Name'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_qty]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "{{__('validation.required',['attribute' => 'Item Quantity'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_vat]"]').each(function() {
            $(this).rules("add", {
                regx: /^([0-9\,\.]){1,16}$/,
                messages: {
                    regx: "{{__('validation.regex',['attribute' => 'Item Total Vat'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_fee]"]').each(function() {
            $(this).rules("add", {
                regx: /^([0-9\,\.]){1,16}$/,
                messages: {
                    regx: "{{__('validation.regex',['attribute' => 'Item Total Fee'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_amount]"]').each(function() {
            $(this).rules("add", {
                regx: /^([0-9\,\.]){1,16}$/,
                messages: {
                    regx: "{{__('validation.regex',['attribute' => 'Item Amount'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_discount]"]').each(function() {
            $(this).rules("add", {
                regx: /^([0-9\,\.]){1,16}$/,
                messages: {
                    regx: "{{__('validation.regex',['attribute' => 'Item Discount'])}}"
                }
            });
        });
        
        bill_payment.filter('input[name$="[item_total_amount]"]').each(function() {
            $(this).rules("add", {
                required: true,
                regx: /^([0-9\,\.]){1,16}$/,
                messages: {
                    required: "{{__('validation.required',['attribute' => 'Item Total Amount'])}}",
                }
            });
        });

    }

    function removeItem(elem_this) {
        console.log('In removeItem '+elem_this)
        $(elem_this).closest(".new-item").remove();
    }
</script>
@endsection