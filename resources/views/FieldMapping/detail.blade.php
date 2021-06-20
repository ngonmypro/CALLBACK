@extends('argon_layouts.app', ['title' => __('E-Tax')])
@section('title', 'Create Mapping Field')
@section('style')
    <style type="text/css">
        
    </style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('fieldmapping.mapping_field_info')}}">

<div class="col-12">
    <div class="d-flex flex-wrap mb-3">
        <div class="ml-auto p-2">
            <button class="btn btn-primary template-download mt-3" onclick="download_temp()">
                <div class="media">
                    <img class="pt-1 pl-1" src="http://127.0.0.1:7070/assets/images/download.png">
                    <div class="media-body text-left pl-3 align-baseline">
                        CSV File<br>for SFTP
                    </div>
                </div>
            </button>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="form-group">  
                <div class="row">
                    <div class="col-6">
                        <label>{{__('fieldmapping.name')}}</label>
                        <input class="form-control" value="{{ isset($data->name) ? $data->name : ''}}" disabled/>
                    </div>
                    <div class="col-6">
                        <label>{{__('fieldmapping.doc_type')}}</label>
                        <input class="form-control" value="{{ isset($data->doc_type) ? ucwords(str_replace('_', ' ', strtolower($data->doc_type))) : ''}}" disabled/>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-12">
                        <label>{{__('fieldmapping.dir')}}</label>
                        <!-- <input class="form-control" value="{{ isset($data->code_name) && isset($data->doc_type) ? 'sftp_upload/'.Session::get('CORP_CURRENT')['corp_code'].'/inbound/'.$data->doc_type.'/'.$data->code_name : ''}}" disabled/> -->
                        <input class="form-control" name="document" value="{{ isset($data->code_name) && isset($data->doc_type) ? $data->doc_type.'/'.$data->code_name : ''}}" disabled/>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="form-group">  
                <div class="row">
                    <table id="mapping_table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('fieldmapping.system_field')}}</th>
                                <th>{{__('fieldmapping.your_field')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->field_data as $k => $v)
                                <tr>
                                    <td class="index">
                                        <span>{{ $v->order }}</span>
                                    </td>
                                    <td class="inputSysKey">
                                        {{ $v->field_key }}
                                    </td>
                                    <td>
                                        {{ $v->field_data }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

</div>
@endsection

@section('script')
    <!-- Dropzone drag & move upload file -->
    <script type="text/javascript">
        function download_temp(){
            var documents = $('input[name="document"]').val();
            window.open(' {{ url("FieldMapping/Template") }}/'+documents);
        }
    </script>
@endsection