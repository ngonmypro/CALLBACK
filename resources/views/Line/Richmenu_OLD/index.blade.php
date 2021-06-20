@extends('layouts.master')
@section('title', 'Rich Menu')
@section('style')
<link href="{{ URL::asset('assets/css/extensions/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all"/>
<!-- <link href="{{ URL::asset('assets/css/extensions/jplist.core.min.css') }}" rel="stylesheet" media="all"/> -->
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
    div.template-menu>div.card{
        border-radius: 6px;
        padding:.25rem;
        flex: 0 0 32%;
        max-width: 32%;
    }
    div.current-template-menu>div.card{
        border-radius: 6px;
        padding:.25rem;
    }
    div.template-menu>div.card>.card-body {
        padding: 0rem!important;
    }
    div.template-menu>div.card>.card-body span{
      font-size: 16px;
    }
    .jplist-pagination{
        text-align: center;
    }
    .jplist-pagination div{
        display: inline-block;
    }
    .jplist-pagination div button{
        background: transparent;
        box-shadow: none;
        border: none;
        cursor: pointer;
        padding: .5rem .75rem;
    }
    .jplist-pagination div button:focus{
        outline-color: transparent;
    }
    .jplist-pagination div button.jplist-current{
        color: #0065ff !important;
        font-weight: 700;
    }
