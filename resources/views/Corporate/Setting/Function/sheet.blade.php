<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form action="{{ url('Corporate/Setting/Sheet') }}" method="POST" class="form" id="sheet_form">
            {{ csrf_field() }}

            <input type="hidden" name="corp_code" value="{{ $corp_code }}">

            <div class="card-header" style="border: none;">
                <h4 class="mb-0 py-1">
                    <span class="template-text">{{__('corpsetting.sheet_setting')}}</span>
                </h4> 
            </div>

            <div id="delivery_form" class="card">
                <div class="card-header">
                    <h4 class="float-sm-left my-0 pt-3">{{__('corpsetting.delivery_form')}}</h4>
                    <div class="float-sm-right pt-1">
                        <label class="custom-toggle custom-toggle-default">
                            <input id="delivery_form_enable" type="checkbox" class="enable-event" name="sheet[enable]" {{ isset($sheet_config->enable) && $sheet_config->enable == 'on' ? 'checked' : '' }}>
                            <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                        </label>
                    </div>
                </div>
                <div class="card-body p-3 delivery-form-list" style="display:{{ isset($sheet_config->enable) && $sheet_config->enable == 'on' ? '' : 'none' }}">
                    <div class="card-body">
                        <div class="pt-3">
                            <label class="form-control-label">{{__('corpsetting.spread_sheet_id')}}</label>
                            <input class="form-control" id="sheet_id" type="text" name="sheet[sheet_id]" value="{{ isset($sheet_config->sheet_id) ? $sheet_config->sheet_id : '' }}" required>
                        </div>
                        <div class="pt-3">
                            <label class="form-control-label">{{__('corpsetting.spread_sheet_name')}}</label>
                            <input class="form-control" id="sheet_name" type="text" name="sheet[sheet_name]" value="{{ isset($sheet_config->sheet_name) ? $sheet_config->sheet_name : '' }}" required>
                        </div>

                        @if(!isset($sheet_config->credentials))
                            <div class="pt-3">
                                <label class="form-control-label">{{__('corpsetting.credentials_file')}}</label>
                                <input id="credentials_file" type="file" name="" accept=".json" class="form-control">
                            </div>
                            <div id="preview_credentials" class="pt-3 d-none">
                                <label class="form-control-label">{{__('corpsetting.credentials_file')}}</label>
                                <textarea class="sheet-editor form-control" name="sheet[credentials]" id="credentials" rows="15" readonly required>
                                    
                                </textarea>
                            </div>
                        @else
                            <div class="pt-3">
                                <label class="form-control-label">{{__('corpsetting.credentials_file')}}</label>
                                <button class="btn btn-outline-primary float-sm-right" onclick="choose_file()" type="button">Upload New</button>
                            </div>
                            <div class="pt-3 d-none" id="choose_file">
                                <input id="credentials_file" type="file" name="" accept=".json" class="form-control">
                            </div>
                            <div class="pt-3" id="preview_credentials">
                                <textarea class="pt-2sheet-editor form-control" name="sheet[credentials]" id="credentials" rows="15" readonly required>
                                    {!! $sheet_config->credentials !!}
                                </textarea>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-right">
                    <div class="form-group">
                        <button onclick="submitSheet()" type="button" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@section('script.eipp.corp-setting.sheet')
<style type="text/css">
    .note-toolbar .note-btn {
        color: #666;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="file"]').change(function(e){
            file = e.target.files[0];
            fr = new FileReader();
            fr.onload = receivedText;
            fr.readAsText(file);
            e.preventDefault();
        });
    });

    function receivedText() {
        document.getElementById('credentials').value = fr.result;
        $("#preview_credentials").removeClass('d-none');
    }   

    function choose_file() {
        $("#preview_credentials").addClass('d-none');
        $("#choose_file").removeClass('d-none');
    }

    $('#delivery_form_enable').change(function() {
        console.log('delivery_form_enable change');
        $('.delivery-form-list').toggle();
    });
    

    function submitSheet()
    {
        // var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/++[++^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
        
        // $('.sheet-editor').each(function(data){
        //     var inp = $(this).attr('name');

        //     var encodedString = Base64.encode($(this).val());

        //     $('textarea[name="'+inp+'"]').val(encodedString)
        // });
        
        var sheet_id_temp   = $("#sheet_id" ).val();
        var sheet_name_temp = $("#sheet_name" ).val();
        var credential_temp = $("textarea#credentials" ).val();

        var find = ' ';
        var re = new RegExp(find, 'g');
        var sheet_id   = sheet_id_temp.replace(re, '');
        var sheet_name = sheet_name_temp.replace(re, '');
        var credential = credential_temp.replace(re, '');

        if ($('#delivery_form_enable').is(":checked")) {
            if(sheet_id == " " || sheet_id == "") {
            $( "#sheet_id" ).addClass("is-invalid");
                return false;
            }
            else {
                $( "#sheet_id" ).removeClass("is-invalid");
            }

            if(sheet_name == " " || sheet_name == "") {
                $( "#sheet_name" ).addClass("is-invalid");
                return false;
            }
            else {
                $( "#sheet_name" ).removeClass("is-invalid");
            }

            if(credentials == " " || credentials == "") {
                $( "textarea#credentials" ).addClass("is-invalid");
                return false;
            }
            else {
                $( "textarea#credentials" ).removeClass("is-invalid");
            }
        }
        
        $('#sheet_form').submit();

    }
</script>
@endsection