@extends('argon_layouts.app', ['title' => __('Import Settlement')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
    
    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Upload Settlement</h6>
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
                        <h4 class="card-title">{{__('recipient.import.instruction')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                        {{__('recipient.import.instruction_description')}}
                        </p>
                    </div>
                </div>
               
              
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">                
                        <h4 class="card-title">Import Settlement</h4>
                        <label>{{__('bill.import.upload_type')}}</label>
                        <select class="form-control" name="type_upload" id="type_upload">
                            <option value="">Please select channel</option>
                            @foreach($bank_payment_channel as $c_nel)
                                <option value="{{$c_nel->id}}">{{$c_nel->channel_name}}</option>
                            @endforeach
                        </select>

                        <div id="form-upload" class="">
                            <br/ >
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="chennel_name" value=""/>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>


    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">

        $(document).ready(function(){
            $('input[name="mapping_id"]').val($("#mapping_list").val());
            $('input[name="branch_code"]').val($("#branch_code").val());
            if($('input[name="upload_type"]').val() == 'new') {
                $('#type_upload option[value=new]').attr('selected','selected');
            }
            else {
                $('#type_upload option[value=replace]').attr('selected','selected');
            }
        });

        $("#type_upload").on("change" ,function(){
            $('input[name="chennel_name"]').val(this.value);
        });


        Dropzone.autoDiscover = false;

        $("#dropzoneForm").dropzone({
            url: "{!! URL::to('Settlement/Product/Upload') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class=" border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('bill.import.dropzone_message_1')}} <br />{{__('bill.import.dropzone_message_2')}}</p></div></div></div>', //override the default text
            init: function() {
                this.on('sending', function() {
                    $.blockUI()
                })
                this.on("success", function(file, response) {
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(response.success == true)
                    {
                        Swal.fire(`{{ (__('common.success')) }}`, response.message, 'success').then((result) => {
                            if (result.value) {
                                window.location.reload()
                            }
                        })
                    }
                    else
                    {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "ข้อมูลไม่ถูกต้อง",
                            type: "error",
                        });
                        window.location.reload()
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

        function download_temp(template_type){
            window.open(' {{ url("Recipient/Upload/Template") }}/'+template_type);
        }
    </script>
@endsection