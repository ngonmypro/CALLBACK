@extends('argon_layouts.app', ['title' => __('Customer Edit')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{ (__('recipient.profile_edit.customer_edit')) }}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                    @if ($profile->status == "INACTIVE")
                        <button type="button" onclick="action_status('active')" class="btn btn-info" data-toggle="tooltip" title="Active Recipient"><i class="fa fa-unlock"></i> {{ (__('recipient.unlock')) }}</button>
                    @elseif ($profile->status == "ACTIVE")
                        <button type="button" onclick="action_status('inactive')" class="btn btn-secondary"  data-toggle="tooltip" title="Inactive Recipient"><i class="fa fa-lock"></i> {{ (__('recipient.lock')) }}</button>
                    @endif
                        <button type="button" onclick="action_status('delete')" class="btn btn-danger" data-toggle="tooltip" title="Delete Recipient"><i class="fa fa-trash"></i> {{ (__('recipient.delete')) }}</button>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-11">
                                <h3 class="mb-0">{{ (__('recipient.profile_edit.customer_edit')) }}</h3>
                                <p class="text-sm mb-0">
                                   
                                </p>
                            </div>
                            <div class="text-right">
                            @if ($profile->status == "ACTIVE")
                                <span class="badge badge-success">{{ (__('recipient.active')) }}</span>
                            @elseif ($profile->status == "INACTIVE")
                                <span class="badge badge-danger">{{ (__('recipient.inactive')) }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Recipient/Profile/Update',$profile->recipient_code) }}" method="POST" enctype="multipart/form-data" id="form-edit-recipient">
                            {{ csrf_field() }}
                            <div id="recipient-profile" class="col-12">
                                <section id="edit-recipient-section" class="Information">
                                    <div class="d-flex flex-wrap mb-3">
                                        <div class="p-2 flex-fill w-50">
                                            <h4 class="mb-3 py-3 card-header-with-border">
                                                {{ (__('recipient.profile.profile')) }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.full_name')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="full_name" placeholder="" class="form-control required-checked" value="{{ old('full_name') != null ? old('full_name') : isset($profile->full_name) ? $profile->full_name : '' }}" disabled/>
                                                        <input type="hidden" id="recipient_code" value="{{ $profile->recipient_code }}">
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
                                                        <input type="text" id="" name="first_name" placeholder="" class="form-control required-checked" value="{{ old('first_name') != null ? old('first_name') : isset($profile->first_name) ? $profile->first_name : '' }}" />
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
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.middle_name')) }} </label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="middle_name" placeholder="" class="form-control required-checked" value="{{ old('middle_name') != null ? old('middle_name') : isset($profile->middle_name) ? $profile->middle_name : '' }}" />
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
                                                        <input type="text" id="" name="last_name" placeholder="" class="form-control required-checked" value="{{ old('last_name') != null ? old('last_name') : isset($profile->last_name) ? $profile->last_name : '' }}" />
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
                                                        <input type="text" id="telephone" name="telephone" placeholder="" class="form-control required-checked" value="{{ old('telephone') != null ? old('telephone') : isset($profile->telephone) ? $profile->telephone : '' }}" data-type="Telephone"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.optional_mobile_no')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="optional_telephones" name="optional_telephones" placeholder="" class="form-control required-checked" value="{{ old('optional_telephone') != null ? old('optional_telephone') : (isset($profile->optional_telephones) && $profile->optional_telephones != '') ? implode(",", json_decode($profile->optional_telephones)) : '' }}" data-type="optional_telephone"/>
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
                                                        <label for="email" class=" form-control-label">{{ (__('recipient.profile.email')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="email" id="email" name="email" placeholder="" class="form-control required-checked" value="{{ old('email') != null ? old('email') : isset($profile->email) ? $profile->email : '' }}" onchange="checkEmail(this);"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="email" class=" form-control-label">{{ (__('recipient.profile.optional_email')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="optional_emails" name="optional_emails" placeholder="" class="form-control required-checked" value="{{ old('optional_emails') != null ? old('optional_emails') : (isset($profile->optional_emails) && $profile->optional_emails != '') ? implode(",", json_decode($profile->optional_emails)) : '' }}" />
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
                                                        <label for="email" class=" form-control-label">{{ (__('recipient.profile.contact')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="contact" name="contact" placeholder="" class="form-control required-checked" value="{{ old('contact') != null ? old('contact') : isset($profile->contact) ? $profile->contact : '' }}" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.citizen_id')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" id="" name="citizen_id" placeholder="" class="form-control required-checked" value="{{ old('citizen_id') != null ? old('citizen_id') : isset($profile->citizen_id) ? $profile->citizen_id : '' }}" data-type="CitizenID" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif -->
                                    </div>
                                    <hr/>
                                    <div class="d-flex flex-wrap mb-3">
                                        <div class="p-2 flex-fill w-50">
                                            <h4 class="mb-3 py-3 card-header-with-border">
                                                {{ (__('recipient.profile.address')) }}
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                   <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.address')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        @if (old('address') !== null)
                                                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                                        @elseif (isset($profile->address))
                                                            <input type="text" name="address" class="form-control" value="{{ $profile->address }}">
                                                        @else
                                                            <input type="text" name="address" class="form-control">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.zipcode')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        @if (old('zipcode') !== null)
                                                            <input type="text" name="zipcode" class="form-control" value="{{ old('zipcode') }}">
                                                        @elseif (isset($profile->zipcode))
                                                            <input type="text" name="zipcode" class="form-control" value="{{ $profile->zipcode }}">
                                                        @else
                                                            <input type="text" name="zipcode" class="form-control">
                                                        @endif
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
                                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.state')) }}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        @if (old('state') !== null)
                                                            <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                                                        @elseif (isset($profile->state))
                                                            <input type="text" name="state" class="form-control" value="{{ $profile->state }}">
                                                        @else
                                                            <input type="text" name="state" class="form-control">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 flex-fill w-50">
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

                                   {{-- <div class="d-flex flex-wrap mb-3">
                                        <div class="p-2 flex-fill w-50">
                                            <h4 class="mb-3 py-3 card-header-with-border">
                                                Notification
                                            </h4>
                                        </div>
                                    </div>
                                    <section class="Notification">
                                        <div class="d-flex flex-wrap">
                                            
                                            @if ($profile->noti_channel && is_array($profile->noti_channel))
                                                @foreach ($profile->noti_channel as $item)
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-12 noti-block">
                                                                    <input id="noti_{{ $item->channel_name }}" class="magic-checkbox noti-check" type="checkbox" name="noti[0][{{ $item->channel_name }}]" value="{{ $item->id }}" {{ !blank($item->status) && $item->status === 'ACTIVE' ? 'checked' : '' }}>
                                                                    <label class="text-left" for="noti_{{ $item->channel_name }}">{{ $item->channel_name }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </section>--}}
                                    <hr/>
                                    <div class="d-flex flex-wrap mb-3">
                                        <div class="p-2 flex-fill w-50">
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
                                                        <input type="text" id="" name="career" placeholder="" class="form-control" value="{{ old('career') != null ? old('career') : isset($profile->career) ? $profile->career : '' }}" data-type="Name">
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
                                                        <input type="text" id="" name="salary" placeholder="" class="form-control" value="{{ old('salary') != null ? old('salary') : isset($profile->salary) ? $profile->salary : '' }}">
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
                                                        <input type="text" id="" name="ref_1" placeholder="" class="form-control" value="{{ old('ref_1') != null ? old('ref_1') : isset($profile->ref_1) ? $profile->ref_1 : '' }}">
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
                                                        <input type="text" id="" name="ref_2" placeholder="" class="form-control" value="{{ old('ref_2') != null ? old('ref_2') : isset($profile->ref_2) ? $profile->ref_2 : '' }}">
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
                                                        <input type="text" id="" name="ref_3" placeholder="" class="form-control" value="{{ old('ref_3') != null ? old('ref_3') : isset($profile->ref_3) ? $profile->ref_3 : '' }}">
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
                                                        <input type="text" id="" name="ref_4" placeholder="" class="form-control" value="{{ old('ref_4') != null ? old('ref_4') : isset($profile->ref_4) ? $profile->ref_4 : '' }}">
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
                                                        <input type="text" id="" name="ref_5" placeholder="" class="form-control" value="{{ old('ref_5') != null ? old('ref_5') : isset($profile->ref_5) ? $profile->ref_5 : '' }}">
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
                                <button type="submit" class="btn btn-success mt-3">{{ (__('recipient.profile.save')) }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




<input type="hidden" name="breadcrumb-title" value="{{ (__('recipient.profile.edit_title')) }}">
<input id="page-current" type="hidden" value="EditRecipient">

{{-- {{ print_r($profile) }} --}}

<!-- MAIN CONTENT-->

@include('layouts.footer_progress')
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EditRecipientRequest', '#form-edit-recipient') !!}

    <script type="text/javascript">

        function download_country_code() {
            // append country_code
            if (localStorage.getItem('country_code') !== null && localStorage.getItem('country_code') !== '') {
                const data = JSON.parse(localStorage.getItem('country_code'))

                // append option data
                $('select[name=localize]').append(function() {
                    let options = '<option></option>'
                    data.forEach(element => {
                        options += `<option value="${element.Code}">${element.Name}</option>`
                    })
                    return options
                })
            } else {
                $.getJSON("{{ URL::asset('assets/json/country_code.json') }}", function(data) {
                    localStorage.setItem('country_code', JSON.stringify(data))

                    // append option data
                    $('select[name=country_code]').append(function() {
                        let options = '<option></option>'
                        data.forEach(element => {
                            options += `<option value="${element.Code}">${element.Name}</option>`
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
                $("#optional_emails").val('');
                $("#optional_emails").attr("readonly", "readonly");
            }
        }

        function ValidateEmail(mail) 
        {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{0,})+$/.test(mail)) {
                return (true)
            }
            return (false)
        }

        function action_status(activity) 
        {
            if(activity == 'inactive') {
                title = `{{__('recipient.lock')}}`
                text = `{{__('recipient.sure')}}`+`{{__('recipient.lock')}}`+`{{__('recipient.or_not')}}`
            }
            else if(activity == 'active') {
                title = `{{__('recipient.unlock')}}`
                text = `{{__('recipient.sure')}}`+`{{__('recipient.unlock')}}`+`{{__('recipient.or_not')}}`
            }
            else if(activity == 'delete') {
                title = `{{__('recipient.delete')}}`
                text = `{{__('recipient.sure')}}`+`{{__('recipient.delete')}}`+`{{__('recipient.or_not')}}`
            }

            Swal.fire({
                    title: title,
                    text: text,
                    confirmButtonText: `{{__('common.confirm')}}`,
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: `{{__('common.cancel')}}`,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `{{__('common.confirm')}}`,
                }).then((result) => {
                    $.blockUI()
                    if ( result.value ) {
                        const data = $('#repayment_form').serializeObject()
                        data._token = `{{ csrf_token() }}`
                        data.action = activity
                        data.recipient_code = document.getElementById("recipient_code").value
                        $.ajax({
                            type: 'POST',
                            url: '{{ action("RecipientManageController@recipient_activity") }}',
                            data
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success').then(() => {
                                    window.location.href = '{{ url("Recipient")}}'
                                })
                            } else {
                                Swal.fire(result.message || 'Oops! Something wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                        })
                    }
                    else {
                        $.unblockUI()
                        Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                    }
                    $.unblockUI()
                })
        }
    </script>

@endsection
