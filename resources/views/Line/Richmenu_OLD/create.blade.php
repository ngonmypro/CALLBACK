@extends('layouts.master')
@section('title', 'Create Rich Menu')
@section('style')
<link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
<style type="text/css">
    .lock-zmdi-icon{
        -moz-transform: rotate(-35deg);
        -webkit-transform: rotate(-35deg);
        -o-transform: rotate(-35deg);
        -ms-transform: rotate(-35deg);
        transform: rotate(-35deg);
        color: #DEDEDE;
        font-size: 35px;
    }
    .image-contain{
        object-fit: contain;
    }
    .image-cover{
        object-fit: cover;
    }
    .container-type{
        cursor: pointer;
    }
    .container-type{
       border:1px solid transparent; 
    }
    .container-type.selected{
        background-color:rgba(179, 211, 249 , 0.5);
        border:1px solid #7388F6;
    }
    .container-type.selected img{
        opacity: 0.5;
    }
    .container-type.unselected{
        background-color:transparent;
        border:1px solid transparent;
    }
    .container-type.unselected img{
        opacity: 1;
    }
    .box-container{
        border:1px solid #7388F6;
        background: #DAE7F7;
    }
    .template-container{
        width: 383px;
    }
    .modal-xl{
        max-width: 950px;
    }
    [data-toggle]{
        cursor: pointer;
    }
    .dropzone .dz-preview .dz-image > img {
      max-width: 100% !important; 
      max-height: 100% !important; 
    }
    .dropzone .dz-preview .dz-image{
        border-radius:0;
        width: 100%;
        height: 100%;
    }
    .dropzone .dz-preview .dz-remove{
        color: #fff;
        font-size: 14px;
        line-height: 1.5;
        border-radius: .3rem;
    }
