@extends('layouts.master')
@section('title', 'News Setting')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
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
</style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="News Setting">

<div class="col-12">
    <form action="{{ url('/Line/News/Update_Status') }}" method="POST" enctype="multipart/form-data" id="form-update-news-status">
    {{ csrf_field() }}
        <div class="d-flex flex-wrap mb-3">
            <div class="p-2 flex-fill w-50">
                <div class="">
                    <h4 class="mb-3 py-3 card-header-with-border">
                        News Detail
                        <div class="float-right pl-3">
                            <button id="edit_news" type="button" class="btn btn-primary text-uppercase" onclick="EditNews()">Edit</button>
                        </div>
                      @if($news_detail->status == "DRAFT")
                        <div class="float-right pl-3">
                            <button id="to_publish" type="button" class="btn btn-primary text-uppercase" onclick="ToPublish()">Publish Now</button>
                        </div>
                      @elseif($news_detail->status == "PUBLISHED")
                        <div class="float-right pl-3">
                            <button id="to_draft" type="button" class="btn btn-outline-primary text-uppercase" onclick="ToDraft()">Un Publish</button>
                        </div>
                      @endif
                        <input id="news_code" type="hidden" value="{{$news_detail->news_code}}" name="news_code">
                        <input id="status" type="hidden" value="" name="status">
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
                            <label for="" class=" form-control-label"> {{ isset($news_detail->publish_date) ? $news_detail->publish_date : '-' }} </label>
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
                            <label for="" class=" form-control-label"> {{ isset($news_detail->title) ? $news_detail->title : '-' }} </label>
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
                        <div class="col-12">
                            <img style="width: 100%;" src="{{ $news_detail->title_image }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-50 message_area">
                <div class="form-group">
                    <div class="row">
                        <div class="col-12">
                            <label for="" class="form-control-label font-weight-bold">News Content<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <div id="news-content-area" class="news-content-area">
                                    <!-- Create the editor container -->
                                    {{-- <p class=" form-control-label"> {{ isset($news_detail->content) ? $news_detail->content : '-' }} </p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="editor" hidden></div>
    @include('layouts.footer_progress')
    </form>
</div>
@endsection

@section('script')
<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<!-- Include the Quill library -->
<script type="text/javascript" src="{{ asset('assets/js/extensions/editor/quill.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
      Backbtn = CustomButton('button' , 'id="BackToStep2" onclick="window.location.href=\'/Line/News\';" type="button"' , '{{__("Cancel")}}' , 'outline-button');
      //first load footer progress
      divLevel2Content = `<div class="col-12 py-3">
                              <div class="pull-left pl-4" style="padding-bottom: 10px;">
                                  ${Backbtn}
                              </div>
                          </div>`;
      //call footer
      FooterProgress( divLevel2Content);
    });

    function EditNews(){
        window.location = "{!! URL::to('Line/News/Edit/'.$news_detail->news_code) !!}";
    }

    var editor = new Quill('#editor', { modules: { toolbar: [] }, readOnly: true, theme: 'bubble'} );

    var news_delta = {!! $news_detail->content !!};
    editor.setContents(news_delta);
    var news_html = editor.root.innerHTML;
    console.log(news_html);
    $("#news-content-area").append(news_html);

    function ToPublish(){
        $("#status").val("PUBLISHED");
        $('#form-update-news-status').submit();
    }
    function ToDraft(){
        $("#status").val("DRAFT");
        $('#form-update-news-status').submit();
    }

</script>
@endsection
