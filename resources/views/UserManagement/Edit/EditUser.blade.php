@extends('layouts.master')
@section('title', 'Edit User')
@section('style')
<!-- pace-theme-loading-bar.css -->
<link href="{{ URL::asset('assets/css/extensions/pace-theme-loading-bar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/css/extensions/bootstrap-slider.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Edit User">
<div class="col-12">
    <form action="{{url('UserManagement/Create/SaveEditUser')}}" id="Form_EditUser" method="POST">
    {{ csrf_field() }}
    
        <div class="col-12">
            <div class="row mx-auto mb-4">
                <div class="col-8">
                    <div class="card">
                        <div  class="card-body px-4 pt-4 pb-0">
                            <div class="row mb-0 px-2">
                                <div class="col-6">
                                    <div class="form-group"> 
                                        <label class="template-text font-weight-bold">{{$user_info->username}}</label> 
                                        @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                                        <label class="d-block text-body font-weight-light">{{__('userManagement.citizen_id')}} : {{$user_info->citizen_id}}</label>
                                        @endif
                                        <input type="hidden" id="user_id" name="user_id" placeholder="" class="form-control select-append" value="{{$user_id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4 text-right">
                    <div class="d-flex justify-content-end">
                        <div>
                            <button id="reset_password" name="reset_password" type="button" class="btn btn-outline-primary mr-2" style="">
                                <span class="">{{__('userManagement.reset_password')}}</span>
                            </button>
                        </div>
                        <div>
                            @if($user_info->login_attempt > 2 && $user_info->status == 'INACTIVE')
                                <button id="reset_login_attempt" name="reset_login_attempt" type="button" class="btn btn-outline-secondary mr-2">
                            @else
                                <button id="reset_login_attempt" name="reset_login_attempt" type="button" class="btn btn-outline-secondary mr-2" disabled>
                            @endif

                                <span class="">{{__('userManagement.reset_login_attempt')}}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-auto mb-4">
                <div class="col-8">
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
                                                <label for="" class=" form-control-label">{{__('userManagement.name_en')}}</label><span class="text-danger">*</span>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="name_en" placeholder="" class="form-control first_1 select-append" value="{{$user_info->firstname_en}}" onkeypress = "return isEnglish(event)" data-spec="name_en" data-language="isEnglish">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.lastname_en')}}</label><span class="text-danger">*</span>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="lastname_en" placeholder="" class="form-control select-append" value="{{$user_info->surname_en}}" onkeypress = "return isEnglish(event)" data-spec="name_en" data-language="isEnglish">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.name_th')}}</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="name_th" placeholder="" class="form-control first_1 select-append" value="{{$user_info->firstname_th}}" onkeypress = "return isThai(event)" data-spec="name_th" data-language="isThai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class=" form-control-label">{{__('userManagement.lastname_th')}}</label>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="" name="lastname_th" placeholder="" class="form-control select-append" value="{{$user_info->surname_th}}" onkeypress = "return isThai(event)" data-spec="name_th" data-language="isThai">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="phone_number" class=" form-control-label">{{__('userManagement.mobile')}}</label><span class="text-danger">*</span>
                                            </div>
                                            <div class="col-12">
                                                <input type="text" id="phone_number" name="phone" placeholder="" class="form-control select-append" value="{{$user_info->telephone}}" onkeypress = "return isNumber(event)" data-language="isNumber" data-spec="phone" maxlength="13">
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
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="mb-0 py-1">
                                <span class="template-text">{{__('userManagement.select_role')}}</span>
                            </h4> 
                        </div>
                        <div  class="card-body px-4 pt-4 pb-2">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="pl-2">{{__('userManagement.select_role')}}</label>
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
        
        @include('layouts.footer_progress')
    </form>
</div>

