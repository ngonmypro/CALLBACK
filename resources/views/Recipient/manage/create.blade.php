@extends('argon_layouts.app', ['title' => __('Recipient Create')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{ (__('recipient.profile.create')) }}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="col-xl-12">
            <form action="{{ url('/Recipient/Create') }}" method="POST" enctype="multipart/form-data" id="form-create-recipient">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header">
                        <div id="recipient-profile" class="col-12">
                            <div class="d-flex">
                                <div class="flex-fill w-50">
                                    <h4 class="mb-3 py-3 card-header-with-border">{{ (__('recipient.profile.title')) }}</h4>
                                </div>
                            </div>
                            <section class="Information">
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.customer_code')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="recipient_code" placeholder="" class="form-control" value="{{ old('recipient_code') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.first_name')) }} <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="first_name" placeholder="" class="form-control" value="{{ old('first_name') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.middle_name')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="middle_name" placeholder="" class="form-control" value="{{ old('middle_name') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.last_name')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="last_name" placeholder="" class="form-control" value="{{ old('last_name') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.mobile_no')) }} <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="telephone" name="telephone" placeholder="" class="form-control" value="{{ old('telephone') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.optional_mobile_no')) }} </label>
                                                    <i class="ni ni-air-baloon" data-toggle="tooltip" data-placement="top" title="{{ (__('recipient.profile.hint_mobile')) }}"></i>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="optional_telephones" name="optional_telephones" placeholder="" class="form-control" value="{{ old('optional_telephones') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.email')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="email" name="email" placeholder="" class="form-control" value="{{ old('email') }}" data-type="email" onchange="checkEmail(this);"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.optional_email')) }}</label>
                                                    <i class="ni ni-air-baloon" data-toggle="tooltip" data-placement="top" title="{{ (__('recipient.profile.hint_email')) }}"></i>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="optional_emails" name="optional_emails" placeholder="" class="form-control" value="{{ old('optional_emails') }}" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.citizen_id')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="citizen" placeholder="" class="form-control" value="{{ old('citizen') }}" data-type="CitizenID" />
                                                        <input id="storeValue" type="hidden" value="{{ old('citizen') }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif    
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.contact')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="contact" placeholder="" class="form-control" value="{{ old('contact') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <hr/>
                            <div class="d-flex">
                                <div class="flex-fill w-50">
                                    <h4 class="mb-3 py-3 card-header-with-border">{{ (__('recipient.profile.address')) }}</h4>
                                </div>
                            </div>
                            <section class="Address">
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.address')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="address" placeholder="" class="form-control" value="{{ old('address') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.state')) }} </label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="state" placeholder="" class="form-control" value="{{ old('state') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.zipcode')) }} </label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" id="" name="zipcode" placeholder="" class="form-control" value="{{ old('zipcode') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{ (__('recipient.profile.country')) }}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('localize') !== null)
                                                    <select class="form-control" name="localize" data-val="{{ old('localize') }}">
                                                    @elseif (isset($profile->localize))
                                                    <select class="form-control" name="localize" data-val="{{ $profile->localize }}">
                                                    @else
                                                    <select class="form-control" name="localize">
                                                    @endif
                                                        <option disabled></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                    <div class="d-flex flex-wrap">
                                        <div class="flex-fill w-50">
                                            <h4 class="mb-3 py-3 card-header-with-border">{{ (__('recipient.profile.additional_information')) }}</h4>
                                        </div>
                                    </div>
                                    @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.career')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="career" placeholder="" class="form-control" value="{{ old('career') }}" data-type="Name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.salary')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="salary" placeholder="" class="form-control" value="{{ old('salary') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_1')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_1" placeholder="" class="form-control" value="{{ old('ref_1') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_2')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_2" placeholder="" class="form-control" value="{{ old('ref_2') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_3')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_3" placeholder="" class="form-control" value="{{ old('ref_3') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_4')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_4" placeholder="" class="form-control" value="{{ old('ref_4') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_5')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="ref_5" placeholder="" class="form-control" value="{{ old('ref_5') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50"></div>
                                    </div>
                                </section>
                            </div>
                            <div class="text-center">
                                <a href="{{ URL::to('/Recipient')}}" class="btn btn-warning mt-3">{{ (__('recipient.profile.cancel')) }}</a>
                                <button type="submit" class="btn btn-success mt-3">{{ (__('recipient.profile.create_confirm')) }}</button>
                            </div>
                            </section>
                        </div>
                    </div>
                </div>
            </form> 
        </div>
    </div>
    @include('layouts.footer_progress')
</form>
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CreateRecipientRequest') !!}
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        init()

        var mail = document.getElementById('email').value;
        if(mail) {
            $("#optional_emails").removeAttr("readonly");
        }
        else {
            $("#optional_emails").attr("readonly", "readonly");
            $("#optional_emails").val('');
        }
    })
    
    function checkEmail(mail) {
        var mail = document.getElementById('email').value;
        var mail = ValidateEmail(mail);

        if(mail) {
            $("#optional_emails").removeAttr("readonly");
        }
        else {
            $("#optional_emails").attr("readonly", "readonly");
            $("#optional_emails").val('');
        }
    }

    function ValidateEmail(mail) 
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{0,})+$/.test(mail)) {
            return (true)
        }
        return (false)
    }

    function download_country_code() {
            // append country_code
            const currentlang = '<?php echo str_replace('_', '-', app()->getLocale()) ?>';
            // console.log(currentlang);
            if (localStorage.getItem('country_code') !== null && localStorage.getItem('country_code') !== '') {
                const data = JSON.parse(localStorage.getItem('country_code'))
                
                // append option data
                $('select[name=localize]').append(function() {
                    let options = '<option></option>'
                    data.forEach(element => {
                        selectted = element.Code == 'TH' ? 'selected' : ''
                        if(currentlang == 'en'){
                            const name_en = element.Name.replace(/[ก-๙|\-]/gi,'')
                            options += `<option value="${element.Code}" ${selectted}>${name_en}</option>`
                        }else{
                            const name_th = element.Name.replace(/[^ก-๙\-]/gi,'')
                            options += `<option value="${element.Code}" ${selectted}>${name_th}</option>`
                        }
                    })
                    return options
                })
            } else {
                $.getJSON("{{ URL::asset('assets/json/country_code.json') }}", function(data) {
                    localStorage.setItem('country_code', JSON.stringify(data))
                    
                    // append option data
                    $('select[name=localize]').append(function() {
                        let options = '<option></option>'
                        data.forEach(element => {
                            if(currentlang == 'en'){
                                const name_en = element.Name.replace(/[ก-๙|\-]/gi,'')
                                options += `<option value="${element.Code}">${name_en}</option>`
                            }else{
                                const name_th = element.Name.replace(/[^ก-๙\-]/gi,'')
                                options += `<option value="${element.Code}">${name_th}</option>`
                            }
                        })
                        return options
                    })
                })
            }
    }

    function init() {
        download_country_code()

        // re-assign value select list not recognize value, because option come later
        if ($('select[name=localize]').data('val')) {
            const data = $('select[name=localize]').data('val')
            $('select[name=localize]').val(data)
        }
    }

</script>
@endsection
