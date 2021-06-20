@extends('argon_layouts.app', ['title' => __('Import Recipient')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
    
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Upload Recurring</h6>
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
                        <h4 class="card-title">{{__("common.import.instruction")}}</h4>
                        <p class="card-text text-grey-template sub-text">
                           {{__("common.import.instruction_description")}}
                        </p>
                    
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__("common.import.file_validation")}}</h4>
                        <p class="card-text text-grey-template sub-text">
                            {{__("common.import.file_validation_description")}}
                        </p>
                        <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                            <li>
                                <p class="card-text text-grey-template sub-text">{{__("common.import.file_validation_description_1")}}</p>
                            </li>
                            <li>
                                <p class="card-text text-grey-template sub-text">{{__("common.import.file_validation_description_2")}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">   
                    <h4 class="card-title">Import Recurring</h4>

                        <label>Type</label>
                        <select class="form-control" name="type_upload" id="type_upload">
                            <option value="approved">APPROVED</option>
                            <option value="declined">DECLINED</option>
                        </select>             
                        <div id="form-upload" class="">
                            <br/ >
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="upload_type" value="approved"/>
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

@endsection

@section('script')
    <!-- Dropzone drag & move upload file -->
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            $('input[name="mapping_id"]').val($("#mapping_list").val());
            $('input[name="branch_code"]').val($("#branch_code").val());
            if($('input[name="upload_type"]').val() == 'approved') {
                $('#type_upload option[value=approved]').attr('selected','selected');
            }
            else {
                $('#type_upload option[value=declined]').attr('selected','selected');
            }
        });

        // $("#type_upload").on("change" ,function(){
        //     $('input[name="upload_type"]').val(this.value);
        //     console.log($('input[name="upload_type"]').val(this.value));
        // });
        $("#type_upload").on("change" ,function(){
            $('input[name="upload_type"]').val(this.value);
        });

        Dropzone.autoDiscover = false;

        $("#dropzoneForm").dropzone({
            
            // maxFiles: 1,
            url: "{!! URL::to('Recurring/Payment/upload') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.txt', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class=" border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('bill.import.dropzone_message_1')}} <br />{{__('bill.import.dropzone_message_2')}}</p></div></div></div>', //override the default text
            init: function() {
                this.on('sending', function() {
                    $.blockUI()
                })
                this.on("success", function(file, response) {
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(response.success == true)
                    {
                        window.location = "{!! URL::to('Recurring/Payment/show') !!}";  
                    }
                    else
                    {
                        $.unblockUI()
                        swal("เกิดข้อผิดพลาด", response.message, "error");
                        CloseModalCallback(() => {
                            window.location.reload()
                        })
                    }

                })
                this.on('error', function(err) {
                    $.unblockUI()
                    console.error('error: ', err)
                    Swal.fire(`{{ __('common.error') }}`, err.message || '', 'error')
                })
            },
            error: (err) => {
                $.unblockUI()
                swal("เกิดข้อผิดพลาด", JSON.stringify(err), "error");
                CloseModalCallback(() => {
                    window.location.reload()
                })
            }
        });

        function download_temp_approve(template_type){
            window.open(' {{ url("Recurring/Transaction/DownloadTemplate/Approve") }}/'+template_type);
        }

        function download_temp_declined(template_type){
            window.open(' {{ url("Recurring/Transaction/DownloadTemplate/Declined") }}/'+template_type);
        }

    </script>
@endsection