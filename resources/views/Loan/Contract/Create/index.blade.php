@extends('layouts.master')
@section('title', 'Create Contract')
@section('style')
<link href="{{ URL::asset('assets/css/extensions/jquery-ui.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="Create Contract">
@include('Loan.Contract.Create.step')
<div class="col-12">
    <form action="{{ url('/Loan/Contract/Create') }}" method="POST" enctype="multipart/form-data" id="form-create-contract">
    {{ csrf_field() }}
        <div class="d-flex flex-wrap mb-3">
            <div class="p-2 flex-fill w-50">
                <h4 class="mb-3 py-3 card-header-with-border">Contrct Information</h4>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Contract Name <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="" name="contract_name" placeholder="" class="form-control required-checked" value="" data-type="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Contract Item <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="" name="contract_item" placeholder="" class="form-control required-checked" value="" data-type="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Amount (Baht) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="amount" name="amount" placeholder="" class="form-control required-checked" value="" data-type="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Product <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control select-append" name="product" id="product" onchange="calculate()">
                                <option disabled selected>----- Product -----</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Recipient <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control select-append" name="recipient" id="recipient">
                                <option disabled selected>----- Recipient -----</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Period <span class="text-danger">*</span></label>
                        </div>
                         <div class="col-12">
                            <input type="text" id="period" name="period" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Fee (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="fee_percent" name="fee_percent" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Interest Rate (%) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="interest_rate_percent" name="interest_rate_percent" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Fee (Baht) <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="fee_amount" name="fee_amount" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">ส่วนต่าง</label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="difference" name="difference" placeholder="" class="form-control required-checked" value="" data-type="" readonly>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Montly Installment <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="mountly_install_amount" name="mountly_install_amount" placeholder="" class="form-control required-checked" value="" data-type="" readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Total Amount <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="total_amount" name="total_amount" placeholder="" class="form-control required-checked" value="" data-type=" " readonly="readonly">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">วันที่สัญญามีผล <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="contract_start_date" name="contract_start_date" placeholder="" class="form-control required-checked datepicker" value="" data-type="" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">วันที่ชำระงวดแรก <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="first_payment_date" name="first_payment_date" placeholder="" class="form-control required-checked datepicker" value="" data-type="" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">รายละเอียดเพิ่มเติม</label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="" name="description" placeholder="" class="form-control required-checked" value="" data-type="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap mb-3">
            <div class="p-2 flex-fill w-50">
                <h4 class="mb-3 py-3 card-header-with-border">ที่อยู่ในการจัดส่งสินค้า</h4>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Address <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <input type="text" id="" name="address" placeholder="" class="form-control required-checked" value="" data-type="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Province <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control province select-append" name="Province" id="province_1" onfocus="province(this)" onchange="district(this)">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">District <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control district select-append" name="District" id="district_1" onchange="sub_district(this)">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Sub District <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control sub_district select-append" name="Sub_District" id="subdistrict_1" onchange="zipcode(this)">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Postal Code <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control zipcode select-append" name="Zipcode" id="zipcode_1" onchange="zipcode(this)">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-2 flex-fill w-50">
                <div class="form-group">        
                    <div class="row">
                        <div class="col-12">
                            <label for="" class=" form-control-label">Country <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-12">
                            <select class="form-control country select-append" name="Country" id="country" >
                                <option value="Thailand">Thailand | ประเทศไทย</option>
                            </select>
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
    
    <script type="text/javascript" src="{{ asset('assets/js/extensions/jsvalidation.js')}}"></script>
    <!--- Daterange picker --->
    <script src="{{ URL::asset('assets/js/extensions/jquery-ui-1.10.4.min.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CreateContractRequest') !!}
    <script type="text/javascript">
          function province(elem)
          {
              var getID = $(elem).attr("id");
              var ID = getID.split("_")[1];
              //console.log(ID);
              $("#province_"+(ID)+"").empty();

              $.ajax({
                  type:'POST',
                  url: "{!! URL::to('/provinceSession') !!}",
                  data:{
                      _token : "{{ csrf_token() }}",
                  },
                  success: function(data)
                  {
                      // console.log(data);
                      var opt = '<option>-</option>';
                      var op = '<option>-</option>';
                      for(var i=0; i< data.length;i++)
                      {
                          opt = opt + '<option value="'+data[i].province_en+'">'+data[i].province_th+' | '+data[i].province_en+'</option>';
                      }
                      //console.log(opt);
                      $("#province_"+(ID)+"").append(opt);

                      $("#district_"+(ID)+"").empty();
                      $("#subdistrict_"+(ID)+"").empty();
                      $("#zipcode_"+(ID)+"").empty();

                      $("#zipcode_"+(ID)+"").append(op);
                      $("#district_"+(ID)+"").append(op);
                      $("#subdistrict_"+(ID)+"").append(op);
                  }
              });

              $("#province_"+(ID)+"").select2();

          }
          function district(elem)
          {
              var getID = $(elem).attr("id");
              var ID = getID.split("_")[1];
              //alert(ID);
              //console.log(ID);
              var province_id = $(elem).val();
              //alert(province_id);
              // console.log(province_id);
              $.ajax({
                  type:'POST',
                  url: "{!! URL::to('/district') !!}",
                  data:{
                      _token : "{{ csrf_token() }}",
                      province : ''+province_id ,
                  },
                  success: function(data)
                  {
                      var op = '<option>-</option>';
                      var opt = '<option>-</option>';

                      for(var i=0; i< data.length;i++)
                      {
                          opt = opt + '<option value="'+data[i].district_en+'">'+data[i].district_th+' | '+data[i].district_en+'</option>';
                      }
                      //  console.log(opt);
                      $("#zipcode_"+(ID)+"").empty();
                      $("#district_"+(ID)+"").empty();
                      $("#subdistrict_"+(ID)+"").empty();
                      $("#zipcode_"+(ID)+"").append(op);
                      $("#district_"+(ID)+"").append(opt);
                      $("#subdistrict_"+(ID)+"").append(op);
                      $("#district_"+(ID)+"").select2();

                  }
              });
          }
          function sub_district(elem)
          {

              var getID = $(elem).attr("id");
              var ID = getID.split("_")[1];
              //alert(ID);
              //console.log(ID);
              var getProvince = $("#province_"+(ID)+"").val();
              var amphur_id = $(elem).val();

              //console.log(amphur_id);
              $.ajax({
                  type:'POST',
                  url: "{!! URL::to('/sub_district') !!}",
                  data:{
                      _token : "{{ csrf_token() }}",
                      amphur_id : ''+amphur_id ,
                      getProvince : ''+getProvince ,
                  },
                  success: function(data)
                  {
                      $("#subdistrict_"+(ID)+"").empty();
                      $("#zipcode_"+(ID)+"").empty();
                      var opt = '<option>-</option>';
                      var op = '<option>-</option>';
                      for(var i=0; i< data.length;i++)
                      {
                          opt = opt + '<option value="'+data[i].sub_district_en+'">'+data[i].sub_district_th+' | '+data[i].sub_district_en+'</option>';
                      }
                      //console.log(opt);
                      $("#subdistrict_"+(ID)+"").append(opt);
                      $("#zipcode_"+(ID)+"").append(op);
                      $("#subdistrict_"+(ID)+"").select2();

                  }
              });
          }
          function zipcode(elem)
          {
              var getID = $(elem).attr("id");
              var ID = getID.split("_")[1];
              //alert(ID);
              //console.log(ID);
              var getProvince = $("#province_"+(ID)+"").val();
              var getDistrict = $("#district_"+(ID)+"").val();
              var sub_district_code = $(elem).val();
              //alert(getProvince);
              //alert(getDistrict);
              //alert(sub_district_code);
              //alert("#district_"+(ID)+"");
              //alert("#province_"+(ID)+"");
              //alert(sub_district_code);
              var zip = '';
              $("#zipcode_"+(ID)+"").empty();

              ///////////////////*************************edit          console.log(ID);
              $.ajax({
                  type:'POST',
                  url: "{!! URL::to('/zipcode') !!}",
                  data:{
                      _token : "{{ csrf_token() }}",
                      sub_district_code : ''+sub_district_code ,
                      getProvince : ''+getProvince ,
                      getDistrict : ''+getDistrict ,
                  },
                  success: function(data)
                  {
                      console.log(data.length);
                      for(var i=0; i< data.length;i++)
                      {
                          zip = '<option value="'+data[i].zipcode+'">'+data[i].zipcode+'</option>';
                      }

                      console.log(zip);
                      $("#zipcode_"+(ID)+"").append(zip);
                      //console.log($("#zipcode_"+(ID)+""));
                      //console.log(zip);
                  }


              });
          }

          function SubmitForm(){
              $('#form-create-contract').submit();
          }

          $(document).ready(function()
          {
             //Call Function Custom button (Make Button)
              Backbtn = CustomButton('button' , 'id="BacktoContractlist" type="button" onclick="window.location.href=\'/Loan/Contract\'"' , 'Cancel' , 'outline-button');
              GoCreate = CustomButton('button' , 'id="create-btn" type="button" onclick="SubmitForm();"' , 'Create' , 'gradient-button');
              //first load footer progress
              divLevel2Content = `<div class="pull-left pl-4" style="padding-bottom: 10px;">
                                      ${Backbtn}
                                  </div>
                                  <div class="pull-right pr-4" style="padding-bottom: 10px;">
                                      ${GoCreate}
                                  </div>`;
              //call footer
              FooterProgress( divLevel2Content );
              //
              // if(window.history.back() == undefined || window.history.back() == "undefined"){
              //     $("#back").attr("onclick" , window.location.href = '{{ url("Recipient")}}');
              // }
              // else{
              //    $("#back").attr("onclick" , window.history.back());
              // }
              //
              $("#back").on("click" , function(){

                  if(window.history.back() == undefined || window.history.back() == "undefined"){
                      window.location.href = '{{ url("Recipient")}}';
                  }
                  else{
                      window.history.back();
                  }
                  // console.log(window.history.back())
              });

          //get product list
          $.ajax({
              type:'POST',
              url: "{!! URL::to('/Loan/Contract/get_product_list') !!}",
              data:{
                  _token : "{{ csrf_token() }}",
              },
              success: function(data)
              {
                  var opt = '';

                  for(var i=0; i< data.length;i++)
                  {
                      opt = opt + '<option value="'+data[i].product_code+'"'
                                + 'period="'+data[i].period+'"'
                                + 'interest_rate_percent="'+data[i].interest_rate_percent+'"'
                                + '>'+data[i].product_name+'</option>';
                  }

                  $("#product").append(opt);
              }
          });

          //get recipient list
          $.ajax({
              type:'POST',
              url: "{!! URL::to('/Loan/Contract/get_recipient_list') !!}",
              data:{
                  _token : "{{ csrf_token() }}",
              },
              success: function(data)
              {
                  var opt = '';

                  for(var i=0; i< data.length;i++)
                  {
                      opt = opt + '<option value='+data[i].recipient_code+'>'+data[i].firstname_th+data[i].surname_th+'</option>';
                  }

                  $("#recipient").append(opt);
              }
          });

          });

          function calculate() {
              if($('#product').val() != '' && $('#product').val() != null){
                  var amount = $('#amount').val();
                  var period = $('option:selected', $('#product')).attr('period');
                  var interest_rate_percent = $('option:selected', $('#product')).attr('interest_rate_percent');
                  var difference = parseInt(amount) * (parseInt(interest_rate_percent) / 100);
                  var total = parseInt(amount) + parseInt(difference);
                  var mountly_installment = parseInt(total) / parseInt(period);
                  $('#period').val(period);
                  $('#interest_rate_percent').val(interest_rate_percent);
                  $('#vat').val('-');
                  $('#fee').val('-');
                  $('#difference').val(difference);
                  $('#total_amount').val(total);
                  $('#mountly_install_amount').val(mountly_installment);
                  $('#fee_percent').val(0);
                  $('#fee_amount').val(0);
              }
          }

          $("#amount").focusout(function(){
            calculate();
          });

          $("#contract_start_date").datepicker({
              changeMonth: false,
              changeYear: false,
              dateFormat: 'dd/mm/yy',
              minDate: 0, // 0 days offset = today
              onSelect: function (selected) {
                  $("#first_payment_date").datepicker("option", "minDate", selected)
              }
          }).val();
          $("#first_payment_date").datepicker({
              changeMonth: false,
              changeYear: false,
              dateFormat: 'dd/mm/yy' ,
              onSelect: function (selected) {
                  $("#contract_start_date").datepicker("option", "maxDate", selected)
                      }
          }).val();

    </script>
@endsection
