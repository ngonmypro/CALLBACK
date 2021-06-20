@extends('argon_layouts.app', ['title' => __('Payment Transaction')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__("payment_transaction.title")}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <!-- <div class="col-lg-6 col-5 text-right">
                        <a href="{{ url('PaymentTransaction')}}" class="btn btn-neutral">{{__("common.back")}}</a>
                    </div> -->
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
                        <button class="btn btn-primary template-download mt-3" onclick="download_temp()">
                            <div class="media">
                                <img class="pt-1 pl-1" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-3 align-baseline">
                                    {{__('bill.import.download')}}<br />{{__('bill.import.template')}}
                                </div>
                            </div>
                        </button>
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
                        <h4 class="card-title">{{__("common.import_file")}}</h4>
                        <select class="form-control" name="bank" id="bank">
                            <option disabled selected>{{__('payment_transaction.please_select')}}</option>
                            <option value="DUITNOW">DuitNow</option>
                            <option value="CASH">{{__('payment_transaction.cash')}}</option>
                        </select>
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
        </div>
    </div>

@endsection

@section('script')
    <!-- Dropzone drag & move upload file -->
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>=
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">
        
        function download_temp() {
            var template = $( '#bank option:selected' ).val()
            const __options = ['CASH', 'DUITNOW']
            if ( __options.indexOf( template ) === -1 ) {
                @if( app()->getLocale() === "th" )
                    Swal.fire( 'เกิดข้อผิดพลาด', 'กรุณาเลือกรูปแบบเอกสาร', 'warning' )
                @elseif ( app()->getLocale() === "en" )
                    Swal.fire( 'Oops! Someting wrong.', 'Please template document.', 'warning' )
                @endif
            } else {
                window.open(` {{ url("PaymentTransaction/Download/Template") }}/${template} `)
            }
        }
        
        $('#bank').on('change' ,function(){
            $('input[name=bank_payment]').val(this.value)
        })

        Dropzone.autoDiscover = false;

        $('#dropzoneForm').dropzone({
            // maxFiles: 1,
            url: "{!! URL::to('PaymentTransaction/Import') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class="border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__("common.import.dropzone_message_1")}} <br />{{__("common.import.dropzone_message_2")}}</p></div></div></div>', //override the default text
            init: function() {

                this.on('sending', function() {
                    $.blockUI()
                })

                this.on('success', function(file, response) {
                    $.unblockUI()
                    sessionStorage.setItem('filename', file.upload.filename)
                    if ( response.success ) {
                        console.log('response: ', response)
                        if (response.redirectTo) {
                            window.location = response.redirectTo
                        } else {
                            window.location = "{!! URL::to('PaymentTransaction/Import/Confirm') !!}"
                        }
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
        })

    </script>
@endsection.