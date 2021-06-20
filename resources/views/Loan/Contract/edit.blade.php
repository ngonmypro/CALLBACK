@extends('argon_layouts.app', ['title' => __('loan_contract.edit.title')])

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <a href="{{ url('/Loan/Contract/Info',$contract_code)}}">
                            <h6 class="h2 text-white d-inline-block mb-0">
                                <i class="ni ni-bold-left"></i>
                                <span class="d-inline">{{__('loan_contract.info.application_info')}}<span>
                            </h6>
                        </a>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ url('/Loan/Contract/Info',$contract_code)}}" class="btn btn-neutral">Back</a>
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
                                <h3 class="mb-0">{{ (__('loan_contract.edit.title')) }}</h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Loan/Contract/Update',$contract_code) }}" method="POST" enctype="multipart/form-data" id="form-edit-contract">
                            {{ csrf_field() }}

                            <div class="col-12">

                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">        
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-contract_item')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="contract_item" value="{{ isset($contract->contract_item) ? $contract->contract_item : '-' }}" placeholder="" class="form-control required-checked" value="" data-type="" {{ $contract->status === 'APPROVAL' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fil w-50">
                                        <div class="form-group">
                                            <div class="col-12 px-0">
                                                <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-delivery_date')) }}</label>
                                            </div>
                                            <div class="col-12 px-0">
                                                <input type="text" name="delivery_date" value="{{ isset($contract->delivery_date) ? date('Y-m-d H:i', strtotime($contract->delivery_date)) : '' }}" placeholder="{{ (__('loan_contract.info.field-delivery_date')) }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">        
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-amount')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="amount" name="amount" name="contract_name" value="{{ isset($contract->amount) ? $contract->amount : '-' }}" placeholder="" class="form-control required-checked" {{ $contract->status === 'APPROVAL' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">        
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-contract_period')) }}</label>
                                                </div>
                                                    <div class="col-12">
                                                    <input type="number" id="period" name="period" placeholder="" class="form-control required-checked" value="{{ isset($contract->period) ? (int)$contract->period : '' }}" {{ $contract->status === 'APPROVAL' ? 'disabled' : '' }}>
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
                                                    <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-monthly_installment')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="monthly_installment_amount" name="monthly_installment_amount" placeholder="" class="form-control required-checked" value="{{ isset($contract->monthly_installment_amount) ? $contract->monthly_installment_amount : '-' }}" readonly="readonly" {{ $contract->status === 'APPROVAL' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">        
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('loan_contract.info.field-total_amount')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="total_amount" name="total_amount" placeholder="" class="form-control required-checked" value="{{ isset($contract->total_amount) ? $contract->total_amount : '' }}" readonly="readonly" {{ $contract->status === 'APPROVAL' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ( isset($contract->description) && is_object($contract->description) )
                    
                                    <div class="d-flex flex-wrap">
                                        @foreach( (array)$contract->description as $key => $value )
                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">        
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="" class=" form-control-label">{{ ucwords(str_replace('_', ' ', $key)) }}</label>
                                                        </div>
                                                        <div class="col-12">
                                                            <input name="description[{{ $key }}]" type="text" value="{{ $value }}" class="form-control desc_dynamic_input">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                @endif

                            </div>

                            <div class="text-center">
                                <a href="{{ url('/Loan/Contract/Info',$contract_code)}}" class="btn btn-warning mt-3">{{ (__('common.cancel')) }}</a>
                                <button onclick="SubmitForm()" type="submit" class="btn btn-success mt-3">{{ (__('common.save')) }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- MAIN CONTENT-->

@include('layouts.footer_progress')
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EditContractRequest') !!}
    <script type="text/javascript">

		function SubmitForm () {
			$('#form-edit-contract').submit()
		}

        function init() {
            //
        }

		$(document).ready(function()
		{
            init()

            // datepicker event on click Clear
            $('input[name="delivery_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $('input[name="delivery_date"]').val('')
            })
            
            $('input[name="delivery_date"] , [name="delivery_date"]').daterangepicker({
                startDate: moment(),
                timePicker: true,
                singleDatePicker: true,
                showDropdowns: true,
                timePickerIncrement: 30,
                timePicker24Hour: true,
                locale: {
                    format: 'YYYY-MM-DD HH:mm',
                    cancelLabel: 'Clear'
                },
                autoUpdateInput: false,
            }, function (date) {
                $('input[name="delivery_date"]').val(date.format('YYYY-MM-DD HH:mm'))
            })
            
			$("#back").on("click" , function(){
				if (window.history.back() === undefined || window.history.back() === "undefined") {
					window.location.href = '{{ url("Recipient")}}'
				} else {
					window.history.back()
				}
			})

            $('input[name=amount]').on('input change paste', function(e) {
                const amount = $(this).val()
                const period = $('input[name=period]').val()

                if (!isNaN(amount) && !isNaN(period) && amount > 0) {
                    const inst = (amount / period).toFixed(2)
                    $('input[name=monthly_installment_amount]').val(inst)
                    $('input[name=total_amount]').val(amount)
                }
            })

            $('input[name=period]').on('input change paste', function(e) {
                const amount = $('input[name=amount]').val()
                const period = $(this).val()

                if (!isNaN(amount) && !isNaN(period)) {
                    const inst = (amount / period).toFixed(2)
                    $('input[name=monthly_installment_amount]').val(inst)
                    $('input[name=total_amount]').val(amount)
                }
            })

		})

    </script>
@endsection