</style>
@endsection
@section('content')
<input type="hidden" name="breadcrumb-title" value="Create Rich Menu">
<form action="{{ url('Line/Richmenu/Richmenu/Create')}}" method="post" enctype="multipart/form-data" id="form-create-richmenu">
    {{ csrf_field() }}
    <div class="d-flex flex-wrap mb-3">
        <div class="p-2 flex-fill w-50">
            <div class="">
                <h4 class="mb-3 py-3 card-header-with-border">
                    Rich Menu Setting
                    <div class="float-right">
                        <button id="create-richmenu" type="button" class="btn btn-primary text-uppercase">Create</button>
                    </div>
                </h4>
            </div>
        </div>
        
    </div>
    <div class="col-12 border-bottom">
        <div class="flex-wrap">
            <div class="form-group"> 
                 <div class="row mx-auto">
                    <div class="col-12">
                        <p class="pb-3">Menu Setting</p>
                    </div>
                </div>
                <div class="row mx-auto">
                    <div class="col-12">
                        <div class="card mx-auto w-75 mb-5 pb-5">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="col-12">
                                        <p class="pb-3 template-text">Setting Name</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <label class="mb-0 text-black-50">Richmenu Name</label>
                                        <input id="richmenu-name" name="richmenu_name" type="" maxlength="30" class="form-control input-with-underline" data-required="required" data-type="richmenu">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-12">
                                        <label class="mb-0 text-black-50">Chatbar Name</label>
                                        <input id="chatbar-name" name="chatbar_name" type="" maxlength="14" class="form-control input-with-underline" data-required="required" data-type="chatbar">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 pt-5">
        <div id="main-wrapper-action" class="d-flex">
            <div class="flex-shrink-1">
                <p class="mb-0 pb-3">Menu Content</p>
                <div id="template-wrapper" class="template-container border position-relative" style="height:257px;">
                    <div class="d-flex flex-column" style="zoom:15.2%">

                        <div id="template-container" class="row mx-auto row-section-1" style="position:absolute; width: 100%; height: auto;">
                            <!-- large -->
                            <!-- Grid 6 * 6 -->
                            <!-- <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                <div class="d-flex justify-content-center align-items-center h-100">
                                     <p class="mt-4" style="transform: scale(10);">A</p>
                                </div>
                            </div> -->
                            <!-- Grid 2 * 2 -->
                            <!-- <div class="box-container" style="width: 1250px;height:842px;">
                        
                            </div>
                            <div class="box-container" style="width: 1250px;height:842px;">
                                
                            </div>
                            <div class="box-container" style="width: 1250px;height:842px;">
                            
                            </div>
                            <div class="box-container" style="width: 1250px;height:842px;">
                        
                            </div> -->
                            <!-- Grid 1 * 3 -->
                            <!-- <div class="box-container" style="width: 2500px;height:842px;">
                        
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                            
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                        
                            </div> -->
                            <!-- Grid 1/2 large * 2 -->
                            <!-- <div class="d-inline-block">
                                <div class="box-container" style="width: 1665px;height:1686px;">
                        
                                </div>
                            </div>
                            <div class="d-inline-block">
                                <div class="box-container" style="width: 833px;height:842px;">
                            
                                </div>
                                <div class="box-container" style="width: 833px;height:842px;">
                            
                                </div>
                            </div> -->
                            <!-- Grid 1*1 horizontal-->
                            <!-- <div class="box-container" style="width: 2500px;height:842px;">
                        
                            </div>
                            <div class="box-container" style="width: 2500px;height:842px;">
                        
                            </div> -->
                            <!-- Grid 1*1 vertical-->
                            <!-- <div class="box-container" style="width: 1250px;height:1686px">
                        
                            </div>
                            <div class="box-container" style="width: 1250px;height:1686px">
                        
                            </div> -->
                            <!-- Grid full-->
                            <!-- <div class="box-container" style="width: 2500px;height:1686px">
                            </div> -->
                            <!-- end of large -->
                            <!-- compact -->
                            <!-- Grid 3 -->
                            <!-- <div class="box-container" style="width: 833px;height:842px;">
                        
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                                
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                            
                            </div> -->
                            <!-- Grid 2 1/2 -01 -->
                            <!-- <div class="box-container" style="width: 833px;height:842px;">
                        
                            </div>
                            <div class="box-container" style="width: 1666px;height:842px;">
                                
                            </div> -->
                            <!-- Grid 2 1/2 -01 -->
                            <!-- <div class="box-container" style="width: 1666px;height:842px;">
                                
                            </div>
                            <div class="box-container" style="width: 833px;height:842px;">
                        
                            </div> -->
                            <!-- Grid 1/2 -->
                            <!-- <div class="box-container" style="width: 1250px;height:842px;">
                                
                            </div>
                            <div class="box-container" style="width: 1250px;height:842px;">
                        
                            </div> -->
                            <!-- Grid full -->
                            <!-- <div class="box-container" style="width: 2500px;height:842px;">
                                
                            </div> -->
                            <!-- end of compact -->
                        </div>
                    </div>
                    
                    <div id="template-background" class="d-flex justify-content-center align-items-center h-100">
                      <!--   <img src="{{ URL::asset('assets/images/1200x405.png') }}" class="card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="405"> -->
                       <!--  <img src="{{ URL::asset('assets/images/1200x810.png') }}" class="card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810"> -->
                        <small class="text-muted">Upload Background Image</small>
                    </div>
                    
                </div>
                <div class="template-container mt-3">
                    <div>
                        <button type="button" class="btn btn-primary btn-lg btn-block template-text border-0 mb-3" style="background-color: #DFEBF9;" onclick="SelectTemplate()">Select Template</button>
                    </div>
                    <div>
                        <button id="upload_button" type="button" class="btn btn-primary btn-lg btn-block mb-3" onclick="UploadImage()" style="background-color: #4B66EB;" disabled>Upload Image</button>
                    </div>
                </div>
            </div>
            <!-- <div class="col">
                <p class="mb-0 pb-3 mt-5">Action</p>
                <div class="d-flex flex-column">
                    <div class="card mb-2">
                        <div class="card-header" id="action-a" data-toggle="collapse" data-target="#collapse-action-a" aria-expanded="true" aria-controls="collapse-action-a">
                            <ul class="list-unstyled list-inline mb-0">
                                <li class="list-inline-item template-text">
                                    A
                                </li>
                                <li class="list-inline-item template-text">
                                    <i class="zmdi zmdi-caret-down"></i>
                                </li>
                            </ul>
                        </div>
                        <div id="collapse-action-a" class="collapse" aria-labelledby="action-a">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Action Type</label>
                                    <div class="col-sm-9">
                                      <select class="form-control">
                                          <option disabled selected>--- Select Type ---</option>
                                          <option value="message">Text</option>
                                          <option value="uri">Url</option>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right"></label>
                                    <div class="col-sm-9">
                                       <input id="uri-action-a" type="text" class="form-control" name="" placeholder="Enter URL">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right"></label>
                                    <div class="col-sm-9">
                                      <textarea id="message-action-a" class="form-control" rows="4" cols="50" placeholder="Enter description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> -->
        </div>
    </div>
   <!--  <div class="col-12">
        <button id="create-richmenu" type="button" class="btn btn-primary btn-lg btn-block mb-3">Test Get Value</button>
    </div> -->
    <input type="hidden" name="template_number" />
