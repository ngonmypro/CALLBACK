@extends('layouts.master')
@section('title', 'Create New User')
@section('style')
<!-- pace-theme-loading-bar.css -->
<link href="{{ URL::asset('assets/css/extensions/pace-theme-loading-bar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/extensions/bootstrap-slider.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('userManagement.new_user')}}">
<div class="col-12">
    <form action="{{ url('UserManagement/Create/queryAddNewUser')}}" method="post" enctype="multipart/form-data" id="form-create-user">
        {{ csrf_field() }}
        <div class="col-12">
            <div id="" class="row mx-auto mb-4">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 py-1">
                                <span class="template-text">{{__('userManagement.user_profile')}}</span>
                            </h4> 
                        </div>
                        <div  class="card-body px-4 pt-4 pb-2">
                            <div class="row mb-3 px-2">
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.name_en')}}<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="first_name_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.lastname_en')}}<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="last_name_en" placeholder="" class="form-control select-append" onkeypress = "" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.name_th')}}<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="first_name_th" placeholder="" class="form-control select-append" onkeypress = "return isThai(event)" data-spec="name" data-language="isThai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.lastname_th')}}<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="last_name_th" placeholder="" class="form-control select-append" onkeypress = "" onkeypress = "return isThai(event)" data-spec="name" data-language="isThai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                                <div class="col-12">
                                    <div class="form-group col-6 pl-0">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="id_no" class=" form-control-label">{{__('userManagement.citizen_id')}}<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="id_no" name="Citizen" placeholder="" class="form-control select-append" onkeypress = "return isNumber(event)" data-spec="citizenid" data-language="isNumber" maxlength="17">
                                                 <input id="storeValue" type="hidden" value="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="email" class=" form-control-label">{{__('userManagement.email')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="email" name="Email" placeholder="" class="form-control select-append" onkeypress = "return isEmail(event)" data-spec="email" data-language="isEmail">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="phone_number" class=" form-control-label">{{__('userManagement.mobile')}} <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="phone_number" name="Mobile" placeholder="" class="form-control select-append" onkeypress = "return isNumber(event)" data-language="isNumber" data-spec="phone" maxlength="13">
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
        <div class="col-12">
            <div id="" class="row mx-auto mb-4">
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 py-1">
                                <span class="template-text">{{__('userManagement.select_role')}}</span>
                            </h4> 
                        </div>
                        <div  class="card-body px-4 pt-4 pb-2">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="pl-2">{{__('userManagement.role')}}</label>
                                    <ul class="list-inline pl-4 mb-0">
                                        <li class="list-inline-item">
                                            <input class="form-check-input input-validate magic-radio" data-rule="radio" type="radio" name="role_name" id="Admin" value="Admin">
                                            <label class="form-check-label" for="Admin">{{__('userManagement.admin')}}</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input class="form-check-input input-validate magic-radio" data-rule="radio" type="radio" name="role_name" id="User" value="User">
                                            <label class="form-check-label" for="User">{{__('userManagement.user')}}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="pl-2">{{__('userManagement.workflow')}}</label>
                                    <ul class="list-inline pl-4 mb-0">
                                        <li class="list-inline-item">
                                            <input class="form-check-input input-validate magic-checkbox" data-rule="checkbox" type="checkbox" name="workflow" id="Maker" value="Maker">
                                            <label class="form-check-label" for="Maker">{{__('userManagement.maker')}}</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input class="form-check-input input-validate magic-checkbox" data-rule="checkbox" type="checkbox" name="workflow" id="Checker" value="Checker">
                                            <label class="form-check-label" for="Checker">{{__('userManagement.checker')}}</label>
                                        </li>
                                        <li class="list-inline-item">
                                            <input class="form-check-input input-validate magic-checkbox" data-rule="checkbox" type="checkbox" name="workflow" id="Viewer" value="Viewer">
                                            <label class="form-check-label" for="Viewer">{{__('userManagement.viewer')}}</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="d-flex content-highlight">
            <hr class="vertical-line-content">
            <div class="py-2 pl-0 pr-2">
                <a class="" href="#" data-url="CreateSelectCorporate">
                    <div class="d-inline-block position-relative">
                        <div class="rounded-circle d-inline-block position-relative active-circle" style="height: 50px;width: 50px;">
                            <span class="position-absolute text-white active-circle" style="top: .75rem;left: 1.4rem;">1</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p-2 flex-shrink-1 w-100">
                <div class="col-lg-12 p-1 pb-3">
                    <h4 class="d-inline-block">Create new user</h4>
                </div>
                <div class="col-lg-12 p-1">
                    <div class="card">
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3 card-header-with-border">
                                    User Information
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">Name (EN)<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="" name="first_name_en" placeholder="" class="form-control select-append" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">Lastname (EN)<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="" name="last_name_en" placeholder="" class="form-control select-append" onkeypress = "" onkeypress = "return isEnglish(event)" data-spec="name" data-language="isEnglish">
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
                                            <label for="" class=" form-control-label">Name (TH)<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="" name="first_name_th" placeholder="" class="form-control select-append" onkeypress = "return isThai(event)" data-spec="name" data-language="isThai">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">Lastname (TH)<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="" name="last_name_th" placeholder="" class="form-control select-append" onkeypress = "" onkeypress = "return isThai(event)" data-spec="name" data-language="isThai">
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
                                            <label for="id_no" class=" form-control-label">Citizen ID<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="id_no" name="Citizen" placeholder="" class="form-control select-append" onkeypress = "return isNumber(event)" data-spec="citizenid" data-language="isNumber" maxlength="17">
                                             <input id="storeValue" type="hidden" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="email" class=" form-control-label">E-mail <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="email" name="Email" placeholder="" class="form-control select-append" onkeypress = "return isEmail(event)" data-spec="email" data-language="isEmail">
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
                                            <label for="phone_number" class=" form-control-label">Mobile no. <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="phone_number" name="Mobile" placeholder="" class="form-control select-append" onkeypress = "return isNumber(event)" data-language="isNumber" data-spec="phone" maxlength="13">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="d-flex content-highlight">
            <hr class="vertical-line-content">
            <div class="py-2 pl-0 pr-2">
                <a class="" href="#" data-url="CreateSelectCorporate">
                    <div class="d-inline-block position-relative">
                        <div class="rounded-circle d-inline-block position-relative active-circle" style="height: 50px;width: 50px;">
                            <span class="position-absolute text-white active-circle" style="top: .75rem;left: 1.3rem;">2</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p-2 flex-shrink-1 w-100">
                <div class="col-lg-12 p-1 pb-3">
                    <h4 class="d-inline-block">Select Type <span class="text-danger">*</span></h4>
                </div>
                <div class="row">
                    <div id="TypeUser" class="col-lg-4 px-4 py-1">
                       
                        <input id="DataTypeUser" type="hidden" name="DataTypeUser" value="">
                        <ul class="ul-list-item px-0 list-unstyled">
                            <li id="Admin_id" class="w-100 item" data-type="Admin" onclick="Type_User('admin',this)">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="pl-3">Type Admin</h4>
                                    </div>
                                </div>
                            </li>

                            <li id="User_id" class="w-100 item" data-type="User" onclick="Type_User('user' , this)">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class="pl-3">Type User</h4>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="DataGroup" class="col-lg-8 px-4 py-1 d-none">
                        <div class="col-lg-12">
                            <div class="card mb-2">
                                <div id="" class="">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h4 class="mb-3 py-3 card-header-with-border">
                                                Corporate name<span class="text-danger">*</span>
                                            </h4>
                                            <div class="d-flex">
                                                <div class="py-2 px-0 flex-fill w-100">
                                                    <select  class="form-control menu_block w-100" name=""  id="AddCoporateName">
                                                        <option disabled selected>--- เลือก Corporate ----</option>
                                                        @foreach ($corporate_list as $data)
                                                            <option id="corp_{{$data['id']}}" value="{{$data['id']}}|{{$data['name']}}">{{$data['name']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div id="store-option" class="d-none">
                                                    @foreach ($corporate_list as $data)
                                                        <option id="corp_{{$data['id']}}" value="{{$data['id']}}|{{$data['name']}}">{{$data['name']}}</option>
                                                    @endforeach
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="ul-list-item px-0 list-unstyled" id="DataGroup_list">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex content-highlight">
            <hr class="vertical-line-content">
            <div class="py-2 pl-0 pr-2">
                <a class="" href="#" data-url="CreateSelectCorporate">
                    <div class="d-inline-block position-relative">
                        <div class="rounded-circle d-inline-block position-relative active-circle" style="height: 50px;width: 50px;">
                            <span class="position-absolute text-white active-circle" style="top: .75rem;left: 1.3rem;">3</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="p-2 flex-shrink-1 w-100">
                <div class="col-lg-12 p-1 pb-3">
                    <h4 class="d-inline-block">Select Role</h4>
                </div>
                <div class="row">
                    <div class="col-lg-12 p-1 px-3 role_user">
                        <ul class="ul-list-item px-0 list-unstyled" id="role_user">
                            
                        </ul>
                    </div>
                </div>

            </div>
        </div> -->
        @include('layouts.footer_progress')
        <input id="check_type" type="hidden" value="">
        <input id="type_user" name="type_user" type="hidden" value="">
    </form>
    <input id="temp_type_user" name="temp_type_user" type="hidden" value="{{ Session::get('user_detail')->user_type }}">
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/extensions/bootstrap-slider.min.js') }}"></script>
     <script data-pace-options='{ "startOnPageLoad": false }' src="{{ URL::asset('assets/js/extensions/pace.js') }}"></script>
    <script type="text/javascript">
        var i=0;
        var _user_type = '{!! Session::get('user_detail')->user_type !!}';
        $(document).ready(function(){

            //Call Function Custom button (Make Button)

            //CustomButton(element ,  attr  , msg , style='')
            Backbtn = CustomButton('button' , 'id="BackToStep2" onclick="window.location.href=\'/UserManagement/CancelCreateUser\';" type="button"' , '{{__("corporateManagement.cancel")}}' , 'outline-button');
            Submitbtn = CustomButton('button' , 'id="create-btn" type="button"', 'Create' , 'gradient-button');
            //first load footer progress
            divLevel2Content = `<div class="col-12 py-3">
                                    <div class="pull-left pl-4" style="padding-bottom: 10px;">
                                        ${Backbtn}
                                    </div>
                                    <div class="pull-right pr-4" style="padding-bottom: 10px;">
                                        ${Submitbtn}
                                    </div>
                                </div>`;
            //call footer
            FooterProgress( divLevel2Content );


            //refresh
            $('#AddCoporateName').select2();

            //start page load
            //line height add height to hr same content height
            var countLength = $(".content-highlight").length;

            $(".content-highlight").each(function(index){
                var contenthighlight = $(this).height();

                $(this).find("hr.vertical-line-content").attr("style" , "height:"+contenthighlight+"px");
                console.log(index)
                //ตัวที่ 3 ไม่ต้องมีเส้น
                if(index > 1){
                    $(this).find("hr.vertical-line-content").attr("style" , "height:0px");
                }
            });
            // Range Slider
            $("#limitation").slider({
                tooltip_split: true,
                tooltip: 'always',
                min: 0,
                max: 2000000,
                value: [0, 2000000],
                lock_to_ticks: true,
                ticks: [0, 1000 , 5000 , 10000 , 50000 , 100000 , 500000 , 1000000 , 1500000 , 2000000],
                ticks_positions: [0, 10, 20, 30, 40, 50, 60, 70, 90, 100],
                ticks_labels: ['0', '1,000', '5,000', '10,000', '50,000' , '100,000' , '500,000' , '1,000,000' , '1,500,000' , '2,000,000'],
                ticks_snap_bounds: 30,
                formatter: function(value) {
                    return addComma(value);
                }
            });


        });
        function Select_Role(data_select)
        {
            var getDataRole = $(data_select).data("role");
            var getHiddenValue = $(data_select).find("input[type='hidden']").val();

            //alert(getDataRole);
            //alert(getHiddenValue);

            if(getHiddenValue == ''){
                $(data_select).find("input[type='hidden']").attr("value" , getDataRole);
                $(data_select).find("input[type='hidden']").attr("name" , 'role['+ getDataRole +']');
                $(data_select).find("div.card").addClass("gradient-active");
            }
            else{
                $(data_select).find("input[type='hidden']").attr("value" , "");
                $(data_select).find("input[type='hidden']").attr("name" , '');
                $(data_select).find("div.card").removeClass("gradient-active");
            }
        }
        //check all 
        $(document).on("click" , "input.check_all" , function(){
            console.log($(this));
            console.log('Need');
            if($(this).is(":checked") == true){
                $(this).parents().eq(1).find("input.switch-input").prop("checked" , true);
                // alert("true");
            }
            else{
                $(this).parents().eq(1).find("input.switch-input").prop("checked" , false);
                // alert("false");
            }
            
        });
        $(document).on("click" , "input.switch-input" , function(){

            var findParents = $(this).parents().eq(2).find(".switch-input");
            var CountCheck = findParents.length;

            var keepTrue = [];
            var keepFalse = [];
            
            findParents.each(function(){
                if($(this).is(":checked") == true){
                    keepTrue.push($(this).is(":checked"));
                }
                else{
                    keepFalse.push($(this).is(":checked"));
                }

            });

            // console.log(keepTrue);
            // console.log(keepFalse);

            // alert("KeepTrue "  +keepTrue.length);
            //  alert("keepFalse " + keepFalse.length);

             if(keepTrue.length == 0){
                // alert("all checked = false")
                $(this).parents().eq(2).find("input.check_all").prop("checked" , false);
             }
             else{
                $(this).parents().eq(2).find("input.check_all").prop("checked" , true);
             }
            // for(var i=0; i<CountCheck;i++){
            //     var falseVal = KeepTrue;
            //     var TrueVal =  keepFalse;

            //     alert(TrueVal.length)
            //     alert(falseVal.length)
            // }
            
        });

        //validate
         //check event keyin
       $('#phone_number').mask('ZZZ-ZZZ-ZZZZ', {
          translation: {
            'Z': {
              pattern: /[0-9]/
            }
          }
        });
       $("#phone_number").on("focusout" , function(){
          var phone_number = $('#phone_number').val().replace(/-/g, "");
          var lengthphone_number = $('#phone_number').val().length;
          var first = phone_number.slice(0, 1);
          var second = phone_number.slice(1, 3);
          var sec1 = phone_number.slice(0, 3);
          var sec2 = phone_number.slice(3, 6);
          var sec3 = phone_number.slice(6, 10);
          var phone_number_sliceconvert = sec1 + '-' + sec2 + '-' + sec3;
           // alert(second)
            if(first != 0){
             // alert("!=0");
             $("#phone_number").addClass("border-danger");
             $("#phone_number").removeClass("border-success");

            }
            else{
              // alert("=0");
              if (lengthphone_number < 12) {
                $("#phone_number").addClass("border-danger");
                $("#phone_number").removeClass("border-success");
                

              }
              else {
                  $("#phone_number").addClass("border-success");
                  $("#phone_number").removeClass("border-danger");
                  $('#phone_number').val(phone_number_sliceconvert);
              }
            }
       });
       $('#id_no').mask('Z-ZZZZZ-ZZZZ-ZZ-Z', {
          translation: {
            'Z': {
              pattern: /[0-9]/
            }
          }
        });
       $("#id_no").on("focusout" , function(){
            var id_no = $('#id_no').val().replace(/-/g, "");
            var lengthid_no = $('#id_no').val().length;
            var sec1 = id_no.slice(0, 1);
            var sec2 = id_no.slice(1, 6);
            var sec3 = id_no.slice(6, 10);
            var sec4 = id_no.slice(10, 12);
            var sec5 = id_no.slice(12, 13);
            var id_no_sliceconvert = sec1 + '-' + sec2 + '-' + sec3 + '-' + sec4 + '-' + sec5;
            if (id_no == "") {
                $("#id_no").addClass("border-danger");
                $("#id_no").removeClass("border-success");
            } else {
                if (lengthid_no < 17) {
                    $("#id_no").addClass("border-danger");
                    $("#id_no").removeClass("border-success");

                } else {
                    var citizen_id = $("#id_no").val().replace(/-/g, "");
                    var summary = 0;
                    var count = parseInt(13);

                    for (var i = 0; i < (citizen_id.length - 1); i++) {
                        if (citizen_id.substring(0, 1) == '0') {
                            $("#id_no").addClass("border-danger");
                            $("#id_no").removeClass("border-success");
                            return false;
                        } else {
                            summary = summary + (citizen_id.substring(i, i + 1) * (count - i));
                        }
                    }
                    var summary_result = summary;
                    var mod_sum = parseInt(summary_result) % parseInt(11);
                    var checkdigit = parseInt(11) - parseInt(mod_sum);
                    $("#storeValue").val(checkdigit);
                    var checkdigitVal = $("#storeValue").val().replace(/-/g, "");
                    if (checkdigitVal.length > 1) {
                        var lastDigitChar = checkdigitVal[checkdigitVal.length - 1];
                        //console.log("ตัวสุดท้าย " + lastDigitChar);
                        var lastCitizen = citizen_id[citizen_id.length - 1];
                        //console.log("ตัวสุดท้ายของเลขบัตร " + lastCitizen);
                        if (lastDigitChar != lastCitizen) {
                            //alert("เลขบัตรประชาชนไม่ถูกต้อง");
                            $("#id_no").addClass("border-danger");
                            $("#id_no").removeClass("border-success");
                        } else {
                            $("#id_no").removeClass("border-danger");
                            $("#id_no").addClass("border-success");
                        }


                    } else {
                        var lastDigitChar = checkdigitVal[checkdigitVal.length - 1];
                        //console.log("ตัวสุดท้าย " + lastDigitChar);
                        var lastCitizen = citizen_id[citizen_id.length - 1];
                        //console.log("ตัวสุดท้ายของเลขบัตร " + lastCitizen);
                        if (lastDigitChar != lastCitizen) {
                            //alert("เลขบัตรประชาชนไม่ถูกต้อง");
                            $("#id_no").addClass("border-danger");
                            $("#id_no").removeClass("border-success");
                        } else {
                            $("#id_no").removeClass("border-danger");
                            $("#id_no").addClass("border-success");
                        }
                    }
                }
            }
       });
       $("#email").focusout(function () {

            var emailinput = $("#email").val();
            // var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            if(emailinput != ''){
                
                if(!pattern.test(emailinput)){
                    // alert("dfgdfg")
                    $("#email").removeClass("border-success");
                    $("#email").addClass("border-danger");
                }
                else{
                    // alert("gg")
                    $("#email").removeClass("border-danger");
                    $("#email").addClass("border-success");
                }
            }
            else{
                $("#email").removeClass("border-success");
                $("#email").addClass("border-danger");
            }
        });
       $("input[name='first_name_en']").on("focusout", function(){
            var input = $(this).val();
            var pattern =  /^[A-Za-z]+$/i;
            if(input != ''){
                if(!pattern.test(input)){
                    $(this).addClass("border-danger");
                    $(this).removeClass("border-success");
                }
                else{
                    $(this).addClass("border-success");
                    $(this).removeClass("border-danger");
                }
            }
            else{
                $(this).addClass("border-danger");
                $(this).removeClass("border-success");
            }
        });
        $("input[name='last_name_en']").on("focusout", function(){
            var input = $(this).val();
            var pattern =  /^[A-Za-z]+$/i;
            if(input != ''){
                if(!pattern.test(input)){
                    $(this).addClass("border-danger");
                    $(this).removeClass("border-success");
                }
                else{
                    $(this).addClass("border-success");
                    $(this).removeClass("border-danger");
                }
            }
            else{
                $(this).addClass("border-danger");
                $(this).removeClass("border-success");
            }
        });
       //
        $(document).on("click" , "#create-btn" ,function() {
            $("input.select-append").each(function () {
                var elem = $(this);
                if ((elem.val() == '' || elem.val() == null)) {
                    // console.log(mandatory_field)
                    elem.removeClass("border-success");
                    elem.addClass("border-danger");
                }
                else {
                    // console.log(elem.data("spec"));
                    // console.log(elem.data("language"));
                    if(elem.data("spec") == "phone"){
                         //validate phone
                        var phone_number = elem.val().replace(/-/g, "");
                        var first = phone_number.slice(0, 1);
                        var lengthphone_number = elem.val().length;
                        if(elem.val() == ""){
                            elem.addClass("border-danger");
                            elem.removeClass("border-success");

                          }
                          else{
                            if(first != 0){
                             // alert("!=0");
                             elem.removeClass("border-success");
                             elem.addClass("border-danger");

                            }
                            else{
                              if (lengthphone_number < 12) {
                                    elem.addClass("border-danger");
                                    elem.removeClass("border-success");

                                }
                                else {
                                    elem.addClass("border-success");
                                    elem.removeClass("border-danger");
                                }
                            }

                          }
                    }
                    else if(elem.data("spec") == "citizenid"){
                        var id_no = elem.val().replace(/-/g, "");
                        var lengthid_no = elem.val().length;
                        var sec1 = id_no.slice(0, 1);
                        var sec2 = id_no.slice(1, 6);
                        var sec3 = id_no.slice(6, 10);
                        var sec4 = id_no.slice(10, 12);
                        var sec5 = id_no.slice(12, 13);
                        var id_no_sliceconvert = sec1 + '-' + sec2 + '-' + sec3 + '-' + sec4 + '-' + sec5;
                        if (id_no == "") {
                            elem.addClass("border-danger");
                            elem.removeClass("border-success");
                        } else {
                            if (lengthid_no < 17) {
                                elem.addClass("border-danger");
                                elem.removeClass("border-success");

                            } else {
                                var citizen_id = elem.val().replace(/-/g, "");
                                var summary = 0;
                                var count = parseInt(13);

                                for (var i = 0; i < (citizen_id.length - 1); i++) {
                                    if (citizen_id.substring(0, 1) == '0') {
                                        elem.addClass("border-danger");
                                        elem.removeClass("border-success");
                                        return false;
                                    } else {
                                        summary = summary + (citizen_id.substring(i, i + 1) * (count - i));
                                    }
                                }
                                var summary_result = summary;
                                var mod_sum = parseInt(summary_result) % parseInt(11);
                                var checkdigit = parseInt(11) - parseInt(mod_sum);
                                $("#storeValue").val(checkdigit);
                                var checkdigitVal = $("#storeValue").val().replace(/-/g, "");
                                if (checkdigitVal.length > 1) {
                                    var lastDigitChar = checkdigitVal[checkdigitVal.length - 1];
                                    //console.log("ตัวสุดท้าย " + lastDigitChar);
                                    var lastCitizen = citizen_id[citizen_id.length - 1];
                                    //console.log("ตัวสุดท้ายของเลขบัตร " + lastCitizen);
                                    if (lastDigitChar != lastCitizen) {
                                        //alert("เลขบัตรประชาชนไม่ถูกต้อง");
                                        elem.addClass("border-danger");
                                        elem.removeClass("border-success");
                                    } else {
                                        elem.removeClass("border-danger");
                                        elem.addClass("border-success");
                                    }


                                } else {
                                    var lastDigitChar = checkdigitVal[checkdigitVal.length - 1];
                                    //console.log("ตัวสุดท้าย " + lastDigitChar);
                                    var lastCitizen = citizen_id[citizen_id.length - 1];
                                    //console.log("ตัวสุดท้ายของเลขบัตร " + lastCitizen);
                                    if (lastDigitChar != lastCitizen) {
                                        //alert("เลขบัตรประชาชนไม่ถูกต้อง");
                                        elem.addClass("border-danger");
                                        elem.removeClass("border-success");
                                    } else {
                                        elem.removeClass("border-danger");
                                        elem.addClass("border-success");
                                    }
                                }
                            }
                        }
                    }
                    else if(elem.data("spec") == "email"){
                        // alert("email case");
                        var emailinput = elem.val();
                        // var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                        var patternemail = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                        if(emailinput != ''){
                             // alert("email case != ''");
                            if(!patternemail.test(emailinput)){
                                // alert("email case fail");
                                elem.removeClass("border-success");
                                elem.addClass("border-danger");
                            }
                            else{
                                // alert("email case success");
                                elem.removeClass("border-danger");
                                elem.addClass("border-success");
                            }
                        }
                        else{
                             // alert("email case empty");
                            elem.removeClass("border-success");
                            elem.addClass("border-danger");
                        }
                    }
                    else if(elem.data("spec") == "name"){
                        if(elem.data("language") == "isThai"){
                            var inputisThaiData = elem.val();
                            var patternisThaiData =  /^[ก-๙]+$/i;
                            if(!patternisThaiData.test(inputisThaiData)){
                                // alert("a-1")
                                elem.addClass("border-danger");
                                elem.removeClass("border-success");
                            }
                            else{
                                // alert("a-2")
                                elem.addClass("border-success");
                                elem.removeClass("border-danger");
                            }
                        }
                        else if(elem.data("language") == "isEnglish"){
                            var inputisEnglishData = elem.val();
                            var patternisEnglishData =  /^[A-Za-z]+$/i;
                            if(!patternisEnglishData.test(inputisEnglishData)){
                                // alert("c-1")
                                $(this).addClass("border-danger");
                                $(this).removeClass("border-success");
                            }
                            else{
                                // alert("c-2")
                                $(this).addClass("border-success");
                                $(this).removeClass("border-danger");
                            }
                        }
                    }
                }

            }); 
            //check status select function
            $(".check-status-function").each(function(){
                // alert($(this).val());

                //if false remove job this position
                if($(this).val() == "false"){
                    var GetDataCorp = $(this).data("corp");
                    // alert("corp name --- "  +GetDataCorp)

                    //find data block for remove
                    $(this).parents().eq(1).find(".job-flow-block").remove();
                }
            });
            //last check 
            if($("body").find(".border-danger").length == 0){
                // alert("sfsdf")
                OpenAlertModal('', '<h3 class="template-color text-center">{{__('userManagement.modal_message_1')}} </h3>' , '<p>{{__('userManagement.modal_message_2')}} ....</p>');
                $('#form-create-user').submit();
            }
            else{
                OpenAlertModal('', '<h3 class="template-color text-center">{{__('userManagement.modal_message_3')}} </h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
            }
           
        });

        $('#form-create-user').submit(function() {
            $(this).ajaxSubmit({
                error: function(data) {
                },
                success:function(data){
                    console.log(data);
                    if (data.success == true)
                    {
                        window.location.href = '{{ url("/UserManagement/Index")}}';
                    }
                    else
                    {
                        OpenAlertModal('{{__('userManagement.modal_message_4')}}', data.data, ModalCloseButtonTemplate('close', 'btn btn-danger standard-outline-danger-btn pt-2 pb-2 text-right'))
                    }
                }
            });
            return false;
        });
        
        var getPositionSelect  = "";
 
        function Type_User(data , this_data)
        {
            var temp_cur_user = document.getElementsByName('temp_type_user')[0].value;
            var cur_user_type = temp_cur_user.split(".")[0];
            if(data=='admin')
            {
                //empty append
                $("#DataGroup_list").empty();
                $("#DataTypeUser").empty();

                //
                $("#DataTypeUser").val('admin');
                $("#Admin_id").find("div.card").addClass("gradient-active");
                $("#User_id").find("div.card").removeClass("gradient-active");

                $("#DataGroup").addClass("d-none");

                $("div.main-block-highlight").children(":last-child").prev().find("hr.vertical-line-content").addClass("d-none");
                $("div.main-block-highlight").children(":last-child").attr("style" ,"display:none !important;");
                //Insert value
                $("#check_type").attr( "value" , "false");
                // alert($("#check_type").val());
                //get roles admin
                get_roles('admin' , this_data , $("#check_type").val());
                getPositionSelect = this_data;

                // $("input[name='type_user']").val("CORPORATE.ADMIN");
                document.getElementsByName('type_user')[0].value = cur_user_type+'.ADMIN';

               
                // console.log(option);
                 //rollback value in select corp
                if($("#store-option").children().length !== 0){
                    var dataVale = $("#store-option").children().attr("value");
                    var data = dataVale.split("|")[0];
                    var optionVal = dataVale.split("|")[1];
                    var option = '<option value="'+dataVale+'">'+optionVal+'</option>';
                    // alert(dataVale);
                    // alert(data);
                    // alert(optionVal);
                    if($('#AddCoporateName').children().length <= 1){

                        //clear empty option (old)
                        $('#AddCoporateName').not(":first-child").remove();
                        //append option return to select
                        $('#AddCoporateName').append(option);

                        $('#AddCoporateName option').eq(0).prop('selected', true);
                        //clear all job append when seelct user
                        $("#job_corporate").empty();
                    }
                }
                //refresh
                $('#AddCoporateName').select2('close');
            }
            else if(data=='user')
            {
                $("div.main-block-highlight").children(":last-child").prev().find("hr.vertical-line-content").removeClass("d-none");
                $("div.main-block-highlight").children(":last-child").removeAttr("style");
                $("#DataTypeUser").empty();
                $("#DataTypeUser").val('user');
                $("#Admin_id").find("div.card").removeClass("gradient-active");
                $("#User_id").find("div.card").addClass("gradient-active");

                if(cur_user_type == 'CORPORATE')
                {
                    $("#DataGroup").removeClass("d-none");
                }
                //Insert value
                $("#check_type").attr( "value" , "true");
                // alert($("#check_type").val());
                // get roles user 
                get_roles('user' , this_data , $("#check_type").val());
                getPositionSelect = this_data;

                document.getElementsByName('type_user')[0].value = cur_user_type+'.USER';
                // $("input[name='type_user']").val("CORPORATE.USER");
                $('#AddCoporateName').select2('close');
            }
        }
        //on change to select corp user in
        $("select.menu_block").on("change" , function(){
            
            var dataVal = $("#AddCoporateName").val();
            var data = dataVal.split("|")[0];
            var optionVal = dataVal.split("|")[1];
            var user_type = $("#DataTypeUser").val();

            var getCheckVal = $("#check_type").val();
            var checkSelect = true;
            if(data != '')
            {
                //start i count option select corp
                i=i+1;
                $("#Num_Coporate").empty();
                $("#Num_Coporate").val(i);

                $("#DataGroup_list").append(
                    '<li class="w-100 item" id="li_'+data+'">'+
                        '<div class="card mb-2 py-1 px-4">'+
                            '<button type="button" class="w-100 selectCorp btn btn-link" data-corp="Corporate_'+data+'">'+
                                '<div class="row">'+
                                    '<div class="col-md-12">'+
                                        '<ul class="ul-list-item text-left mb-0 py-1 list-unstyled">'+
                                            '<li class="w-100">'+
                                                '<div class="left-content d-inline-block position-relative pull-left">'+
                                                    '<div class="d-inline-block align-top py-2">'+
                                                        '<h3 class="pl-2 pt-2" style="color: #4272D7;">'+optionVal+'</h3>'+
                                                    '</div>'+
                                                    '</div>'+
                                                        '<input type="hidden" name="corporate['+i+']" value="'+data+'">'+
                                                    '<div class="right-content d-inline-block position-relative pull-right">'+
                                                    '<div class="d-inline-block position-relative">'+
                                                        '<i id="Coporate_'+data+'" value="'+dataVal+'" onClick="Remove_Coporate(this)" class="zmdi zmdi-delete pt-3" style="font-size: 30px;"></i>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</li>'+
                                        '</ul>'+
                                    '</div>'+
                                '</div>'+
                            '</button>'+
                        '</div>'+
                    '</li>'
                );
                //remove selected current value
                //remove selected current value
                $("#AddCoporateName").find("option[value='"+dataVal+"']").remove();
                //select default 
                $('#AddCoporateName option').eq(0).prop('selected', true);
                //refresh
                $('#AddCoporateName').select2('close');
                // console.log(getPositionSelect)
                //get role user
                get_roles(user_type , getPositionSelect , getCheckVal  , optionVal , checkSelect , data);
                // get job by corp id
//                get_jobs(data);
            }
        });
        function get_roles(user_type , this_data , check_value , CorpName , checkSelect , corpID)
        {
            var _userxx= '{!! Session::get('user_detail')->user_type !!}';
            // console.log(checkSelect)
            // console.log('asdasdasdsd');
            //start pace and hide append content
            Pace.on("start", function(){
                //hidden append block role
                $(".role_user").attr("style" , "visibility:hidden");
                $("#page_overlay").removeClass("d-none");
                //
                $("#AddCoporateName").prop("disabled" ,true);
                //refresh
                $('#AddCoporateName').select2('close');
            });
            //track pace ajax request
            Pace.track(function(){
                // get roles]
                $.ajax({
                    url: "{!! URL::to('UserManagement/GetRoles') !!}/",
                    method: 'POST',
                    data : {
                            _token      : "{{ csrf_token() }}",
                            user_type   : user_type
                    },
                    error: function(data) {

                    },
                    success: function(response)
                    {
                        if(response.success == true)
                        {
                            var role_user = response.data;
                            // console.log(role_user);
                            if(user_type == 'admin'){
                                
                                $("#role_user").empty();
                                $("#role_user").parents().eq(0).find("h4.corp_title").remove();
                                for (var i = 0 ; i < role_user.length ; i++) {
                                    // console.log(role_user[i].name);

                                    $("#role_user").append(                      
                                        '<li class="w-50 item px-2 roles-list" onclick="Select_Role(this)" data-role="'+role_user[i].id+'">'+
                                            '<div class="card mb-2 py-3 px-4">'+
                                                '<input type="hidden" name="" value="">'+
                                                '<h4 class="d-inline-block">'+role_user[i].name+'</h4>'+
                                            '</div>'+
                                        '</li>'
                                    );
                                } 
                                
                            }
                            else if(user_type == 'user'){
                                $("#role_user").empty();
                                $("#role_user").parents().eq(0).find("h4.corp_title").remove();
                                for (var i = 0 ; i < role_user.length ; i++) {
                                    // console.log(role_user[i].name);

                                    $("#role_user").append(                      
                                        '<li class="w-50 item px-2 roles-list" onclick="Select_Role(this)" data-role="'+role_user[i].id+'">'+
                                            '<div class="card mb-2 py-3 px-4">'+
                                                '<input type="hidden" name="" value="">'+
                                                '<h4 class="d-inline-block">'+role_user[i].name+'</h4>'+
                                            '</div>'+
                                        '</li>'
                                    );
                                }
                            }
                            //Adjust vertical line height same content height
                            // console.log(this_data)
                            //Role Height
                            // $(this_data).parents().eq(4).next().find("hr.vertical-line-content").height($(this_data).parents().eq(4).next().height());

                            //Type Line
                            $(this_data).parents().eq(4).find("hr.vertical-line-content").height($(this_data).parents().eq(4).height());
                        }
                        
                    }
                });
            });
           
            //pace progress success scrollto and show append content
            Pace.on("done", function(){
                //data prepare for show , show role
                $(".role_user").removeAttr("style");
                $("#page_overlay").addClass("d-none");
                //
                $("#AddCoporateName").prop("disabled" ,false);
                //refresh
                $('#AddCoporateName').select2('close');
            });
        }
  
        $(document).on("change" , ".check-function-type", function(){

            var getCorpTarget = $(this).data("corp");
            // alert($(this).data("corp"));

            // alert("checked " + $(this).data("corp") + " -----" + $(this).is(":checked"));


            // console.log($(this).parents().closest(".job-section"))

            // var html = $(this).parents().closest(".job-section").html();
            console.log($(this).is(":checked"))
            // $("#job_corporate").append(html)
            if($(this).is(":checked") == true){
                //alert("true")
                $(this).parents().closest("."+getCorpTarget+"-main").children().not(":first-child").removeClass("d-none");
                $(this).parents().closest("."+getCorpTarget+"-main").find("input.check-status-function").attr("value" , "true");
            }
            else if($(this).is(":checked") == false){
               // alert("false")
                $(this).parents().closest("."+getCorpTarget+"-main").children().not(":first-child").addClass("d-none");
                $(this).parents().closest("."+getCorpTarget+"-main").find("input.check-status-function").attr("value" , "false");
            }
        });

         //function resize line height
        function ResizeCircleLine(){
            //line height add height to hr same content height
            var countLength = $(".content-highlight").length;

            $(".content-highlight").each(function(index){
                var contenthighlight = $(this).height();

                $(this).find("hr.vertical-line-content").attr("style" , "height:"+contenthighlight+"px");
                // console.log(index)
                //ตัวที่ 3 ไม่ต้องมีเส้น
                if(index > 1){
                    $(this).find("hr.vertical-line-content").attr("style" , "height:0px");
                }
            });
        }
        function Remove_Coporate(elem_id)
        {
            var dataVale = $(elem_id).attr("value");
            var data = dataVale.split("|")[0];
            var optionVal = dataVale.split("|")[1];

            var TrimSpaceJobCorpName = optionVal.replace(/\s/g,"");
            
            console.log(dataVale);
            //alert(data);
            // alert(data)
            // alert(TrimSpaceJobCorpName)
            $('#li_'+data+'').remove();
            var option = '<option value="'+dataVale+'">'+optionVal+'</option>';
            // console.log(option);
            $('#AddCoporateName').append(option);

            //reset i option select corp
            i=i-1;
            $("#Num_Coporate").empty();
            $("#Num_Coporate").val(i);


            //remove Corp Job
            $('section.'+TrimSpaceJobCorpName+'-corp-block-'+data+'').remove();
            //remove Corp Roles
              //check corp select is empty (if not empty don't do anything)
            if($("#DataGroup_list").children().length == 0){
                // alert("ลบหมด")
                $('li.roles-list') .remove();
            }else{
                //  alert("ยังลบไม่ลบหมด")
            }
            
            //resize & adjust line display
            ResizeCircleLine();
        }
        //get Switch Value 
        $(document).on("click" , "input.selected-job-channel" , function(){
            var elem = $(this).attr("value");

            if($(this).is(":checked") == true){
                $(this).attr("value" , "true");
                $(this).prop("checked" , true);
                $(this).attr("checked" , "checked");
                // alert($(this).attr("value"))
            }
            else if($(this).is(":checked") == false){
                $(this).attr("value" , "false");
                $(this).prop("checked" , false);
                $(this).removeAttr("checked");
                // alert($(this).attr("value"))
            }
            
        });  
    </script>
@endsection
