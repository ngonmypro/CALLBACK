@extends('argon_layouts.app', ['title' => __('Corporate Management')])
@section('title', 'Create PDF Template')

@section('style')
    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        table.tier-table td{
            border:none;
            padding: 0 .75rem;
        }
    </style>
@endsection

@section('content')
    <input type="hidden" name="breadcrumb-title" value="{{__('corpsetting.corporate_setting')}}">
    <form method="POST" action="{{ URL::to('/Corporate/Setting/PDF/Confirm')}}" id="upload" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">{{__('corpsetting.create_pdf_template')}}</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                
                            </nav>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('corpsetting.create_pdf_template')}}</h3>
                                <p class="text-sm mb-0">
                                    {{__('corpsetting.create_pdf_description')}}
                                </p>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-xl-6">
                                <label for="" class="form-control-label">{{__('corpsetting.document_for')}}</label>
                                <div class="row pl-2">
                                    <div class="col-6">
                                        <input class="radio" type="radio" id="eipp" name="app_type" value="EIPP" onchange="appType('EIPP')" checked="">
                                        <label for="eipp">Don't Signature Sign</label>
                                    </div>
                                    <div class="col-6">
                                        <input class="radio" type="radio" id="etax" name="app_type" value="ETAX" onchange="appType('ETAX')">
                                        <label for="etax">Signature Sign</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-xl-6">
                                <label for="" class=" form-control-label">{{__('corpsetting.template_name')}}</label>
                                <input class="form-control" type="text" id="template_name" name="template_name" value=""/>
                                <input type="hidden" id="corp_code" name="corp_code" value="{{ $corp_code }}"/>
                                <input type="hidden" name="method" value="create"/>
                            </div>
                            <div class="col-xl-6">
                                <label for="" class="form-control-label">{{__('corpsetting.document_type')}}</label>
                                <select id="" name="document_type" class="form-control">
                                    @foreach($documents as $doc_type)
                                        <option value="{{$doc_type->name}}">{{$doc_type->name_en}} | {{$doc_type->name_th}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-xl-6">
                                <label for="" class=" form-control-label">{{__('corpsetting.max_record')}}</label>
                                <input class="form-control" type="number" id="max_record" name="max_record" min="1" max="5" value=""/>
                            </div>
                            <div class="col-xl-6">
                                <label for="" class="form-control-label">{{__('corpsetting.status')}}</label>
                                <div class="form-control-label p-2">
                                    <input class="form-control-label" id="active" type="radio" name="status" value="ACTIVE" checked=""> <label for="active"> {{__('common.active')}}</label>
                                    <input class="form-control-label" id="inactive" type="radio" name="status" value="INACTIVE"> <label for="inactive"> {{__('common.inactive')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2">
                            <div class="col-xl-6">
                                <label for="" class="form-control-label">{{__('corpsetting.select_file')}}</label><br/>
                                <input id="file" type="file" name="file" accept=".jrxml" class="form-control p-2">
                            </div>
                        </div>
                        <div class="d-none" id="for-etax-section">
                            <hr/>
                            <div class="row p-2">
                                <div class="col-xl-6">
                                    <label for="" class="form-control-label">{{__('corpsetting.signature_visibility')}}</label>
                                    <div class="row pl-2">
                                        <div class="col-6">
                                            <input id="dsVisibility" type="radio" name="ds_visibility" value="false" class="magic-radio green-check" checked="" onchange="SignatureVisible('false');">
                                            <label for="dsVisibility">Hidden</label>
                                        </div>
                                        <div class="col-6">
                                            <input id="dsVisibility-true" type="radio" name="ds_visibility" value="true" class="magic-radio green-check" onchange="SignatureVisible('true');">
                                            <label for="dsVisibility-true">Show</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 visibility d-none">
                                    <label for="" class="form-control-label">{{__('corpsetting.signature_position')}}</label>
                                    <div class="row pl-2">
                                        <div class="col-6">
                                            <input id="page-true" type="radio" name="page" value="first" class="magic-radio green-check" checked="">
                                            <label for="page-true">First page</label>
                                        </div>
                                        <div class="col-6">
                                            <input id="page" type="radio" name="page" value="last" class="magic-radio green-check">
                                            <label for="page">Last page</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2 visibility d-none">
                                <div class="col-xl-6">
                                    <label for="" class="form-control-label">{{__('corpsetting.signature_type')}}</label>
                                    <div class="row pl-2">
                                        <div class="col-6">
                                            <input id="signature_sign_text" type="radio" class="magic-radio green-check" name="signature_type" value="TEXT" data-disabled="true" checked="" onchange="SignatureType('TEXT')" data-check="checked" data-type="text" data-input="old" data-index="0">
                                            <label for="signature_sign_text">Text</label>
                                            
                                            <div class="font-type pt-2">
                                                <div class="pr-4">
                                                    <label class="template-text">Fonts</label>
                                                </div>
                                                <div class="pr-4">
                                                    <select name="font_name" id="font_txt" class="form-control">
                                                        <option value="Angsana New">Angsana New</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-6">
                                            <input id="signature_sign_picture" type="radio" class="magic-radio green-check" name="signature_type" value="IMAGE" onchange="SignatureType('IMAGE')" data-input="old" data-check="" data-type="image" data-index="0">
                                            <label for="signature_sign_picture">Image</label>

                                            <div class="font-type pt-2">
                                                <div class="pr-4">
                                                    <label class="template-text">Fonts Size</label>
                                                </div>
                                                <div class="pr-4">
                                                    <select name="font_size" id="font_txt" class="form-control">
                                                        @for ($i = 14; $i <= 18; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <div class="font-type pt-2">
                                                <div class="pr-4">
                                                    <label class="template-text">Signature Text</label>
                                                </div>
                                                <div class="pr-4">
                                                    <input class="form-control" name="signature_text" id="signature_text" type="text"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="image-type pt-2 d-none">
                                            <div class="col-12">
                                                <label class="template-text">Browse Image <span>({{__('corpsetting.file_size_limit')}})</span></label>
                                                <input type="hidden" value="" class="form-control input_logo" name="image_signature">
                                                <input type="file" class="form-control logo-file" data-target="input_logo" accept="image/gif, image/jpeg, image/png"  onchange="convertB64(this)">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label for="" class="form-control-label">{{__('corpsetting.signature_page_position')}}</label>
                                    <div class="row pl-2">
                                        <div class="col-6">
                                            <label class="" for="signature_x">X-axis</label>
                                            <input type="text" name="signature_x" onkeypress="return isNumber(event)" value="372" class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <label class="" for="signature_y">Y-axis</label>
                                            <input type="text" name="signature_y" onkeypress="return isNumber(event)" value="765" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="col-12 py-3">
                            <div class="row justify-content-center" id="loading">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-warning mt-3" type="button" id="cancel" onclick="cancel_template()"> {{__('common.cancel')}}</button>
                                <button type="submit" class="btn btn-success mt-3" id="btn_submit"> {{__('common.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CorpSettingPDFTemplate','#upload') !!}

<script type="text/javascript">
    $(document).ready(function(){
        init(oldData)
    });

    const init = (data = null) => {
        const oldData = data
        backData( oldData )
    }

    const oldData = JSON.parse(`{!! json_encode(Session::getOldInput()) !!}`)
    const backData = (oldData) => {

        if ( oldData === undefined || oldData.length === 0 ) {
            return
        }

        const _exclude = []
        Object.keys( oldData ).map(function(objectKey, index) {
            if ( _exclude.indexOf( objectKey ) !== -1 ) {
                // skip in exclude list
                return
            }

            const value = oldData[objectKey]
            if($(`*[name=${objectKey}]`).attr('type') === 'radio') {
                $("input:radio[name="+objectKey+"][value="+value+"]").attr('checked', true);
                $("input:radio[name="+objectKey+"][value="+value+"]").trigger("change");
            }
            else {
                $(`*[name=${objectKey}]`).val( value )
            }
        })
    }

    function convertB64(img) {
        var target = $(img).data('target');
        file = img.files[0];
        if (img.files && img.files[0]) {
            if(file.size < 419200){
                
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var image = new Image();

                        image.src = e.target.result;
                        image.onload = function () {

                            var height = this.height;
                            var width = this.width;
                            // console.log(height);
                            // console.log(width);

                            if (height > 60 && width > 148 )
                            {
                                Swal.fire("ผิดพลาด", "ความสูงต้องไม่เกิน 60 px และความกว้างไม่เกิน 148 px", 'error')
                                const file = document.querySelector('.logo-file');
                                file.value = '';
                                return false;
                            }
                            else
                            {
                                var base64 = e.target.result;
                                $('.'+target).val(base64)
                            }
                        }
            };
            }else{
                Swal.fire("ผิดพลาด", "ขนาดรูปใหญ่เกินไป", 'error')
                const file = document.querySelector('.logo-file');
                file.value = '';
                return false;
            }
            reader.readAsDataURL(img.files[0]);
        }
    }

    function cancel_template() {
        window.location = "{!! URL::to('Corporate') !!}/"+$("#corp_code").val()+'/Setting';
    }

    function appType(appType) {
        if(appType == "EIPP") {
            $("#for-etax-section").addClass("d-none");
        }
        else if (appType == "ETAX") {
            $("#for-etax-section").removeClass("d-none");
        }
    }

    function SignatureType(type) {
        if (type == "IMAGE") {
            $(".font-type").addClass("d-none");
            $(".image-type").removeClass("d-none");
        }
        else if (type == 'TEXT'){
            $(".image-type").addClass("d-none");
            $(".font-type").removeClass("d-none");
        }
    }

    function SignatureVisible(visible) {
        if (visible == "false") {
            $(".visibility").addClass("d-none");
        }
        else if (visible == 'true'){
            $(".visibility").removeClass("d-none");
        }
    }

</script>
@endsection