</style>
@endsection
@section('content')
<input type="hidden" name="breadcrumb-title" value="Rich Menu"/>
<div class="col-12">
    <form action="{{ url('Line/Richmenu/Search') }}" method="POST" enctype="multipart/form-data" id="search">
    {{ csrf_field() }}
        <div class="col-12">
            <div class="d-flex mb-3">
                <div class="p-2 w-50">
                    <div class="col-12 px-0">
                        <label for="" class=" form-control-label font-weight-bold">Search</label>
                    </div>
                    <div class="col-12 px-0">
                        <input type="text" id="data_search" name="data_search" placeholder="Richmenu Name" class="form-control pl-5">
                        <span class="oi oi-magnifying-glass inline-icon text-style-6"></span>
                    </div>   
                </div>
                <div class="p-2 align-self-end">
                    <div class="col-12 px-0">
                        <button class="btn btn-link grid-display" type="button" id="fullview">
                            <i class="zmdi zmdi-view-dashboard" style="font-size: 24px;"></i>
                        </button>
                        <button class="btn btn-link text-secondary grid-display" type="button" id="datatable">
                            <i class="zmdi zmdi-view-day" style="font-size: 24px;"></i>
                        </button>
                    </div>
                </div>
                <div class="ml-auto p-2 align-self-end">
                    <button type="button" class="btn btn-print" onclick="window.location.href='{{ url('/Line/Richmenu/Create')}}'">
                        <i class="zmdi zmdi-plus mr-2" style="font-size: 18px;"></i>
                        New Template
                    </button>
                </div>
            </div>
        </div>

        <div class="col-12 d-none" id="richmenu_viewtable">
            <div id="template-wrapper" class="d-flex flex-wrap mb-3">
                <div id="template-list" class="px-2" style="width: 70% !important;">
                    <div id="template-list-wrapper" class="template-menu d-flex flex-wrap justify-content-between">
                        <div class="col-12">
                            <div class="d-flex flex-wrap flex-column">
                                <div class="p-2">
                                    <div class="col-12 px-0 table-responsive">
                                        <table id="demo" class="table with-checkbox" style="width:100%">
                                            <tbody class="text-center">
                                                @if(isset($richmenu))
                                                    @for($i=0;$i<$count_richmenu;$i++)
                                                        @if(isset($menu_active[0]) && $menu_active[0] != '')
                                                            @if($richmenu[$i]->status === 'active')
                                                            <tr class="opacity-unlock">
                                                                <td class="text-center" width="8%">
                                                                    <input id="demo1" class="magic-checkbox magic-tbody event-auto" type="checkbox"  value="" disabled checked>
                                                                    <label for="demo1"></label>
                                                                </td>
                                                                <td class="text-center">{{$richmenu[$i]->name}}</td>
                                                                <td class="text-center">
                                                                    {{$corp_name}}
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="">
                                                                        <i class="zmdi zmdi-check-circle text-success"></i>
                                                                        <span class="text-success">Active</span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @else
                                                            <tr class="opacity-unlock">
                                                                <td class="text-center" width="8%">
                                                                </td>
                                                                <td class="text-center">
                                                                    {{$richmenu[$i]->name}}</td>
                                                                <td class="text-center">
                                                                    {{$corp_name}}
                                                                </td>
                                                                <td class="text-center">
                                                                    <span class="">
                                                                        <i class="zmdi zmdi-close-circle-o text-danger"></i>
                                                                        <span class="text-danger">Inactive</span>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @else
                                                        <tr class="opacity-unlock">
                                                            <td class="text-center" width="8%">
                                                            </td>
                                                            <td class="text-center">
                                                                {{$richmenu[$i]->name}}</td>
                                                            <td class="text-center">
                                                                {{$corp_name}}
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="">
                                                                    <i class="zmdi zmdi-close-circle-o text-danger"></i>
                                                                    <span class="text-danger">Inactive</span>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endif 
                                                    @endfor 
                                                @endif  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($menu_active[0]) && $menu_active[0] != '')
                    <div id="current-template" class="px-2" style="width: 30% !important;">
                        <div class="current-template-menu">
                            <div class="card px-3 pb-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-2 pt-3">
                                        <span>{{$menu_active[0]->name}}</span>
                                    </h5>
                                </div>
                                <img src="{{ URL::asset('assets/images/chatcontent.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                                <img src="{{ $menu_active[0]->image_url }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                                <img src="{{ URL::asset('assets/images/menubar.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                            </div>
                        </div>
                    </div>
                @endif 
            </div>
        </div>
           
        <div class="col-12" id="richmenu_overview">
            <div id="template-wrapper" class="d-flex flex-wrap mb-3">
                <div id="template-list" class="px-2" style="width: 70% !important;">
                    <div id="paginate_template" class="box jplist" style="">   
                        <div id="template-list-wrapper" class="template-menu d-flex flex-wrap justify-content-start list box">             
                                @if(isset($richmenu))
                                @for($i=0;$i<$count_richmenu;$i++)
                                    <div class="card px-2 py-2 list-item box" id="">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                        @if($richmenu[$i]->status === 'active')
                                                            <i class="zmdi zmdi-check-circle template-text" style="font-size:21px;"></i>
                                                        @endif
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <span>{{$richmenu[$i]->name}}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <div class="dropdown dropleft">
                                                        <button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="template-1">
                                                            @if(isset($menu_active[0]) && $menu_active[0] != '')
                                                                @if($richmenu[$i]->status === 'active')
                                                                    <button class="dropdown-item" type="button" id="in_active" value="{{$richmenu[$i]->id}}">Inactive</button>
                                                                    <input class="dropdown-item" type="hidden" id="edit" value="{{$richmenu[$i]->id}}">
                                                                    <input class="dropdown-item confirm_delete" type="hidden"  value="{{$richmenu[$i]->id}}" data-menu="{{$richmenu[$i]->name}}">
                                                                @else
                                                                    <button class="dropdown-item" type="button" id="edit" value="{{$richmenu[$i]->id}}">Edit</button>
                                                                    <button class="dropdown-item confirm_delete" type="button"  value="{{$richmenu[$i]->id}}" data-menu="{{$richmenu[$i]->name}}">Delete</button>
                                                                @endif
                                                            @else
                                                                @if($richmenu[$i]->status === 'inactive')
                                                                    <button class="dropdown-item" type="button" id="active" value="{{$richmenu[$i]->id}}">Active</button>
                                                                    <button class="dropdown-item" type="button" id="edit" value="{{$richmenu[$i]->id}}">Edit</button>
                                                                    <button class="dropdown-item confirm_delete" type="button"  value="{{$richmenu[$i]->id}}" data-menu="{{$richmenu[$i]->name}}">Delete</button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <img src="{{ $richmenu[$i]->image_url }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">
                                    </div>
                                @endfor
                            @endif
                        </div>


                        <!-- panel -->
                        <div class="jplist-panel box d-flex flex-wrap mt-5 justify-content-center"> 
                            <div 
                               class="jplist-label pr-4 pt-2" 
                               data-type="Page {current} of {pages}" 
                               data-control-type="pagination-info" 
                               data-control-name="paging" 
                               data-control-action="paging">
                            </div>                      
                            <div 
                                class="jplist-pagination text-center" 
                                data-control-type="pagination" 
                                data-control-name="paging" 
                                data-control-action="paging"
                                data-items-per-page="9"
                                data-range="5"
                                data-prev="Pervious"
                                data-first="First"
                                data-last="Last"
                                data-next="Next">
                            </div>           

                        </div> 
                    </div>
                    <!--<><><><><><><><><><><><><><><><><><><><><><><><><><> DEMO END <><><><><><><><><><><><><><><><><><><><><><><><><><>-->     
                </div>
                @if(isset($menu_active[0]) && $menu_active[0] != '')
                    <div id="current-template" class="px-2" style="width: 30% !important;">
                        <div class="current-template-menu">
                            <div class="card px-3 pb-3">
                                <div class="card-body">
                                    <h5 class="card-title mb-2 pt-3">
                                    <span>{{$menu_active[0]->name}}</span>
                                    </h5>
                                </div>
                                <img src="{{ URL::asset('assets/images/chatcontent.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                                <img src="{{ $menu_active[0]->image_url }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                                <img src="{{ URL::asset('assets/images/menubar.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                            </div>
                        </div>
                    </div>
                @endif  
            </div>
        </div>
    @include('layouts.footer_progress')
    </form>
</div>
<div id="confirm_delete_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div id="" class="modal-body">
                <h3 class="template-color text-center">ยืนยันการลบเทมเพลต <span id="template_name_text" class="template-text font-weight-bold"></span> ?</h3>
            </div>
            <div id="" class="modal-footer justify-content-center border-0">
                <button type="button" id="confirm" class="btn btn-primary standard-primary-btn pt-2 pb-2" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2 delete">ลบ</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')


<script src="{{ URL::asset('assets/js/extensions/jplist.core.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/extensions/jplist.pagination-bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/extensions/jplist.bootstrap-pagination-bundle.min.js') }}"></script>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script> <!-- script line LIFF-->
<script type="text/javascript">
    $(document).ready(function(){
        /*jPList start*/
        $('#paginate_template').jplist({               
            itemsBox: '.list' 
            ,itemPath: '.list-item' 
            ,panelPath: '.jplist-panel' 
        });
        $(document).on("click" , "#active" , function(){
            var richmenu_id = $(this).val();
            $.ajax(
            {
                type: 'POST',
                url: '{{ url("Line/Richmenu/Set/allUser") }}',
                dataType: 'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    id     : richmenu_id
                },
                success: function(response) {
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" id="confirm" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                },
                error: function(e) {
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                }
            });
        });
        $(document).on("click" , "#in_active" , function(){
            var richmenu_id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ url("Line/Richmenu/Unset/allUser") }}',
                dataType: 'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    id     : richmenu_id
                },
                success: function(response) {
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" id="confirm" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                },
                error: function(e) {
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                }
            });
        });
         $(document).on("click" , ".delete" , function(){
            var richmenu_id =  $(this).data("target");
            // alert(richmenu_id)
            $.ajax({
                type: 'POST',
                url: '{{ url("Line/Richmenu/Delete") }}',
                dataType: 'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    id     : richmenu_id
                },
                success: function(response) {
                     $("#confirm_delete_modal").modal("hide");
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" id="confirm" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                },
                error: function(e) {
                    $("#confirm_delete_modal").modal("hide");
                    OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                }
            });
        });
        $(document).on("click" , ".confirm_delete" , function(){
            var richmenu_id = $(this).val();
            $("#confirm_delete_modal").modal("show");
            $("#confirm_delete_modal").find("button.delete").attr("data-target" , richmenu_id);
            $("#template_name_text").text($(this).data("menu"));
        });
        // $(document).on("click" , "#delete" , function(){
        //     var richmenu_id = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: '{{ url("Line/Richmenu/Delete") }}',
        //         dataType: 'json',
        //         data:{
        //             _token : "{{ csrf_token() }}",
        //             id     : richmenu_id
        //         },
        //         success: function(response) {
        //             OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" id="confirm" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
        //         },
        //         error: function(e) {
        //             OpenAlertModal('', '<h3 class="template-color text-center">' + response.message + '</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
        //         }
        //     });
        // });
        $(document).on("click" , "#edit" , function(){
            var id = $(this).val();
            window.location = '{{ url("Line/Richmenu/Update")}}/'+id;
        });
        $(document).on("click" , "#confirm" , function(){
            window.location = "{!! URL::to('Line/Richmenu') !!}";
        });
        $(document).on("click" , "#datatable" , function(){
            $('#richmenu_viewtable').removeClass('d-none');
            $('#richmenu_overview').addClass('d-none');
        });
        $(document).on("click" , "#fullview" , function(){
            $('#richmenu_viewtable').addClass('d-none');
            $('#richmenu_overview').removeClass('d-none');
        });
        $(document).on("click",".grid-display" , function(){
            $(this).removeClass("text-secondary");
            $(".grid-display").not($(this)).addClass("text-secondary");
        });
    });

    

   
</script>
@endsection