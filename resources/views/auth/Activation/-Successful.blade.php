<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <title>EIPP | Activation Successful</title>

    <link href="{{ URL::asset('assets/css/frameworks/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Jquery JS-->
    <script src="{{ URL::asset('assets/js/frameworks/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap JS-->
    <script src="{{ URL::asset('assets/js/frameworks/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/frameworks/bootstrap.min.js') }}"></script>

    <script src="{{ URL::asset('assets/js/extensions/mainFunction.js') }}"></script>
    

</head>

<body>

    <section>
        <div id="global_modal_alert" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div id="global_modal_alert_header" class="modal-header">
                        
                    </div>
                    <div id="global_modal_alert_body" class="modal-body">
                        
                    </div>
                    <div id="global_modal_alert_footer" class="modal-footer justify-content-center border-0">
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>

<script>
    $(document).ready(function() {
        var body = `<div class="container-fluid py-3">
                        <div class="d-flex justify-content-center pt-4 pb-3">
                            <div class="">
                                <img src="{{ URL::asset('assets/images/graphic_confirm.png') }}" width="350">
                                <!-- <div class="float-right">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="text-center">
                                <h5 style="color: #0065FF!important;">คุณได้ทำรายการสำเร็จ </h5>
                                <p>เราจะพาคุณไปยังหน้าหลักเพื่อเข้าสู่ระบบ</p>
                            </div>
                        </div>
                    </div>`
        OpenAlertModal("", body)

        setTimeout(() => { 
            CloseAlertModal()
        }, 2000)

        CloseModalCallback(() => {
            window.location.replace('/')
        })

    })
</script>

</html>
<!-- end document-->