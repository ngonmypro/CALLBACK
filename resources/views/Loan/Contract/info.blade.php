@extends('argon_layouts.app', ['title' => __('loan_contract.info.title')])

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/extensions/dropzone/4.3.0/dropzone.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker-v2/daterangepicker.css') }}" />

<style type="text/css">
    .ui-timepicker-standard {
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
    iframe body {
        text-align: center;
    },
    a {
        text-decoration: none;
        color: inherit;
    },
</style>
@endsection

@section('content')

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{__('leftmenu.loan')}}</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ url('Loan/Contract')}}" class="btn btn-neutral">{{__('common.back')}}</a>
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
                        <div class="col-md-6 col-xs-12">
                            <span class="mb-0 h3 d-inline">{{__('loan_contract.info.application_info')}}</span>
                            <span class="text-sm mb-0">
                                <?php 
                                    $__badge = [
                                        'ACTIVE'        => 'primary',
                                        'APPROVAL'      => 'info',
                                        'REJECTED'      => 'danger',
                                        'NEW'           => 'warning'
                                    ];
                                    $__status = [
                                        'ACTIVE'        => trans('common.active'),
                                        'APPROVAL'      => trans('common.approval'),
                                        'REJECTED'      => trans('common.rejected'),
                                        'NEW'           => trans('common.new'),
                                        'CLOSED'        => trans('common.closed'),
                                    ];
                                ?>
                                @if (isset($__badge[$contract->status]))
                                    <span class="badge badge-{{ $__badge[$contract->status] }}">{{ isset($__status[$contract->status]) 
                                                                                                        ? $__status[$contract->status]
                                                                                                        : $contract->status }}</span>
                                @else
                                    <span class="badge badge-info">{{ isset($__status[$contract->status]) 
                                                                                                        ? $__status[$contract->status]
                                                                                                        : $contract->status }}</span>
                                @endif
                            </span>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">

                            @if (isset($contract->status) && $contract->status === 'NEW')
            
                                @Permission(LOAN_MANAGEMENT.APPROVE_APPLICATION)
                                    <div class="d-inline mb-3 py-3 px-1 h4 action-btn">
                                        <a href="#btn_approve" id="btn_approve" class="btn btn-success pt-2 pb-2" style="margin-top: -10px;">
                                            <span>{{__('common.approve')}}</span>
                                        </a>
                                    </div>
                                @EndPermission
            
                                @Permission(LOAN_MANAGEMENT.REJECT_APPLICATION)
                                    <div class="d-inline mb-3 py-3 px-1 h4 action-btn">
                                        <a href="#btn_reject" id="btn_reject" class="btn btn-warning pt-2 pb-2" style="margin-top: -10px;">
                                            <span>{{__('common.reject')}}</span>
                                        </a>
                                    </div>
                                @EndPermission

                            @elseif ( isset($contract->status) && $contract->status === 'APPROVAL' )

                                @Permission(LOAN_MANAGEMENT.REJECT_APPLICATION)
                                    <div class="d-inline mb-3 py-3 px-1 h4 action-btn">
                                        <a href="#btn_reject" id="btn_reject" class="btn btn-warning pt-2 pb-2" style="margin-top: -10px;">
                                            <span>{{__('common.reject')}}</span>
                                        </a>
                                    </div>
                                @EndPermission
                                
                            @endif
                
                            @if (isset($contract->status) && in_array($contract->status, ['APPROVAL', 'NEW']))

                                @Permission(LOAN_MANAGEMENT.EDIT_APPLICATION)
                                <div class="d-inline mb-3 py-3 px-1 h4 action-btn">
                                    <a href="{{ action('Loan\ContractController@UpdateContract', ['contract_code' => $contract_code]) }}" class="btn btn-primary pt-2 pb-2" style="margin-top: -10px;">
                                        <span>{{__('common.edit')}}</span>
                                    </a>
                                </div>
                                @EndPermission

                            @endif

                            @if ( isset($contract->status) && in_array($contract->status, ['ACTIVE', 'APPROVAL']) )
                                <div class="d-inline mb-3 py-3 px-1 h4">
                                    <button id="repayment" class="btn btn-success pt-2 pb-2" style="margin-top: -10px;">
                                        <span>{{ __('loan_contract.info.button_repayment') }}</span>
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="card-body">

                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-contract_name')}}</label>
                                        </div>
                                        <div class="col-12">
                                            {{-- <input type="text" id="" name="contract_name" placeholder="" class="form-control required-checked" value="" data-type=""> --}}
                                            <label for="" class=" form-control-label">{{ isset($contract->contract_name) ? $contract->contract_name : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class="form-control-label">{{__('loan_contract.info.field-contract_item')}}</label>
                                        </div>
                                        <div class="col-12">
                                            {{-- <input type="text" id="" name="contract_item" placeholder="" class="form-control required-checked" value="" data-type=""> --}}
                                            <label for="" class=" form-control-label">{{ isset($contract->contract_item) ? $contract->contract_item : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-amount')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->amount) ? number_format($contract->amount, 2, '.', ',') : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-outstanding_balance')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->outstanding_balance) ? number_format($contract->outstanding_balance, 2, '.', ',') : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-monthly_installment')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->monthly_installment_amount) ? number_format($contract->monthly_installment_amount, 2, '.', ',') : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-contract_period')}}</label>
                                        </div>
                                        <div class="col-12">
                                            {{-- <input type="text" id="period" name="period" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly"> --}}
                                            <label for="" class=" form-control-label">{{ isset($contract->period) ? (int)$contract->period : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-total_amount')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->total_amount) ? number_format($contract->total_amount, 2, '.', ',') : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-currency')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->currency) ? $contract->currency : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-recipient')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <a href="{{ url('/Recipient/Profile/'.$contract->customer_code)}}">
                                                {{ isset($contract->customer_code) ? __('loan_contract.info.field-goto_recipient_detail') : '-' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-delivery_date')}}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($contract->delivery_date) ? date('Y-m-d, Hi', strtotime($contract->delivery_date)) : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex flex-wrap">

                            @if ( isset($contract->description) && is_object($contract->description) )
                                @foreach ( (array)$contract->description as $key => $val )
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">        
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ str_replace('_', ' ', ucwords($key)) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ !blank($val) ? $val : '-' }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    
                        <div class="d-flex flex-wrap">
                            <div class="p-2 w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{__('loan_contract.info.field-contact_address')}}</label>
                                        </div>
                                        <div class="col-12">
                                            @if (isset($contract->recipient->address) && isset($contract->recipient->zipcode) && isset($contract->recipient->state))
                                                @php 
                                                    $address = $contract->recipient->address . ' ' . $contract->recipient->zipcode . ' ' .$contract->recipient->state;
                                                    $address = trim($address);
                                                @endphp
                                                <label for="" class=" form-control-label">{{ $address }}</label>
                                            @else 
                                                <label for="" class=" form-control-label">{{ '-' }}</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3">
                                    <span>{{__('loan_contract.info.field-document_list')}}</span>
                    
                                    @Permission(LOAN_MANAGEMENT.UPLOAD_DOCUMENT)
                                    <div class="float-right">
                                        <div class="d-inline mb-3 py-3 h4">
                                            <a id="btn_upload_document" href="#btn_upload_document" class="btn btn-primary pt-2 pb-2" style="margin-top: -10px;">
                                                <span>{{__('loan_contract.info.field-upload_document_btn')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    @EndPermission
                    
                                </h4>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                    
                                            @Permission(LOAN_MANAGEMENT.VIEW_DOCUMENT)
                                            <table class="table simple-table" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">{{__('loan_contract.info.field-file_upload_at')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-file_name')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-file_option')}}</th>
                                                </tr>
                                                </thead>
                    
                                                @if (isset($contract->document) && count($contract->document) > 0)
                    
                                                    <tbody>
                                                        @foreach ($contract->document as $item)
                                                            {{-- {{ print_r($item) }} --}}
                                                            <tr role="row">
                                                                <td class="text-center">{{ isset($item->created_at) ? date('Y-m-d', strtotime($item->created_at)) : '-' }}</td>
                                                                <td class="text-center">{{ $item->doc_name != '' ? $item->doc_name : 'ไม่ระบุ' }}</td>
                                                                <td class="text-center">
                                                                    <a role="button" onclick="opendoc(`{{ action('Loan\ContractController@GetDocument', ['code' => $item->code ]) }}?type={{ $item->doc_type }}`)">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                                @else
                                                    <tbody>
                                                        <tr role="row">
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            </table>
                                            @EndPermission
                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3">{{__('loan_contract.info.field-bill_transaction_title')}}</h4>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table simple-table" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_created_date')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_reference')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_amount')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_due_date')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_overdue')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_payment_date')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_payment_status')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_status')}}</th>
                                                    <th class="text-center">{{__('loan_contract.info.field-bill_download')}}</th>
                                                </tr>
                                                </thead>
                    
                                                {{-- {{ print_r($contract->bill) }} --}}
                                                @if (isset($contract->bill) && count($contract->bill) > 0 && $contract->status != 'NEW' )
                    
                                                    <?php 
                                                        $bill_status = array(
                                                            "SUCCESS"   => "success",
                                                            "OVERDUE"   => "danger",
                                                            "CANCEL"    => "warning",
                                                            "ISSUED"    => "info",
                                                            "PENDING"   => "primary",
                                                            "NEW"       => "primary"
                                                        );
                                                        $bill_title = [
                                                            "SUCCESS"   => trans('common.success'),
                                                            "OVERDUE"   => trans('common.overdue'),
                                                            "CANCEL"    => trans('common.cancel'),
                                                            "PENDING"   => trans('common.pending'),
                                                            "NEW"       => trans('common.new')
                                                        ];
                                                        $payment_status = [
                                                            'PENDING'   => 'warning',
                                                            'PAID'      => 'success',
                                                            'FAILED'    => 'danger'
                                                        ];
                                                        $payment_title = [
                                                            'PENDING'   => trans('common.pending'),
                                                            'PAID'      => trans('common.paid'),
                                                            'FAILED'    => trans('common.failed')
                                                        ];
                                                    ?>
                                                    <tbody>
                                                        @foreach ($contract->bill as $item)
                                                            <tr role="row">
                                                                <td class="text-center" style="width: 150px;">{{ date('Y-m-d', strtotime($item->issue_date)) }}</td>
                                                                <td class="text-center" style="width: 230px;">{{ isset($item->reference_code) ? $item->reference_code : ' - ' }}</td>
                                                                <td class="text-center">{{ number_format($item->bill_amount, 2, '.', ',') }}</td>
                                                                <td class="text-center" style="width: 150px;">{{ $item->bill_due_date }}</td>
                                                                <td class="text-center">
                                                                    <span class="role badge badge-{{$item->bill_is_overdue == true ? 'danger' : 'success' }}">{{ $item->bill_is_overdue == true ? trans('common.overdue_yes') : trans('common.overdue_no') }}</span>
                                                                </td>
                                                                <td class="text-center" style="width: 150px;">{{ isset($item->payment_date_time) ? date('Y-m-d', strtotime($item->payment_date_time)) : ' - ' }}</td>
                                                                @if (!blank($item->payment_status))
                                                                <td class="text-center" style="width: 150px;">
                                                                    <span class="role badge badge-{{ isset($payment_status[$item->payment_status]) ? $payment_status[$item->payment_status]: 'secondary' }}" 
                                                                        data-toggle="popover" 
                                                                        data-placement="top" 
                                                                        data-content="">{{ isset($payment_title[$item->payment_status]) 
                                                                                                        ? $payment_title[$item->payment_status]
                                                                                                        : $item->payment_status }}</span>
                                                                </td>
                                                                @else
                                                                <td class="text-center" style="width: 150px;">
                                                                    <span class="role" data-toggle="popover" data-placement="top" data-content="">{{ $item->payment_status === null ? '-' : $item->payment_status }}</span>
                                                                </td>
                                                                @endif
                                                                <td class="text-center">
                                                                    <span class="role badge badge-{{ isset($bill_status[$item->bill_status]) 
                                                                                                        ? $bill_status[$item->bill_status]
                                                                                                        : 'secondary' }}" 
                                                                        data-toggle="popover" 
                                                                        data-placement="top" 
                                                                        data-content="">{{ isset($bill_title[$item->bill_status]) 
                                                                                                        ? $bill_title[$item->bill_status]
                                                                                                        : $item->bill_status }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a onclick="opendoc(`{{ action('Loan\ContractController@bill_download', ['contract_code' => $contract_code, 'ref' => $item->reference_code]) }}?type=pdf`)">
                                                                        <i class="fa fa-file" aria-hidden="true"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                                @else
                                                    <tbody>
                                                        <tr role="row">
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3">
                                    <span>{{__('loan_contract.info.field-unbilled_title')}}</span>
                                    <div class="float-right">
                                        <div class="d-inline mb-3 py-3 h4">
                                            <a id="add_bill_item" href="#add_bill_item" class="btn btn-primary pt-2 pb-2" style="margin-top: -10px;">
                                                <span>{{__('loan_contract.info.field-unbilled_add')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table simple-table" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">{{__('loan_contract.info.field-unbilled_date')}}</th>
                                                        <th class="text-center">{{__('loan_contract.info.field-unbilled_name')}}</th>
                                                        <th class="text-center">{{__('loan_contract.info.field-unbilled_desc')}}</th>
                                                        <th class="text-center">{{__('loan_contract.info.field-unbilled_amount')}}</th>
                                                    </tr>
                                                </thead>
                                                @if(isset($contract->unbill))
                                                    <tbody>
                                                        @foreach ($contract->unbill as $item)
                                                            <tr role="row">
                                                                <td class="text-center">{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                                                <td class="text-center">{{ $item->item_name }}</td>
                                                                <td class="text-center">{{ $item->description }}</td>
                                                                <td class="text-center">{{ number_format($item->item_type == 'DISCOUNT' ? $item->item_price*-1 : $item->item_price, 2, '.', ',') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                @else
                                                    <tbody>
                                                    <tr role="row">
                                                        <td class="text-center sorting_1"> - </td>
                                                        <td class="text-center"> - </td>
                                                        <td class="text-center"> - </td>
                                                        <td class="text-center"> - </td>
                                                    </tr>
                                                    </tbody>
                                                @endif
                                            </table>
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

<section class="d-none" id="initForm">
    <form id="repayment_form" class="" method="POST" action="{{ action('Loan\ContractController@Repayment') }}" enctype="multipart/form-data">
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

                    

                @endif

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">

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
                                    <input type="text" class="form-control" name="payment_channel" id="payment_channel" placeholder="{{__('bill.detail.repayment.required')}}">
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

@include('layouts.footer_progress')
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\LoanRepaymentRequest','#repayment_form') !!}
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/moment.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker-v2/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jquery.mask.js') }}"></script>   
    <script type="text/javascript" src="{{ asset('assets/js/extensions/dropzone/4.3.0/dropzone.js') }}"></script>
    <script type="text/javascript">

        const createCaurosel = (slips) => {
            return `
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="row p-3">

                        <div id="payslip" class="carousel slide border rounded col-12 p-0" data-ride="carousel" data-interval="false">
                            <div class="carousel-inner">

                                ${slips}
                                
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
            `
        } 

        const createImgCaurosel = (img, active = true) => {
            return `
                <div class="carousel-item">
                    <img class="d-block w-100" src="${img}">
                </div>
            `
        }

        const loadBills = async () => {

            return new Promise( (resolve, reject) => {
                $.ajax({
                    type: 'POST',
                    url: '{{ action("Loan\ContractController@loadBills") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        contract_code: "{{ $contract_code }}"
                    }
                }).done(function(result) {
                    
                    resolve(result)

                }).fail(function(err) {

                    reject(err)

                })
            })
            
        }

        const createBillRadio = (data, checked) => {

            let dueDate = data.bill_due_date || null
            if ( dueDate ) {
                const dt = (new Date(dueDate).getTime() / 1000).toFixed(0)
                if (data === null || data === '') {
                    dueDate = '-'
                } else if ( !moment(dueDate).isValid() ) {
                    dueDate = '-'
                } else {
                    dueDate = moment.unix(dt).format('YYYY-MM-DD')
                }
            } else {
                dueDate = '-'
            }
            
            return `
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="radio-${data.reference_code}" name="radio_reference_code" class="custom-control-input radio_reference_code" value="${data.reference_code}" ${checked ? 'checked' : ''}>
                    <label class="custom-control-label text-left" for="radio-${data.reference_code}">
                        <div class="row">
                            <div class="col-12">
                                <b>${data.reference_code}</b>
                            </div>
                            <div class="col-6">
                                <small>Payment</small><pre><i>${_.ucwords(data.payment_status || '')}</i></pre>
                            </div>
                            <div class="col-6">
                                <small>Bill</small><pre><i>${_.ucwords(data.bill_status || '')}</i></pre>
                            </div>
                            <div class="col-6">
                                <small>Due date</small><pre><i>${dueDate}</i></pre>
                            </div>
                        </div>
                    </label>
                </div>
            `
        }

        const createTransactionRadio = (data, checked) => {

            let txnDate = data.transaction_date || null
            if ( txnDate ) {
                const dt = (new Date(txnDate).getTime() / 1000).toFixed(0)
                if (data === null || data === '') {
                    txnDate = '-'
                } else if ( !moment(txnDate).isValid() ) {
                    txnDate = '-'
                } else {
                    txnDate = moment.unix(dt).format('YYYY-MM-DD')
                }
            } else {
                txnDate = '-'
            }

            return `
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" id="radio-${data.transaction_id}" name="radio_txn_id" class="custom-control-input radio_txn_id" value="${data.transaction_id}" ${checked ? 'checked' : ''}>
                    <label class="custom-control-label text-left" for="radio-${data.transaction_id || '-'}">
                        <div class="row">
                            <div class="col-6">
                                <small>Transaction</small><pre><i>${data.transaction_id || '-'}</i></pre>
                            </div>
                            <div class="col-6">
                                <small>Status</small><pre><i>${_.ucwords(data.payment_status || '-')}</i></pre>
                            </div>
                            <div class="col-6">
                                <small>Reason</small><pre><i>${data.payment_reason || '-'}</i></pre>
                            </div>
                            <div class="col-6">
                                <small>Transaction date</small><pre><i>${txnDate}</i></pre>
                            </div>
                        </div>
                    </label>
                </div>
            `
        }

        function opendoc(url)
        {
            var html = ''
            const type = (new URL(url)).searchParams.get('type')
            if (['pdf', 'docx', 'doc'].indexOf(type) === -1) {
                html = `<div style="height:600px;"><image src="${url}" style="max-width:100%; max-height: 100%; display: block; margin: 0 auto;"/></div>`
            } else {
                html = `<iframe height="600" width="100%" src="${url}" style="border:none"></iframe>`
            }
            Swal.fire({
                html
            })
        }

        function SubmitForm() {
            $('#pending_item').ajaxSubmit({
                success: function (responseData) {
                    if (responseData.success === true) {
                        console.log(responseData.message)
                        location.reload()
                    } else {
                        const head = GetModalHeader('{{ (__("loan_contract.info.unbill-add_btn")) }}')
                        const body = `<div class="p-3">${responseData.message}</div>`
                        OpenAlertModal(head, body, null)
                        console.error('error: ', responseData.message)
                    }
                },
                error: function (responseData) {
                    const head = GetModalHeader('{{ (__("loan_contract.info.unbill-add_btn")) }}')
                    const body = responseData.message
                    OpenAlertModal(head, body, null)
                    console.error('error: ', responseData.message)
                }
            });
        }
        
    </script>
    <script>

        Dropzone.autoDiscover = false
        const dropzoneOptions = {
            url: "{{ action('Loan\ContractController@Repayment') }}",
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
                        title: '', 
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
            
            $('[data-toggle="popover"]').popover({
                'trigger': 'hover',
                'placement': 'top',
                'container': 'body'
            })
            
            // APPROVE SUBMIT
            $('#btn_approve').on('click', function(e) {
                e.preventDefault()

                Swal.fire({
                    title: "{{ (__('common.ask-for-confirm')) }}",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "{{ (__('common.cancel')) }}",
                    cancelButtonClass: "btn btn-secondary",
                    buttonsStyling: !1,
                    confirmButtonClass: "btn btn-warning",
                    confirmButtonText: "{{ (__('common.confirm')) }}",
                    reverseButtons: true,
                    focusCancel: true
                }).then(function(result) {
                    if ( result.value ) {
                        $.blockUI()

                        $.ajax({
                            type: 'POST',
                            url: '{{ action("Loan\ContractController@loan_approve", ["contract_code" => $contract_code]) }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if (!!result.success) {
                                Swal.fire(`{{ (__('common.success')) }}`, `{{ (__('loan_contract.error.status_success', ['status' => 'Approval'])) }}`, 'success').then(function() {
                                    window.location.reload()
                                })
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(`{{ (__('common.error')) }}`, result.message, 'error').then(function() {
                                    window.location.reload()
                                })
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, `{{ (__('loan_contract.error.status_failed', ['status' => 'Approval'])) }}`, 'error').then(function() {
                                window.location.reload()
                            })
                        })
                    }
                })

                
            })

            // REJECT SUBMIT
            $('#btn_reject').on('click', function(e) {
                e.preventDefault()

                Swal.fire({
                    title: "{{ (__('common.ask-for-confirm')) }}",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "{{ (__('common.cancel')) }}",
                    cancelButtonClass: "btn btn-secondary",
                    buttonsStyling: !1,
                    confirmButtonClass: "btn btn-warning",
                    confirmButtonText: "{{ (__('common.confirm')) }}",
                    reverseButtons: true,
                    focusCancel: true
                }).then(function(result) {
                    if ( result.value ) {
                        $.blockUI()

                        $.ajax({
                            type: 'POST',
                            url: '{{ action("Loan\ContractController@loan_reject", ["contract_code" => $contract_code]) }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                Swal.fire(`{{ (__('common.success')) }}`, `{{ (__('loan_contract.error.status_success', ['status' => 'Rejected'])) }}`, 'success').then(function() {
                                    window.location.reload()
                                })
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(`{{ (__('common.error')) }}`, result.message, 'error').then(function() {
                                    window.location.reload()
                                })
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, `{{ (__('loan_contract.error.status_failed', ['status' => 'Rejected'])) }}`, 'error').then(function() {
                                window.location.reload()
                            })
                        })
                    }
                })

                
            })

            // OPEN UPLOAD DOCUMENT MODAL
            $(document).on('click', '#btn_upload_document', async function() {
                const inputOptions = {
                    'FILE': "{{ (__('common.browse_file')) }}",
                    'URL': "{{ (__('common.file_url')) }}",
                }
                const { value: type } = await Swal.fire({
                    title: "{{ (__('common.please_select_radio', ['radio' => 'type'])) }}",
                    input: 'radio',
                    inputOptions: inputOptions,
                    inputValidator: (value) => {
                        if (!value) {
                            return "{{ (__('common.validate.please_select_radio', ['radio' => 'type'])) }}"
                        }
                    }
                })
                if (type) {

                    if (type === 'FILE') {

                        // OPEN DIALOG FILE BROWSE
                        // const { value: file } = await Swal.fire({
                        Swal.fire({
                            title: "{{ (__('common.please_select_file')) }}",
                            input: 'file',
                            inputAttributes: {
                                accept: '.pdf,image/*,.doc,.docx',
                            },
                            inputValidator: (value) => {
                                if (!value) {
                                    return "{{ (__('common.validate.please_select_file')) }}"
                                }
                            }
                        }).then((file) => {

                            // On file has been selected
                            if (file.value) {
                                $.blockUI()

                                // file extension from input file
                                const extension = file.value.name.split('.').pop().toLowerCase()
                                    
                                // check is extension pdf type
                                const isPdf = (['pdf','doc','docx']).indexOf(extension) !== -1
                                
                                var formData = new FormData()
                                formData.append('document_file', file.value)
                                formData.append('_token', `{{ csrf_token() }}`)
                                $.ajax({
                                    method: 'post',
                                    url: `{{ URL("/Loan/Contract/UploadDocument/".$contract_code) }}`,
                                    enctype: 'multipart/form-data',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (response) {
                                        // console.log('response: ', response)
                                        if (!response.success) {
                                            console.error('Error: ', response.message || '')
                                            var message = response.message || ''
                                            Swal.fire("{{ (__('common.fail')) }}", message, 'error').then(function() {
                                                $.unblockUI()
                                                window.location.reload()
                                            })
                                        } else if (!isPdf) {
                                            const reader = new FileReader()
                                            reader.onload = (e) => {
                                                Swal.fire({
                                                    title: "{{ (__('common.success')) }}",
                                                    imageUrl: e.target.result,
                                                    type: 'success'
                                                }).then(function() {
                                                    $.unblockUI()
                                                    window.location.reload()
                                                })
                                            }
                                            reader.readAsDataURL(file.value)
                                        } else {
                                            Swal.fire({
                                                title: "{{ (__('common.success')) }}",
                                                type: 'success'
                                            }).then(function() {
                                                $.unblockUI()
                                                window.location.reload()
                                            })
                                        }
                                    },
                                    error: function(err) {
                                        console.error('Error: ', err)
                                        var message = err.responseJSON.message || ''
                                        Swal.fire("{{ (__('common.fail')) }}", message, 'error').then(function() {
                                            $.unblockUI()
                                            window.location.reload()
                                        })
                                    }
                                })
                                
                            }
                            
                        })
                        
                    } else if (type === 'URL') {

                        // OPEN DIALOG INPUT
                        const { value: url } = await Swal.fire({
                            title: "{{ (__('common.please_type', ['input' => 'URL'])) }}",
                            input: 'text',
                            inputValidator: (value) => {
                                if (!_.isURL(value)) {
                                    return "{{ (__('common.validate.please_valid_url')) }}"
                                }
                            }
                        })
                        if (url) {
                            $.blockUI()

                            // Set up form input
                            var formData = new FormData()
                            formData.append('document_url', url)
                            formData.append('_token', `{{ csrf_token() }}`)
                            $.ajax({
                                method: 'post',
                                url: `{{ URL("/Loan/Contract/UploadDocument/".$contract_code) }}`,
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    console.log('response: ', response)
                                    Swal.fire({
                                        title: "{{ (__('common.success')) }}",
                                        type: 'success'
                                    }).then(function() {
                                        $.unblockUI()
                                        window.location.reload()
                                    })
                                },
                                error: function(err) {
                                    console.error('Error: ', err)
                                    var message = err.responseJSON.message || ''
                                    Swal.fire("{{ (__('common.fail')) }}", message, 'error').then(function() {
                                        $.unblockUI()
                                        window.location.reload()
                                    })
                                }
                            })
                        }    
                    }
                    
                }
            })

            $(document).on('click', '#add_bill_item', async function() {
                const options = `
                    <option value="DEBT_TRACKING_FEE">{{ (__("loan_contract.info.unbill-option-calling_fee")) }}</option>
                    <option value="INST_UNPAID_FEE">{{ (__("loan_contract.info.unbill-option-unpaid_fee")) }}</option>
                    <option value="DISCOUNT">{{ (__("loan_contract.info.unbill-option-discount")) }}</option>
                `
                const html = `
                    <div class="row">
                        <div class="py-2 col-xs-12 offset-lg-1 col-lg-10 px-5" id="input-wrapper">
                            {{ csrf_field() }}
                            <input type="hidden" name="contract_code" data-name="Application No." value="{{$contract_code}}" />
                            <select id="swal-input1" class="swal2-select form-control" data-name="Item type" name="item_type" placeholder="{{ (__('loan_contract.info.placeholder-unbilled_item_type')) }}" style="width: 100%;">${options}</select>
                            <input type="text" id="swal-input2" class="swal2-input form-control" data-name="Description" placeholder="{{ (__('loan_contract.info.placeholder-unbilled_description')) }}" name="description" style="width: 100%;">
                            <input type="number" id="swal-input3" class="swal2-input form-control" data-name="Amount" name="item_price" placeholder="{{ (__('loan_contract.info.placeholder-unbilled_amount')) }}" style="width: 100%; max-width: 100%;">    
                        </div>    
                    </div>
                `
                const {value: formValues} = await Swal.fire({
                    title: '{{ (__("loan_contract.info.unbill-add_btn")) }}',
                    html,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: true,
                    reverseButtons: true,
                    cancelButtonText: "{{ (__('common.cancel')) }}",
                    confirmButtonText: "{{ (__('common.confirm')) }}",
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        var pleaseFill = []
                        $('#input-wrapper select, #input-wrapper input').each(function() {
                            const mandatory = ['item_type', 'item_price']
                            console.log('element: ', {
                                this: $(this),
                                val: $(this).val()
                            })
                            if ( ($(this).val() === '' || $(this).val() === null) && mandatory.indexOf($(this).attr('name')) !== -1 ) {
                                pleaseFill.push($(this).data('name'))
                            }
                        })
                        if (pleaseFill.length > 0) {
                            Swal.showValidationMessage(`Please fill in ${pleaseFill.join(', ')}`)
                        }
                    },
                })

                if (formValues) {
                    $.blockUI()
                    var formData = new FormData()
                    $('#input-wrapper select, #input-wrapper input').each(function() {
                        console.log('element: ', {
                            this: $(this),
                            val: $(this).val()
                        })
                        formData.append($(this).attr('name'), $(this).val())
                    })
                    $.ajax({
                        method: 'post',
                        url: `{{ URL::to('/Loan/Contract/CreatePendingItem') }}`,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log('response: ', response)
                            Swal.fire({
                                title: "{{ (__('common.success')) }}",
                                type: 'success'
                            }).then(function() {
                                $.unblockUI()
                                window.location.reload()
                            })
                        },
                        error: function(err) {
                            console.error('Error: ', err)
                            var message = err.responseJSON.message || ''
                            Swal.fire("{{ (__('common.fail')) }}", message, 'error').then(function() {
                                $.unblockUI()
                                window.location.reload()
                            })
                        }
                    })
                }
            })

            $('input[name=transaction_date]').mask('00/00/0000', { placeholder: 'DD/MM/YYYY' });

            $('input[name=transaction_time]').mask('00:00', { placeholder: 'HH:MM' });
        
            $('input[name="transaction_datetime"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                timePicker: true,
                startDate: moment().format("DD/MM/YYYY HH:mm"),
                locale: {
                    format: 'DD/MM/YYYY HH:mm' 
                }
            }, function(start, end, label) {
                var getDate = start.format('DD/MM/YYYY')
                var splitTime = start.format('HH:mm')

                var getDate = start.format('DD/MM/YYYY')
                var splitTime = start.format('HH:mm')

                $('input[name="transaction_date"]').val(getDate)
                $('input[name="transaction_time"]').val(splitTime)
            })

            var getDate = $('input[name="transaction_datetime"]').val()
            var splitTime = getDate.split(' ')

            $('input[name="transaction_date"]').val(splitTime[0])
            $('input[name="transaction_time"]').val(splitTime[1])

            $(document).on('click', '#repayment', async function() {
                $.blockUI()

                const { data } = await loadBills()
                    .then(data => {
                        return {
                            data: (data.bills || []).filter((item) => {
                                return item.payment_status !== 'PAID'
                            })
                        }

                    }).catch(err => {
                        console.error('error: ', err)

                        return {
                            data: []
                        }

                    }).finally(() => {
                        $.unblockUI()
                    })
                
                data.forEach(element => {

                    if ( typeof element.optional_data !== 'object' && !Array.isArray(element.optional_data.slips || null) ) {
                        return 
                    }
                    
                    if ( element.optional_data?.slips ) {
                        element.optional_data.slips.forEach(item => {
                            if ( !element.imgCaurosel ) {
                                element.imgCaurosel = ''
                            }

                            element.imgCaurosel = createImgCaurosel(element.image).trim()
                        })
                    }
                })

                // open select bill modal
                Swal.fire({
                    confirmButtonText: `{{ __('common.confirm') }}`,
                    showLoaderOnConfirm: true,
                    onOpen: () => {
                        if ( data && Array.isArray(data) && data.length !== 0 ) {
                            Swal.update({
                                showConfirmButton: true,
                                showCloseButton: false,
                                showCancelButton: false,
                                type: 'info',
                                title: `{{ __('loan_contract.info.please_select_bill') }}`,
                                html: data.map( (el, index) => {
                                    return `<div class="col-12 py-2" style="height: 150px;">${createBillRadio(el, index == 0 ? true : false)}</div>`
                                }).join('')
                            })
                        } else {
                            // incorrect data
                            Swal.fire('', `{{ __('loan_contract.info.bill_payment_not_found') }}`, 'error')
                        }
                    },
                    preConfirm: (ev) => {

                        return new Promise((resolve, reject) => {

                            let result = false
                            let referenceCode = null
                            $('.radio_reference_code').each( (index, value) => {
                                if ( $(value).is(':checked')  ) {
                                    referenceCode = $(value).val()
                                    return !(result = true);   // mark as success && exit loop
                                } else {
                                    return; // skip iteration
                                }
                            })

                            if ( !result ) {
                                Swal.showValidationMessage(`{{ __('loan_contract.info.please_select_bill') }}`)
                            } else {
                                resolve({
                                    referenceCode
                                })
                            }
                            
                        })

                    }
                })
                .then(async (value) => {
                    
                    // check modal is close
                    if ( typeof value === 'undefined' || value.hasOwnProperty('dismiss')) {
                        return false
                    }

                    $.blockUI()

                    const { referenceCode } = value.value || {}
                    let transactionId = null

                    const transactions = await fetch(`{{ action('Loan\ContractController@loadTransactions') }}`, {
                        method: 'POST', // or 'PUT'
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            _token: '{{ csrf_token() }}',
                            contract_code: "{{ $contract_code }}"
                        }),
                    })
                    .then(async (response) => {
                        const results = await response.json() || []
                        return (results.transactions || []).filter((item) => {
                                return item.status === 'DUPLICATE_PAID'
                            })
                    })
                    .catch((error) => {
                        console.error('Error: ', error)
                        return []
                    }).finally(() => {
                        $.unblockUI()
                    })

                    return Swal.fire({
                        showConfirmButton: true,
                        showCloseButton: false,
                        showCancelButton: false,
                        type: 'info',
                        title: `{{ __('loan_contract.info.please_select_transactions') }}`,
                        html: transactions.map( (el, index) => {
                            return `<div class="col-12 py-2" style="height: 150px;">${createTransactionRadio(el, index == 0 ? true : false)}</div>`
                        }).join(''),
                        onOpen: () => {
                            if ( transactions.length === 0 ) {
                                // incorrect data
                                Swal.fire('', `{{ __('loan_contract.info.dup_transactions_not_found') }}`, 'error')
                            }
                        },
                        preConfirm: function(ev) {

                            return new Promise((resolve, reject) => {

                                let result = false
                                let txnId = null
                                $('.radio_txn_id').each( (index, value) => {
                                    if ( $(value).is(':checked')  ) {
                                        txnId = $(value).val()
                                        return !(result = true);   // mark as success && exit loop
                                    } else {
                                        return; // skip iteration
                                    }
                                })

                                if ( !result ) {
                                    Swal.showValidationMessage(`{{ __('loan_contract.info.please_select_transactions') }}`)
                                } else {
                                    resolve({
                                        transactionId: txnId,
                                        referenceCode,
                                    })
                                }

                            })

                        }
                    })

                    
                })
                .then(value => {

                    // check modal is close
                    if ( !value || typeof value === 'undefined' || value.hasOwnProperty('dismiss') ) {
                        return false
                    }

                    const { referenceCode, transactionId } = value.value || {}

                    // add field value
                    $('input[name="reference_code"]').val( referenceCode )

                    if ( !_.isEmpty(transactionId) ) {
                        $('input[name="transaction_id"]').val( transactionId ).attr('readonly', true)
                    }

                    // Form part
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
                                            Swal.fire(`{{ (__('common.error')) }}`, '', 'error')
                                        }
                                    },
                                    error: function(err) {
                                        $.unblockUI()
                                        console.error('Error: ', err)
                                        Swal.fire(`{{ (__('common.error')) }}`, '', 'error')
                                    }
                                })
                                    
                            }
                        }
                    })
                })

            })

        })

    </script>
@endsection
