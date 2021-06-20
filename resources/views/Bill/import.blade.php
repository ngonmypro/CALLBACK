@extends('argon_layouts.app', ['title' => __('Bill Import')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('bill.import.title')}}</h6>
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
                        <h4 class="card-title">{{__('bill.import.instruction')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                            {{__('bill.import.instruction_description')}}
                        </p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('bill.import.file_template')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                            {{__('bill.import.file_template_description')}}
                        </p>
                        <button class="btn btn-primary template-download mt-3" onclick="download_temp('short')">
                            <div class="media">
                                <img class="pt-1" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-2 align-baseline">
                                    {{__('bill.import.download')}}<br />{{__('bill.import.template')}}
                                </div>
                            </div>
                        </button>
                        <button class="btn btn-primary template-download mt-3 w-30" onclick="download_temp('full')">
                            <div class="media">
                                <img class="pt-1" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-2 align-baseline">
                                    {{__('bill.import.download')}}<br />{{__('bill.import.full_template')}}
                                </div>
                            </div>
                        </button>
                        <p class="pt-4 card-text text-grey-template sub-text">
                            {{__('bill.import.file_template_xls_description')}}
                        </p>
                        <button class="btn btn-primary template-download" onclick="download_temp('xlsx')">
                            <div class="media">
                                <img class="" src="{{ URL::asset('assets/images/download.png') }}">
                                <div class="media-body text-left pl-2 align-baseline">
                                    {{__('bill.import.download_xls')}}<br />{{__('bill.import.template')}}
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('bill.import.file_validation')}}</h4>
                        <p class="card-text text-grey-template sub-text">
                            {{__('bill.import.file_validation_description')}}
                        </p>
                        <ul class="card-text text-grey-template list-style-type-decimal pl-2_5 sub-text">
                            <li>
                                <p class="card-text text-grey-template sub-text">{{__('bill.import.file_validation_description_1')}}</p>
                            </li>
                            <li>
                                <p class="card-text text-grey-template sub-text">{{__('bill.import.file_validation_description_2')}}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{__('bill.import.import_bill')}}</h4>
                        <label>{{__('bill.import.upload_type')}}</label>
                        <select class="form-control" name="type_upload" id="type_upload">
                            <option value="new">{{__('bill.import.new_upload')}}</option>
                            <option value="replace">{{__('bill.import.replace_upload')}}</option>
                        </select>
                        <br/>
                        @if(in_array('recurring', @Session::get('payment_recurring')) && session('user_detail')->user_type === 'USER')
                        <div id="div-payment" class="">
                        <label>{{__('bill.import.payment_type')}}</label>
                        <select class="form-control" id="payment_type">
                            <!-- <option value="null">{{__('bill.import.general_payment')}}</option>
                            <option value="recurring">{{__('bill.import.payment_recurring')}}</option> -->
                            <option value="null">{{__('bill.import.general_payment')}}</option>
                            @if(isset($payment_channel))
                                @foreach($payment_channel as $payment_channel)
                                    <option value="{{ $payment_channel }}">{{ strtoupper(str_replace('_', ' ', $payment_channel)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br/>
                        </div>
                        @endif
                        <label>{{__('bill.import.mapping')}}</label>
                        <select class="form-control" name="mapping_field" id="mapping_list">
                            @if(isset($mapping))
                                @foreach($mapping as $list)
                                    <option value="{{ $list['id'] }}">{{ $list['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        <br/>
                        <label>{{__('bill.import.corporate_branch')}}</label>
                        <select class="form-control" name="branch_code" id="branch_code">
                            @if(isset($branch))
                                @foreach($branch as $list)
                                    @if(app()->getLocale() == 'th')
                                    <option value="{{ $list['branch_code'] }}">{{ $list['name_th'] }}</option>
                                    @else
                                    <option value="{{ $list['branch_code'] }}">{{ $list['name_en'] }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        <div id="form-upload" class="">
                            <br/ >
                            <div class="card border-light" id="dropzone">
                                <div class="card-body">
                                    <div class="col-xl-12 upload-zone" style="cursor: pointer;">
                                        <form method="post" class="dropzone custom-dropzone" id="dropzoneForm" enctype="multipart/form-data">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="document_type" value="b2c_invoice"/>
                                            <input type="hidden" name="mapping_id" />
                                            <input type="hidden" name="branch_code" />
                                            <input type="hidden" name="upload_type" value="new"/>
                                            <input type="hidden" name="payment_type" value=""/>
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
    
    {{-- <script src="{{ asset('argon') }}/assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script> --}}

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('input[name="mapping_id"]').val($("#mapping_list").val());
            $('input[name="branch_code"]').val($("#branch_code").val());
            $('input[name="payment_type"]').val($("#payment_type").val());
            if($('input[name="upload_type"]').val() == 'new') {
                $('#type_upload option[value=new]').attr('selected','selected');
            }
            else {
                $('#type_upload option[value=replace]').attr('selected','selected');
            }
        });

        $("#type_upload").on("change" ,function(){
            $('input[name="upload_type"]').val(this.value);
        });
        
        $("#mapping_list").on("change" ,function(){
            $('input[name="mapping_id"]').val(this.value);
        });

        $("#branch_code").on("change" ,function(){
            $('input[name="branch_code"]').val(this.value);
        });

        $("#payment_type").on("change" ,function(){
            $('input[name="payment_type"]').val(this.value);
        });

        Dropzone.autoDiscover = false;

        $("#dropzoneForm").dropzone({
            // maxFiles: 1,
            url: "{!! URL::to('Bill/Import') !!}",
            method: 'post',
            clickable: '.upload-zone',
            acceptedFiles: '.csv', //allowed filetypes
            dictDefaultMessage: '<div class="row"><div class="col-12"><div class=" border_excel d-inline-block" align="center"><img src="{{ URL::asset("assets/images/upload_1.png") }}"><p class="text-left align-middle d-inline-block pl-4 description-text">{{__('bill.import.dropzone_message_1')}} <br />{{__('bill.import.dropzone_message_2')}}</p></div></div></div>', //override the default text
            init: function() {
                this.on('sending', function() {
                    $.blockUI()
                })
                this.on("success", function(file, response) {
                    console.log(response.success);
                    $.unblockUI()
                    sessionStorage.setItem("filename", file.upload.filename);
                    if(response.success == true)
                    {
                        window.location = "{!! URL::to('Bill/Import/Confirm') !!}";   
                    }
                    else
                    {
                        $.unblockUI()
                        swal("เกิดข้อผิดพลาด", "oops !!", "warning");
                        return false;
                    }
                })
                this.on('error', function(err) {
                    $.unblockUI()
                    console.error('error: ', err)
                    Swal.fire(`{{ __('common.error') }}`, err.message || '', 'error')
                })
            },
        });

        // function download_temp(){
        //     window.open(' {{ url("Bill/Get/Template") }}');
        // }

        function download_temp(template_type){
            var document_type = $('input[name="document_type"]').val();
            var mapping_id = $('input[name="mapping_id"]').val();

            if((document_type == null || document_type == "") && (mapping_id == null || mapping_id == "")){
                @if( app()->getLocale() == "th" )
                    swal("Oops! Someting wrong.", "กรุณาเลือกประเภทเอกสารและรูปแบบเอกสาร", "warning");
                @elseif(app()->getLocale() == "en")
                    swal("Oops! Someting wrong.", "Please document tpye and mapping.", "warning");
                @endif
                return false;
            }
            window.open(' {{ url("Bill/Get/Bill/Template") }}/'+template_type);
        }
    </script>
@endsection