@extends('argon_layouts.app', ['title' => __('E-Tax')])
@section('title', 'Upload Field Mapping')
@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('fieldmapping.upload_field_mapping')}}">
    <section>
        <div class="section__content section__content--p30 pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 pr-4">
                        <div class="card border-0">
                            <div class="card-body pr-12">
                                <h4 class="card-title border-bottom pb-3 template-text">{{__('fieldmapping.instruction')}}</h4>
                                <p class="card-text text-grey-template sub-text">
                                    {{__('fieldmapping.instruction_description')}}
                                </p>
                            </div>
                        </div>
                        <div class="card border-0">
                            <div class="card-body pr-12">
                                <h4 class="card-title border-bottom pb-3 template-text">{{__('fieldmapping.file_validation')}}</h4>
                                <p class="card-text text-grey-template sub-text">
                                   {{__('fieldmapping.file_validation_title')}}
                                </p>
                                <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                                    <li>
                                        <p class="card-text text-grey-template sub-text">{{__('fieldmapping.file_validation_description_1')}}</p>
                                    </li>
                                    <li>
                                        <p class="card-text text-grey-template sub-text">{{__('fieldmapping.file_validation_description_2')}}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li>{{__('fieldmapping.select_document_type')}}</li>
                                </ul>
                                <select class="form-control" name="doc_type" id="doc_type_list">
                                    <option value="">-- {{__('fieldmapping.please_select_document_type')}} --</option>
                                    @if($document_type != null)
                                        @foreach($document_type as $list)
                                            <option value="{{ $list->document_name_alias }}">{{ $list->document_name_en }} | {{ $list->document_name_th }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div id="form-upload" class="d-none">
                                    <div class="card border-light" id="dropzone">
                                        <div class="card-body">
                                            <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                                <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="document_type" />
                                                </form>
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
    </section>

@endsection

@section('script')
    <!-- Dropzone drag & move upload file -->
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
    <script type="text/javascript">
        $("#doc_type_list").on("change" ,function(){
            // $('input[name="doc_type"]').val(this.value)
            
            $('input[name="document_type"]').val(this.value);
            
            if(this.value != null && this.value != "")
            {
                $('#form-upload').removeClass('d-none');
            }
            else
            {
                $('#form-upload').addClass('d-none');
            }
        });

        Dropzone.autoDiscover = false;

        $("#dropzoneForm").dropzone({
            // maxFiles: 1,
            url: "{!! URL::to('FieldMapping/Import') !!}",
            method: 'post',
            clickable: '.upload-zone',
            params: {'document_type': $('#document_type').val()},
            acceptedFiles: '.csv,.xls,.xlsx', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class="center border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('fieldmapping.dropzone_message_1')}} <br />{{__('fieldmapping.dropzone_message_2')}}</p></div></div></div>', //override the default text
            init: function() {
                this.on("success", function(file, response) {
                    // console.log(response)
                    if(response.success == true)
                    {
                        window.location = "{!! URL::to('FieldMapping/Create') !!}";
                    }
                    else
                    {
                        console.log(response)
                        OpenAlertModal('Oops!', response.message, ModalCloseButtonTemplate('close', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'));
                        this.removeFile(file);
                        return false;
                    }
                })
            },
        });


    </script>
@endsection