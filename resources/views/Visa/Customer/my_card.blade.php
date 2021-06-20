@extends('Visa.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/OwlCarousel/assets/owl.theme.default.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/ion_rangeSlider/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        .pin-block > div{
            padding: 1rem;
        }
        .pin-block > div button{
            font-size: 26px;
            color: #000;
            font-weight: bold;
        }
        .magic-radio + label:before, .magic-checkbox + label:before{
            left: 5px !important;
        }
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
                        <h5 class="color-primary mb-0">บัตรของฉัน</h5>
                    </li>
                </ul>
                
            </div>
            <div class="card-body pt-3 pb-2">
                <form action="{{ url('/virtual_card/request')}}" class="pb-4" method="post" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <input type="hidden" name="recipient_code" value="">
                    <input type="hidden" name="line_id" value="">
                    <div class="form-group mb-0">
                        <div class="d-flex flex-column">
                            <div class="pb-3">
                                <img src="{{ URL::asset('assets/images/virtual_card/business_card_01.png') }}" class="img-fluid" alt="..." >
                            </div>
                            <div class="text-right">
                                <h4>Visa Business Card</h4>
                            </div>
                            <div class="text-right">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <p>กำหนดชำระวันที่ : </p>
                                    </li> 
                                    <li class="list-inline-item">24 มี.ค.63</li> 
                                </ul>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group mb-0">
                        <label class="text-secondary mb-0">ชื่อเจ้าของบัตร</label>
                        <p class="text-uppercase">{{ isset($data->recipient_info->full_name) ? $data->recipient_info->full_name : ''  }}</p>
                    </div>
                    <div class="form-group mb-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label class="text-secondary mb-0">หมายเลขบัตร</label>
                                <p class="text-uppercase">{{ isset($data->virtual_cards->account_number) ? $data->virtual_cards->account_number : ''  }}</p>
                            </div>
                            <div class="pr-5">
                                <label class="text-secondary mb-0">CVV</label>
                                <p class="text-uppercase">{{ isset($data->virtual_cards->cvv) ? $data->virtual_cards->cvv : ''  }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="text-secondary mb-0">วันหมดอายุบัตร</label>
                        <p class="text-uppercase">{{ isset($data->virtual_cards->expire_date) ? $data->virtual_cards->expire_date : ''  }}</p>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label class="text-secondary mb-0">วงเงินที่ใช้ไป</label>
                                <h5 class="comma color-primary">0</h5>
                            </div>
                            <div class="text-right">
                                <label class="text-secondary mb-0">วงเงินคงเหลือ</label>
                                <h5 class="comma">0</h5>
                            </div>
                        </div>
                        <div class="progress" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>


@endsection

@section('script')

<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script src="liff-starter.js"></script>
<script type="text/javascript">

     /////*********** */start script line LIFF
    window.onload = function (e) {
        liff.init(function (data) {
            initializeApp(data);
        });

      
    };

</script>
@endsection