<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form id="payment_form" action="{{ url('Corporate/Setting/Payment') }}" method="POST" class="form">

                {{ csrf_field() }}

                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                <div class="card-header" style="border: none;">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">{{__('corpsetting.payment_setting')}}</span>
                    </h4> 
                </div>

            @if(! blank($channel_name ?? null) )

                {{-- SCB --}}
                @if(in_array('scb_thai_qr', $channel_name))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">SCB QR PROMPT PAY</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input type="checkbox" name="scb_qr_enable" id="scb_qr_enable" {{ isset($payment_config->scb_thai_qr->enable) ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body scb_qr pb-0" style="display: {{ !isset($payment_config->scb_thai_qr) ? 'none' : '' }}">
                            <div class="row"> 
                                <div class=" col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-payment')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <label>BILLER</label>
                                                <input type="text" class="form-control" name="scb_qr_biller" value="{{ isset($payment_config->scb_thai_qr->biller) ? $payment_config->scb_thai_qr->biller : '' }}">
                                            </div>
                                            <div class="row py-1">
                                                <label>REF 3</label>
                                                <input type="text" class="form-control" name="scb_qr_ref3" value="{{ isset($payment_config->scb_thai_qr->ref3) ? $payment_config->scb_thai_qr->ref3 : '' }}">
                                            </div>
                                            <div class="row py-1">
                                                <label>MERCHANT NAME</label>
                                                <input type="text" class="form-control" name="scb_qr_merchant_name" value="{{ isset($payment_config->scb_thai_qr->merchant_name) ? $payment_config->scb_thai_qr->merchant_name : '' }}">
                                            </div>
                                            <div class="row py-1">
                                                <label>NOTIFY TYPE</label>
                                                <select class="form-control" name="scb_qr_notify_type">
                                                    @if($notify_type != NULL)
                                                        @foreach($notify_type as $k => $v)
                                                            <option value="{{ $v }}" {{ isset($payment_config->scb_thai_qr->notify_type) ? 'selected': '' }}> {{ $v }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="row py-1">
                                                <label>NOTIFY URL</label>
                                                <input type="text" class="form-control" name="scb_qr_notify_url" value="{{ isset($payment_config->scb_thai_qr->notify_url) ? $payment_config->scb_thai_qr->notify_url : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6">
                                    <div class="card">
                                        <div class="card-header">
                                        <h4 class="">{{__('corpsetting.customer_fee-field-fee')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                        <select class="form-control" name="scb_qr_fee_type">
                                                            <option>PLEASE SELECT</option>
                                                            <option value="FLAT" {{ isset($payment_config->scb_thai_qr->fee_type) && $payment_config->scb_thai_qr->fee_type == 'FLAT' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                            <option value="PERCENTAGE" {{ isset($payment_config->scb_thai_qr->fee_type) && $payment_config->scb_thai_qr->fee_type == 'PERCENTAGE' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                        <div class="input-group">
                                                            <input type="text" name="scb_qr_fee_rate" value="{{ isset($payment_config->scb_thai_qr->fee_rate) ? $payment_config->scb_thai_qr->fee_rate : '' }}" class="form-control">
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
                @endif

                @if(in_array('scb_redirect_credit', $channel_name))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">SCB CREDIT CARD</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input type="checkbox" name="scb_credit_enable" id="scb_credit_enable" {{ isset($payment_config->scb_redirect_credit->enable) ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body scb_credit pb-0" style="display: {{ !isset($payment_config->scb_redirect_credit) ? 'none' : '' }}">
                            <div class="row"> 
                                <div class=" col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-payment')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <label>MID</label>
                                                <input type="text" class="form-control" name="scb_credit_mid" value="{{ isset($payment_config->scb_redirect_credit->mid) ? $payment_config->scb_redirect_credit->mid : '' }}">
                                            </div>
                                            <div class="row py-1">
                                                <label>TID</label>
                                                <input type="text" class="form-control" name="scb_credit_tid" value="{{ isset($payment_config->scb_redirect_credit->tid) ? $payment_config->scb_redirect_credit->tid : '' }}">
                                            </div>
                                            <div class="row py-1">
                                                <label>ENCRYPTION PUBLIC</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="encryption_public">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="hidden" name="scb_credit_enc_pub" class="inputb64" value="{{ isset($payment_config->scb_redirect_credit->encrypt_public_full) ? $payment_config->scb_redirect_credit->encrypt_public_full : '' }}">
                                                        <input type="file" class="custom-file-input" id="encryption_public_file"
                                                        aria-describedby="encryption_public" onchange="changeFileName(this)" accept=".key">
                                                        <label class="custom-file-label" for="encryption_public_file">{{ isset($payment_config->scb_redirect_credit->encrypt_public) ? $payment_config->scb_redirect_credit->encrypt_public : 'Choose file' }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <label>DECRYPTION PUBLIC</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="decryption_public">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="hidden" name="scb_credit_dec_pub" class="inputb64" value="{{ isset($payment_config->scb_redirect_credit->decrypt_public_full) ? $payment_config->scb_redirect_credit->decrypt_public_full : '' }}">
                                                        <input type="file" class="custom-file-input" id="decryption_public_file"
                                                        aria-describedby="decryption_public" onchange="changeFileName(this)" accept=".key">
                                                        <label class="custom-file-label" for="decryption_public_file">{{ isset($payment_config->scb_redirect_credit->decrypt_public) ? $payment_config->scb_redirect_credit->decrypt_public : 'Choose file' }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <label>DECRYPTION PRIVATE</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="decryption_private">Upload</span>
                                                    </div>
                                                    <div class="custom-file">
                                                        <input type="hidden" name="scb_credit_dec_pri" class="inputb64" value="{{ isset($payment_config->scb_redirect_credit->decrypt_private_full) ? $payment_config->scb_redirect_credit->decrypt_private_full : '' }}">
                                                        <input type="file" class="custom-file-input" id="encryption_private_file"
                                                        aria-describedby="decryption_private" onchange="changeFileName(this)" accept=".key">
                                                        <label class="custom-file-label" for="encryption_private_file">{{ isset($payment_config->scb_redirect_credit->decrypt_private) ? $payment_config->scb_redirect_credit->decrypt_private : 'Choose file' }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6">
                                    <div class="card">
                                        <div class="card-header">
                                        <h4 class="">{{__('corpsetting.customer_fee-field-fee')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                        <select class="form-control" name="scb_credit_fee_type">
                                                            <option>PLEASE SELECT</option>
                                                            <option value="FLAT" {{ isset($payment_config->scb_redirect_credit->fee_type) && $payment_config->scb_redirect_credit->fee_type == 'FLAT' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                            <option value="PERCENTAGE" {{ isset($payment_config->scb_redirect_credit->fee_type) && $payment_config->scb_redirect_credit->fee_type == 'PERCENTAGE' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                        <div class="input-group">
                                                            <input type="text" name="scb_credit_fee_rate" value="{{ isset($payment_config->scb_redirect_credit->fee_rate) ? $payment_config->scb_redirect_credit->fee_rate : '' }}" class="form-control">
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
                @endif
                {{-- SCB --}}


                {{-- TMB --}}
                @if(in_array('tmb_thai_qr', $channel_name))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">TMB QR PROMPT PAY</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input type="checkbox" name="tmb_qr_enable" id="tmb_qr_enable" {{ isset($payment_config->tmb_thai_qr->enable) ? 'checked' : '' }}>
                                 
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body pb-0 tmb_qr" style="display: {{ !isset($payment_config->tmb_thai_qr->enable) ? 'none' : '' }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-payment')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <label>SUB BILLER</label>
                                                <input type="text" class="form-control" name="tmb_qr_sub_biller" value="{{ isset($payment_config->tmb_thai_qr->sub_biller) ? $payment_config->tmb_thai_qr->sub_biller : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-header">
                                        <h4 class="">{{__('corpsetting.customer_fee-field-fee')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                        <select class="form-control" name="tmb_qr_fee_type">
                                                            <option>PLEASE SELECT</option>
                                                            <option value="FLAT" {{ isset($payment_config->tmb_thai_qr->fee_type) && $payment_config->tmb_thai_qr->fee_type == 'FLAT' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                            <option value="PERCENTAGE" {{ isset($payment_config->tmb_thai_qr->fee_type) && $payment_config->tmb_thai_qr->fee_type == 'PERCENTAGE' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                        <div class="input-group">
                                                            <input type="text" name="tmb_qr_fee_rate" value="{{ isset($payment_config->tmb_thai_qr->fee_rate) ? $payment_config->tmb_thai_qr->fee_rate : '' }}" class="form-control">
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
                @endif

                @if(in_array('tmb_redirect_credit', $channel_name))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">TMB CREDIT CARD</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                <input type="checkbox" name="tmb_credit_enable" id="tmb_credit_enable" {{ isset($payment_config->tmb_redirect_credit->enable) ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>

                        <div class="card-body pb-0 tmb_credit" style="display: {{ !isset($payment_config->tmb_redirect_credit->enable) ? 'none' : '' }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-payment')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <label>MID</label>
                                                <input type="text" class="form-control" name="tmb_credit_mid" value="{{ isset($payment_config->tmb_redirect_credit->mid) ? $payment_config->tmb_redirect_credit->mid : '' }}">
                                            </div>
                                            <div class="card-body">
                                                <label>{{__('corpsetting.payment_api_user_id')}}</label>
                                                <input type="text" class="form-control" name="tmb_credit_api_user_id" value="{{ isset($payment_config->tmb_redirect_credit->api_user_id) ? $payment_config->tmb_redirect_credit->api_user_id : '' }}">
                                            </div>
                                            <div class="card-body">
                                                <label>{{__('corpsetting.payment_api_password')}}</label>
                                                <input type="text" class="form-control" name="tmb_credit_api_password" value="{{ isset($payment_config->tmb_redirect_credit->api_password) ? $payment_config->tmb_redirect_credit->api_password : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-fee')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                        <select class="form-control" name="tmb_credit_fee_type">
                                                            <option>PLEASE SELECT</option>
                                                            <option value="FLAT" {{ isset($payment_config->tmb_redirect_credit->fee_type) && $payment_config->tmb_redirect_credit->fee_type == 'FLAT' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                            <option value="PERCENTAGE" {{ isset($payment_config->tmb_redirect_credit->fee_type) && $payment_config->tmb_redirect_credit->fee_type == 'PERCENTAGE' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                        <div class="input-group">
                                                            <input type="text" name="tmb_credit_fee_rate" value="{{ isset($payment_config->tmb_redirect_credit->fee_rate) ? $payment_config->tmb_redirect_credit->fee_rate : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            
                        </div>
                    </div>
                @endif
                {{-- TMB --}}

                {{-- BANK TRANSFER --}}
                @if( in_array('bank_transfer', $channel_name) )
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">Bank Transfer</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input type="checkbox" name="bank_transfer_enable" id="bank_transfer_enable" >
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body bank_transfer" style="{{ isset($payment_config->bank_transfer->enable) ? '' : 'display: none;' }}">
                            
                            <div class="row account-wrapper"></div>

							<div class="row text-center pt-3"> 
							
								<div class="col-4"></div>

								<div class="col-4">
									<button type="button" id="add" class="btn btn-secondary">{{ __('corpsetting.bank_transfer-field-add') }}</button>
								</div>

								<div class="col-4"></div>
                            
                            </div>
                               
                        </div>
                    </div>
                @endif

                {{-- Recurring --}}
                @if( in_array('recurring', $channel_name) )
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">Recurring</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input type="checkbox" name="recurring_enable" id="recurring_enable">
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- BBL --}}
                @if(in_array('bbl_redirect_credit', $channel_name))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">BBL CREDIT CARD</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                <input type="checkbox" name="bbl_credit_enable" id="bbl_credit_enable" {{ isset($payment_config->bbl_redirect_credit->enable) ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>

                        <div class="card-body pb-0 bbl_credit" style="display: {{ !isset($payment_config->bbl_redirect_credit->enable) ? 'none' : '' }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-payment')}} Payment</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-body">
                                                <label>MID</label>
                                                <input type="text" class="form-control" name="bbl_credit_mid" value="{{ isset($payment_config->bbl_redirect_credit->mid) ? $payment_config->bbl_redirect_credit->mid : '' }}">
                                            </div>
                                            <div class="card-body">
                                                <label>{{__('corpsetting.payment_api_user_id')}}</label>
                                                <input type="text" class="form-control" name="bbl_credit_api_user_id" value="{{ isset($payment_config->bbl_redirect_credit->api_user_id) ? $payment_config->bbl_redirect_credit->api_user_id : '' }}">
                                            </div>
                                            <div class="card-body">
                                                <label>{{__('corpsetting.payment_api_password')}}</label>
                                                <input type="text" class="form-control" name="bbl_credit_api_password" value="{{ isset($payment_config->bbl_redirect_credit->api_password) ? $payment_config->bbl_redirect_credit->api_password : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" col-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="">{{__('corpsetting.customer_fee-field-fee')}}</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-type')}}</label>
                                                        <select class="form-control" name="bbl_credit_fee_type">
                                                            <option>PLEASE SELECT</option>
                                                            <option value="FLAT" {{ isset($payment_config->bbl_redirect_credit->fee_type) && $payment_config->bbl_redirect_credit->fee_type == 'FLAT' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-flat')}}</option>
                                                            <option value="PERCENTAGE" {{ isset($payment_config->bbl_redirect_credit->fee_type) && $payment_config->bbl_redirect_credit->fee_type == 'PERCENTAGE' ? 'selected'  : '' }}>{{__('corpsetting.customer_fee-field-type-percentage')}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row py-1">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>{{__('corpsetting.customer_fee-field-value')}}</label>
                                                        <div class="input-group">
                                                            <input type="text" name="bbl_credit_fee_rate" value="{{ isset($payment_config->bbl_redirect_credit->fee_rate) ? $payment_config->bbl_redirect_credit->fee_rate : '' }}" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            
                        </div>
                    </div>
                @endif
                {{-- BBL --}}

            @endif

            <div class="row">
                <div class="col-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


<section class="template d-none" id="bank_transfer">

    <section class="clonable-parent-account-item">
        <div class="col-6 account-item p-3">
            <input type="hidden" class="form-control" name="bank_transfer[0][bank_name]">
            <div class="card mb-0">
                <div class="card-header pb-1">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="bank_name" style="height: 50px;"></h2>
                        </div>
                        <div class="col-6 w-remove p-0 m-0"></div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="row p-2">
                        <div class="col-12">
                            <label>{{ __('corpsetting.bank_transfer-field-account_name') }}</label>
                            <input type="text" class="form-control" name="bank_transfer[0][account_name]">
                        </div>
                    </div>
                    <div class="row p-2">
                        <div class="col-12">
                            <label>{{ __('corpsetting.bank_transfer-field-account_number') }}</label>
                            <input type="text" class="form-control" name="bank_transfer[0][account_number]">
                        </div>
                    </div>
                    <div class="row p-2 py-3">
                        <div class="col-12">
                            <label>{{ __('corpsetting.bank_transfer-field-select-bank') }}</label>
                            <div class="py-3" style="overflow-x: scroll; white-space: nowrap; opacity:0.65;">
                                @if ( isset($data->bank_logo) && is_array($data->bank_logo) )
                                    @foreach ( $data->bank_logo as $k => $v )
                                        <span class="d-inline px-3 bank_logo">
                                            <img style="max-width: 50px;" src="{{ asset($v['path']) }}" data-value="{{ $v['filename'] }}" alt="{{ $v['name'] }}">
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</section>


@section('script.eipp.corp-setting.payment')
{!! JsValidator::formRequest('App\Http\Requests\CorpSettingPayment','#payment_form') !!}
<script>

    $('#tmb_qr_enable').change(function() {
      	$('.tmb_qr').toggle();
    });

    $('#tmb_credit_enable').change(function() {
      	$('.tmb_credit').toggle();
    });

    $('#scb_qr_enable').change(function() {
      	$('.scb_qr').toggle();
    });

    $('#scb_credit_enable').change(function() {
      	$('.scb_credit').toggle();
    });


    $('#bbl_credit_enable').change(function() {
      	$('.bbl_credit').toggle();
    });

    function changeFileName(elem) {
        var fileName = $(elem).val().replace('C:\\fakepath\\', " ");
        var dest = $(elem).parent().find('.custom-file-label');
        var inputb64 = $(elem).parent().find('.inputb64');
        var reader = new FileReader();  
        var file = elem.files[0];

        reader.readAsDataURL(file);

        reader.onload = function () {
            $(inputb64).val(reader.result);
            $(dest).html(fileName);
        };
    }

</script>


<script>

const btpayment = {}
btpayment.oldData = JSON.parse(`{!! json_encode(Session::getOldInput()) !!}`)
// btpayment.oldData = JSON.parse(`{"_token":"B0HBKQgyCHStcUtwbbCPCg2DJCCcxoq5NlgVY89D","corp_code":"SDSFBLX9G1","tmb_qr_enable":"on","tmb_qr_sub_biller":"DSWE","tmb_qr_fee_type":"PERCENTAGE","tmb_qr_fee_rate":"5","tmb_credit_enable":"on","tmb_credit_mid":"GF32","tmb_credit_api_user_id":"","tmb_credit_api_password":"","tmb_credit_fee_type":"PERCENTAGE","tmb_credit_fee_rate":"","bank_transfer_enable":"on","bank_transfer":[{"bank_name":"bay.png","account_name":"asf","account_number":"asfafs"},{"bank_name":"bbl.png","account_name":"asfasf","account_number":"asfasf"}]}`)

btpayment.removeBtnUpdate = () => {
	const count = $('#payment_form .account-item').length === 0 
        ? $('#payment_form .account-item').length
        : $('#payment_form .account-item').length - 1

	$('#payment_form .account-item').each(function() {
		if ( $(this).index() === 0 ) {
            //
		} else if ( $(this).index() === count ) {

			if ( $(this).find('.removable').first().length === 0 ) {

				$(this).find('.w-remove').first().prepend( btpayment.removeBtn() )

			} else {
               //
            }

		} else {

			$(this).find('.removable').first().remove()

		}
	})
}

btpayment.removeBtn = () => {
	return `
		<div class="col-12 text-right p-0 m-0">
			<span class="text-danger removable p-0 m-0">
				<i class="ni ni-fat-remove fa-2x"></i>
			</span>
		</div>
	`
}

btpayment.onStart = (jsonStr, oldData) => {
    
    const obj = JSON.parse(jsonStr)

    if ( !_.isEmpty(oldData) ) {

        btpayment.backData( oldData )

    } else if ( _.isEmpty(obj) ) {

        $('.account-wrapper').append( btpayment.newItem() )
		btpayment.removeBtnUpdate()

    } else {

        obj.bank_transfer.accounts.forEach( (elem, index) => {
            $('.account-wrapper').append( btpayment.newItem( elem ) )
		    btpayment.removeBtnUpdate()
        })

        if ( obj.bank_transfer.enable && obj.bank_transfer.enable === 'on' ) {
            $('#bank_transfer_enable').prop('checked', true)
        } else {
            //
        }

        if ( obj.recurring.enable && obj.recurring.enable === 'on' ) {
            $('#recurring_enable').prop('checked', true)
        }

    }
}

btpayment.backData = (oldData) => {

	if ( oldData === undefined || oldData.length === 0 ) {
		return
	}

	const bankTransfer = ['bank_transfer', 'bank_transfer_enable']

	Object.keys( oldData ).map(function(objectKey, index) {

		if ( bankTransfer.indexOf( objectKey ) !== -1 ) {
			const value = oldData[objectKey]

			if ( Array.isArray( value ) ) {

				value.forEach( (element, index) => {

					if ( typeof element === 'object' ) {

						Object.keys( element ).map(function(k, i) {
							
							if ( $(`#payment_form *[name='${objectKey}[${index}][${k}]']`).length === 0  ) {
								$('.account-wrapper').append( btpayment.newItem() ) // appendItem
							}
							const el = $(`#payment_form *[name='${objectKey}[${index}][${k}]']`)
							
							if ( k === 'bank_name' ) {
								const item = el.parent().closest('.account-item')
								const img = item.find(`img[data-value='${element[k]}']`).clone()
								item.children().find('.bank_name').html( img )
							}

							$(`#payment_form *[name='${objectKey}[${index}][${k}]']`).val( element[k] )
						})
					}
				})
			} else {
				if ( objectKey === 'bank_transfer_enable' && value === 'on' ) {
					$('#bank_transfer_enable').prop('checked', true)
				} else {
				    $(`*[name=${objectKey}]`).val( value )
                }
			}
		}

	})
}

btpayment.newItem = (obj = null) => {
    const data = obj || {}

	const count = $('#payment_form .account-item').length
	const newItem = $('.account-item').first().clone().off()

	// remove current state image
	newItem.find('.bank_name').empty()

	// change input name
	newItem.find('input').each(function() {
        const inputName = $(this).attr('name')
		$(this).attr( 'name', this.name.replace('[0]', `[${count}]`) )

        if ( data.bank_name && inputName.indexOf('bank_name') !== -1 ) {
            
		    $(this).val( data.bank_name )
            const img = newItem.find(`img[data-value='${data.bank_name}']`).clone()
            newItem.children().find('.bank_name').html( img )

        } else if ( data.account_name && inputName.indexOf('account_name') !== -1 ) {

		    $(this).val( data.account_name )

        } else if ( data.account_number && inputName.indexOf('account_number') !== -1 ) {

		    $(this).val( data.account_number )

        } else {

		    $(this).val( $(this).data('default') || '' )

        }

		$(this).removeClass('is-valid').removeClass('is-invalid')
	})

	return newItem
}

$(document).ready(function() {

    $('#bank_transfer_enable').change(function() {
      	$('.bank_transfer').toggle()
    })

    $(document).on('click', '.bank_logo', function() {
		const item = $(this).closest('.account-item')
		const index = item.index()

		const img = $(this).find('img').clone()
		item.find('.bank_name').html( img )

		const imgVal = $(this).children('img').attr('data-value')
		$(`input[name='bank_transfer[${index}][bank_name]']`).val( imgVal )
	})

	btpayment.onStart( 
        `{!! json_encode($payment_config ?? []) !!}`, 
        btpayment.oldData 
    )

    $('#recurring_enable').change(function() {
      	$('.recurring_enable').toggle()
    })

	$(document).on('click', '#add', function() {
		$('.account-wrapper').append( btpayment.newItem() )
		btpayment.removeBtnUpdate()
	})

	$(document).on('click', '.removable', function(e) {
		if ( $(this).closest('.account-item').index() !== 0 ) {
			$(this).closest('.account-item').remove()
			btpayment.removeBtnUpdate()
		} else {
			$(this).remove()
		}
	})
})
</script>

@endsection