</form>
<div id="select_template_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div id="select_template_header" class="modal-header border-0">

            </div>
            <div id="select_template_body" class="modal-body py-5">
                <div class="col-12">
                    <h2 class="mb-3" style="color: #C7C7C7;">SELECT TEMPLATE</h2>
                </div>
                <div class="col-12">
                    <label class="font-weight-bold text-capitalize">large</label>
                </div>
                <div class="col-12 template-selected-container-large">
                    <div class="row pl-3 mb-3">
                        <div class="d-flex flex-wrap">
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="0" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_01.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="1" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_02.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="2" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_03.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="3"data-guide="inline-block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_04.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div> 
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="4" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_05.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="5" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_06.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="6" data-guide="block" data-style="large">
                                <img src="{{ URL::asset('assets/images/template/t_07.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12">
                    <label class="font-weight-bold text-capitalize">compact</label>
                </div>
                <div class="col-12 template-selected-container-compact">
                    <div class="row pl-3 mb-3">
                        <div class="d-flex flex-wrap">
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="7" data-guide="block" data-style="compact">
                                <img src="{{ URL::asset('assets/images/template/t_08.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="8" data-guide="block" data-style="compact">
                                <img src="{{ URL::asset('assets/images/template/t_09.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="9" data-guide="block" data-style="compact">
                                <img src="{{ URL::asset('assets/images/template/t_10.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="10" data-guide="block" data-style="compact">
                                <img src="{{ URL::asset('assets/images/template/t_11.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div> 
                            <div class="px-2 container-type unselected" onclick="SelectContainerType(this)" data-template="11" data-guide="block" data-style="compact"> 
                                <img src="{{ URL::asset('assets/images/template/t_12.png') }}" class="card-img image-contain" alt="..." style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="select_template_footer" class="modal-footer justify-content-center border-0">
                <button id="select_template_button" type="button" class="btn btn-primary" style="background-color: #4B66EB;">Confirm</button>
            </div>
        </div>
    </div>
</div>
<div id="upload_image_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div id="upload_image_header" class="modal-header">

            </div>
            <div id="upload_image_body" class="modal-body">
                <div class="col-12">
                    <h2 class="mb-3" style="color: #C7C7C7;">FILE IMAGE</h2>
                </div>
                <div class="col-12 upload-zone mb-5" style="cursor: pointer;">
                    <div class="dropzone custom-dropzone" id="dropzoneForm">
                      <div class="dz-message needsclick">    
                            <div class="row">
                                <div class="col-12">
                                    <div class="center border_excel d-inline-block" align="center">
                                        <i class="zmdi zmdi-attachment lock-zmdi-icon"></i>
                                        <p class="text-left align-middle d-inline-block pl-4 description-text">
                                            <span class="font-weight-bold template-text">Add image</span> 
                                            <span class="text-black-50">or drop here</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <p class="text-black-50 mb-0">file format : JPEG , PNG</p>
                    <p class="text-black-50 mb-0">file size : Up to 1MB</p>
                    <p class="text-black-50 mb-0">Image size : ขนาด 1200×810 และ 1200×405</p>
                    <p class="text-black-50 mb-0">*** หากรูปความละเอียดสูงมากจะไม่สามารถใช้ได้</p>
                </div>
            </div>
            <div id="upload_image_footer" class="modal-footer justify-content-center border-0">
                <button id="upload_image_button" type="button" class="btn btn-primary" style="background-color: #4B66EB;">Upload</button>
            </div>
        </div>
    </div>
</div>
<div id="on_process_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div id="" class="modal-body">
                <h3 class="template-color text-center">ระบบกำลังสร้าง </h3>
            </div>
            <div id="" class="modal-footer justify-content-center border-0">
                <p>กรูณารอสักครู่ ....</p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/input-validation.js') }}"></script>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script> <!-- script line LIFF-->
