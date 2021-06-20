@extends('argon_layouts.app', ['title' => __('Role Management')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('role.role_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right d-none">
                        <a href="{{ action('Corporate\RoleManagementController@corporate_role_page_index') }}" class="btn btn-neutral">{{__('common.back')}}</a>
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
                                <h3 class="mb-0">{{__('role.add_new_role')}}</h3>
                                <p class="text-sm mb-0">
                                    {{__('role.role_title_description')}}
                                </p>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="create_role" class="item-form" action="{{ action('Corporate\RoleManagementController@SubmitCreateRole')}}" method="post" enctype="multipart/form-data">
                            
                            {{ csrf_field() }}

                            <input type="hidden" name="agent_code">                            
                            <input type="hidden" name="corp_code">

                            <div class="row">
                                <div class="col-lg-12 px-4 pb-3">
                                    <div class="d-flex flex-wrap">
                                        <div class="w-100">
                                            <div class="form-group">     

                                                <div class="row mx-auto mb-4">
                                                    @if(\Session::get('user_detail')->user_type == "USER")
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="" class=" form-control-label">{{__('role.data_group')}}</label>
                                                                <select id="user_group" name="user_type" class="form-control">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="corporate" name="corporate" placeholder="" class="form-control" value="{{ Session::get('CORP_CURRENT')['corp_code'] }}"> 
                                                        <input type="hidden" id="is_user" placeholder="" class="form-control" value="USER"> 
                                                    @else
                                                        <div class="col-lg-6 col-sm-12">
                                                            <div class="form-group">
                                                                <label for="" class=" form-control-label">{{__('role.data_group')}}</label>
                                                                <select id="user_group" name="user_type" class="form-control">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 d-none" id="div-agent">
                                                            <div class="form-group">
                                                                <label for="" class=" form-control-label">{{__('role.agent')}}</label>
                                                                <select id="agent" name="agent" class="form-control">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 d-none" id="div-corporate">
                                                            <div class="form-group">
                                                                <label for="" class=" form-control-label">{{__('role.corporate')}}</label>
                                                                <select id="corporate" name="corporate" class="form-control">
                                                                    <option></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="row mx-auto mb-4">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="form-group">        
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="" class=" form-control-label">{{__('role.role_name')}}</label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" name="role_name" placeholder="" class="form-control">                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mx-auto mb-4">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="form-group">        
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="" class="form-control-label">{{__('role.role_description')}}</label>
                                                                </div>
                                                                <div class="col-12">
                                                                    <input type="text" name="role_description" placeholder="" class="form-control">
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
                            
                            <div class="row">
                                <div class="col-lg-12 px-4 pb-3">
                                    <div class="d-flex flex-wrap">
                                        <div class="w-100">
                                            <div class="form-group">        
                                                <div class="row mx-auto">
                                                    <div class="col-12">
                                                        <h4 class="py-3">{{__('role.permission')}}</h4>
                                                    </div>
                                                    <div class="col-12">
                                                        <p>{{__('role.permission_description')}}</p>
                                                    </div>
                                                </div>
                                                
                                                <div id="loader" class="row mx-auto m-5">
                                                    <div class="col-12 text-center" style="letter-spacing: 1.2px;">
                                                        <span>{{__('common.loading')}}...</span>
                                                    </div>                            
                                                    {{-- <div class="spinner-border" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div> --}}
                                                </div>

                                                <div class="row mx-auto">
                                                    <div id="permission_list" class="w-100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" id="btn_cancel" class="btn btn-warning mt-3">{{__('common.cancel')}}</button>
                                <button type="button" id="btn_submit" class="btn btn-success mt-3">{{__('common.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CreateUserRole','#create_role') !!}

<script>
    var perm = {}

    perm.ucwords = (str) => {
        return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase()
        })
    }

    perm.buildMenu = (index, menu, childs) => {
        let el = []
        Object.keys(childs).forEach(function(item) {
            el.push(perm.buildChild(childs[item]))
        })
        const rand = Math.floor(Math.random() * 100)

        return `
            <div class="card my-3">
                <div class="card-header" id="menu-${index}">
                    <h5 class="mb-0">
                        <div class="d-inline pl-3">
                            <input id="select-all-${index}" type="checkbox" class="form-check-input select-all mt-2 magic-checkbox">
                            <label for="select-all-${index}" class="pr-2 d-inline-block">&nbsp;</label>
                        </div>
                        <div class="d-inline">
                            <button type="button" class="btn btn-link collapsed pt-1" data-toggle="collapse" data-target="#menu-${index}-perm-${rand}" aria-expanded="false" aria-controls="menu-${index}-perm-${rand}">
                                <span>${menu}</span>
                            </button>
                        </div>
                    </h5>
                </div>
                <div id="menu-${index}-perm-${rand}" class="collapse show perm-elem" aria-labelledby="menu-${index}" data-parent="#permission_list">
                    <div class="card-body">${el.join('')}</div>
                </div>
            </div>
        `
    }

    perm.buildChild = (data) => {
        const rand = Math.random()
        const name = perm.ucwords(data.name.replace(/_/g, ' '))

        return  `
            <div class="row m-0 pl-5">
                <div class="form-group">
                    <input type="checkbox" name="permission[]" class="form-check-input magic-checkbox perm-check" id="chb-${rand}" value=${data.id}>
                    <label class="" for="chb-${rand}">${name}</label>
                </div>
            </div>
        `
    }

    perm.getPermission = (callback = null) => {
        let data = {
            _token: '{{ csrf_token() }}'
        }

        if ($('input[name=agent_code]').val() !== '') {
            data.agent_code = $('input[name=agent_code]').val()
        } else if ($('input[name=corp_code]').val() !== '') {
            data.corp_code = $('input[name=corp_code]').val()
        }
        data.type = $( "#user_group option:selected" ).val();

        webRequest('POST', `{{ action('Corporate\RoleManagementController@GetPermissions') }}`, data,
            function(err, result) {
                // console.log('response: ', result)
                if (err) {
                    console.error(err)
                } else if (result.success === true) {
                    $('#loader').addClass('d-none')

                    const _data = result.data.permission
                    // render element
                    Object.keys(_data).forEach(function (item) {
                        const menu = perm.ucwords(item.replace(/_/g, ' '))
                        const perms = _data[item]
                        // console.log({ menu, perms })

                        const _rand = Math.floor(Math.random() * 1000)
                        const el = perm.buildMenu(_rand, menu, perms)
                        $('#permission_list').append(el)
                    })

                    if ($('#user_group option').length <= 1) {
                        const _user_gruop = result.data.user_gruop
                        $('#user_group').append('<option value="USER">CORPORATE</option>')
                    }
                    
                } else {
                    console.error(result.message)
                }

                if (callback) {
                    callback()
                }
            })
    }

    perm.init = () => {
        $('#loader').addClass('d-none')
        
        perm.getPermission(function() {
            $('#permission_list').empty()
        })
    }

    $(document).ready(function() {


        perm.init()
        
        
        $(document).on('click', '.perm-check', function() {
            let findInput = $(this).closest(".card-body").find(".perm-check").length;
            let findInputChecked = $(this).closest(".card-body").find(".perm-check:checked").length;
            //check input length == input checked
            if(findInputChecked === findInput){
                $(this).closest(".card").find("input.select-all").prop("checked" , true);
                $(this).closest(".card").find("input.select-all").attr("checked" , "checked");
            }
            else{
                $(this).closest(".card").find("input.select-all").prop("checked" , false);
                $(this).closest(".card").find("input.select-all").removeAttr("checked");
            }
        });
        $(document).on('click', '.select-all', function() {
            if( $(this).is(":checked") == true){
                $(this).closest(".card").find("input.perm-check").prop("checked" , true);
                $(this).closest(".card").find("input.perm-check").attr("checked" , "checked");
            }
            else{
                $(this).closest(".card").find("input.perm-check").prop("checked" , false);
                $(this).closest(".card").find("input.perm-check").removeAttr("checked");
            }
            
        })

        $(document).on('change', '#user_group', function() {
            const type = this.value
            const data = {
                _token: '{{ csrf_token() }}',
                type:   type
            }

            $('#permission_list').empty()
            $('#agent').empty();
            $('#corporate').empty();
            $('#div-agent').addClass('d-none');
            $('#div-corporate').addClass('d-none');

            webRequest('POST', `{{ action('Corporate\RoleManagementController@GetObjectType') }}`, data,
                function(err, result) {
                    if (err) {
                        console.error(err)
                    } else if (!!result.success) {
                        console.log(result)
                        if (type === 'AGENT') {
                            const data = result.data
                            $('#agent').append('<option></option>')
                            data.forEach( function(element) {
                                $('#div-agent').removeClass('d-none');
                                @if( app()->getLocale() == "th" )
                                    $('#agent').append('<option value="'+element.id+'">'+element.name_th+'</option>')
                                @else
                                    $('#agent').append('<option value="'+element.id+'">'+element.name_en+'</option>')
                                @endif
                            })
                        } else if(type === 'USER') {
                            if ($('#is_user').val() == "USER") {
                                $('#corporate').trigger('change')
                            }
                            const data = result.data
                            $('#corporate').append('<option></option>')
                            data.forEach( function(element) {
                                $('#div-corporate').removeClass('d-none');
                                @if( app()->getLocale() == "th" )
                                    $('#corporate').append('<option value="'+element.id+'">'+element.name_th+'</option>')
                                @else
                                    $('#corporate').append('<option value="'+element.id+'">'+element.name_en+'</option>')
                                @endif
                            })
                        } else {
                            // re-initialize
                            $('#permission_list').empty()
                            $('#loader').removeClass('d-none')
                            perm.getPermission()
                        }

                    } else {
                        console.error(result.message)
                    }
                })
        })

        $(document).on('click', '#btn_submit', function() {
            $('form').submit()
        })

        $(document).on('click', '#btn_cancel', function() {
            window.location.href = "{{ action('Corporate\RoleManagementController@corporate_role_page_index') }}"
        })

        $(document).on('change', '#agent', function() {
            $('input[name=agent_code]').val($(this).val())
            $('input[name=corp_code]').val('')

            // re-initialize
            $('#permission_list').empty()
            $('#loader').removeClass('d-none')
            perm.getPermission()
        })

        $(document).on('change', '#corporate', function() {
            $('input[name=corp_code]').val($(this).val())
            $('input[name=agent_code]').val('')

            // re-initialize
            $('#permission_list').empty()
            $('#loader').removeClass('d-none')
            perm.getPermission()
        })
    })
</script>

@endsection