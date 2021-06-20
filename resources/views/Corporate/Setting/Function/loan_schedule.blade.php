{{-- Customer Fee Form --}}
<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <div class="card" style="border: none;">
            <form id="loan_schedule_form" action="{{ url('Corporate/Setting/LoanSchedule') }}" method="POST" class="form">
                {{-- {!! print_r($data->loan_schedule) !!} --}}
                @php
                    $loan_schedule = isset($data->loan_schedule) ? $data->loan_schedule : null;
                @endphp
                {{ csrf_field() }}
                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                <div class="card-header" style="border: none;">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">{{__('corpsetting.loan_schedule')}}</span>
                    </h4> 
                </div>

                <div class="card-body px-4 pt-4 pb-2" style="border: none;">

                    <div class="col-12">

                        <div class="row py-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__('corpsetting.loan_schedule-billing_date')}}</label>
                                    @if (old('billing_date'))
                                    <input type="text" name="billing_date" value="{{ old('billing_date') }}" placeholder="{{ (__('corpsetting.loan_schedule-day_of_month')) }}" class="form-control">
                                    @elseif (isset($loan_schedule->config->billing_date) && !blank($loan_schedule->config->billing_date))
                                    <input type="text" name="billing_date" value="{{ $loan_schedule->config->billing_date }}" placeholder="{{ (__('corpsetting.loan_schedule-day_of_month')) }}" class="form-control">
                                    @else
                                    <input type="text" name="billing_date" value="" placeholder="{{ (__('corpsetting.loan_schedule-day_of_month')) }}" class="form-control">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row py-2 mb-4 border-bottom">

                            <div class="col-12">

                                <div class="row py-2">
                                    <div class="col-12 border-bottom">
        
                                        <div class="form-group">
                                            <h5>{{__('corpsetting.loan_schedule-days_after')}}</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="row py-2">
                                    <div class="col-12">
        
                                        <div class="form-group">
                                            <label>{{__('corpsetting.loan_schedule-due_date')}}</label>
        
                                            <div class="input-group">
        
                                                @if (old('due_date'))
                                                <input type="text" name="due_date" value="{{ old('due_date') }}" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @elseif (isset($loan_schedule->config->due_date) && !blank($loan_schedule->config->due_date))
                                                <input type="text" name="due_date" value="{{ $loan_schedule->config->due_date }}" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @else
                                                <input type="text" name="due_date" value="" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @endif
        
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{__('corpsetting.loan_schedule-unit_day')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row py-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{__('corpsetting.loan_schedule-grace_period_1st')}}</label>
        
                                            <div class="input-group">
                                                @if (old('grace_period_1st'))
                                                <input type="text" name="grace_period_1st" value="{{ old('grace_period_1st') }}" class="form-control" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}">
                                                @elseif (isset($loan_schedule->config->grace_period_1st) && !blank($loan_schedule->config->grace_period_1st))
                                                <input type="text" name="grace_period_1st" value="{{ $loan_schedule->config->grace_period_1st }}" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @else
                                                <input type="text" name="grace_period_1st" value="" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @endif
        
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{__('corpsetting.loan_schedule-unit_day')}}</span>
                                                </div>
                                            </div>
        
                                        </div>
                                    </div>
                                </div>
            
                                <div class="row py-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>{{__('corpsetting.loan_schedule-grace_period_2nd')}} <small class="text-muted">({{__('corpsetting.optional')}})</small></label>
        
                                            <div class="input-group">
                                                @if (old('grace_period_2nd'))
                                                <input type="text" name="grace_period_2nd" value="{{ old('grace_period_2nd') }}" class="form-control" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}">
                                                @elseif (isset($loan_schedule->config->grace_period_2nd) && !blank($loan_schedule->config->grace_period_2nd))
                                                <input type="text" name="grace_period_2nd" value="{{ $loan_schedule->config->grace_period_2nd }}" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @else
                                                <input type="text" name="grace_period_2nd" value="" placeholder="{{ (__('corpsetting.loan_schedule-placeholder_days')) }}" class="form-control">
                                                @endif
                                                
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{__('corpsetting.loan_schedule-unit_day')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                            </div>

                        </div>   
                        
                        <div class="row py-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__('corpsetting.loan_schedule-fee_type')}}</label>
                                    @if (old('type'))
                                    <select data-input="{{ old('fee_type') }}" class="form-control" name="fee_type">
                                    @elseif (isset($loan_schedule->config->fee_type) && !blank($loan_schedule->config->fee_type))
                                    <select data-input="{{ $loan_schedule->config->fee_type }}" class="form-control" name="fee_type">
                                    @else
                                    <select class="form-control" name="fee_type">
                                    @endif
                                        <option></option>
                                        <option value="FLAT">{{__('corpsetting.loan_schedule-field-type-flat')}}</option>
                                        <option value="PERCENTAGE">{{__('corpsetting.loan_schedule-field-type-percentage')}}</option>
                                    </select>
                                    <small id="" class="form-text text-muted">{{__('corpsetting.fee_charge_message')}}</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row py-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>{{__('corpsetting.loan_schedule-fee_rate')}}</label>
                                    @if (old('fee_rate'))
                                    <input type="number" name="fee_rate" value="{{ old('fee_rate') }}" class="form-control">
                                    @elseif (isset($loan_schedule->config->fee_rate) && !blank($loan_schedule->config->fee_rate))
                                    <input type="number" name="fee_rate" value="{{ $loan_schedule->config->fee_rate }}" class="form-control">
                                    @else
                                    <input type="number" name="fee_rate" value="" placeholder="" class="form-control">
                                    @endif
                                </div>
                            </div>
                        </div>
    
                        <div class="row py-2">
                            <div class="col-12 text-right">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </form>
        </div>
    </div>
</div>


@section('script.eipp.corp-setting.loan_schedule')
{!! JsValidator::formRequest('App\Http\Requests\CorpSettingLoanSchedule', '#loan_schedule_form') !!}
<script>

    let lnSchedule = {}
    lnSchedule.init = () => {
        // re-initial select-option
        const sel = $('#loan_schedule_form select[name=fee_type]').data('input')
        $('#loan_schedule_form select[name=fee_type]').val(sel)
    }

    $(document).ready(function() {
        lnSchedule.init()
    })

</script>
@endsection