<div class="modal fade" id="ResetPasswordConfirmModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title py-3 px-2" style="color: #4272D7;">{{__('userManagement.reset_password')}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-3">
              <div class="py-2 px-0 flex-shrink-1" style="margin-left: -5px;">
                  <h4>{{__('userManagement.reset_header')}}</h4>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="ConfirmResetPassword" class="btn btn-primary menu_block" style="height: 40px;">
                  {{__('userManagement.yes')}}
              </button>
              <button type="button" class="btn btn-secondary menu_block" data-dismiss="modal" style="height: 40px;">
                  {{__('userManagement.no')}}
              </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ResetAttemptConfirmModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title py-3 px-2" style="color: #4272D7;">{{__('userManagement.reset_login_attempt')}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-3">
              <div class="py-2 px-0 flex-shrink-1" style="margin-left: -5px;">
                  <h4>{{__('userManagement.reset_header')}}</h4>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="ConfirmResetAttempt" class="btn btn-primary menu_block" style="height: 40px;">
                  {{__('userManagement.yes')}}
              </button>
              <button type="button" class="btn btn-secondary menu_block" data-dismiss="modal" style="height: 40px;">
                  {{__('userManagement.no')}}
              </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/extensions/bootstrap-slider.min.js') }}"></script>
    <script data-pace-options='{ "startOnPageLoad": false }' src="{{ URL::asset('assets/js/extensions/pace.js') }}"></script>
    <script type="text/javascript">
        $("input[name='name_en']").on("focusout", function(){
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
        $("input[name='lastname_en']").on("focusout", function(){
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

        $("input[name='name_th']").on("focusout", function(){
            var input = $(this).val();
            var pattern =  /^[ก-๙0-9 ().,_/-]+$/i;
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
        $("input[name='lastname_th']").on("focusout", function(){
            var input = $(this).val();
            var pattern =  /^[ก-๙0-9 ().,_/-]+$/i;
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

        $(document).on("click" , '#submit_SaveEditUser' , function()
        {
            $("input.select-append").each(function () {
                var elem = $(this);
                if ((elem.val() == '' || elem.val() == null)) {
                    // console.log(mandatory_field)
                    elem.removeClass("border-success");
                    elem.addClass("border-danger");
                    console.log('Fail');
                }
                else {
                    console.log('aaaa '+elem.data("spec"));
                    console.log('bbbb '+elem.data("language"));
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

                    if(elem.data("spec") == "email"){
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
                    if(elem.data("spec") == "name_en"){
                        if(elem.data("language") == "isEnglish"){
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
                    if(elem.data("spec") == "name_th"){
                        if(elem.data("language") == "isThai"){
                            var inputisThaiData = elem.val();
                            var patternisThaiData = /^[ก-๙0-9 ().,_/-]+$/i;
                            if(!patternisThaiData.test(inputisThaiData)){
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
            //last check
            if($("body").find(".border-danger").length == 0){
                $('#Form_EditUser').submit();
            }
        });

         $('#Form_EditUser').submit(function() {
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
                          alert(data.message);
                     }
                 }
             });
             return false;
         });

        $("#AddCoporateName").select2();
        function Remove_Coporate(elem_id)
        {
            //remove Append and restore option to select
            var getValue = $(elem_id).attr("value");
            var getName = $(elem_id).attr("data-name");

            console.log($(elem_id))

            var option = '<option value="'+getValue+'">'+getName+'</option>';
            $('#AddCoporateName').append(option);

            //remove selected li
            $('#li_'+getValue+'').remove();
            //refresh
            $('#AddCoporateName').select2('close');

            //reset
            $(".item-corporate").each(function(index){
                $(this).find("input[type='hidden']").attr('name' , 'coporate['+index+']');
                $(this).find("input[type='hidden']").attr('id' , 'id_corp'+index+'');
            })
        }
        //////
        function Select_Role(data_select)
        {
            var getDataRole = $(data_select).data("role");
            var getHiddenValue = $(data_select).find("input[type='hidden']").val();
            //alert(getHiddenValue);
            if(getHiddenValue == ''){
                $(data_select).find("input[type='hidden']").attr("value" , getDataRole);
                // $(data_select).find("input[type='hidden']").attr("name" , 'Role[Role_operation]');
                $(data_select).find("div.card").addClass("gradient-active");
            }
            else{
                $(data_select).find("input[type='hidden']").attr("value" ,"");
                $(data_select).find("div.card").removeClass("gradient-active");
            }
        }
        $(document).ready(function(){

            //Call Function Custom button (Make Button)

            //CustomButton(element ,  attr  , msg , style='')
            Submitbtn = CustomButton('button' , ' id="submit_SaveEditUser" type="button"', 'Save and Change' , 'gradient-button');
            //first load footer progress
            divLevel2Content = `<div class="col-12 py-3">
                                    <div class="pull-right pr-4" style="padding-bottom: 10px;">
                                        ${Submitbtn}
                                    </div>
                                </div>`;
            //call footer
            FooterProgress( divLevel2Content );
            //
            $(".menu_block").on("click" , function()
            {
                var data = $("#AddCoporateName").val();
                var name = $("#AddCoporateName option:selected").text();
                var LengthCorporateSelected =$(".item-corporate").length;

                if(data != '')
                {
                    $("#DataGroup_list").append(
                        '<li class="w-100 item item-corporate" id="li_'+data+'">'+
                            '<div class="card mb-2 py-1 px-4">'+
                                '<a class="w-100  selectCorp" href="#" data-corp="Corporate_'+data+'">'+
                                    '<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<ul class="ul-list-item text-left mb-0 py-1 list-unstyled">'+
                                                '<li class="w-100">'+
                                                    '<div class="left-content d-inline-block position-relative pull-left">'+
                                                        '<div class="d-inline-block align-top py-2">'+
                                                            '<h3 class="pl-2 pt-2" style="color: #4272D7;">'+name+'</h3>'+
                                                        '</div>'+
                                                    '</div>'+
                                                    '<input type="hidden" id="id_corp'+LengthCorporateSelected+'" name="coporate['+LengthCorporateSelected+']" value="'+data+'" data-name="'+name+'" class="corp-name">'+
                                                    '<div class="right-content d-inline-block position-relative pull-right">'+
                                                        '<div class="d-inline-block position-relative">'+
                                                            '<i id="Coporate_'+data+'" value="'+data+'" onClick="Remove_Coporate(this)" class="zmdi zmdi-delete pt-3" style="font-size: 30px;" data-name="'+name+'" data-corp="Corporate_'+data+'"></i>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</li>'+
                                            '</ul>'+
                                        '</div>'+
                                    '</div>'+
                                '</a>'+
                            '</div>'+
                        '</li>'
                    );

                    //alert(i);
                    $("#AddCoporateName").find("option[value="+data+"]").remove();
                }
            });

            $("#select_existing").on("click" , function(){
                $("#existing_group").removeClass("d-none");
                // $("#crete_new_group").addClass("d-none");
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
            //add Corporate
            $("#add_Corporate").on("click" , function(){
                //find store value to detect position corp.
                var FindElement = $(this).next().val();
                //alert(FindElement)
                //re store value (use dynamic)
                $('#AddCorporrateModal').find(".store_hidden_value").empty();
                //append store value
                $('#AddCorporrateModal').find(".store_hidden_value").append('<input type="hidden" value="'+FindElement+'" />');

                //add if to attr
                $("#AddCorporrateModal").modal("show");

                //remove Append and restore option to select
                $(".display_select_corp").each(function(){
                    var getValue = $(this).attr("value");

                    $('#AddCoporateName option[value="'+getValue+'"]').remove();
                });
                //refresh
                $('#AddCoporateName').select2('close');

            });
            var checkEdit = false;
            $(document).on("click" ,".AddCorporateButton" , function(){
                //alert('1111');
                //find store value to detect position corp.
                // check what copr still add branch
                //var FindElement = $(this).parents().eq(1).find(".store_hidden_value > input[type='hidden']").val();
                var FindElement = $('#TotalBranch').val();

                //count li length (content curenltly append )
                var lengthContent = $("#corp_block > li").length;

                //Count Select Corp
                var lengthSelectContent = $(this).parents().eq(1).find("#DataGroup_list > li").length;
                //alert("----------- " + lengthSelectContent)
                if($("#DataGroup_list").children().length < 1){

                    alert("คุณยังไม่ได้เพิ่ม Corporate");
                }
                else{

                    //hide no corp
                    $("#no_corp_block").addClass("d-none");
                    //Get Value
                    $("#corp_block").empty();
                    $(".corp-name").each(function(index){
                        var CorpName = $(this).attr("data-name");
                        var idCorp = $(this).attr("value");
                        // alert("CorpName " + CorpName);
                        // alert("idCorp " + idCorp);
                        $("#corp_block").append(
                            '<ul class="ul-list-item-block list-unstyled list-inline py-1">'+
                                '<li class="list-inline-item">'+
                                    '<div class="d-flex justify-content-center align-items-center rounded" style="height: 50px;width: 50px;border: 2px solid #2B7EFF;">'+
                                        '<span class="" style="color: #2B7EFF;">'+(index+1)+'</span>'+
                                    '</div>'+
                                '</li>'+
                                '<li class="list-inline-item">'+
                                    '<div class="d-flex justify-content-center align-items-center">'+
                                        '<p class="font-weight-bold padding-top075rem">'+CorpName+'</p>'+
                                    '</div>'+
                                    '<div>'+
                                        '<input type="hidden" id="corp_id'+index+'" name="corporate['+index+']" value="'+idCorp+'" class="display_select_corp" />'+
                                    '</div>'+
                                '</li>'+
                            '</ul>'
                        );
                     });

                        $("#AddCorporrateModal").modal("hide");
                    }
            });
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
        });
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

        $("#reset_password").on("click" , function()
        {
            $("#ResetPasswordConfirmModal").modal("show");
        });

        $("#ConfirmResetPassword").on("click" , function()
        {
            const btn = ModalCloseButtonTemplate('Close')
            const data = {
                _token : "{{ csrf_token() }}",
                email : "{{$user_info->email}}"
            }
            if (data.email === '' || data.email === null) {
                $('#ResetPasswordConfirmModal').modal('hide');
                OpenAlertModal(GetModalHeader('Error'), '{{__('userManagement.not_process')}}', `<div class="text-center">${btn}</div>`)
                return
            }
            $.ajax({
                type:'POST',
                url: "{!! URL::to('/UserManagement/ResetPassword') !!}",
                data,
                error: function(data) {
                    $('#ResetPasswordConfirmModal').modal('hide');
                    OpenAlertModal(GetModalHeader('Error'), '{{__('userManagement.not_process')}}', `<div class="text-center">${btn}</div>`);
                },
                success: function(data)
                {
                    OpenAlertModal('<p>Email reset password has been send</p>', '{{__('userManagement.reset_form_message')}}', `<div class="text-center">${btn}</div>`);
                    $('#ResetPasswordConfirmModal').modal('toggle');
                }
            });
        });

        $("#reset_login_attempt").on("click" , function()
        {
            $("#ResetAttemptConfirmModal").modal("show");
        });

        $("#ConfirmResetAttempt").on("click" , function()
        {
          const btn = ModalCloseButtonTemplate('Close')
          $.ajax({
              type:'POST',
              url: "{!! URL::to('UserManagement/Update/ChangeStatus') !!}",
              data:{
                  _token : "{{ csrf_token() }}",
                  user_id : "{{$user_id}}"
              },
              error: function(data) {
                  OpenAlertModal(GetModalHeader('Error'), '{{__('userManagement.not_process')}}', `<div class="text-center">${btn}</div>`);
              },
              success: function(data)
              {
                  // OpenAlertModal('<p>Reset login attempt successfully</p>', 'ทำการ Reset จำนวนครั้งการ Login เรียบร้อยแล้ว', `<div class="text-center">${btn}</div>`);
                  $('#ResetAttemptConfirmModal').modal('toggle');
                  location.reload();
              }
          });
        });
    </script>
@endsection
