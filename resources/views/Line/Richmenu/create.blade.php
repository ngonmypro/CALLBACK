@extends('argon_layouts.app', ['title' => __('Rich Menu')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Create Rich Menu</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Upload Image</h4>
                        <label>Preview Image</label>
                        <img id="preview_img" src="" class="img" style="width: 100%;border: 1px dashed #ccc">
                        <div id="form-upload" class="">
                            <br/>
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="bank_payment" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">{{__("common.import_file")}}</h4>
                        <div class="form-group">
                            <label>App</label>
                            <select name="line_app_code" class="form-control">
                                <option value="">Please Select App</option>
                                @if(isset($data))
                                    @foreach($data as $item)
                                        @php
                                            $config = isset($item->config) ? json_decode($item->config) : NULL;
                                        @endphp
                                        <option value="{{ $item->code }}">{{ isset($config->name) ? $config->name : '' }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="richmenu_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="richmenu_desc" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Config</label>
                            <textarea class="form-control" rows="20" name="config"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Default Auth</label>
                            <br/>
                            <label class="custom-toggle">
                                <input name="richmenu_default_auth" type="checkbox">
                                <span class="custom-toggle-slider rounded-circle" data-label-off="Off" data-label-on="On"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Default App</label>
                            <br/>
                            <label class="custom-toggle">
                                <input name="richmenu_default_app" type="checkbox">
                                <span class="custom-toggle-slider rounded-circle" data-label-off="Off" data-label-on="On"></span>
                            </label>
                        </div>
                        <br>
                        <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
                    </div>
                </div>                      
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>=
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">


        Dropzone.options.dropzoneForm = {
            // maxFiles: 1,
            url: "{!! URL::to('Line/Richmenu/Create') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.png,.jpg,.jpeg', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class="border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__("common.import.dropzone_message_1")}} <br />{{__("common.import.dropzone_message_2")}}</p></div></div></div>', //override the default text
            autoProcessQueue: false,
            init: function() {

                var drop = this;

                $("#submit_btn").click(function (e) {
                    e.preventDefault();
                    drop.processQueue();
                });

                this.on('addedfile', function(file) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview_img').attr('src',event.target.result)
                    };
                    reader.readAsDataURL(file);
                })

                this.on('sending', function(file, xhr, formData) {
                    formData.append("file_type", file.type);  
                    formData.append("line_app_code", $('select[name="line_app_code"]').val());  
                    formData.append("img_base64", $('#preview_img').attr('src')); 
                    formData.append("config", $('textarea[name="config"]').val());  
                    formData.append("richmenu_name", $('input[name="richmenu_name"]').val());   
                    formData.append("richmenu_desc", $('input[name="richmenu_desc"]').val());   
                    formData.append("richmenu_default_app", $('input[name="richmenu_default_app"]').val()); 
                    formData.append("richmenu_default_auth", $('input[name="richmenu_default_auth"]').val());   
                    $.blockUI()
                    var data = $('dropzoneForm').serializeArray();
                    $.each(data, function(key, el) {
                        formData.append(el.name, el.value);
                    });
                })

                this.on('success', function(file, response) {
                    $.unblockUI()
                    if ( response.success ) {
                        window.location = "{!! URL::to('Line/Richmenu') !!}"
                    } else {
                        Swal.fire(`{{ __('common.error') }}`, response.message, 'error')
                        return false
                    }
                })

                this.on('error', function(err) {
                    $.unblockUI()
                    console.error('error: ', err)
                    Swal.fire(`{{ __('common.error') }}`, err.message || '', 'error')
                })
            },
        }
    </script>
@endsection