@extends('layouts.master')
@section('title', 'Manage Apps')
@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
<style type="text/css">
    .list-no-border button{
        border-left: 0;
        border-right: 0;
        border-bottom: 4px solid transparent;
        border-top: 0;
        padding-left: 0;
        padding-right: 0;
        margin: 0rem 1.25rem;
        line-height: 2.5rem;
        color: #9C9C9C;
    }
    .list-no-border button:focus{
        outline-color: transparent;
    }
    .list-no-border button.active-filter{
        border-bottom:4px solid #4B66EA;
        color: #222222;
    }
    .list-no-border button:hover{
        border-bottom:4px solid #4B66EA;
        color: #222222;
    }
    div.card.custom-card{
        /*max-width: 450px;*/
    }
    div.card > .card-body.pb-0{
        padding-bottom: 0!important;
    }
    .lock-zmdi-icon{
        /*-moz-transform: rotate(-35deg);
        -webkit-transform: rotate(-35deg);
        -o-transform: rotate(-35deg);
        -ms-transform: rotate(-35deg);
        transform: rotate(-35deg);*/
        color: #DEDEDE;
        cursor: pointer;
    }
    .download-zmdi-icon{
        color: #325FFF;
        cursor: pointer;
    }
    .download-zmdi-icon + span{
        color: #325FFF;
        margin-top: -8px;
        font-size: 12px;
    }
    .check-zmdi-icon.unlock{
        color: #0ce2b0;
    }
    .check-zmdi-icon.new{
        color: #0ce2b0;
    }
    .check-zmdi-icon.processing{
        color: #0ce2b0;
    }
    .check-zmdi-icon.success{
        color: #0ce2b0;
    }
    .check-zmdi-icon.fail{
        color: #0ce2b0;
    }
    .check-zmdi-icon.lock{
        color: #FF413E;
    }
    .check-zmdi-icon + span{
        vertical-align: top;
        font-weight: bold;
    }
    .check-zmdi-icon + span.unlock{
        color: #0ce2b0;
        font-size: 16px;

    }
    .check-zmdi-icon + span.lock{
        color: #FF413E;
        font-size: 16px;
    }
    .zmdi-size{
        font-size: 24px;
    }
    .zmdi-size + span{
        vertical-align: top;
    }
    .magic-checkbox.magic-thead + label:after{
        top: -8px;
    }
    .magic-checkbox.magic-thead + label:before{
        top: -10px;
        background: #EBEDF0;
        border: none;
    }
    .magic-checkbox.magic-thead:checked + label:before{
        border: #3e97eb;
        background: #0065FF;
    }
    .magic-checkbox.magic-tbody + label:before{
        background: #EBEDF0;
        border: none;
    }
    .magic-checkbox.magic-tbody:checked + label:before{
        border: #3e97eb;
        background: #0065FF;
    }
    .opacity-unlock{
        opacity: 1;
    }
    .opacity-lock{
        opacity: 0.5;
    }
    .zmdi.zmdi-lock-open{
        color:  #3e97eb;
    }
    .event-none{
        pointer-events: none !important; 
    }
    .event-auto{
        pointer-events: auto !important;
    }
    /*button*/
    .btn-print.warning{
        background: #EFA53C;
    }
    .custom-w-130px{
        width: 130px !important;
    }
    .custom-w-200px{
        width: 200px !important;
    }



    /* */
    a.disabled {
      pointer-events: none;
      cursor: default;
    }

    .modal-xl { max-width: 1200px; }

</style>
@endsection

@section('content')

<input type="hidden" name="breadcrumb-title" value="Apps">

    <div class="col-12">
        <div class="d-flex flex-wrap mb-3">
            <div class="ml-auto p-2">
                <button type="button" class="btn btn-print" onclick="window.location.href='{{ url('Manage/Apps/Create')}}'">
                    Create App
                </button>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="d-flex flex-wrap">
            <div class="card flex-fill border-0 px-4 py-3">
                <div class="card-body">
                    <div class="">
                        <p class="mb-2 font-weight-bold">Search Apps</p>
                    </div>
                    <div class="">
                        <div class="d-flex">
                            <div class="mx-2">
                                <div class="col-12 px-0">
                                    <div class="form-group">
                                        <input type="text" id="data_search" name="data_search" placeholder="name" class="form-control pl-5">
                                        <span class="oi oi-magnifying-glass inline-icon text-style-6" onclick=""></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-2">
                                <div class="col-12 px-0">
                                    <div class="form-group">
                                        <select class="form-control custom-form-control">
                                            <option disabled selected>all status</option>
                                            <option>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-2 flex-fill">
                                <div class="col-12 px-0">
                                    <div class="form-group">
                                        <input type="text" name="daterange" id="daterange" class="form-control input-no-border text-style-6" autocomplete="off"
                                            readonly="readonly" value="" placeholder="Select date"/>
                                        <span class="oi oi-calendar icon-inline text-style-6" name="daterange"></span>
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
        <div class="d-flex flex-wrap flex-column">
            <div class="p-2">
                <div class="col-12 px-0 table-responsive">
                    <form id="form_etax" action="{{ url('Etax/ConfirmSign') }}" method="POST" enctype="multipart/form-data" >

                        {{ csrf_field() }}
                    	<table id="dt" class="table centered" style="width:100%"></table>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="d-flex flex-wrap flex-column">
            <div class="p-2">
            </div>
        </div>
    </div>



@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.form.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
        $("#dt").DataTable({
            sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            serverSide: true,
            order: [[ 0, "desc" ]],
            dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
            ajax: {
                url: '{!! URL::to("Manage/Apps/objectData") !!}',
                method: 'POST',
                data: function (d) {
                    d._token = "{{ csrf_token() }}"
                }
            },
            columns: [
                { data: 'code',             title: 'ID'  },
                { data: 'app_name',         title: 'App name'  },
                { data: 'created_at',       title: 'Create date'  },
                { data: 'updated_at',       title: 'Update date'  },
                { data: null,               title: '' }
            ],
            columnDefs : [
                {
                    targets: [-1],
                    render: function(data, type, row) {
                        return `<button type="button" class="btn btn-print btn-sm" style="height: 30px; width: 80px;" onclick="onclick="window.location.href='{{ url('Manage/Apps/')}}/${data.code}'"">View</button>`
                    },
                    className: 'text-center'
                },
                {   
                    className: 'text-center',
                    targets: "_all"
                }
            ]
        });

        $('input[name="daterange"] , [name="daterange"]').daterangepicker({
            startDate: moment(),
            endDate: moment(),
            autoUpdateInput: true,
            timePicker: true,
            dateLimit: {
                "months": 1
            },
            timePickerIncrement: 30,
            timePicker24Hour: true,
            locale: {
                format: 'MMM,YYYY'
            }

        }, function (v1, v2) {
            $('input[name="daterange"]').val(v1.format('DD/MM/YYYY hh:mm A') + '-' + v2.format('DD/MM/YYYY hh:mm A'));
            oTable.draw();
        });

        $("select").select2();
    });
</script>
@endsection
