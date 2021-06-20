@extends('argon_layouts.app', ['title' => __('loan_contract.upload.title')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('loan_contract.upload.title')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ url('Loan/Contract')}}" class="btn btn-neutral">{{__('common.back')}}</a>
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
                        <h4 class="card-title">{{__('loan_contract.upload.instruction')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                            {{__('loan_contract.upload.instruction_description')}}
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('loan_contract.upload.file_template')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                                {{__('loan_contract.upload.file_template_description')}}
                        </p>
                        <button id="template-download" class="btn btn-primary mt-3" disabled>
                            <div class="media">
                                <img class="pt-1 pl-1" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-3 align-baseline">
                                        {{__('loan_contract.upload.download')}}<br />{{__('loan_contract.upload.template')}}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('loan_contract.upload.validation_title')}}</h4>
                        <p class="card-text text-grey-template sub-text">{{__('loan_contract.upload.validation_description')}}</p>
                        <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                            <li>{{__('loan_contract.upload.validation_description_1')}}</li>
                            <li>{{__('loan_contract.upload.validation_description_2')}}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="card-title">{{__('common.import_file')}}</h4>
                        <select class="form-control" name="template" id="template">
                            <option value="">{{__('loan_contract.upload.please_select')}}</option>
                            <option value="FLASH">{{__('loan_contract.upload.option_1')}}</option>
                            <option value="SOFTSPACE">{{__('loan_contract.upload.option_2')}}</option>
                        </select>
                        <div id="form-upload" class="">
                            <br/ >
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="function" />
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
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">

        Dropzone.autoDiscover = false;
        $("#dropzoneForm").dropzone({
            maxFiles: 1,
            url: "{!! URL::to('Loan/Upload') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class=" border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('bill.import.dropzone_message_1')}} <br />{{__('bill.import.dropzone_message_2')}}</p></div></div></div>', //override the default text
            init: function() {
                this.on("success", function(file, response) {
                    console.log('response: ', response);
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(!!response.success) {
                        window.location = "{!! URL::to('Loan/Upload/Confirm') !!}";   
                    } else {
                        Swal.fire('Oops! Someting wrong.', response.message || '', 'error');
                        return false
                    }
                })
                this.on('error', function(err) {
                    Swal.fire('Oops! Someting wrong.', response.message || '', 'error');
                    return false
                })
            },
        })

        function download_temp () {
            var template = $( "#template option:selected" ).val();
            if ( template === 'SOFTSPACE' ) {
                window.location="{!! URL::to('Loan/Upload/Template') !!}/SOFTSPACE";
            } else if ( template === 'FLASH' ) {
                window.location="{!! URL::to('Loan/Upload/Template') !!}/FLASH";
            } else {
                Swal.fire('Oops! Someting wrong.', 'Please template document.', "error");
            }
        }

        $(document).ready(function() {

            $('#template').on('change' ,function(){
                if (this.value === '' || this.value === null) {
                    $('#template-download').attr('disabled', 'disabled')
                    $('input[name="function"]').val(this.value)
                } else {
                    $('#template-download').removeAttr('disabled')
                    $('input[name="function"]').val(this.value)
                }
            })

            $('#template-download').on('click' ,function(){
                download_temp()
            })
        })
        

    </script>
@endsection