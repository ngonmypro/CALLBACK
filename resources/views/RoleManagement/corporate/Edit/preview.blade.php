@extends('argon_layouts.app', ['title' => __('Role Management')])

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
                    <div class="col-lg-6 col-5 text-right">
                        @Permission(CORPORATE_ROLE_MANAGEMENT.EDIT_ROLE_DETAIL)
                            <a href="{{ action('Corporate\RoleManagementController@EditRolePermission', ['code' => $code]) }}" class="btn btn-neutral">{{__('common.edit')}}</a>
                        @EndPermission
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
                                <h3 class="mb-0">{{__('role.update_role_and_permission')}} : {{$data['role']}} </h3>
                                <p class="text-sm mb-0">
                                </p>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="create_role" class="item-form" action="{{ action('Corporate\RoleManagementController@UpdateRoleAndPermission') }}" method="post" enctype="multipart/form-data" id="update-permission">
                            <div class="col-lg-12 px-4 pb-2">
                                <div class="d-flex flex-wrap mb-3">
                                    <div class="w-100">
                                        <div class="form-group">        
                                            <div id="top_view_section" class="row mx-0">
                                                <div class="">
                                                    <h4 class="pt-0">{{__('role.role_name')}} : <span>{{ $data['role'] }}</span></h4>
                                                    <p>{{__('role.role_title_description')}}</p>
                                                    <input type="hidden" name="existing_role_id" value="{{$code}}">
                                                </div>

                                                @if( !blank($data['role_description'] ?? null) )
                                                    <div class="">
                                                        <h4 class="pt-0">{{__('role.role_description')}} : <span>{{ $data['role_description'] }}</span></h4>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 px-4 pb-2">
                                    <div class="d-flex flex-wrap">
                                        <div class="w-100">
                                            <div class="form-group">     
                                                <div class="row mx-auto mb-4">
                                                    <div class="col-lg-6 col-sm-12">
                                                        <div class="form-group">
                                                            <label for="" class=" form-control-label">{{__('role.data_group')}}</label>
                                                            <select id="user_group" name="user_type" class="form-control" disabled>
                                                                <option></option>
                                                                @foreach($data['user_group'] as $group)
                                                                    <option value="{{$group}}" {{$data['role_group'] == $group ? 'selected' : ''}}>{{$group}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    @if(\Session::get('user_detail')->user_type != "USER")
                                                        @if($data['role_group'] == "AGENT")
                                                            <div class="col-lg-6 col-sm-12" id="div-agent">
                                                                <div class="form-group">
                                                                    <label for="" class=" form-control-label">{{__('role.agent')}}</label>
                                                                    <select id="agent" name="agent" class="form-control" disabled>
                                                                        <option></option>
                                                                        @foreach($data['partner_group'] as $partner)
                                                                            <option value="{{$partner['id']}}" {{$data['select_agent'] === $partner['id'] ? 'selected' : ''}}>{{ app()->getLocale() == "en" ? $partner['name_en'] : $partner['name_th']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @elseif($data['role_group'] == "USER")
                                                            <div class="col-lg-6 col-sm-12" id="div-corporate">
                                                                <div class="form-group">
                                                                    <label for="" class=" form-control-label">{{__('role.corporate')}}</label>
                                                                    <select id="corporate" name="corporate" class="form-control" disabled>
                                                                        <option></option>
                                                                        @foreach($data['partner_group'] as $partner)
                                                                            <option value="{{$partner['id']}}" {{$data['select_corp'] === $partner['id'] ? 'selected' : ''}}>{{ app()->getLocale() == "en" ? $partner['name_en'] : $partner['name_th']}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
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
                                                                    <input type="text" name="role_name" placeholder="" class="form-control" value="{{$data['role']}}" disabled>                                   
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
                                                                    <input type="text" name="role_description" placeholder="" class="form-control" value="{{$data['role_description']}}" disabled>
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
                                                                            <input disabled id="select-all-{{$key}}" type="checkbox" class="form-check-input select-all mt-2 magic-checkbox">
                                                                            <label for="select-all-{{$key}}" class="pr-2 d-inline-block">&nbsp;</label>
                                                                        </div>
                                                                        <div class="d-inline">
                                                                            <button disabled type="button" class="btn btn-link collapsed pt-1" data-toggle="collapse" data-target="#menu-{{$key}}-perm-${rand}" aria-expanded="false" aria-controls="menu-{{$key}}-perm-${rand}">
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
                                                                                        <input disabled type="checkbox" name="permission[]" class="form-check-input magic-checkbox perm-check" id="{{$key}}-{{$_per['name']}}" value="$_per['id']" {{isset($_per['is_select']) && $_per['is_select'] === true ? 'checked' : ''}} disabled>
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

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('script')
    <script type="text/javascript">
       $(document).ready(function() {
            //each check permission
            $(".perm-elem").each(function(){
                let findInput = $(this).find("input.perm-check").length;
                let findInputChecked = $(this).find("input.perm-check:checked").length;

                if(findInputChecked === findInput){
                    $(this).closest(".card").find("input.select-all").prop("checked" , true);
                    $(this).closest(".card").find("input.select-all").attr("checked" , "checked");
                }
                else{
                    $(this).closest(".card").find("input.select-all").prop("checked" , false);
                    $(this).closest(".card").find("input.select-all").removeAttr("checked");
                }
            });

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

                $('#agent').empty();
                $('#corporate').empty();
                $('#div-agent').addClass('d-none');
                $('#div-corporate').addClass('d-none');

                webRequest('POST', `{{ action('Corporate\RoleManagementController@GetObjectType') }}`, data,
                    function(err, result) {
                        if (err) {
                            console.error(err)
                        } else if (result.success === true) {
                            
                            if(type === 'AGENT')
                            {
                                const data = result.data
                                data.forEach( function(element) {
                                    $('#div-agent').removeClass('d-none');
                                    @if( app()->getLocale() == "th" )
                                        $('#agent').append('<option value="'+element.id+'">'+element.name_th+'</option>')
                                    @else
                                        $('#agent').append('<option value="'+element.id+'">'+element.name_en+'</option>')
                                    @endif
                                })
                            }
                            else if(type === 'USER')
                            {
                                const data = result.data
                                data.forEach( function(element) {
                                    $('#div-corporate').removeClass('d-none');
                                    @if( app()->getLocale() == "th" )
                                        $('#corporate').append('<option value="'+element.id+'">'+element.name_th+'</option>')
                                    @else
                                        $('#corporate').append('<option value="'+element.id+'">'+element.name_en+'</option>')
                                    @endif
                                })
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

        })
    </script>
@endsection
