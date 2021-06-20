@extends('argon_layouts.app', ['title' => __('User Management')])

@section('content')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.profile')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
            
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <form action="{{ url('User/Update/Profile')}}" method="post" enctype="multipart/form-data" id="form-edit-user">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ old('user_id') != null ? old('user_id') : isset($data->code) ? $data->code : '' }}">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 py-3">
                            <div class="card">
                                <div class="d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="py-3 px-5">
                                            @if (isset($data->username))
                                                <span class="d-block h5" style="color: #4272D7;">{{$data->username}}</span>
                                                <input type="hidden" name="username" value="{{$data->username}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12 col-sm-12 py-3">
                            <div class="card">
                                <div class="card-header">
                                    {{__('userManagement.user_profile')}}
                                </div>
                                <div class="px-5 d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{__('userManagement.name_en')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('firstname_en') != null)
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ old('firstname_en') }}">
                                                    @elseif (isset($data->firstname_en))
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ $data->firstname_en }}">
                                                    @else
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{__('userManagement.lastname_en')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('lastname_en') != null)
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ old('lastname_en') }}">
                                                    @elseif (isset($data->lastname_en))
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ $data->lastname_en }}">
                                                    @else
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-5 d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{__('userManagement.name_th')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('lastname_th') != null)
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="{{ old('firstname_th') }}">
                                                    @elseif (isset($data->firstname_th))
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="{{ $data->firstname_th }}">
                                                    @else
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="" class=" form-control-label">{{__('userManagement.lastname_th')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('lastname_th') != null)
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="{{ old('lastname_th') }}">
                                                    @elseif (isset($data->lastname_th))
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="{{ $data->lastname_th }}">
                                                    @else
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-5 d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="email" class="form-control-label">{{__('userManagement.email')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('email') != null)
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="{{ old('email') }}">
                                                    @elseif (isset($data->email))
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="{{ $data->email }}">
                                                    @else
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2 w-50">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="telephone" class=" form-control-label">{{__('userManagement.mobile')}}</label>
                                                </div>
                                                <div class="col-12">
                                                    @if (old('telephone') != null)
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="{{ old('telephone') }}">
                                                    @elseif (isset($data->telephone))
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="{{ $data->telephone }}">
                                                    @else
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-4 text-center">
                                    <a href="javascript:history.back()" class="btn btn-warning mt-3">{{ __('common.cancel') }}</a>
                                    <button type="submit" class="btn btn-success mt-3">{{ __('common.save') }}</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

<input type="hidden" name="breadcrumb-title" value="{{__('userManagement.user_profile')}}">
<div class="col-12">

</div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EditUser','#form-edit-user') !!}

    <script type="text/javascript">

        $(document).ready(function() {

            $(document).on('keypress input propertychange paste change', 'input[type=number]', function(e) {
                // console.log('event fired')
                return isNumber(e)
            })

            $(document).on('keypress input propertychange paste change', 'input[name=citizen_id]', function(e) {
                // console.log('event fired')
                return isNumber(e)
            })

            $(document).on('paste', 'input', function(e) {
                // disable paste event
                return false
            })
        })

        $('#reset_password').on('click' , function() {
                Swal.fire({
                    title: "{{__('userManagement.reset_header')}}",
                    type: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonClass: "btn btn-success",
                    confirmButtonText: "Confirm",
                    cancelButtonClass: "btn btn-secondary",
                    reverseButtons: true
                }).then(function(isConfirm) {

                    if (!!isConfirm.value) {
                        $.blockUI()

                        $.ajax({
                            type:'POST',
                            url: "{!! URL::to('/UserManagement/ResetPassword') !!}",
                            data:{
                                _token : "{{ csrf_token() }}",
                                username : "{{ isset($data->username) ? $data->username : '' }}"
                            },
                            success: function (response) {
                                console.log('response: ', response)
                                $.unblockUI()

                                if (response.success) {
                                    Swal.fire("{{ (__('common.success')) }}", `{{__('userManagement.reset_form_message')}}`, 'success')
                                        .then(function() {
                                            $.unblockUI()
                                            window.location.reload()
                                        })
                                } else {
                                    console.error('Error: ', response)
                                    $.unblockUI()
                                    var message = response.message || _.first(response[0]) || `{{__('common.system_error_1')}}`
                                    Swal.fire('Oops! Someting wrong.', message, 'error')
                                }
                            },
                            error: function(err) {
                                console.error('Error: ', err)
                                $.unblockUI()
                                var message = err.responseJSON.message || `{{__('userManagement.not_process')}}`
                                Swal.fire('Oops! Someting wrong.', message, 'error')
                            }
                        })
                    }
                })
            })

    </script>
@endsection
