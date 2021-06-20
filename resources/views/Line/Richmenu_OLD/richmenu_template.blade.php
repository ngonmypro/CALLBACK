@extends('layouts.master')
@section('title', 'Rich Menu')
@section('style')
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
</style>
@endsection
@section('content')
<input type="hidden" name="breadcrumb-title" value="Rich Menu">
<div class="col-12">
    <form action="{{ url('/Product/Create') }}" method="POST" enctype="multipart/form-data" id="form-create-product">
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
                        <button class="btn btn-link grid-display" type="button" data-grid="fullview">
                            <i class="zmdi zmdi-view-dashboard" style="font-size: 24px;"></i>
                        </button>
                        <button class="btn btn-link text-secondary grid-display" type="button" data-grid="datatable">
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
        <div class="col-12">
            <div id="template-wrapper" class="d-flex flex-wrap mb-3">
                <div id="template-list" class="px-2" style="width: 70% !important;">
                    <div id="template-list-wrapper" class="template-menu d-flex flex-wrap justify-content-between">
                        <!-- <div class="col-12">
                            <div class="d-flex flex-wrap flex-column">
                                <div class="p-2">
                                    <div class="col-12 px-0 table-responsive">
                                        <table id="demo" class="table with-checkbox" style="width:100%">
                                            <tbody class="text-center">
                                                <tr class="opacity-unlock">
                                                    <td class="text-center" width="8%">
                                                        <input id="demo1" class="magic-checkbox magic-tbody event-auto" type="checkbox" name="" value="" checked>
                                                        <label for="demo1"></label>
                                                    </td>
                                                    <td class="text-center">Digio Richmenu</td>
                                                    <td class="text-center">
                                                        PTTGC
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="">
                                                            <i class="zmdi zmdi-check-circle text-success"></i>
                                                            <span class="text-success">Active</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="opacity-unlock">
                                                    <td class="text-center" width="8%">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-center">Digio Richmenu</td>
                                                    <td class="text-center">
                                                        PTTGC
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="">
                                                            <i class="zmdi zmdi-close-circle-o text-danger"></i>
                                                            <span class="text-danger">Inactive</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="opacity-unlock">
                                                    <td class="text-center" width="8%">
                                                        &nbsp;
                                                    </td>
                                                    <td class="text-center">Digio Richmenu</td>
                                                    <td class="text-center">
                                                        PTTGC
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="">
                                                            <i class="zmdi zmdi-close-circle-o text-danger"></i>
                                                            <span class="text-danger">Inactive</span>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="card px-2 py-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <i class="zmdi zmdi-check-circle template-text" style="font-size:21px;"></i>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>Digio Villa</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="dropdown dropleft">
                                            <button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="template-1">
                                                <button class="dropdown-item" type="button">Active</button>
                                                <button class="dropdown-item" type="button">Edit</button>
                                                <button class="dropdown-item" type="button">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                             <img src="{{ URL::asset('assets/images/1200x810.png') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">
                        </div>
                        <div class="card px-2 py-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span>Digio Villa</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="dropdown dropleft">
                                            <button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="template-2">
                                                <button class="dropdown-item" type="button">Active</button>
                                                <button class="dropdown-item" type="button">Edit</button>
                                                <button class="dropdown-item" type="button">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                             <img src="{{ URL::asset('assets/images/1200x810.png') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">
                        </div>
                        <div class="card px-2 py-2">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span>Digio Villa</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <div class="dropdown dropleft">
                                            <button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="template-3">
                                                <button class="dropdown-item" type="button">Active</button>
                                                <button class="dropdown-item" type="button">Edit</button>
                                                <button class="dropdown-item" type="button">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                             <img src="{{ URL::asset('assets/images/1200x810.png') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">
                        </div>
                    </div>
                </div>
                <div id="current-template" class="px-2" style="width: 30% !important;">
                    <div class="current-template-menu">
                        <div class="card px-3 pb-3">
                            <div class="card-body">
                                <h5 class="card-title mb-2 pt-3">
                                  <span>Current Menu</span>
                                </h5>
                            </div>
                            <img src="{{ URL::asset('assets/images/chatcontent.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                            <img src="{{ URL::asset('assets/images/1200x810.png') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
                            <img src="{{ URL::asset('assets/images/menubar.PNG') }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200">
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
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script> <!-- script line LIFF-->
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.form.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
       $(document).on("click" , ".grid-display" , function(){
            var getDataGrid = $(this).data("grid");
            $(this).removeClass("text-secondary");
            $(".grid-display").not($(this)).addClass("text-secondary");
            $("#template-list-wrapper").empty();
            if(getDataGrid == "fullview"){
                $("#template-list-wrapper").append(
                    '<div class="card px-2 py-2">'+
                        '<div class="card-body">'+
                            '<div class="d-flex justify-content-between">'+
                                '<div>'+
                                    '<ul class="list-inline">'+
                                        '<li class="list-inline-item">'+
                                            '<i class="zmdi zmdi-check-circle template-text" style="font-size:21px;"></i>'+
                                        '</li>'+
                                        '<li class="list-inline-item">'+
                                            '<span>Digio Villa</span>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div>'+
                                    '<div class="dropdown dropleft">'+
                                        '<button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            '<i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>'+
                                        '</button>'+
                                        '<div class="dropdown-menu" aria-labelledby="template-1">'+
                                            '<button class="dropdown-item" type="button">Active</button>'+
                                            '<button class="dropdown-item" type="button">Edit</button>'+
                                            '<button class="dropdown-item" type="button">Delete</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+ 
                        '</div>'+
                         '<img src="{{ URL::asset("assets/images/1200x810.png") }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">'+
                    '</div>'+
                    '<div class="card px-2 py-2">'+
                        '<div class="card-body">'+
                            '<div class="d-flex justify-content-between">'+
                                '<div>'+
                                    '<ul class="list-inline">'+
                                        '<li class="list-inline-item">'+
                                            '<span>Digio Villa</span>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div>'+
                                    '<div class="dropdown dropleft">'+
                                        '<button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            '<i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>'+
                                        '</button>'+
                                        '<div class="dropdown-menu" aria-labelledby="template-1">'+
                                            '<button class="dropdown-item" type="button">Active</button>'+
                                            '<button class="dropdown-item" type="button">Edit</button>'+
                                            '<button class="dropdown-item" type="button">Delete</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+ 
                        '</div>'+
                         '<img src="{{ URL::asset("assets/images/1200x810.png") }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">'+
                    '</div>'+
                    '<div class="card px-2 py-2">'+
                        '<div class="card-body">'+
                            '<div class="d-flex justify-content-between">'+
                                '<div>'+
                                    '<ul class="list-inline">'+
                                        '<li class="list-inline-item">'+
                                            '<span>Digio Villa</span>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                                '<div>'+
                                    '<div class="dropdown dropleft">'+
                                        '<button class="btn btn-link pt-1 px-0 text-secondary" type="button" id="template-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
                                            '<i class="zmdi zmdi-more-vert" style="font-size: 18px;"></i>'+
                                        '</button>'+
                                        '<div class="dropdown-menu" aria-labelledby="template-1">'+
                                            '<button class="dropdown-item" type="button">Active</button>'+
                                            '<button class="dropdown-item" type="button">Edit</button>'+
                                            '<button class="dropdown-item" type="button">Delete</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+ 
                        '</div>'+
                         '<img src="{{ URL::asset("assets/images/1200x810.png") }}" class="card-img-top card-img image-cover" alt="..." style="max-width: 100%;max-height: 100%;height:auto;" width="1200" height="810">'+
                    '</div>'
                );
            }   
            else if(getDataGrid == "datatable"){
                $("#template-list-wrapper").append(
                    '<div class="col-12">'+
                        '<div class="d-flex flex-wrap flex-column">'+
                            '<div class="p-2">'+
                                '<div class="col-12 px-0 table-responsive">'+
                                    '<table id="demo" class="table with-checkbox" style="width:100%">'+
                                        '<tbody class="text-center">'+
                                            '<tr class="opacity-unlock">'+
                                                '<td class="text-center" width="8%">'+
                                                    '<input id="demo1" class="magic-checkbox magic-tbody event-auto" type="checkbox" name="" value="" checked>'+
                                                    '<label for="demo1"></label>'+
                                                '</td>'+
                                                '<td class="text-center">Digio Richmenu</td>'+
                                                '<td class="text-center">'+
                                                    'PTTGC'+
                                                '</td>'+
                                                '<td class="text-center">'+
                                                    '<span class="">'+
                                                        '<i class="zmdi zmdi-check-circle text-success"></i>'+
                                                        '<span class="text-success">Active</span>'+
                                                    '</span>'+
                                                '</td>'+
                                            '</tr>'+
                                            '<tr class="opacity-unlock">'+
                                                '<td class="text-center" width="8%">'+
                                                    '&nbsp;'+
                                                '</td>'+
                                                '<td class="text-center">Digio Richmenu</td>'+
                                                '<td class="text-center">'+
                                                    'PTTGC'+
                                                '</td>'+
                                                '<td class="text-center">'+
                                                    '<span class="">'+
                                                        '<i class="zmdi zmdi-close-circle-o text-danger"></i>'+
                                                        '<span class="text-danger">Inactive</span>'+
                                                    '</span>'+
                                                '</td>'+
                                            '</tr>'+
                                            '<tr class="opacity-unlock">'+
                                                '<td class="text-center" width="8%">'+
                                                    '&nbsp;'+
                                                '</td>'+
                                                '<td class="text-center">Digio Richmenu</td>'+
                                                '<td class="text-center">'+
                                                    'PTTGC'+
                                                '</td>'+
                                                '<td class="text-center">'+
                                                    '<span class="">'+
                                                        '<i class="zmdi zmdi-close-circle-o text-danger"></i>'+
                                                        '<span class="text-danger">Inactive</span>'+
                                                    '</span>'+
                                                '</td>'+
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );
            }
       });

    });
</script>
@endsection