@extends('argon_layouts.app', ['title' => __('Create User')])

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
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('userManagement.new_user')}}</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
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
                            <form action="{{ action('Corporate\UserManagementController@create_submit')}}" method="post" enctype="multipart/form-data" id="form-create-user">
                                {{ csrf_field() }}

                                {{-- allow create user for mult-corp --}}
                                @if (isset($data->corp_code))
                                    <input type="hidden" name="corp_code" value="{{ $data->corp_code }}">
                                @endif  

                                <div class="row mb-4">
                                    <div class="col-lg-10 col-sm-12">
                                        <div class="card p-3">
                                            <div class="d-flex flex-wrap mb-3">
                                                <div class="p-2 flex-fill w-50">
                                                    <h4 class="mb-3 py-3 card-header-with-border">{{__('userManagement.user_profile')}}</h4>
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
                                                                    <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ old('firstname_en') }}">
                                                                @else
                                                                    <input type="text" id="" name="firstname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="">
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
                                                                    <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="{{ old('lastname_en') }}">
                                                                @else
                                                                    <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish" value="">
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
                                                                    <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ old('firstname_th') }}">
                                                                @else
                                                                    <input type="text" id="" name="firstname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="">
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
                                                                    <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="{{ old('lastname_th') }}">
                                                                @else
                                                                    <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" onkeypress="return isThai(event)" data-spec="name" data-language="isThai" value="">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="px-5 d-flex flex-wrap">

                                                <div class="p-2 w-50">
                                                    <div class="form-group">        
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="telephone" class=" form-control-label">{{__('userManagement.mobile')}} <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-12">
                                                                @if (old('telephone') != null)
                                                                    <input type="text" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="{{ old('telephone') }}" onkeypress="return isNumber(event)">
                                                                @else
                                                                    <input type="text" name="telephone" placeholder="" class="form-control select-append" data-language="isNumber" data-spec="phone" maxlength="13" value="" onkeypress="return isNumber(event)">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="p-2 flex-fill w-50"></div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-10 col-sm-12">
                                        <div class="card p-3">
                                            <div class="d-flex flex-wrap mb-3">
                                                <div class="p-2 flex-fill w-50">
                                                    <h4 class="mb-3 py-3 card-header-with-border">{{__('userManagement.select_role')}}</h4>
                                                </div>
                                            </div>
                                            <div class="px-5 d-flex flex-wrap">
                                                <div class="p-2 flex-fill w-100">
                                                    <div class="form-group">  
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-check" id="radio_role">
                                                                    @if (isset($data->roles))
                                                                        @foreach($data->roles as $item)
                                                                            <div class="d-block py-2">
                                                                                @if($item->name == 'DEFAULT USER ROLE')
                                                                                    <input id="{{ $item->id }}-radio" class="form-check-input magic-radio" type="radio" name="roles[]" value="{{ $item->id }} " checked>
                                                                                    <label class="form-check-label" for="{{ $item->id }}-radio">{{ $item->name }}</label>
                                                                                    <span class="d-block text-muted font-10 text-overflow">{{ $item->description ?? '' }}</span>
                                                                                @else
                                                                                    <input id="{{ $item->id }}-radio" class="form-check-input magic-radio" type="radio" name="roles[]" value="{{ $item->id }} ">
                                                                                    <label class="form-check-label" for="{{ $item->id }}-radio">{{ $item->name }}</label>
                                                                                    <span class="d-block text-muted font-10 text-overflow">{{ $item->description ?? '' }}</span>
                                                                                @endif
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <span> - </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <a href="{{ action('Corporate\UserManagementController@index')}}" id="btn_cancel" class="btn btn-warning mt-3">{{__('common.cancel')}}</a>
                                            <button type="submit" id="btn_submit" class="btn btn-success mt-3">{{__('common.save')}}</button>
                                        </div>
                                    </div>
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
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CreateUser','#form-create-user') !!}

    <script type="text/javascript">

        $(document).ready(function() {

            $(document).on('keypress input propertychange paste change', 'input[type=number]', function(e) {
                return isNumber(e)
            })

            // $(document).on('paste', 'input', function(e) {
            //     return false
            // })

        })
        
    </script>
@endsection
