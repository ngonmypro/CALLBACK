{{-- Customer Fee Form --}}
<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <div class="card" style="border: none;">
            <form id="customer_fee_form" action="{{ url('Corporate/Setting/CustomerFee') }}" method="POST" class="form">
                {{-- {!! json_encode($data->customer_fee) !!} --}}
                {{ csrf_field() }}
                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                <div class="card-header" style="border: none;">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">{{__('corpsetting.customer_fee')}}</span>
                    </h4> 
                </div>

                <div class="card-body px-4 pt-4 pb-2" style="border: none;">

                    <div class="col-12" id="item-wrapper">

                        <div class="row">
                            <div class="col-12 text-right">
                                <button type="button" id="add" class="btn btn-outline-success">
                                    <i class="fa fa-plus" aria-hidden="true"></i><span>{{__('corpsetting.add')}}</span>
                                </button>
                            </div>
                        </div>

                        @if (isset($data->customer_fee->config) && is_array(json_decode($data->customer_fee->config)))
                            @php 
                                $i = 0;
                                $data->customer_fee->config = json_decode($data->customer_fee->config);
                            @endphp
                            @foreach ($data->customer_fee->config as $item)

                                @if (!isset($item->payment_channel) || !isset($item->type) || !isset($item->value))
                                    @php break; @endphp
                                @endif

                                <div class="row py-3 border-bottom items">

                                    <div class="col-12">
        
                                        {{-- PAYMENT_CHANNEL --}}
                                        <div class="row py-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{__('corpsetting.customer_fee-field-payment_channel')}}</label>
                                                    <select data-input="{{ $item->payment_channel }}" class="form-control" name="payment_channel[]">
                                                        <option selected="selected">PLEASE SELECT</option>
                                                        @if($channel_name != NULL)
                                                            @foreach($channel_name as $i => $channel)
                                                                <option value="{{ $channel }}">{{ strtoupper($channel) }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
        
                                        {{-- TYPE --}}
                                        <div class="row py-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                    <select data-input="{{ $item->type }}" class="form-control" name="type[]">
                                                        <option></option>
                                                        <option value="FLAT">{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                        <option value="PERCENTAGE">{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- VALUE --}}
                                        <div class="row py-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                    <div class="input-group">
                                                        <input type="number" name="value[]" value="{{ $item->value }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    @if ($i !== 0)
                                        <div class="col-12 text-right">
                                            <button type="button" class="remove btn btn-outline-danger">
                                                <i class="fa fa-trash"></i><span>{{__('corpsetting.remove')}}</span>
                                            </button>
                                        </div>
                                    @endif
                                    
                                </div>
                                
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="row py-3 border-bottom items">

                                <div class="col-12">
    
                                    {{-- PAYMENT_CHANNEL --}}
                                    <div class="row py-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('corpsetting.customer_fee-field-payment_channel')}}</label>
                                                <select class="form-control" name="payment_channel[]">
                                                    <option></option>
                                                    <option value="PROMPT_PAY">{{__('corpsetting.customer_fee-field-payment_channel-pp')}}</option>
                                                    <option value="CREDIT_CARD">{{__('corpsetting.customer_fee-field-payment_channel-cc')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
    
                                    {{-- TYPE --}}
                                    <div class="row py-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                <select class="form-control" name="type[]">
                                                    <option></option>
                                                    <option value="FLAT">{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                    <option value="PERCENTAGE">{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- VALUE --}}
                                    <div class="row py-2">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                <div class="input-group">
                                                    <input type="number" name="value[]" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                
                            </div>
                            
                        @endif

                    </div>

                    {{-- SUMIT FORM --}}
                    <div class="row py-2 mt-5">
                        <div class="col-12 text-right">
                            <div class="form-group">
                                @Permission(CORPORATE_MANAGEMENT.VIEW)
                                @if (isset($corp_code) && !blank($corp_code))
                                    <a href="{{ url('Corporate')}}" class="btn bg-gradient-danger">{{__('common.cancel')}}</a>
                                @else
                                    <a onclick="window.history.back()" class="btn bg-gradient-danger">{{__('common.cancel')}}</a>
                                @endif
                                @EndPermission
                                <button type="submit" class="btn btn-outline-primary">{{__('corpsetting.save')}}</button>
                            </div>
                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>
</div>

<section class="d-none" id="item-clonable">
    <div class="row py-3 border-bottom items">
        <div class="col-12">
            {{-- PAYMENT_CHANNEL --}}
            <div class="row py-2">
                <div class="col-12">
                    <div class="form-group">
                        <label>{{__('corpsetting.customer_fee-field-payment_channel')}}</label>
                        <select class="form-control" name="payment_channel[]">
                            <option selected="selected">PLEASE SELECT</option>
                            @if($channel_name != NULL)
                                @foreach($channel_name as $i => $channel)
                                    <option value="{{ $channel }}">{{ strtoupper($channel) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            {{-- TYPE --}}
            <div class="row py-2">
                <div class="col-12">
                    <div class="form-group">
                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                        <select class="form-control" name="type[]">
                            <option></option>
                            <option value="FLAT">{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                            <option value="PERCENTAGE">{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                        </select>
                    </div>
                </div>
            </div>      
            {{-- VALUE --}}
            <div class="row py-2">
                <div class="col-12">
                    <div class="form-group">
                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                        <div class="input-group">
                            <input type="number" name="value[]" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="col-12 text-right">
            <button type="button" class="remove btn btn-outline-danger">
                <i class="fa fa-trash"></i><span>Remove</span>
            </button>
        </div>
    </div>
</section>


@section('script.eipp.corp-setting.customer_fee')
{!! JsValidator::formRequest('App\Http\Requests\CorpCustomerFeeRequest', '#customer_fee_form') !!}
<script>

    let customer = {}
    customer.init = () => {
        // re-initial select-option

        $('#customer_fee_form select[name^=type]').each(function() {
            $(this).val($(this).data('input'))
        })

        $('#customer_fee_form select[name^=payment_channel]').each(function() {
            $(this).val($(this).data('input'))
        })
    }

    $(document).ready(function() {
        customer.init()

        $(document).on('click', '#customer_fee_form #add', function() {
            const elem = $('#item-clonable').children().clone()
            $('#customer_fee_form #item-wrapper').append(elem)
        })

        $(document).on('click', '.remove', function() {
            $(this).parents().closest('.items').first().remove()
        })

        // $(document).on('change', '#customer_fee_form select[name^=payment_channel]', function() {
        //     const val = $(this).val()
        //     if (val !== '') {
        //         $( '#customer_fee_form select[name^=payment_channel] option' ).not( $(this).children('option') ).each(function () {
        //             if ( this.value === val ) {
        //                 this.disabled = true  // DISABLED ALL, EXCEPT SELF
        //             }
        //         })
        //     }
        // })

        // $(document).on('focus', '#customer_fee_form select[name^=payment_channel]', function() {
        //     let values = []
        //     $( '#customer_fee_form select[name^=payment_channel] option:selected' ).each(function () {
        //         values.push(this.value)
        //     })
        //     $( '#customer_fee_form select[name^=payment_channel] option' ).each(function (item) {
        //         if ( values.indexOf( $(this).val() ) === -1 ) {
        //             this.disabled = false
        //         } else if ( !$(this).is(':selected') ) {
        //             this.disabled = true
        //         }
        //     })
        // })

    })

</script>
@endsection