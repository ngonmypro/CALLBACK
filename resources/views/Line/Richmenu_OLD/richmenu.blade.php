@extends('layouts.master')

@section('content')
<input type="hidden" name="breadcrumb-title" value="Create Rich Menu">
<div class="card">
    <div class="col-12">
    <form class="" action="{{ url('Line/Richmenu/Richmenu/Create')}}" method="post" enctype="multipart/form-data" runat="server" id="form-create">
            {{csrf_field()}}
        <div class="" id="template">
            <div class="p-2 flex-fill bd-highlight w-50">
                <div class="p-2 bd-highlight">  
                    <label>Select Template</label>
                    <!-- <div class="btn btn-secondary" id="open">Select Template</div> -->
                    <select class="form-control select-append" name="size" id="open">
                        <option value="large"> ขนาดใหญ่ </option>
                        <option value="compact"> ขนาดเล็ก</option>
                    </select>
                </div>
            </div>
        </div>
   
         <div class="d-flex bd-highlight">
            <div class="p-2 flex-fill bd-highlight w-50">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        ชื่อเมนู<input type="text" class="form-control select-append" name="richmenu_name" value="Richmenu name">
                    </div>
                    <div class="p-2 bd-highlight">
                        ชื่อแชทที่แสดงในเมนู<input type="text" class="form-control select-append" name="chatbar_name" value="chatbar name">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none" id="show_head">
            <div class="d-flex bd-highlight " >
                <div class="p-2 flex-fill bd-highlight w-50" >
                    <label for="" class="form-control-label font-weight-bold">RICHMENU IMAGE</label>
                </div>
                <div class="p-2 flex-fill bd-highlight w-50">
                    <label for="" class="form-control-label font-weight-bold">ACTION</label>
                </div>
            </div>
        </div>

        <div class="d-flex bd-highlight">
            <div class="p-2 flex-fill bd-highlight w-50">
                
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">
                            <img class="d-none" id="blah" src="#" width="90%"/>
                        </div>
                        <div class="p-2 bd-highlight" >   
                            <label>Select File for Upload</label>
                            <input type='file' id="imgInp" name="upload_image"/>
                        </div>
                        <div class="p-2 bd-highlight" >
                            <span class="text-muted">File formats: JPG, JPEG, PNG</span><br>
                            <span class="text-muted">File size: Up to 1 MB </span><br>
                            <span class="text-muted">Image sizes: 1200×810, 1200×405</span>
                        </div>
                    </div>
                
            </div>
            <div class="p-2 flex-fill bd-highlight w-50">
                <div class="d-none" id="show_action">      
                    <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 1 : </label>
                        <select class="form-control select-append" name="action[0]">
                            <option value="message">text</option>
                            <option value="uri">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[0]" value="test01">
                    </div>
                    <!-- <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 2 : </label>
                        <select class="form-control select-append" name="action[1]">
                            <option value="text">text</option>
                            <option value="url">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[1]" value="test02">
                    </div>
                    <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 3 : </label>
                        <select class="form-control select-append" name="action[2]">
                            <option value="text">text</option>
                            <option value="url">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[2]" value="test03">
                    </div>
                    <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 4 : </label>
                        <select class="form-control select-append" name="action[3]">
                            <option value="text">text</option>
                            <option value="url">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[3]" value="test04">
                    </div>
                    <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 5 : </label>
                        <select class="form-control select-append" name="action[4]">
                            <option value="text">text</option>
                            <option value="url">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[4]" value="test05">
                    </div>
                    <div class="">
                        <label for="" class="form-control-label font-weight-bold">action 6 : </label>
                        <select class="form-control select-append" name="action[5]">
                            <option value="text">text</option>
                            <option value="url">url</option>
                        </select>
                        <input type="text" class="form-control select-append" name="text_action[5]" value="test06">
                    </div> -->
                    
                    </form>
                    <div class="">
                        <div class="col-12">
                            <br><br><br>
                            <button type="button" class="btn btn-print" id="create" onclick="formSubmit()"  style="width:100%;">
                                CREATE RICHMENU
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>  
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.form.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">

    $(document).on("click" , "#open",function(){
        // $('#template').addClass('d-none');
        $('#form-create').removeClass('d-none');
    });

    $("#imgInp").change(function() {
        readURL(this);
    });
    function readURL(input) {
        if (input.files && input.files[0]) 
        {
            // var filePath = $('#imgInp').val();
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah').removeClass('d-none');
                $('#show_head').removeClass('d-none');
                $('#show_action').removeClass('d-none');
                // alert(filePath);
                // $('#image_path').attr('value',filePath);
                $('#blah').attr('src', e.target.result);
               
                
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    //Submit
    function formSubmit(){
       $('#form-create').submit();        
    }
    
    $('#form-create').submit(function() {
        $(this).ajaxSubmit({
            error: function(data) {
                alert(data.message);
            },
            success:function(data){
                if (data.success == true)
                {
                    alert(data.message);
                }
                else
                {
                    alert(data.message);
                }
            }
        });
        return false;
    });

</script>
@endsection