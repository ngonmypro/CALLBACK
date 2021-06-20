@extends('argon_layouts.app', ['title' => __('E-Tax')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Upload E-Tax">
    <section>
        <div class="section__content section__content--p30 pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 pr-4">
                        <div class="card border-0">
                            <div class="card-body pr-12">
                                <h4 class="card-title border-bottom pb-3 template-text">{{__('etax.instruction')}}</h4>
                                <p class="card-text text-grey-template sub-text">
                                    {{__('etax.instruction_description')}}
                                </p>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body pr-12">
                                <h4 class="card-title border-bottom pb-3 template-text">{{__('etax.file_template')}}</h4>
                                <p class="card-text text-grey-template sub-text">
                                    {{__('etax.file_template_description')}}
                                </p>
                                <button class="btn btn-primary template-download mt-3" onclick="download_temp()">
                                    <div class="media">
                                        <img class="pt-1 pl-1" src="{{ URL::asset('assets/images/download.png') }}">
                                        <div class="media-body text-left pl-3 align-baseline">
                                            {{__('etax.download')}}<br />{{__('etax.template')}}
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body pr-12">
                                <h4 class="card-title border-bottom pb-3 template-text">{{__('etax.file_validation')}}</h4>
                                <p class="card-text text-grey-template sub-text">
                                    {{__('etax.file_validation_title')}}
                                </p>
                                <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                                    <li>
                                        <p class="card-text text-grey-template sub-text">{{__('etax.file_validation_description_1')}}</p>
                                    </li>
                                    <li>
                                        <p class="card-text text-grey-template sub-text">{{__('etax.file_validation_description_2')}}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="font-weight-bold">{{__('etax.upload_type')}}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <select class="form-control" name="type_upload" id="type_upload">
                                                <option value="new">{{__('etax.new_upload')}}</option>
                                                <option value="replace">{{__('etax.replace_upload')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </ul>
                                <hr/>
                                <ul class="list-unstyled">
                                    <li class="font-weight-bold">{{__('etax.select_document_type')}}</li>
                                </ul>
                                <ul class="list-unstyled">
                                    <select class="form-control" name="doc_type" id="doc_type_list">
                                        <option value="">-- {{__('etax.please_select_document_type')}} --</option>
                                        @foreach($doc_type as $list)
                                            <option value="{{ $list->document_name_alias }}" {{ $list->document_name_alias == session('upload_template')['document_type'] ? 'selected' : '' }}>{{ $list->document_name_en }} | {{ $list->document_name_th }}</option>
                                        @endforeach
                                    </select>
                                </ul>
                                <ul class="list-unstyled" id="form-upload">
                                    <div class="">
                                        <div class="row">
                                            <div class="list-unstyled col-xl-6">
                                                <label class="form-control-label mb-3 font-weight-bold">{{__('etax.please_select_mapping_type')}}</label>
                                                <select class="form-control" name="mapping_field" id="mapping_list">
                                                </select>
                                            </div>
                                            <div class="list-unstyled col-xl-6">
                                                <label class="form-control-label mb-3 font-weight-bold">{{__('etax.pdf_template')}}</label>
                                                <select class="form-control" name="template_pdf" id="template_pdf">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row py-5">
                                            <div class="list-unstyled col-xl-12" id="dropzone">
                                                <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                                    <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="upload_type" value="{{ isset(session('upload_template')['upload_type']) ? session('upload_template')['upload_type'] : 'new'}}"/>
                                                        <input type="hidden" name="document_type" value="{{ session('upload_template')['document_type'] }}"/>
                                                        <input type="hidden" name="mapping_id" value="{{ session('upload_template')['mapping_id'] }}"/>
                                                        <input type="hidden" name="pdf_template" value="{{ isset(session('upload_template')['pdf_template']) ? session('upload_template')['pdf_template'] : 'default' }}"/>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <!-- Dropzone drag & move upload file -->
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            if($('input[name="document_type"]').val() != null && $('input[name="document_type"]').val() != '') {
                get_mapping($('input[name="document_type"]').val())  
                $('#form-upload').removeClass('d-none')
            }
            else {
                $('#form-upload').addClass('d-none')
            }

            if($('input[name="upload_type"]').val() == 'new') {
                $('#type_upload option[value=new]').attr('selected','selected');
            }
            else {
                $('#type_upload option[value=replace]').attr('selected','selected');
            }
        });
        
        $("#doc_type_list").on("change" ,function(){
            // $('input[name="doc_type"]').val(this.value)
            
            $('input[name="document_type"]').val(this.value);
            
            if(this.value != null && this.value != "")
            {
                $("#mapping_list").empty();
                get_mapping(this.value)
            }
            else
            {
                $('#form-upload').addClass('d-none');
            }
        });

        $('select[name="type_upload"]').on("change" ,function(){
            $('input[name="upload_type"]').val(this.value);
        });

        $("#template_pdf").on("change" ,function(){
            $('input[name="pdf_template"]').val(this.value);
        });

        function get_mapping(name_alias) {
            $.ajax({
                url: "{!! URL::to('ETax/get_corp_mapping_field') !!}/",
                method: 'POST',
                data : {
                        _token      : "{{ csrf_token() }}",
                        name_alias  : name_alias
                },
                error: function(response) {
                    // OpenAlertModal('{{__('create_confirm.fail')}}', response.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2'));
                    Swal.fire({
                        title: '{{__("create_confirm.fail")}}',
                        html: responseData.message,
                        type: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                success: function(response)
                {
                    if(response.success == true)
                    {
                        mapping_list = response.mapping_list;
                        // opt = '<option value="defualt">-- Defualt --</option>';
                        $("#mapping_list").empty();
                        opt = "";
                        for(var i=0; i < mapping_list.length; i++)
                        {
                            opt = opt + '<option value="'+mapping_list[i].id+'">'+mapping_list[i].name+'</option>';
                        }
                        $("#mapping_list").append(opt);
                        $('input[name="mapping_id"]').val($("#mapping_list").val());

                        pdf_template = response.pdf_template;
                        // opt = '<option value="defualt">-- Defualt --</option>';
                        $("#template_pdf").empty();
                        opt = '<option value="default">Default Template</option>';
                        for(var i=0; i < pdf_template.length; i++)
                        {
                            opt = opt + '<option value="'+pdf_template[i].template_name+'">'+pdf_template[i].template_name+'</option>';
                        }
                        $("#template_pdf").append(opt);
                        $('#form-upload').removeClass('d-none');
                        $('input[name="pdf_template"]').val($("#template_pdf").val());
                    }
                    else
                    {
                        // OpenAlertModal('{{__('create_confirm.fail')}}', response.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2'));
                        Swal.fire({
                            title: '{{__("create_confirm.fail")}}',
                            html: responseData.message,
                            type: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        $("#mapping_list").on("change" ,function(){
            // alert(this.value);
            $('input[name="mapping_id"]').val(this.value);
        });
        
        Dropzone.autoDiscover = false;

        $("#dropzoneForm").dropzone({
            // maxFiles: 1,
            url: "{!! URL::to('ETax/Create') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class="center border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">drag or click to upload file <br />from your computer</p></div></div></div>', //override the default text
            init: function() {
                this.on('sending', function() {
                    $.blockUI()
                })
                this.on("success", function(file, response) {
                    console.log(response.success);
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(response.success == true)
                    {
                        console.log(response);
                        window.location = "{!! URL::to('ETax/Create/Confirm') !!}";   
                    }
                    else
                    {
                        $.unblockUI();
                        // OpenAlertModal('{{__('create_confirm.fail')}}', response.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2'));
                        Swal.fire({
                            title: '{{__("create_confirm.fail")}}',
                            html: responseData.message,
                            type: 'error',
                            confirmButtonText: 'OK'
                        });
                        this.removeFile(file);
                        return false;
                    }
                })
                this.on('error', function(err) {
                    $.unblockUI()
                    // OpenAlertModal('{{__('create_confirm.fail')}}', response.message, ModalCloseButtonTemplate('{{__('create_confirm.close')}}', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2'));
                    Swal.fire({
                        title: '{{__("create_confirm.fail")}}',
                        html: responseData.message,
                        type: 'error',
                        confirmButtonText: 'OK'
                    });
                })
            },
        });

        function download_temp(){
            var document_type = $('input[name="document_type"]').val();
            var mapping_id = $('input[name="mapping_id"]').val();



            if(document_type === "" || mapping_id === "") {
                // OpenAlertModal('{{__('create_confirm.fail')}}', '{{__('create_confirm.select_document')}}', ModalCloseButtonTemplate('close', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2'));
                Swal.fire({
                    title: '{{__("create_confirm.fail")}}',
                    html: responseData.message,
                    type: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            window.open(' {{ url("ETax/Get/Template") }}/'+document_type+'/'+mapping_id);
        }
    </script>
@endsection
