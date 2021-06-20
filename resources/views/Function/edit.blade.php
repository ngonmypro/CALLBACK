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
                    <form id="edit_function" class="item-form" action="{{ action('FunctionController@edit_save')}}" method="post" enctype="multipart/form-data">
                        
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-12 px-4 pb-3">
                                <div class="d-flex flex-wrap">
                                    <div class="w-100">
                                        <input type="hidden" name="function_code" value="{{$function_code}}">
                                        
                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="app" class=" form-control-label">{{__('function.app')}}</label>
                                                    <select id="app" name="app" class="form-control" disabled>
                                                        <option value="{{$data['app_code']}}" selected>{{$data['app_name']}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label for="function_type" class=" form-control-label">{{__('function.function_type')}}</label>
                                                <select id="function_type" name="function_type" class="form-control" disabled>
                                                    @if($data['function_type'] == 'AGENT')
                                                        <option value="AGENT" selected>{{__('function.agent')}}</option>
                                                    @elseif($data['function_type'] == 'USER')
                                                        <option value="USER" selected>{{__('function.corporate')}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12"> 
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="function_name" class=" form-control-label">{{__('function.function_type')}}</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="function_name" value="{{$data['function_name']}}" placeholder="" class="form-control">                                   
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mx-auto mb-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="function_des" class="form-control-label">Function Description</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <input type="text" name="function_des" value="{{$data['function_description']}}" placeholder="" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 px-4 pb-0">
                                <div class="d-flex flex-wrap">
                                    <div class="w-100">
                                        <div class="form-group">        
                                            <div class="row mx-auto">
                                                <div class="col-12">
                                                    <h4 class="pb-3">{{__('role.permission')}}</h4>
                                                </div>
                                                <div class="col-12">
                                                    <p>{{__('role.permission_description')}}</p>
                                                </div>
                                            </div>
                                            <div class="row mx-auto">
                                                <div id="permission_list" class="w-100">
                                                    @foreach($data['permission'] as $key => $permission)
                                                        <div class="card my-3">
                                                            <div class="card-header" id="menu-{{$key}}">
                                                                <h5 class="mb-0">
                                                                    <div class="d-inline pl-3">
                                                                        <input id="select-all-{{$key}}" type="checkbox" class="form-check-input select-all mt-2 magic-checkbox">
                                                                        <label for="select-all-{{$key}}" class="pr-2 d-inline-block">&nbsp;</label>
                                                                    </div>
                                                                    <div class="d-inline">
                                                                        <button type="button" class="btn btn-link collapsed pt-1" data-toggle="collapse" data-target="#menu-{{$key}}-perm" aria-expanded="false" aria-controls="menu-{{$key}}-perm">
                                                                            <span>{{$key}}</span>
                                                                        </button>
                                                                    </div>
                                                                </h5>
                                                            </div>
                                                            <div id="menu-{{$key}}-perm" class="collapse show perm-elem" aria-labelledby="menu-{{$key}}" data-parent="#permission_list">
                                                                <div class="card-body">
                                                                    @foreach($permission as $_key => $action)
                                                                        @foreach($action as $_per)
                                                                            <div class="row m-0 pl-5">
                                                                                <div class="form-group">
                                                                                    <input type="checkbox" name="permission[]" class="form-check-input magic-checkbox item-checkbox perm-check" id="{{$key}}-{{$_per['name']}}" value="{{$_per['id']}}" {{isset($_per['is_select']) && $_per['is_select'] === true ? 'checked' : ''}}>
                                                                                    <label class="" for="{{$key}}-{{$_per['name']}}">{{$_per['name']}}</label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
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
{!! JsValidator::formRequest('App\Http\Requests\FunctionRequest','#edit_function') !!}
<script type="text/javascript">
    var perm = {}

    $(document).ready(function() {
       //each check permission
        $(".perm-elem").each(function() {
            let findInput = $(this).find("input.perm-check").length;
            let findInputChecked = $(this).find("input.perm-check:checked").length;

            if(findInputChecked === findInput) {
                $(this).closest(".card").find("input.select-all").prop("checked" , true);
                $(this).closest(".card").find("input.select-all").attr("checked" , "checked");
            }
            else{
                $(this).closest(".card").find("input.select-all").prop("checked" , false);
                $(this).closest(".card").find("input.select-all").removeAttr("checked");
            }
        });

        $(document).on('click', '.perm-check', function() {
            let checked = null
            let findInput = $(this).closest(".card-body").find(".perm-check").length;
            let findInputChecked = $(this).closest(".card-body").find(".perm-check:checked").length;
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

        $(document).on('click', '#btn_submit', function() {
            $('form').submit()
            $('#btn_submit').text('Wait...')
            $('#btn_submit').attr("disabled", 'disabled')
        })

        $(document).on('click', '#btn_cancel', function() {
            window.location.href = "{{ action('FunctionController@index') }}"
        })

    })


    $(document).on('click', '#btn_submit', function() {
        $('form').submit()
    })

    $(document).on('click', '#btn_cancel', function() {
        window.location.href = "{{ action('FunctionController@index') }}"
    })
</script>

@endsection
