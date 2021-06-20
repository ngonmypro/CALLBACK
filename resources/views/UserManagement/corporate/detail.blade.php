@extends('argon_layouts.app', ['title' => __('User Detail')])

@section('style')
<style>
    .font-10 {
        font-size: 10px;
    }
    .text-overflow {
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-xs-3 col-sm-4 col-lg-6 py-2">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.user_detail')}}</h6>
                    </div>
                    <div class="col-xs-9 col-sm-8 col-lg-6 text-center py-2">
                        <div class="d-flex justify-content-end">

                            @Permission(CORPORATE_USER_MANAGEMENT.RESET_PASSWORD)
                            <div class="col-4 m-0 py-0 px-2">
                                <button id="reset_password" type="button" class="w-100 btn btn-default">{{__('userManagement.reset_password')}}</button>
                            </div>
                            @EndPermission
                            <?php 
                                $dateToday = date( 'Y-m-d H:i:s' );
                            ?>
                            @if ($data->expired_at >= $dateToday )
                                @if ( isset($data->status) )
                                    @Permission(CORPORATE_USER_MANAGEMENT.SUSPEND_USER|CORPORATE_USER_MANAGEMENT.UNSUSPEND_USER)
                                    <div class="col-4 m-0 py-0 px-2">
                                        @if ($data->status === 'ACTIVE' || $data->status === 'INACTIVE' && $data->lock_reason === null)
                                            @Permission(CORPORATE_USER_MANAGEMENT.SUSPEND_USER)
                                            <button id="suspend" type="button" class="w-100 btn btn-warning" data-status="{{ $data->status }}" data-lock_reason="{{ $data->lock_reason }}">{{__('userManagement.suspend')}}</button>
                                            @EndPermission
                                        @else
                                            @Permission(CORPORATE_USER_MANAGEMENT.UNSUSPEND_USER)
                                            <button id="suspend" type="button" class="w-100 btn btn-warning" data-status="{{ $data->status }}" data-lock_reason="{{ $data->lock_reason }}">{{__('userManagement.unsuspend')}}</button>
                                            @EndPermission
                                        @endif
                                    </div>
                                    @EndPermission
                                @endif
                            @endif

                            @Permission(CORPORATE_USER_MANAGEMENT.EDIT_USER_DETAIL)
                            <div class="col-4 m-0 py-0 px-2">
                                <a href="{{ action('Corporate\UserManagementController@edit', ['user_code' => $data->user_code ])}}" class="w-100 btn btn-secondary">{{__('userManagement.edit')}}</a>
                            </div>
                            @EndPermission

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">

                <form>

                    <input type="hidden" name="user_id" value="{{ ( old('user_id') != null ? old('user_id') : isset($data->user_code) ) ? $data->user_code : '' }}">

                    {{-- allow create user for mult-corp --}}
                    @if (isset($data->user_type) && $data->user_type === 'USER')

                        @if (old('corp_code') != null)
                            <input type="hidden" name="corp_code" value="{{ old('corp_code') }}">
                        @else if ( isset($data->corp_code) )
                            <input type="hidden" name="corp_code" value="{{ $data->corp_code }}">
                        @endif

                    @elseif (isset($data->user_type) && $data->user_type === 'AGENT')

                        @if (old('agent_code') != null)
                            <input type="hidden" name="agent_code" value="{{ old('agent_code') }}">
                        @elseif (isset($data->agent_code))
                            <input type="hidden" name="agent_code" value="{{ $data->agent_code }}">
                        @endif

                    @endif

                    <div class="row">
                        <div class="col-lg-12 col-sm-12 py-3">
                            <div class="card">
                                <div class="d-flex flex-wrap">

                                    <div class="p-2 flex-fill w-10">

                                        <div class="py-3 px-5">
                                            <?php 
                                                $status = [
                                                    'ACTIVE' => trans('common.active'),
                                                    'INACTIVE' => trans('common.inactive'),
                                                ];
                                            ?>

                                            @if (isset($data->username))
                                                <span class="d-block h5" style="color: #4272D7;">{{$data->username}}</span>
                                            @endif

                                            @if ( isset($data->status) && !blank($data->status) )
                                                @if ($data->status === 'ACTIVE')
                                                    <span class="badge badge-success">{{ isset($status[$data->status]) ? $status[$data->status] : '$data->status'}}</span>
                                                @else
                                                    <span class="badge badge-warning">{{ $status[$data->status] }}</span>
                                                @endif
                                            @endif

                                            @if ($data->expired_at <= $dateToday )
                                                <span class="badge badge-warning">{{__('common.expired')}}</span>
                                            @endif

                                        </div>

                                    </div>

                                    <div class="p-2 flex-fill w-90">

                                        <div class="py-3 px-5">

                                            @if (isset($data->username))
                                                <span class="d-block h5" style="color: #4272D7;">{{__('userManagement.reason')}}</span>
                                            @endif

                                            @if ( $data->lock_reason != null && $data->status === 'INACTIVE' )
                                                @if ($data->lock_reason === 1)
                                                    <span class="badge badge-success">ผู้ใช้งานอยู่ในสถานะพักงาน</span>
                                                @else
                                                    <span class="badge badge-success">ผู้ใช้งานนี้ได้ทำการลาออกไปแล้ว</span>
                                                @endif
                                                <br>
                                                <span>{{ $data->lock_description }}</span>
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
                                    <span class="">{{__('userManagement.user_profile')}}</span>
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
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ old('firstname_en') }}" disabled="disabled">
                                                    @elseif (isset($data->firstname_en))
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ $data->firstname_en }}" disabled="disabled">
                                                    @else
                                                        <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="" disabled="disabled">
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
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ old('lastname_en') }}" disabled="disabled">
                                                    @elseif (isset($data->lastname_en))
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ $data->lastname_en }}" disabled="disabled">
                                                    @else
                                                        <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="" disabled="disabled">
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
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ old('firstname_th') }}" disabled="disabled">
                                                    @elseif (isset($data->firstname_th))
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ $data->firstname_th }}" disabled="disabled">
                                                    @else
                                                        <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="" disabled="disabled">
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
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ old('lastname_th') }}" disabled="disabled">
                                                    @elseif (isset($data->lastname_th))
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ $data->lastname_th }}" disabled="disabled">
                                                    @else
                                                        <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="" disabled="disabled">
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
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="{{ old('email') }}" disabled="disabled">
                                                    @elseif (isset($data->email))
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="{{ $data->email }}" disabled="disabled">
                                                    @else
                                                        <input readonly type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="" disabled="disabled">
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
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="{{ old('telephone') }}" disabled="disabled">
                                                    @elseif (isset($data->telephone))
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="{{ $data->telephone }}" disabled="disabled">
                                                    @else
                                                        <input type="number" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="" disabled="disabled">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="px-5 d-flex flex-wrap">
                                        <div class="p-2 flex-fill w-50">
                                            <div class="pt-3 col-12">
                                                {{__('userManagement.select_role')}}
                                            </div>
                                            <div class="p-2 flex-fill w-100">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-check" id="radio_role"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

        const RadioRole = (data) => {
            @if (isset($data->roles))
                const roles = JSON.parse('{!! json_encode($data->roles) !!}')
            @elseif (old('roles') !== null)
                const roles = JSON.parse('{!! json_encode(old("roles")) !!}')
            @else
                const roles = []
            @endif
            return `
                <div class="px-1 my-3">
                    <input id="${data.name}-radio" class="form-check-input magic-radio" type="radio" name="roles[]" value="${data.id || ''}" ${roles.map(x => x.id).indexOf(data.id) !== -1 ? 'checked' : ''}  disabled="disabled">
                    <label class="form-check-label" for="${data.name}-radio">${data.name || ''}</label>
                    <span class="d-block text-muted font-10 text-overflow">${data.description || ''}</span>
                </div>
            `
        }

        const GetRoles = (elem) => {

            const corp = '{{ $data->corp_code ?? '' }}'
            const agent = '{{ $data->agent_code ?? '' }}'

            const data = {
                _token: '{{ csrf_token() }}',
                corp,
                agent,
            }
            const url = `{{ action('UserManagementController@GetRoles') }}`

            $.ajax({
                url,
                data,
                method: 'POST',
                success: function(result) {
                    // console.log('response: ', result)

                    if (result.success === true) {
                        result.data.forEach((item) => {
                            $(elem).append(RadioRole(item))
                        })
                    } else {
                        console.error(result.message)
                    }
                },
                error: function(err) {
                    console.error(err)
                }
            })
        }

        const __init = () => {
            GetRoles('#radio_role')
        }

        $(document).ready(function() {

            __init()

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

    </script>

    @Permission(CORPORATE_USER_MANAGEMENT.RESET_PASSWORD)
    <script>
        $(document).ready(function() {
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
                            url: "{{ action('Corporate\UserManagementController@resetPassword') }}",
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
        })
    </script>
    @EndPermission

    @Permission(CORPORATE_USER_MANAGEMENT.SUSPEND_USER|CORPORATE_USER_MANAGEMENT.UNSUSPEND_USER)
    <script>

        $(document).ready(function() {

            $(document).on('click', '#suspend', function() {
                if ( $(this).data('status') === 'ACTIVE' || $(this).data('status') === 'INACTIVE' && $(this).data('lock_reason') === '' ) {
                    $.blockUI()
                    $.ajax({
                        url: `{{ action('Corporate\UserManagementController@suspendList') }}`,
                        method: 'POST',
                        data: {
                            _token: `{{ csrf_token() }}`
                        },
                        success: async function(response) {
                            console.log('response: ', response)
                            $.unblockUI()

                            if (response.success) {
                                var data = response.data
                                var options = ''
                                data.forEach((elem) => {
                                    options += `<option value="${elem.id}">${elem.message}</option>`
                                })
                                const html = `
                                    <div class="row">
                                        <div class="py-2 col-xs-12 offset-lg-1 col-lg-10 px-5" id="input-wrapper">
                                            <div class="form-group">
                                                <p class="text-left">{{__('userManagement.reason')}}</p>
                                                <select class="form-control" name="lock_reason">${options}</select>
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" name="reason_message"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                `

                                const {value: formValues} = await Swal.fire({
                                    title: `{{ (__('userManagement.suspend')) }}`,
                                    html,
                                    showCloseButton: true,
                                    showCancelButton: true,
                                    focusConfirm: true,
                                    reverseButtons: true,
                                    showLoaderOnConfirm: true,
                                    preConfirm: () => {
                                        var pleaseFill = []
                                        // VALIDATION
                                        $('#input-wrapper select, #input-wrapper textarea').each(function() {
                                            const mandatory = ['lock_reason']  // MANDATORY FIELD
                                            // console.log('INPUT: ', { this: $(this), val: $(this).val() })
                                            if ( ($(this).val() === '' || $(this).val() === null) && mandatory.indexOf($(this).attr('name')) !== -1 ) {
                                                pleaseFill.push(  _.ucwords($(this).attr('name'))  )  /* CAST TO UPPER CASE WORD */
                                            }
                                        })
                                        if (pleaseFill.length > 0) {
                                            Swal.showValidationMessage(`Please fill in ${pleaseFill.join(', ')}`)  // MARK AS INVALID
                                        }
                                    }
                                })

                                if (formValues) {
                                    $.blockUI()
                                    var formData = new FormData()
                                    formData.append('_token', `{{ csrf_token() }}`)
                                    formData.append('user_id', `{{ isset($data->user_code) ? $data->user_code : '' }}`)
                                    $('#input-wrapper select, #input-wrapper textarea').each(function() {
                                        formData.append($(this).attr('name'), $(this).val())
                                    })
                                    $.ajax({
                                        method: 'post',
                                        url: `{{ action('Corporate\UserManagementController@requestSuspend') }}`,
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            console.log('response: ', response)
                                            $.unblockUI()

                                            if (response.success) {
                                                Swal.fire({
                                                    title: "{{ (__('common.success')) }}",
                                                    type: 'success'
                                                }).then(function() {
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
                                            var message = err.responseJSON.message || `{{__('common.system_error_1')}}`
                                            Swal.fire('Oops! Someting wrong.', message, 'error')
                                        }
                                    })
                                }


                            } else {
                                console.error('error: ', response.message)
                                Swal.fire('Oops! Someting wrong.', response.message || `{{__('common.system_error_1')}}`, 'error')
                            }
                        },
                        error: function(err) {
                            console.error('error: ', err)
                            $.unblockUI()
                            Swal.fire('Oops! Someting wrong.', err.message || `{{__('common.system_error_1')}}`, 'error')
                        }
                    })
                } else {
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
                                url: "{{ action('Corporate\UserManagementController@requestSuspend') }}",
                                data:{
                                    _token : `{{ csrf_token() }}`,
                                    user_id : `{{ isset($data->user_code) ? $data->user_code : '' }}`
                                },
                                success: function (response) {
                                    console.log('response: ', response)
                                    $.unblockUI()

                                    if (response.success) {
                                        Swal.fire({
                                            title: "{{ (__('common.success')) }}",
                                            type: 'success'
                                        }).then(function() {
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
                                    var message = err.responseJSON.message || `{{__('common.system_error_1')}}`
                                    Swal.fire('Oops! Someting wrong.', message, 'error')
                                }
                            })
                        }
                    })
                }
            })

        })

    </script>
    @EndPermission

@endsection
