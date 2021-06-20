<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form id="form_notify" action="{{ url('Corporate/Setting/Notify') }}" method="POST" class="form">

                {{ csrf_field() }}

                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                <div class="card-header" style="border: none;">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">{{__('corpsetting.notify_setting')}}</span>
                    </h4> 
                </div>

                @if(isset($notify))

                    @foreach($notify as $k => $v)
                        @php 
                            $s=0;
                            $e=0;
                        @endphp

                        @if ( !isset($v->type) || !isset($v->provider) ) 
                            @php 
                                continue;
                            @endphp 
                        @endif

                        @if($v->type === 'SMS')
                            @php
                                $provider = $v->provider ?? '';
                                $sms      = $notify_config->sms->$provider ?? null;
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="float-sm-left my-0 pt-2">SMS : {{ strtoupper($provider) }}</h4>
                                    <div class="float-sm-right pt-1">
                                        <label class="custom-toggle custom-toggle-default">
                                            <input type="checkbox" class="enable-event" data-target="group-{{ $v->provider }}" name="input[sms][{{ $v->provider }}][enable]" {{ isset($sms->enable) ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body group-{{ $v->provider }}" style="display: ">
                                    <label>{{__('corpsetting.sender_name')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="input[sms][{{ $v->provider }}][sms_sender_name]" value="{{ isset($sms->sms_sender_name) ? $sms->sms_sender_name : '' }}">
                                </div>
                                <div class="card-body group-{{ $v->provider }}" style="display: ">
                                    <label>{{__('corpsetting.sms_invoice_message')}}</label>
                                    <input type="text" class="form-control" id="sms_message" name="input[sms][{{ $v->provider }}][sms_message]" value="{{ isset($sms->sms_message) ? $sms->sms_message : '' }}">
                                    <ul id="sms-counter" class="pt-3">
                                        <li>{{__('corpsetting.sms_encode_type')}} : <span class="encoding"></span></li>
                                        <li>{{__('corpsetting.sms_length')}} : <span class="length"></span></li>
                                        <li>{{__('corpsetting.sms_per_message')}} : <span class="per_message"></span></li>
                                        <li>{{__('corpsetting.sms_remaining')}} : <span class="remaining"></span></li>
                                        <li>{{__('corpsetting.sms_messages')}} : <span class="messages"></span></li>
                                    </ul>
                                    <label><span class="text-danger">* </span>{{__('corpsetting.sms_remark')}}</lable>
                                    <p class="pt-2">
                                        กรุณาระบุข้อมูลด้านล่างลงในข้อความที่ท่านต้องการ
                                        <small>
                                            <ul>
                                                <li>{AGENT_NAME}</li>
                                                <li>{CUSTOMER_CODE}</li>
                                                <li>{URL}</li>
                                                <li>{AMOUNT}</li>
                                                <li>{CURRENCY}</li>
                                                <li>{COMPANY_SHORT_NAME}</li>
                                            </ul>
                                        </small>
                                    </p>
                                </div>
                            </div>
                            @php 
                                $s++;
                            @endphp
                        @endif



                        @if($v->type === 'EMAIL')
                            @php
                                $provider = $v->provider ?? '';
                                $email    = $notify_config->email->$provider ?? null;
                            @endphp
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="float-sm-left my-0 pt-2">{{__('corpsetting.email')}}</h4>
                                    <div class="float-sm-right pt-1">
                                        <label class="custom-toggle custom-toggle-default">
                                            <input id="email_enable" type="checkbox" class="enable-event" name="input[email][enable]" {{ isset($notify_config->email->enable) ? 'checked' : '' }}>
                                            <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card email-provider" style="display: {{ isset($notify_config->email->enable) ? '' : 'none' }}">
                                        <div class="card-header">
                                            <h4 class="float-sm-left my-0 pt-2">{{ strtoupper($provider) }}</h4>
                                            <div class="float-sm-right pt-1">
                                                <label class="custom-toggle custom-toggle-default">
                                                    <input id="email_provider"  type="checkbox" class="enable-event" name="input[email][{{ $v->provider }}][enable]" {{ isset($email->enable) ? 'checked' : '' }}>
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="card-body group-{{ $v->provider }} email-provider-config" style="display: {{ isset($email->enable) ? '' : 'none' }}">
                                            <label>{{__('corpsetting.email_from')}}</label>
                                            <input type="text" class="form-control" name="input[email][{{ $v->provider }}][email_from]" value="{{ isset($email) ? $email->email_from : '' }}">
                                        </div>
                                        <div class="card-body group-{{ $v->provider }} email-provider-config" style="display: {{ isset($email->enable) ? '' : 'none' }}">
                                            <label>{{__('corpsetting.email_domain')}}</label>
                                            <input type="text" class="form-control" name="input[email][{{ $v->provider }}][domain]" value="{{ isset($email) ? $email->domain : '' }}">
                                        </div>
                                        <div class="card-body group-{{ $v->provider }} email-provider-config" style="display: {{ isset($email->enable) ? '' : 'none' }}">
                                            <label>{{__('corpsetting.email_api_key')}}</label>
                                            <input type="text" class="form-control" name="input[email][{{ $v->provider }}][api_key]" value="{{ isset($email) ? $email->api_key : '' }}">
                                        </div>
                                    </div>
                                    @php 
                                        $e++;
                                    @endphp
                                </div>
                            </div>
                        @endif
                    @endforeach


                    <div id="email_template" class="card">
                        <div class="card-header">
                            <h4 class="float-sm-left my-0 pt-2">{{__('corpsetting.email_template')}}</h4>
                            <div class="float-sm-right pt-1">
                                <label class="custom-toggle custom-toggle-default">
                                    <input id="email_template_enable" type="checkbox" class="enable-event" name="input[email][template]" {{ isset($notify_config->email->template) ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                </label>
                            </div>
                        </div>
                        <div class="card-body p-3 email-template-list" style="display: {{ isset($notify_config->email->template) ? '' : 'none' }}">
                    
                           @if(isset($email_config) && $email_config != null)
                                @foreach($email_config as $item)
                                    <div class="card">
                                        <div class="card-header">
                                        @if($item->email_type === 'INVOICE')
                                            <h4 class="float-sm-left my-0 pt-2">{{__('corpsetting.invoice')}}</h4>
                                        @elseif($item->email_type === 'RECEIPT')
                                            <h4 class="float-sm-left my-0 pt-2">{{__('corpsetting.receipt')}}</h4> 
                                            <div class="float-sm-right pt-1">
                                                <label class="custom-toggle custom-toggle-default">
                                                    <input id="receipt_enable" type="checkbox" class="enable-event"  name="input[receipt_notify]" {{ isset($notify_config->receipt_notify) ? 'checked' : '' }}>
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                                </label>
                                            </div>    
                                        @endif
                                        </div>
                                            <div class="card-body">
                                                <label>{{__('corpsetting.subject')}}</label>
                                                <input class="form-control" type="text" name="template[{{ $item->email_type }}][subject]" value="{{ $item->email_subject }}">
                                            </div>
                                            <div class="card-body ">
                                                <textarea class="email-editor" name="template[{{ $item->email_type }}][data]">
                                                    {!! $item->template !!}
                                                </textarea>
                                            </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                @endif



            <div class="row">
                <div class="col-12 text-right">
                    <div class="form-group">
                        <button onclick="submitForm()" type="button" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


@section('script.eipp.corp-setting.notify')
<style type="text/css">
    .note-toolbar .note-btn {
        color: #666;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/summernote/summernote-bs4.css') }}"/>
<script type="text/javascript" src="{{ URL::asset('assets/summernote/summernote-bs4.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/sms_counter.js') }}"></script>

<script>

    $(document).ready(function() {
        $('.email-editor').summernote();
    });

    $('#sms_message').countSms('#sms-counter');

    function isDoubleByte(str) {

        for (var i = 0, n = str.length; i < n; i++) {
            if (str.charCodeAt( i ) > 255) { 
                return true;
            }
        }
        return false;
    }

    $('#email_enable').change(function() {
        $('.email-provider').toggle();
        $('#email_tempalte').toggle();
    });

    $('#email_template_enable').change(function() {
        $('.email-template-list').toggle();
    });

    $('#receipt_enable').change(function() {
        $('.receipt-enable-list').toggle();
    });

    $('#email_provider').change(function() {
        $('.email-provider-config').toggle();
    });
 
    function submitForm()
    {
        var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
        
        $('.email-editor').each(function(data){
            var inp = $(this).attr('name');

            var encodedString = Base64.encode($(this).val());

            $('textarea[name="'+inp+'"]').val(encodedString)
        });

        $('#form_notify').submit();

    }

</script>
@endsection