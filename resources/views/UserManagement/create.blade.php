@extends('argon_layouts.app', ['title' => __('Create User')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.create_user')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <form action="{{ url('UserManagement/Create/')}}" method="post" enctype="multipart/form-data" id="form-create-user">
                                {{ csrf_field() }}

                                @if (isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type === 'SYSTEM')
                                <div class="row mb-4">
                                    <div class="col-lg-10 col-sm-12">
                                        <div class="card">
                                            <div class="d-flex flex-wrap mb-3">
                                                <div class="p-2 flex-fill w-50">
                                                    <div class="card-header-with-border">
                                                        <div class="h4 d-inline">{{__('userManagement.select_agent')}}</div>
                                                        <div class="float-right">
                                                            <label class="switch mr-3 align-middle">
                                                                <input type="checkbox" id="agent_enable" class="switch-input" name="" checked>
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="px-5 d-flex flex-wrap">
                                                <div class="p-2 flex-fill w-100">
                                                    <div class="form-group">
                                                        <div class="row d-none" id="agent_sel">
                                                            <div class="col-12">
                                                                <select class="form-control" name="agent_code">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row text-center" id="agent_spinner">
                                                            <div class="col-12" id="agent_loading_text">{{__('common.loading')}}...</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-4">
                                    <div class="col-lg-12 col-sm-12">

                                        <div class="d-flex flex-wrap mb-3">
                                            <div class="p-2 flex-fill w-50">
                                                <h4 class="mb-3 card-header-with-border">{{__('userManagement.user_profile')}}</h4>
                                            </div>
                                        </div>

                                        <div class="px-5 d-flex flex-wrap">

                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="username" class="form-control-label">{{__('userManagement.username')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            @if (old('username') != null)
                                                                <input type="text" name="username" placeholder="" class="form-control select-append" data-spec="username" data-language="isUsername" value="{{ old('username') }}">
                                                            @else
                                                                <input type="text" name="username" placeholder="" class="form-control select-append" data-spec="username" data-language="isUsername" value="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 flex-fill w-50">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="email" class="form-control-label">{{__('userManagement.email')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            @if (old('email') != null)
                                                                <input type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="{{ old('email') }}">
                                                            @else
                                                                <input type="email" name="email" placeholder="" class="form-control select-append" data-spec="email" data-language="isEmail" value="">
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
                                                            <label for="" class=" form-control-label">{{__('userManagement.name_en')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            @if (old('firstname_en') != null)
                                                                <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ old('firstname_en') }}">
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
                                                            <label for="" class=" form-control-label">{{__('userManagement.lastname_en')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            @if (old('lastname_en') != null)
                                                                <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" data-spec="name" data-language="isEnglish" value="{{ old('lastname_en') }}">
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
                                                            @if (old('firstname_th') != null)
                                                                <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" data-spec="name" data-language="isThai" value="{{ old('firstname_th') }}">
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
                                                            <label for="telephone" class=" form-control-label">{{__('userManagement.mobile')}} <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12">
                                                            @if (old('telephone') != null)
                                                                <input type="text" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" value="{{ old('telephone') }}">
                                                            @else
                                                                <input type="text" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" value="">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 flex-fill w-50"></div>

                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-10 col-sm-12">
                                        {{-- <div class="card p-3"> --}}
                                            <div class="d-flex flex-wrap mb-3">
                                                <div class="p-2 flex-fill w-50">
                                                    <h4 class="mb-3 card-header-with-border">{{__('userManagement.select_role')}}</h4>
                                                </div>
                                            </div>
                                            <div class="px-5 d-flex flex-wrap mb-3">
                                                <div class="p-2 flex-fill w-100">
                                                    <div class="form-group">
                                                        <div class="row" id="role_radio_wrapper">
                                                            <div class="col-12">
                                                                <div class="form-check" id="radio_role"></div>
                                                            </div>
                                                        </div>
                                                        <div class="row text-center" id="role_spinner">
                                                            <div class="col-12" id="role_spinner_text">{{__('userManagement.loadingRecords')}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a href="{{ URL::to('/UserManagement')}}" id="btn_cancel" class="btn btn-warning mt-3">{{__('common.cancel')}}</a>
                                    <button type="submit" id="btn_submit" class="btn btn-success mt-3">{{__('common.save')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CreateUser','#form-create-user') !!}

    <script type="text/javascript">

        const __init = () => {
            GetAgents('select[name=agent_code]')

            GetRoles('#radio_role')
        }

        const AgentSelectList = (data) => {
            return `
                <option value="${data.id}">${data.name}</option>
            `
        }

        const GetAgents = (elem) => {
            @if (isset(Session::get('user_detail')->user_type) && Session::get('user_detail')->user_type === 'SYSTEM')

                const data = {
                    _token: '{{ csrf_token() }}',
                }
                const url = (`{{ url('UserManagement/Get/Agents') }}`)

                webRequest('POST', url, data, function (err, result) {
                    // console.log('response: ', result)
                    if (err) {
                        console.error(err)
                    } else if (result.success === true) {
                        result.data.forEach((item) => {
                            @if(app()->getLocale() == "th")
                                $(elem).append(AgentSelectList({
                                    id: item.id,
                                    name: item.name_th
                                }))
                            @else
                                $(elem).append(AgentSelectList({
                                    id: item.id,
                                    name: item.name_en
                                }))
                            @endif

                            $('#agent_spinner').addClass('d-none')
                            $('#agent_sel').removeClass('d-none')
                        })
                    } else {
                        console.error(result.message)
                        $('#agent_loading_text').text(result.message)
                    }
                })
            @endif

            return
        }

        const RadioRole = (data) => {

            return `
                <div class="d-block py-2">
                    <input id="${data.name}-radio" class="form-check-input magic-radio" type="radio" name="roles[]" value="${data.id || ''}" checked>
                    <label class="form-check-label" for="${data.name}-radio">${data.name || ''}</label>
                </div>
            `
        }

        const GetRoles = (elem, _data = null) => {
            $(elem).empty()
            $('#role_radio_wrapper').addClass('d-none')
            $('#role_spinner').removeClass('d-none')

            let data = {
                _token: '{{ csrf_token() }}'
            }
            if (_data) {
                data.agent = _data.agent || null
            }

            const url = (`{{ url('UserManagement/Get/Roles') }}`)

            webRequest('POST', url, data, function (err, result) {
                // console.log('response: ', result)
                if (err) {
                    console.error(err)
                } else if (result.success === true) {
                    result.data.forEach((item) => {
                        $(elem).append(RadioRole(item))
                    })

                    $('#role_radio_wrapper').removeClass('d-none')
                    $('#role_spinner').addClass('d-none')
                } else {
                    console.error(result.message)
                    $('#role_spinner_text').text(result.message)
                }
            })
        }

        $(document).ready(function() {

            __init()

            $(document).on('click', '#agent_enable', function() {
                // console.log('click')

                if ($(this).is(':checked')) {
                    $('#agent_sel').removeClass('d-none')
                    $('select[name=agent_code]').attr('disabled', false)
                } else {
                    $('#agent_sel').addClass('d-none')
                    $('select[name=agent_code]').attr('disabled', true)

                    if ($('select[name=agent_code]').val() !== '') {
                        GetRoles('#radio_role', null)
                    }
                }

            })

            $(document).on('change', 'select[name=agent_code]', function() {
                // console.log('change')

                if ($(this).prop('disabled') !== true) {
                    GetRoles('#radio_role', {
                        agent: $(this).val()
                    })
                } else {
                    GetRoles('#radio_role', null)
                }
            })
        })

    </script>
@endsection
