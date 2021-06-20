@extends('layouts.master')
@section('title', 'Upload Recipient Invoice')
@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Upload Recipient Invoice">
    <section>
        <div class="section__content section__content--p30 pt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 pr-4">
                        <div class="card bg-transparent border-0">
                            <div class="card-body pl-0 pb-0 pr-12">
                                <h4 class="card-title border-bottom pb-3 text-secondary">Instruction</h4>
                                <p class="card-text text-grey-template sub-text">
                                    To upload new Bill, Click upload file and select file from your computer or drag selectred file directory to this site.
                                </p>
                            </div>
                        </div>
                        <div class="card bg-transparent border-0">
                            <div class="card-body pl-0 pb-0 pr-12">
                                <h4 class="card-title border-bottom pb-3 text-secondary">File Templates</h4>
                                <p class="card-text text-grey-template sub-text">
                                    For new user, You can download template file from download template button.
                                </p>
                                <button class="btn btn-primary template-download mt-3" onclick="download_temp()">
                                    <div class="media">
                                        <img class="pt-1 pl-1" src="{{ URL::asset('assets/images/download.png') }}">
                                        <div class="media-body text-left pl-3 align-baseline">
                                            download<br />template
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="card bg-transparent border-0">
                            <div class="card-body pl-0 pb-0 pr-12">
                                <h4 class="card-title border-bottom pb-3 text-secondary">File Validation</h4>
                                <p class="card-text text-grey-template sub-text">
                                    File data should follow this validation
                                </p>
                                <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                                    <li>Filling data in every fills ,Only  remarks is optional.</li>
                                    <li>This function ia only support CSV file.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="form-group row" id="group_MAID">
                            <label for="bill_template" class="col-3 col-form-label text-right">Bill Template :</label>
                            <div class="col-8">
                                <select id="bill_template" class="form-control" name="bill_template" >
                                    <option value="default" selected>Default Template</option>
                                    @foreach($template_list as $template)
                                        <option value="{{$template->id}}">{{$template->template_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card border-light">
                            <div class="card-body">
                                <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                    <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data" disabled>
                                        {!! csrf_field() !!}

                                    </form>
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
            $("#bill_template").val($("#bill_template option:first").val());
        });

        Dropzone.autoDiscover = false;

        var mydropzone = new Dropzone("#dropzoneForm", {
            // maxFiles: 1,
            url: "{!! URL::to('Bill/Consumer/Upload') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class="center border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">drag or click to upload file <br />from your computer</p></div></div></div>', //override the default text
            sending: function(file, xhr, formData) {
                formData.append("template_id", $('#bill_template').val());
            },
            init: function() {
                this.on("success", function(file, response) {
                    console.log(response.success);
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(response.success == true)
                    {
                        console.log(response);
                        window.location = "{!! URL::to('Bill/Consumer/Upload/Confirm') !!}";
                    }
                    else
                    {
                        console.log(response);
                        OpenAlertModal(GetModalHeader('แจ้งเตือน'), `<div class="py-3">${response.message}</div>`)
                        mydropzone.removeFile(file);
                        return false
                    }
                })
            },
        });

        // mydropzone.disable();
        //
        // $('.blockOverlay', '#dropzoneForm').css('cursor', 'auto');
        //
        // $('#dropzoneForm').block({ message: 'กรุณาเลือก Bill Template ก่อนทำการ Upload', css: { width: '400px', height: '50px' }});
        //
        // $('#bill_template').on('change', function() {
        //   mydropzone.enable();
        //   $('#dropzoneForm').unblock();
        // });

        function download_temp(){
            window.location="{!! URL::to('Bill/Consumer/Upload/Template') !!}";
        }
    </script>
@endsection
