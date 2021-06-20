@extends('Visa.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ion_rangeSlider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        
    </style>
@endsection

@section('content')

<div class="d-flex justify-content-center mt-4">
    <div class="col-sm-12 col-md-6">
        <div class="card mb-4">
            <div class="card-header card-header-img bg-white border-dashed">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <img src="{{ URL::asset('assets/images/virtual_card/ic_card.png') }}" class="img-fluid" alt="..." width="40">
                    </li>
                    <li class="list-inline-item align-middle">
                        <h5 class="color-primary mb-0"> ข้อมูลบัตร</h5>
                    </li>
                </ul>
                
            </div>

            <div class="card-body pt-3 pb-2">
                <form id="form_card_request" action="{{ url('/virtual_card/request')}}" class="pb-4" method="post" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <input type="hidden" name="recipient_code" value="">
                    <input type="hidden" name="line_id" value="">
                    <div class="form-group">
                        <label>กรุณาเลือกบัตร</label>
                        <div class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                   <div class="">
                                        <img src="{{ URL::asset('assets/images/virtual_card/business_card_01.png') }}" class="align-self-start" alt="..." >
                                    </div>
                                    <div class="text-right">
                                        <h5 class="mt-0">Visa Travel Money</h5>
                                        <small class="text-muted">Passport of asian Trendy lifestyle.</small>
                                    </div> 
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                   <div class="">
                                        <img src="{{ URL::asset('assets/images/virtual_card/business_card_02.png') }}" class="align-self-start" alt="..." >
                                    </div>
                                    <div class="text-right">
                                        <h5 class="mt-0">Visa Travel Money</h5>
                                        <small class="text-muted">Passport of asian Trendy lifestyle.</small>
                                    </div> 
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                   <div class="">
                                        <img src="{{ URL::asset('assets/images/virtual_card/travel_card_01.png') }}" class="align-self-start" alt="..." >
                                    </div>
                                    <div class="text-right">
                                        <h5 class="mt-0" style="font-size: 80%;">Visa Travel Money</h5>
                                        <small class="text-muted">Passport of asian Trendy lifestyle.</small>
                                    </div> 
                                </div>
                            </div>
                            <div class="item">
                                <div class="d-flex justify-content-between">
                                   <div class="">
                                        <img src="{{ URL::asset('assets/images/virtual_card/travel_card_02.png') }}" class="align-self-start" alt="..." >
                                    </div>
                                    <div class="text-right">
                                        <h5 class="mt-0" style="font-size: 80%;">Visa Travel Money</h5>
                                        <small class="text-muted">Passport of asian Trendy lifestyle.</small>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>เลือกวัตถุประสงค์การใช้งาน</label>
                        <select class="form-control" name="card_type">
                            <option disabled="disabled" selected="selected">กรุณาเลือกวัตถุประสงค์การใช้งาน</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>วันที่เริ่มต้นการใช้งาน</label>
                        <div class="row">
                            <div class="col-sm-6 pb-4">
                                <input type="text" name="start_date" class="form-control">
                                <img src="{{ URL::asset('assets/images/virtual_card/calendar.png') }}" class="" alt="..." style="position: absolute;right:25px;top: 10px;">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="end_date" class="form-control">
                                <img src="{{ URL::asset('assets/images/virtual_card/calendar.png') }}" class="" alt="..." style="position: absolute;right:25px;top: 10px;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>สกุลเงิน</label>
                        <select class="form-control" name="currency">
                            <option disabled="disabled" selected="selected">กรุณาเลือกสกุลเงิน</option>
                            @if($currencies != NULL)
                                @foreach($currencies as $v)
                                    <option value="{{ $v->code }}"> {{ $v->name }} </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>วงเงินที่ขอ</label>
                         <div class="form-group">
                            <input type="text" class="form-control numeric" name="change_credit">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control js-range-slider" name="credit_limit">
                        </div>
                    </div>
                   
                    <button id="submit_btn" type="button" class="btn btn-primary col-12">ยืนยัน</button>
                </form>
            </div>
        </div>
        
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/OwlCarousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/ion_rangeSlider/js/ion.rangeSlider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
<script src="{{ URL::asset('assets/js/extensions/sweetalert2.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\VisaLineCardRequest','#form_card_request') !!}
<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script src="liff-starter.js"></script>
<script type="text/javascript">


    liff.init({ liffId: "1653643703-PpzEYn5k" }, () => {
        if (liff.isLoggedIn()) {
            initializeApp()
        } else {
            liff.login();
        }
    }, err => console.error(err.code, error.message));

    $(document).ready(function(){

        $('.owl-carousel').owlCarousel({
            stagePadding: 30,
            loop:false,
            nav:false,
            margin:0,
            singleItem:true,
            items: 1,
            responsive:{
                0:{
                    stagePadding: 20,
                },
                600:{
                    stagePadding: 25,
                },
            }
        });

        let d5_instance = $(".js-range-slider");
        
        d5_instance.ionRangeSlider({
            min: 20000,
            max: 500000,
            from: 200000,
            onChange: function (data) {
                $("input[name='change_credit']").val(addComma(data.from));
                $("input[name='change_credit']").attr("value" , removeComma(data.from));
            }
        });
        //add comma
        $("input[name='change_credit']").val(addComma(d5_instance.data("from")));

        $("input[name='change_credit']").on("focusout" , function(){
            let elemValue = removeComma($(this).val());
            let d5_instance = $(".js-range-slider").data("ionRangeSlider");
            var getMin = d5_instance.options.min;
            var getMax =  d5_instance.options.max;
            console.log(d5_instance)

            // alert("elemValue " +elemValue)
            // alert("getMin " +getMin)
            // alert("getMax " +getMax)

            if(parseInt(elemValue) < parseInt(getMin)){
                $(this).addClass("is-invalid");
                $(this).val("");
                $(this).attr("value" , "");
            }
            else if(parseInt(elemValue) > parseInt(getMax)){
                $(this).addClass("is-invalid");
                $(this).val("");
                $(this).attr("value" , "");
            }
            else{
                d5_instance.update({
                    from: elemValue,
                }); 
                $(this).attr("value" ,elemValue);
            }
               
            
        });
    });

    function initializeApp() 
    {
        liff.getProfile().then(profile => {

            var lineId = profile.userId;

            // GET PROFILE
            $.ajax({
                url: "{{ url('/app/line/profile')}}",
                type: "POST",
                data: { 
                    _token: '{{ csrf_token() }}',
                    line_id: lineId
                },
                success: function (response) {

                    if(response.success == true)
                    {
                        $('input[name="recipient_code"]').val(response.data.recipient_code)
                        $('input[name="line_id"]').val(lineId)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
        }).catch(err => console.error(err));
    }

    $('input[name="start_date"]').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD/MM/YYYY'
        }

    }, function (start, end) {
        $('input[name="start_date"]').val(start.format('DD/MM/YYYY'))
    });

    $('input[name="end_date"]').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD/MM/YYYY'
        }

    }, function (start, end) {
        $('input[name="end_date"]').val(start.format('DD/MM/YYYY'))
    });


    $('#submit_btn').click(function(){
        if($('#form_card_request').valid()) {
            $('#form_card_request').submit()
        }
    });

 

    $('#form_card_request').submit(function() {

        $(this).ajaxSubmit({
            error: function(data) {
            },
            success:function(response){
                console.log(response)

                if (response.success == true)
                {
                    $('#confirm_register').attr('disabled','disabled');
                    Swal.fire('Request success','','success').then(function() {
                        if (liff.isInClient()) {
                            liff.closeWindow();
                        } 
                    })
                }
                else
                {
                    Swal.fire('เกิดข้อผิดพลาด','ERROR','error').then(function() {
                 
                    })
                }
            }
        });
        return false;
    });

    
</script>
@endsection