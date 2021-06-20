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
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('recipient.import.title')}}</h6>
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
                        <h4 class="card-title">Instruction</h4>
                        <p class="card-text text-grey-template sub-text">
                        To upload your File, Click upload file and select file from your computer or drag and drop file to Dropzone.
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('recipient.import.file_template')}}</h4>
                        {{-- <p class="card-text text-grey-template sub-text">
                            template_description
                        </p> --}}
                        <button class="btn btn-primary template-download" onclick="download_temp('csv')">
                            <div class="media">
                                <img class="pt-1 pl-1" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-3 align-baseline">
                                    Download CSV<br />Template
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">                
                        <h4 class="card-title">Import Product</h4>
                        <div id="form-upload" class="">
                            <br/ >
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="category_name" value=""/>
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
<script type="text/javascript">

    Dropzone.autoDiscover = false;

    $("#dropzoneForm").dropzone({
        // maxFiles: 1,
        url: "{!! URL::to('BAAC/Product/Upload') !!}",
        method: 'post',
        clickable: '.upload-zone',
        acceptedFiles: '.csv,.xls,.xlsx', //allowed filetypes
        dictDefaultMessage: '<div class="row"><div class="col-12"><div class=" border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('bill.import.dropzone_message_1')}} <br />{{__('bill.import.dropzone_message_2')}}</p></div></div></div>', //override the default text
        init: function() {
            this.on('sending', function() {
                $.blockUI()
            })
            this.on("success", function(file, response) {
                if(response.success == true)
                {
                    console.log(response);
                    $.unblockUI()
                    Swal.fire("Import Success", "Import Product Success", "success");
                }
                else
                {
                    console.log(response.message);
                    $.unblockUI()
                    // OpenAlertModal('เกิดข้อผิดพลาด', response.message, ModalCloseButtonTemplate('close', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'))
                     Swal.fire("เกิดข้อผิดพลาด", response.message, "error")
                    .then(() => {
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
            // OpenAlertModal('เกิดข้อผิดพลาด', JSON.stringify(err), ModalCloseButtonTemplate('close', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'))
            Swal.fire("เกิดข้อผิดพลาด", JSON.stringify(err), "error")
            .then(() => {
                window.location.reload()
            })
        }
    });

    function download_temp(template_type){
        alert('not available');
    }
</script>
@endsection