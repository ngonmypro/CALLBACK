@extends('visaregis_layouts.app', ['title' => __('Bill')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    
    <style type="text/css">
        a {
            text-decoration: none;
            color: inherit;
        },

        body {
  font-family: Arial, sans-serif;
  background: url(http://www.shukatsu-note.com/wp-content/uploads/2014/12/computer-564136_1280.jpg) no-repeat;
  background-size: cover;
  height: 100vh;
}

.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}

.popup {
  margin: 70px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
  transition: all 5s ease-in-out;
}

.popup h2 {
  margin-top: 0;
  color: #333;
  font-family: Tahoma, Arial, sans-serif;
}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;
}
.popup .close:hover {
  color: #06D85F;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
}

@media screen and (max-width: 700px){
  .box{
    width: 70%;
  }
  .popup{
    width: 70%;
  }
}

.img-fluid {
    width: 275px;
    height: 275px;
    object-fit: contain;
}

</style>
    </style>
@endsection

@section('content')

 <!-- https://getbootstrap.com/docs/4.0/components/modal/ -->

  

        <div class="modal fade" id="myModal" role="dialog" >
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
           
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                           <div class="row">
                               <div class="col-sm-5 text-center">
                                    <!-- <div class="col-12"> -->
                                        <img src="{{ URL::asset('assets/images/visaregis/icon_mee_thanks.png') }}" class="img-fluid" alt="...">
                                    <!-- </div> -->
                               </div>
                               <div class="col-sm-7">
                                    <div class="col-sm-12 ">
                                        สมัครร้านค้าสำเร็จ !
                                    </div>
                                    <br>
                                    <div class="col-sm-12 ">
                                        <p>ข้อมูลการสมัครของคุณจะถูกส่งไปยังอีเมลผู้ติดต่อ เจ้าหน้าที่จะติดต่อกลับเพื่อแจ้งสถานะการเปิดร้านค้า    หรือขอข้อมูลเพิ่อเติมภายใน 2 วันทำการ</p>
                                    </div>
                                    <div class="col-sm-12 ">
                                        <p> หากมีคำถามเพิ่มเติม สามารถสอบถามได้ทางเจ้าหน้าที่หมีบิล 0899235220 หรือ support.pimbill@digio.co.th</p>
                                    </div>
                                  
                                </div>
                           </div>
                       </div>        
                </div>
                <div class="modal-footer">
                    <a  class="btn btn-primary"  href="https://www.digio.co.th/meebill">ตกลง</a> 
                </div>
            </div>
            </div>
        </div>
 

@endsection

@section('script')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>


<script type="text/javascript">


      
    $("#popup1").text();
 

$(document).ready(function(){
    $("#myModal").modal()
});

 
</script>

@endsection