<!-- Dropzone drag & move upload file -->
<script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
<script type="text/javascript">
 //large
 //base width 2500
 //base height 1686
 //compact 
 //base width 2500
 //base height 843
   
    // var richmenu_name = "";
    // var chatbar_name = "";
    // var sizeMenu = "";

    var sendData = {
        richmenu_name: "",
        chatbar_name: "",
        size:"",
        x: [],
        y: [],
        width:[],
        height:[],
        action:[],
        text_action:[],
        upload_image:{},
        template_number:""
    };
    // sendData.richmenu_name = "123"
    //object 
    var templateData = {};
    // var actionData = {};
    // var text_actionData = {};
    
    var uploadImage = [];
    

    var largeWrapper = "259.17";
    var compactWrapper = "130.58";
    var dataGuide = "";
    var dataWrapperStyle = "";
    var dataTemplateNumber = "";
    function UploadImage(){
        $("#upload_image_modal").modal("show");
    }
    function SelectTemplate(){
        $("#select_template_modal").modal("show");
    }
    function SelectContainerType(elem){
        //clear data
        templateData = "";
        dataGuide = "";
        dataWrapperStyle = "";
        //check grid select
        var getDataTemplate = $(elem).data("template");
        var getDataGuide = $(elem).data("guide");
        var getDataWarpperStyle = $(elem).data("style");
        //get template name same index data json
        
        $.ajax({
            type: 'GET',
            url: '{{ URL::asset('assets/json/template.json') }}',
            dataType: 'json',
            data:{
                _token : "{{ csrf_token() }}"
            },
            success: function(json) {
                // console.log("--------- json -------------");
                // console.log(json[getDataTemplate]);
                templateData = json[getDataTemplate];
                dataGuide = getDataGuide;
                dataWrapperStyle = getDataWarpperStyle;
                //insert data for send
                sendData.size = getDataWarpperStyle;
                sendData.x = templateData.x;
                sendData.y = templateData.y;
                sendData.width = templateData.width;
                sendData.height = templateData.height;
                sendData.template_number = getDataTemplate;
                dataTemplateNumber = getDataTemplate;
            },
            error: function(e) {
                console.log(e.message);
            }
        });
       
        
    }
    //Dropzone Configuration
Dropzone.autoDiscover = false;

