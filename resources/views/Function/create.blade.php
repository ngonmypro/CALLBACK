@extends('argon_layouts.app', ['title' => __('Function')])

@section('style')

<link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
<style type="text/css">
</style>
@endsection

@section('content')

<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">{{__('function.function')}}</h6>
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
                            <h3 class="mb-0">{{__('common.create')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="create_function" class="item-form" action="{{ action('FunctionController@create_save')}}" method="post" enctype="multipart/form-data">
                        
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-12 px-4 pb-3">
                                <div class="d-flex flex-wrap">
                                    <div class="w-100">  

                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="app" class=" form-control-label">{{__('function.app')}}</label>
                                                    <select id="app" name="app" class="form-control">
                                                        <option selected disabled>-- {{__('function.select_app_type')}} --</option>
                                                        @foreach($apps as $app)
                                                            <option value="{{$app->code}}">{{$app->app_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label for="function_type" class=" form-control-label">{{__('function.function_type')}}</label>
                                                <select id="function_type" name="function_type" class="form-control" disabled>
                                                    <option selected disabled>-- {{__('function.select_function_type')}} --</option>
                                                    <option value="AGENT">{{__('function.agent')}}</option>
                                                    <option value="USER">{{__('function.corporate')}}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12"> 
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="function_name" class=" form-control-label">{{__('function.function_name')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="function_name" placeholder="" class="form-control">                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="function_des" class="form-control-label">{{__('function.function_description')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="function_des" placeholder="" class="form-control">
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
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\FunctionRequest','#create_function') !!}
<script type="text/javascript">
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
        
        data.app = $( "#app option:selected" ).val();
        data.type = $( "#function_type option:selected" ).val();
        
        webRequest('POST', `{{ action('FunctionController@get_permission') }}`, data,
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
        $('#loader').addClass('d-none');
        $('#permission_list').empty();
    }

    $(document).ready(function() {

        perm.init();
        
        $(document).on('click', '.perm-check', function() {
            let findInput = $(this).closest(".card-body").find(".perm-check").length;
            let findInputChecked = $(this).closest(".card-body").find(".perm-check:checked").length;
            //check input length == input checked
            if(findInputChecked === findInput) {
                $(this).closest(".card").find("input.select-all").prop("checked" , true);
                $(this).closest(".card").find("input.select-all").attr("checked" , "checked");
            }
            else{
                $(this).closest(".card").find("input.select-all").prop("checked" , false);
                $(this).closest(".card").find("input.select-all").removeAttr("checked");
            }
        });
        $(document).on('click', '.select-all', function() {
            if( $(this).is(":checked") == true) {
                $(this).closest(".card").find("input.perm-check").prop("checked" , true);
                $(this).closest(".card").find("input.perm-check").attr("checked" , "checked");
            }
            else{
                $(this).closest(".card").find("input.perm-check").prop("checked" , false);
                $(this).closest(".card").find("input.perm-check").removeAttr("checked");
            }
            
        })

        $(document).on('click', '#btn_submit', function() {
            $('form').submit();
        })

        $(document).on('click', '#btn_cancel', function() {
            window.location.href = "{{ action('FunctionController@index') }}"
        })

        $(document).on('change', '#function_type', function() {
            $('#permission_list').empty();
            $('#loader').removeClass('d-none');
            perm.getPermission();
        })
        
        $(document).on('change', '#app', function() {
            $('#function_type').removeAttr("disabled");
            $("#function_type").val($("#function_type option:first").val());
            $('#permission_list').empty();
        })

    })

    $(document).on('click', '#btn_submit', function() {
        $('form').submit();
    })

    $(document).on('click', '#btn_cancel', function() {
        window.location.href = "{{ action('FunctionController@index') }}"
    })
</script>

@endsection
