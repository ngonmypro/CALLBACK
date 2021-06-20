<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form action="{{ url('Corporate/Setting/Line') }}" method="POST" class="form">

                {{ csrf_field() }}

                <input type="hidden" name="corp_code" value="{{ $corp_code }}">

                <div class="card-header" style="border: none;">
                    <h4 class="mb-0 py-1">
                        <span class="template-text">Line Setting</span>
                    </h4> 
                </div>
                @if(isset($line_config) && $line_config != NULL)
                    @foreach($line_config as $i => $data)
                        @php
                            $item = $data != NULL ? json_decode($data->config) : NULL;
                        @endphp
                        <div class="card">
                            <div class="card-body" style="display: ">
                                <input type="hidden" name="config[{{$i}}][code]" value="{{ isset($data->code) ? $data->code : '' }}">
                                <div class="form-group">
                                    <label>NAME</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][name]" value="{{ isset($item->name) ? $item->name : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>LINE ID</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][line_id]" value="{{ isset($item->line_id) ? $item->line_id : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>LINE URI</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][line_uri]" value="{{ isset($item->line_uri) ? $item->line_uri : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>AUTH ENDPOINT</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][auth_endpoint]" value="{{ isset($item->auth_endpoint) ? $item->auth_endpoint : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>AUTH LIFF ID</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][auth_liff]" value="{{ isset($item->auth_liff) ? $item->auth_liff : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>APP ENDPOINT</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][app_endpoint]" value="{{ isset($item->app_endpoint) ? $item->app_endpoint : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>APP LIFF ID</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][app_liff]" value="{{ isset($item->app_liff) ? $item->app_liff : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>THEME</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][theme]" value="{{ isset($item->theme) ? $item->theme : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>TOKEN</label>
                                    <input type="text" class="form-control" name="config[{{$i}}][token]" value="{{ isset($item->token) ? $item->token : '' }}">
                                </div>
                                <div class="form-group">
                                    <label>DEBUG</label>
                                    <br>
                                    <label class="custom-toggle custom-toggle-default">
                                        <input type="checkbox" class="enable-event" name="config[{{$i}}][enable]" {{ isset($item->enable) ? 'checked' : '' }}>
                                        <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
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


@section('script.eipp.corp-setting.notify')
<script>


</script>
@endsection