$(document).ready(function(){
    //get richmenu name
    $(document).on("focusout" , "#richmenu-name" ,function(){
        const ValidField = InputValidation([
            {
                elem: $(this),
                data: $(this).val(),
                rule: ['REQUIRED','LENGTH_LESS_THAN_MAX'],
                option: {
                    maxlength: $(this).attr("maxlength") || '',
                }
            }
        ])

        if(ValidField == true){
            sendData.richmenu_name = $(this).val();
        }
        else if(ValidField == false){
            if($(this).val() == '' || $(this).val() == null){
                OpenAlertModal('', '<h3 class="template-color text-center">กรุณาระบุข้อมูล</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
            else{
                OpenAlertModal('', '<h3 class="template-color text-center">ข้อมูลความยาวต้องไม่เกิน 30 ตัวอักษร</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
           
        }
        
        // console.log("--- input event  ----");
        // console.log(richmenu_name);
    });
    //get chatbar name
    $(document).on("focusout" , "#chatbar-name" ,function(){
       
        // console.log("--- input event  ----");
        // console.log(richmenu_name);
        const ValidField = InputValidation([
            {
                elem: $(this),
                data: $(this).val(),
                rule: ['REQUIRED','LENGTH_LESS_THAN_MAX'],
                option: {
                    maxlength: $(this).attr("maxlength") || '',
                }
            }
        ])
        if(ValidField == true){
             sendData.chatbar_name = $(this).val();
        }
        else if(ValidField == false){
            if($(this).val() == '' || $(this).val() == null){
                OpenAlertModal('', '<h3 class="template-color text-center">กรุณาระบุข้อมูล</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
            else{
                OpenAlertModal('', '<h3 class="template-color text-center">ข้อมูลความยาวต้องไม่เกิน 14 ตัวอักษร</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
            
        }
    });

    //get x y (review)
    $(document).on("click" , ".box-container" , function(){
        var x = $('#template-container').find($(this)).position().left;
        var y = $('#template-container').find($(this)).position().top;
        // console.log('x: ' + x + ' y: ' + y);
    });
    //active select container type
     $(document).on("click", ".container-type" , function(){
        $(this).toggleClass("unselected selected");
        $(".container-type").not($(this)).removeClass("selected").addClass("unselected");
     });
    //
    
    var myDropzone = new Dropzone("#dropzoneForm", {
        url: "/file/post",
            method: 'POST',
            maxFiles: 1,
            maxFilesize: 1,
            maxThumbnailFilesize: 1,
            clickable: '.upload-zone',
            acceptedFiles: 'image/jpeg,image/png,image/jpg', //allowed filetypes
            thumbnailWidth: null,
            thumbnailHeight: null,
            addRemoveLinks: true,
            dictRemoveFile : "<button type='button' class='btn btn-danger btn-lg btn-block'>Delete Image</button>",
        });
    myDropzone.on('uploadprogress', function(file, progress) {
        console.log("File progress", progress);
    });
     myDropzone.on('addedfile', function(file, progress) {
        if (myDropzone.files.length > 1) {
           myDropzone.removeFile(this.files[0]);
        }
    });
    myDropzone.on('thumbnail', function(file, dataUri) {
        /* Maybe display some more file information on your page */
            // console.log(file.height);
            // console.log(file.width);
            // console.log(dataWrapperStyle)
            if(dataWrapperStyle == "large"){
                if (file.height !== 810 || file.width  !== 1200) {
                    alert("Image ratio not compatible.");
                    myDropzone.removeFile(file);
                }
                else{
                //    console.log("---------------")
                //     console.log(file);
                    //remove old image
                    if(uploadImage.length !== 0){
                       for(var i=uploadImage.length; i>0;i--){
                            uploadImage.pop(dataUri ,file.height,file.width)
                        } 
                    }
                    
                    
                    uploadImage.push(dataUri ,file.height,file.width); 
                    sendData.upload_image = dataUri;
                    
                }
            }
            else if(dataWrapperStyle == "compact"){
                if (file.height !== 405 || file.width  !== 1200) {
                    alert("Image ratio not compatible.");
                    myDropzone.removeFile(file);
                }
                else{
                //    console.log("---------------")
                //     console.log(file);
                //remove old image
                    if(uploadImage.length !== 0){
                       for(var i=uploadImage.length; i>0;i--){
                            uploadImage.pop(dataUri ,file.height,file.width)
                        } 
                    }

                    uploadImage.push(dataUri ,file.height,file.width); 
                    sendData.upload_image = dataUri;
                    
                }
            }
            
    });
    //get text_action
    $(document).on("focusout" , ".text_action-data" , function(){

        if($(this).data("type") == "uri"){
            const ValidField = InputValidation([
                {
                    elem: $(this),
                    data: $(this).val(),
                    rule: ['REQUIRED' ,'LINE_URL']
                }
            ])
            if(ValidField == true){
                sendData.text_action [$(this).closest(".card").index()] = $(this).val();
            }
            else if(ValidField == false){
                OpenAlertModal('', '<h3 class="template-color text-center">ข้อมูลไม่ถูกต้องตาม URL Format <br />ต้องขึ้นต้นด้วย line://app/ หรือ http:// หรือ https:// เท่านั้น</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
        }
        else if($(this).data("type") == "message"){
            const ValidField = InputValidation([
                {
                    elem: $(this),
                    data: $(this).val(),
                    rule: ['REQUIRED']
                }
            ])
            if(ValidField == true){
                 sendData.text_action [$(this).closest(".card").index()] = $(this).val();
            }
            else if(ValidField == false){
                OpenAlertModal('', '<h3 class="template-color text-center">กรุณาระบุข้อมูล</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>')
            }
        }
        // sendData.text_action [$(this).closest(".card").index()] = $(this).val();
    });
    //append action type
    $(document).on("change" , ".select-action-type" , function(){
        // console.log($(this).closest(".card-body"))
        var getDataAction = $(this).data("action");
        //remove append
        $(this).closest(".card-body").find(".append-section").remove();

        if($(this).val() == "message"){
            $(this).closest(".card-body").append(
                '<div class="form-group row append-section">'+
                    '<label class="col-sm-3 col-form-label text-right"></label>'+
                    '<div class="col-sm-9">'+
                        '<textarea id="message-action-'+getDataAction+'" name="action_text[]" class="form-control text_action-data" rows="4" cols="50" placeholder="Enter description" data-type="message" data-required="required"></textarea>'+
                    '</div>'+
                '</div>'
            );
        }
        else if($(this).val() == "uri"){
            $(this).closest(".card-body").append(
                '<div class="form-group row append-section">'+
                    '<label class="col-sm-3 col-form-label text-right"></label>'+
                    '<div class="col-sm-9">'+
                        '<input id="uri-action-'+getDataAction+'" type="text" class="form-control text_action-data" name="action_text[]" placeholder="Enter URL" data-type="uri" data-required="required">'+
                    '</div>'+
                '</div>'
            );
        }
        //set data
        sendData.action  [$(this).closest(".card").index()] = $(this).val(); 
    });
    function ActionAppend(alphabet){
        // alert(alphabet)
        
        $("#action-wrapper").append(
            '<div class="card mb-2">'+
                '<div class="card-header" id="action-'+alphabet+'" data-toggle="collapse" data-target="#collapse-action-'+alphabet+'" aria-expanded="true" aria-controls="collapse-action-'+alphabet+'">'+
                    '<ul class="list-unstyled list-inline mb-0">'+
                        '<li class="list-inline-item template-text text-uppercase">'+
                            alphabet+
                        '</li>'+
                        '<li class="list-inline-item template-text">'+
                            '<i class="zmdi zmdi-caret-down"></i>'+
                        '</li>'+
                    '</ul>'+
                '</div>'+
                '<div id="collapse-action-'+alphabet+'" class="collapse" aria-labelledby="action-'+alphabet+'">'+
                    '<div class="card-body">'+
                        '<div class="form-group row">'+
                            '<label class="col-sm-3 col-form-label text-right">Action Type</label>'+
                            '<div class="col-sm-9">'+
                                '<select id="select-action-'+alphabet+'" class="form-control select-action-type" data-action="'+alphabet+'" name="action[]" data-required="required">'+
                                    '<option disabled selected>--- Select Type ---</option>'+
                                    '<option value="message">Text</option>'+
                                    '<option value="uri">Url</option>'+
                                '</select>'+
                            '</div>'+
                        '</div>'+ 
                    '</div>'+
                '</div>'+
            '</div>'
        );
    }
    function AlphabetRunning(i){
        var a = 97;
        var charArray = {};
        //remove append first
        $("#main-wrapper-action").find(".action-main-wrapper").remove();
        //append action block
        $("#main-wrapper-action").append(
            '<div class="w-100 ml-5 action-main-wrapper">'+
                '<p class="mb-0 pb-3 mt-5">Action</p>'+
                '<div id="action-wrapper" class="d-flex flex-column">'+
                    
                '</div>'+
            '</div>'
        );

        if(dataTemplateNumber == "3" && dataGuide == "inline-block"){
            for (var char = 0; char<i; char++){
                if(char == 0){
                    // console.log("--- count char 0---")
                    // console.log(char)
                    $("#template-container").find("#grid-section-1").children().eq(char).append(
                        '<div class="d-flex justify-content-center align-items-center h-100">'+
                            '<p class="mt-4 text-uppercase template-text" style="transform: scale(10);">'+
                             String.fromCharCode(a + char)+
                             '</p>'+
                        '</div>'
                    );
                }
                else{
                    // console.log("--- count char > 0---")
                    // console.log(char)
                    $("#template-container").find("#grid-section-2").children(":nth-child("+char+")").append(
                        '<div class="d-flex justify-content-center align-items-center h-100">'+
                            '<p class="mt-4 text-uppercase template-text" style="transform: scale(10);">'+
                             String.fromCharCode(a + char)+
                             '</p>'+
                        '</div>'
                    );
                }
                //append action
                ActionAppend(String.fromCharCode(a + char));
            }
        }
        else{
            for (var char = 0; char<i; char++){
                $("#template-container").children().eq(char).append(
                    '<div class="d-flex justify-content-center align-items-center h-100">'+
                        '<p class="mt-4 text-uppercase template-text" style="transform: scale(10);">'+
                         String.fromCharCode(a + char)+
                         '</p>'+
                    '</div>'
                );
                //append action
                ActionAppend(String.fromCharCode(a + char));
            }
        }
        

    }
    var getImageHeight = "";
    //select template select_template_button
    $(document).on("click" , "#select_template_button" ,function(){

        // console.log(getTemplateSelect.x)
        //check img length (when change template)
        if($("#template-background").find("img").length !== 0){
            //
        }
        else{
            $("#template-background").empty();
        }
        $("#template-container").empty();
        $("#template-wrapper").find(".store_template_value").remove();

        // console.log(templateData.length)
        //check style guide
        if (dataGuide == "inline-block"){
            $("#template-container").append(
                 '<div id="grid-section-1">'+
                 '</div>'+
                 '<div id="grid-section-2">'+
                 '</div>'
            );
        }
        var i = 0;
        for (var key in templateData.width) {
            if(dataGuide == "block"){
                $("#template-container").append(
                    '<div class="box-container" style="width: '+templateData.width[i]+'px;height:'+templateData.height[i]+'px;" data-x="'+templateData.x[i]+'" data-y="'+templateData.y[i]+'" data-width="'+templateData.width[i]+'" data-height="'+templateData.height[i]+'"></div>'
                );
                $("#template-wrapper").append(
                    '<div class="store_template_value">'+
                    '<input type="hidden" name="width[]" value="'+templateData.width[i]+'" />'+
                    '<input type="hidden" name="height[]" value="'+templateData.height[i]+'" />'+
                    '<input type="hidden" name="x[]" value="'+templateData.x[i]+'" />'+
                    '<input type="hidden" name="y[]" value="'+templateData.y[i]+'" />'+
                    '</div>'
                );
            }
            else if (dataGuide == "inline-block"){
                if(i == 0){
                    $("#grid-section-1").append(
                        '<div class="box-container" style="width: '+templateData.width[i]+'px;height:'+templateData.height[i]+'px;" data-x="'+templateData.x[i]+'" data-y="'+templateData.y[i]+'" data-width="'+templateData.width[i]+'" data-height="'+templateData.height[i]+'"></div>'
                    );
                }
                else{
                    $("#grid-section-2").append(
                        '<div class="box-container" style="width: '+templateData.width[i]+'px;height:'+templateData.height[i]+'px;" data-x="'+templateData.x[i]+'" data-y="'+templateData.y[i]+'" data-width="'+templateData.width[i]+'" data-height="'+templateData.height[i]+'"></div>'
                    );
                }
                $("#template-wrapper").append(
                    '<div class="store_template_value">'+
                    '<input type="hidden" name="width[]" value="'+templateData.width[i]+'" />'+
                    '<input type="hidden" name="height[]" value="'+templateData.height[i]+'" />'+
                    '<input type="hidden" name="x[]" value="'+templateData.x[i]+'" />'+
                    '<input type="hidden" name="y[]" value="'+templateData.y[i]+'" />'+
                    '</div>'
                );
                
            }
            
            i++;
        }
        //check template type
        if(dataWrapperStyle == "large"){
            $("#template-wrapper").attr("style" , "height:"+largeWrapper+"px");
        }
        else if(dataWrapperStyle == "compact"){
            $("#template-wrapper").attr("style" , "height:"+compactWrapper+"px");
             
        }
        //running alphabet
        AlphabetRunning(i);
        //unlock upload image
        if($("#template-container").children().length !== 0){
            $("#upload_button").prop("disabled" , false);
        }
        else{
            $("#upload_button").prop("disabled" , true);
        }
        //height
        getImageHeight = $("#template-background").height();
        //close modal
        $("#select_template_modal").modal("hide");


    });
    //preview background
    $(document).on("click" , "#upload_image_button" ,function(){
        // console.log(uploadImage)
        $("#template-background").empty();
        // $("#template-container").empty();
        $("#template-container").children().addClass("bg-transparent");
        
        console.log("----- check img source -----");
        console.log(uploadImage)
        //
        // $("#template-background").attr("style" , "background-image: url("+uploadImage[0]+"); background-size: contain;background-repeat: no-repeat;max-width: 100%;max-height: 100%;height:"+getImageHeight+" !important;")
        $("#template-background").append(
            '<img src="'+uploadImage[0]+'" class="card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;opacity:0.2;" width="'+uploadImage[2]+'" height="'+uploadImage[1]+'"/>'+
            '<input type="hidden" name="size" value="'+dataWrapperStyle+'"/>'+
            '<input type="hidden" name="upload_image" value="'+sendData.upload_image+'"/>'
        );
        $(".template-container").attr("style" , "height:auto;");
        
        $("#upload_image_modal").modal("hide");

    });

    //select2
    $("select").select2();

    //create
    $(document).on("click" , "#create-richmenu" , function(){
        //get data  
        //1.richmenu name , 2. chatbar name ,3. size , 4.x (object) ,5.y (object)
        //6.width (object) , 7.height (object) , 8.action (object) , 9.text_action (object) ,10.upload_image (object)
        // console.log("--- later ---");
        // console.log(JSON.stringify(sendData));
        $("input[name='template_number']").attr("value" , sendData.template_number);
        // alert(sendData.template_number);
        //Check senddata value not empty
        console.log("----- heck senddata value not empty ----------")
        console.log("richmenu_name " + sendData.richmenu_name)
        console.log("chatbar_name " + sendData.chatbar_name)
        console.log("size " + sendData.size)
        console.log("x " + jQuery.isEmptyObject(sendData.x))
        console.log("y " + jQuery.isEmptyObject(sendData.y))
        console.log("width " + jQuery.isEmptyObject(sendData.width))
        console.log("height " + jQuery.isEmptyObject(sendData.height))
        console.log("action " + jQuery.isEmptyObject(sendData.action))
        console.log("text_action " + jQuery.isEmptyObject(sendData.text_action))
        console.log("upload_image " + jQuery.isEmptyObject(sendData.upload_image))
        console.log("sendData.template_number " + sendData.template_number);
        console.log("----- end senddata value not empty ----------")
        console.log("----- start get value in send data ----------")
        console.log(sendData.richmenu_name)
        console.log(sendData.chatbar_name)
        console.log(sendData.size)
        console.log(sendData.x)
        console.log(sendData.y)
        console.log(sendData.width)
        console.log(sendData.height)
        console.log(sendData.action)
        console.log(sendData.text_action)
        console.log(sendData.upload_image)
        console.log(sendData.template_number);
        console.log("-----end  get value in send data ----------")

        if(sendData.richmenu_name == "" ||
            sendData.chatbar_name == "" ||
            sendData.size == "" ||
            jQuery.isEmptyObject(sendData.x) == true ||
            jQuery.isEmptyObject(sendData.y) == true ||
            jQuery.isEmptyObject(sendData.width) == true ||
            jQuery.isEmptyObject(sendData.height) == true ||
            jQuery.isEmptyObject(sendData.action) == true ||
            jQuery.isEmptyObject(sendData.text_action) == true ||
            jQuery.isEmptyObject(sendData.upload_image) == true ||
            (parseInt(sendData.template_number) == NaN)){
            //show modal
            console.log("template_number  เป็นค่าว่าง")
            OpenAlertModal('', '<h3 class="template-color text-center">ข้อมูลสำหรับสร้าง Rich Menu ไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
            //validate
            $("[data-required='required']").each(function () {
                console.log($(this))
                console.log($(this).closest(".collapse"))
                var elem = $(this);
                if ((elem.val() == '' || elem.val() == null || elem.val() == undefined)) {
                    // console.log(mandatory_field)
                    elem.removeClass("is-valid");
                    elem.addClass("is-invalid");
                    elem.parents().eq(3).addClass("show");
                }
                else { 
                    console.log("checked + " + $(this).data("type"))
                    switch ($(this).data("type") || '') {
                        case 'richmenu':
                            InputValidation([
                                {
                                    elem: $(this),
                                    data: $(this).val(),
                                    rule: ['REQUIRED','LENGTH_LESS_THAN_MAX'],
                                    option: {
                                        maxlength: $(this).attr("maxlength") || '',
                                    }
                                }
                            ])
                        break;
                        case 'chatbar':
                            InputValidation([
                                {
                                    elem: $(this),
                                    data: $(this).val(),
                                    rule: ['REQUIRED','LENGTH_LESS_THAN_MAX'],
                                    option: {
                                        maxlength: $(this).attr("maxlength") || '',
                                    }
                                }
                            ])
                        break;
                        case 'message':
                            InputValidation([
                                {
                                    elem: $(this),
                                    data: $(this).val(),
                                    rule: ['REQUIRED']
                                }
                            ])
                        break;
                        case 'uri':
                            InputValidation([
                                {
                                    elem: $(this),
                                    data: $(this).val(),
                                    rule: ['REQUIRED','LINE_URL']
                                }
                            ])
                        break;
                    }
                }
            });
            $("select[data-required='required']").each(function () {
                var elem = $(this);
                if ((elem.val() == '' || elem.val() == null || elem.val() == undefined)) {
                    // console.log(mandatory_field)
                    elem.removeClass("is-valid");
                    elem.addClass("is-invalid");
                    elem.parents().eq(3).addClass("show");
                }
                else{
                    elem.removeClass("is-invalid");
                    elem.addClass("is-valid");
                }
            });
            
        }
        else{
            if($("body").find(".is-invalid").length == 0){
                $('#form-create-richmenu').submit();
                $("#on_process_modal").modal("show");
            }
            else{
                OpenAlertModal('', '<h3 class="template-color text-center">ข้อมูลสำหรับสร้าง Rich Menu ไม่ครบถ้วน กรุณากรอกข้อมูลให้ครบ</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
            }
            
            
        }
        // 
    });

    $('#form-create-richmenu').submit(function() {
            $(this).ajaxSubmit({
              error: function(data) {
              },
              success:function(response){
                if ( response.success == true )
                {
                   window.location.href = '{{ url("Line/Richmenu")}}';
                }
                else
                {
                    setTimeout(function()
                    { 
                        $("#on_process_modal").modal("hide");
                    }, 1200);
                    setTimeout(function()
                    { 
                        OpenAlertModal(  '', '<h3 class="template-color text-center">'+response.message+'</h3>' ,
                             '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>'
                           );
                    }, 2000);
                    
                }
              }
            });
            return false;
        });
});
   
</script>
@endsection