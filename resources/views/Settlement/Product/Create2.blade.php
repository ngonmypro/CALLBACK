@extends('argon_layouts.app', ['title' => __('Create Settlement')])

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
    .modal-backdrop {
        background-color: rgba(0,0,0,0.6) !important;
        position: fixed;
    }
</style>
@endsection

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">



<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">


<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Fee Setting</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
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
                                <h3 class="mb-0">{{$channel}}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                 

                    <div class="card-body">
                        <form id="create_settlement" action="{{ url('Settlement/Product/corporate/create_corporate')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mx-auto">
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-control-label">Company Name</label>
                                                    <select name="company_name" class="company_name" id="company_name"></select>
                                                </div>
                                            </div>

                                            <input type="hidden" class="form-control product_type" name="channel_name" id="channel_name" value="{{$channel_name}}"/>
                                            <div class="col-md-6">
                                                <div class="form-group mb-0 d-none " id="type_mid">
                                                    <label class="form-control-label" id="type">MID</label>
                                                    <input type="text" class="form-control" name="mid" id="mid" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row fee_set d-none">
                                            <div class="col-md-6">
                                                <div class="form-group mb-0">
                                                    <label class="form-control-label">FEE</label>
                                                    <input type="number" class="form-control" name="fee" id="fee" min="1" placeholder="" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group mb-0" id="type_mid">
                                                    <label class="form-control-label" id="type">MDR</label>
                                                    <input type="number" class="form-control" name="mdr" id="mdr" min="1" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                            <hr class="border-bottom bottom-devide">
                                        </div>
                                    </section>
                                </section>
                            </div>

                            <div class="text-center">
                                <button  class="btn btn-success mt-3">Create</button>
                            </div>
                            
                        </form>
                      


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CreateSettlement','#create_settlement') !!}

    <script>
        function checkCode(elem) 
        {
                var recipient_code = $(elem).val();
                $.ajax({
                        type: 'POST',
                        url: '{{ action("RecipientManageController@check_code") }}',
                        data: {
                            _token: `{{ csrf_token() }}`,
                            recipient_code: recipient_code,
                        }
                    }).done(function(result) {
                        $.unblockUI()
                        if ( result.success ) {
                            Swal.fire({
                                    title: 'recipient code  มีอยู่แล้ว'
                                })
                        }
                    }).fail(function(err) {
                        $.unblockUI()
                        console.error('Error: ', err)
                        Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Something wrong.', 'error')
                    })
        }

        $(document).ready(function() 
        {
            const currentlang = `{{ app()->getLocale() }}`
            var channel_name = $('#channel_name').val();

            $('#company_name').select2({
                placeholder: "{{__('role.corp_search')}}",
                minimumInputLength: 2,
                language: {
                    inputTooShort: function() {
                        return "{{__('role.corp_search_validate')}}";
                    }
                },
                ajax: {
                    delay: 250,
                    cache: true,
                    url: '{{ action("SettlementController@select2_corpid") }}',
                    dataType: 'json',
                    type: 'post',
                    data: function(params) {
                        const query = {
                            search: params.term,
                            channel_name: channel_name,
                            _token: '{{ csrf_token() }}'
                        }
                        return query
                    },
                    processResults: function(data, page) {
                        if(currentlang == 'en'){
                            return {
                                results: $.map(data.items, function(item) {
                                    return { id: item.id, text: item.text_en }
                                })
                            }
                        }else{
                            return {
                                results: $.map(data.items, function(item) {
                                    return { id: item.id, text: item.text_en }
                                })
                            }
                        }
                    }
                }
            })
        });

        $('#company_name').on('select2:select', function (e) 
        {

            var channel_name = $('#channel_name').val();
            const corp_code = e.params.data.id
            const mid = e.params.mid
        
            $.ajax({
                url: '{{ action("SettlementController@select2_config") }}',
                type: "post",
                data: { 
                    _token: '{{ csrf_token() }}',
                    channel_name: channel_name,
                    corp_code: corp_code
                },
                success: function (response) {
                
                    if(response.success == true)
                    {
                        if(response.data != null){
                            $("#type_mid").removeClass("d-none");
                            $( "#type" ).text(response.type);
                            $('input[name=mid]').val(response.data|| '').prop('readonly', true).removeClass('is-invalid').removeClass('is-valid')
                        }
                            $(".fee_set").removeClass("d-none");
                        }else{
                            $(".fee_set").removeClass("d-none");  
                            $("#type_mid").addClass("d-none");
                        }
                    // $.unblockUI()
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function(){})
                    $.unblockUI()
                }
            });

         
        })

    </script>

    <script type="text/javascript">

            $("#select_all").click(function () 
            {
                $('.case').attr('checked', this.checked);
            });
          
            $(".case").click(function(){
                if($(".case").length == $(".case:checked").length) {
                    $("#select_all").attr("checked", "checked");
                } else {
                    $("#select_all").removeAttr("checked");
                }
            });

    


            
    </script>

@endsection
