@extends('layouts.master')
@section('title', 'News Setting')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
<link href="{{ URL::asset('assets/css/extensions/jquery-ui.css') }}" rel="stylesheet" media="all">
<!-- Include Quill stylesheet -->
<link href="{{ asset('assets/css/extensions/editor/quill.snow.css') }}" rel="stylesheet">
<style type="text/css">
    .select2-selection__choice{
        display: none;
    }
    .tag-selected {
      list-style: none;
      background-color: #DAE7F7;
      border: 1px solid #0065FF;
      border-radius: 4px;
      cursor: default;
      float: left;
      margin-right: 5px;
      margin-top: 5px;
      padding: 5px 10px;
    }

    .destroy-tag-selected {
      color: #0065FF;
      cursor: pointer;
      display: inline-block;
      font-weight: bold;
      margin-right: 2px;
      &:hover {
        text-decoration: none;
      }
    }
    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #DAE7F7;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #5897fb;
        color: white;
    }
    .select2-selection.select2-selection--multiple{
        max-height: 38px;
    }
    .ql-editor{
        min-height :200px;
    }
    .img-wrap {
        position: relative;
        float:left;
    }
    #clear{
        position: absolute;
        top: -10px;
        right: -10px;
        z-index: 100;
        border-radius: 10em;
        padding: 2px 6px 3px;
        text-decoration: none;
        font: 700 21px/20px sans-serif;
        background: #555;
        border: 3px solid #fff;
        color: #FFF;
        box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
        text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }
    #clear:hover {
        background: #E54E4E;
        padding: 3px 7px 5px;
        top: -11px;
        right: -11px;
    }
    #clear:active {
        background: #E54E4E;
        top: -10px;
        right: -11px;
    }
</style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="News Setting">

<div class="col-12">
    <form action="{{ url('/Line/News/Create') }}" method="POST" enctype="multipart/form-data" id="form-create-news">
    {{ csrf_field() }}
        <div class="d-flex flex-wrap mb-3">
            <div class="p-2 flex-fill w-50">
                <div class="">
                    <h4 class="mb-3 py-3 card-header-with-border">
                        Add new News
                        <div class="float-right">
                            <button id="save_as_draft" type="button" class="btn btn-outline-primary text-uppercase" onclick="SaveDraft()">SAVE AS DRAFT</button>
                            <button id="send_message_now" type="button" class="btn btn-primary text-uppercase" onclick="Publish()">Publish Now</button>
                            <input id="status" type="hidden" value="" name="status">
                        </div>
                    </h4>
                </div>
            </div>

        </div>
        <div class="d-flex flex-column flex-wrap">
            <div class="w-50">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-control-label font-weight-bold">Effective Date</label>
                        </div>
                        <div class="col-12">
                            <input type="text" name="effective_date" id="effective_date" class="form-control" autocomplete="off"
                                   readonly="readonly" value="" placeholder="Select date"/>
                        </div>

                    </div>
                </div>
            </div>
            <div class="w-50">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-control-label font-weight-bold">News Title<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="title" name="title" placeholder="" class="form-control required-checked">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-50">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-control-label font-weight-bold">Title Image<span class="text-danger">*</span></label>
                        </div>
                        <div class="img-wrap pl-3">
                            <input type="file" id="title_pic" name="title_pic" class="form-control" accept="image/*" onchange="loadFile(event)">
                            <img style="width: 100%;" id="output"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="message_area">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-control-label font-weight-bold">News Content<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Create the editor container -->
                                    <div id="editor"></div>
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
@endsection

@section('script')
<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<!-- Include the Quill library -->
<script src="{{ URL::asset('assets/js/extensions/jquery-ui-1.10.4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/editor/quill.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#effective_date").datepicker({
            dateFormat: 'dd/mm/yy',
            minDate: 0, // 0 days offset = today
            onSelect: function (selected) {
                $("#effective_date").datepicker("option", selected)
            }
        }).val();

            Backbtn = CustomButton('button' , 'id="BackToStep2" onclick="window.location.href=\'/News\';" type="button"' , '{{__("corporateManagement.cancel")}}' , 'outline-button');
            //first load footer progress
            divLevel2Content = `<div class="col-12 py-3">
                                    <div class="pull-left pl-4" style="padding-bottom: 10px;">
                                        ${Backbtn}
                                    </div>
                                </div>`;
            //call footer
            FooterProgress( divLevel2Content);
    });

    var toolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
      ['blockquote', 'code-block'],

      [{ 'header': 1 }, { 'header': 2 }],               // custom button values
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
      [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
      [{ 'direction': 'rtl' }],                         // text direction

      // [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
      [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

      [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
      [{ 'font': [] }],
      [{ 'align': [] }],
      ['image', 'code-block'],
      ['clean']                                         // remove formatting button
    ];

    var editor = new Quill('#editor', {
        modules: { toolbar: toolbarOptions },
        placeholder: 'Type your news content here',
        theme: 'snow'
      });

    function SaveDraft(){
        $("#status").val("DRAFT");
        SubmitForm();
    }
    function Publish(){
        $("#status").val("PUBLISHED");
        SubmitForm();
    }

    function SubmitForm(){
        var delta_content = editor.getContents();
        var json_delta_content = JSON.stringify(delta_content);
        $('#form-create-news').append('<input type="hidden" id="content_delta" name="content_delta" value="">');
        $('#content_delta').val(json_delta_content);
        $('#form-create-news').submit();
    }

    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        $("#title_pic").hide();
        $(".img-wrap").append('<a id="clear" class="clear_img" href="#" onclick="remove_image()" style="display: inline;">&#215;</a>')
    };

    function remove_image(){
        $('#output').removeAttr('src');
        $('#output').show();
        $('#title_pic').val("");
        $('.clear_img').hide();
        $("#title_pic").show();
        if ($(".img-wrap").children('input').length == 0) {
           $(".img-wrap").append('<input type="file" id="title_pic" name="title_pic" class="form-control" accept="image/*" onchange="loadFile(event)">')
        }
    }
</script>
@endsection
