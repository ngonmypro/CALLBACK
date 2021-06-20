@extends('argon_layouts.app', ['title' => __('Line Broadcast')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Role Management</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button id="save_as_draft" type="button" class="btn btn-neutral">SAVE AS DRAFT</button>
                        <button id="send_message_now" type="button" class="btn btn-default">SEND NOW</button>
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
                                <h3 class="mb-0">{{__('role.add_new_role')}}</h3>
                                <p class="text-sm mb-0">
                                    {{__('role.role_title_description')}}
                                </p>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Product/Create') }}" method="POST" enctype="multipart/form-data" id="form-create-product">
                            {{ csrf_field() }}
                            <div class="d-flex flex-wrap mb-3">
                                <div class="p-2 flex-fill w-50">
                                    <div class="">
                                        <h4 class="mb-3 py-3 card-header-with-border">
                                            Add new broadcast
                                            <div class="float-right">

                                                
                                            </div>
                                        </h4>
                                    </div>
                                </div>

                            </div>
                            <div class="d-flex flex-column flex-wrap">
                                <div class="w-50">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class="form-control-label font-weight-bold">Recipient</label>
                                            </div>
                                            <div class="col-12 pl-5">
                                                <div class="d-flex flex-row mb-2 group-option">
                                                    <div class="col-4">
                                                        <input id="select_group" type="checkbox" name="" class="magic-checkbox select_type_recipient" data-select="group">
                                                        <label for="select_group">Group</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 pl-5">
                                                <div class="d-flex flex-row mb-2 individual-option">
                                                    <div class="col-4">
                                                        <input id="select_individual" type="checkbox" name="" class="magic-checkbox select_type_recipient" data-select="individual">
                                                        <label for="select_individual">Individual</label>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-50">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="" class="form-control-label font-weight-bold">Broadcast Time</label>
                                            </div>
                                            <div class="col-12 pl-5">
                                                <input id="send_now" type="radio" name="broadcast_time" class="magic-radio">
                                                <label for="send_now">Send Now</label>
                                            </div>
                                            <div class="col-12 pl-5">
                                                <div class="d-flex flex-row mb-3">
                                                    <div class="">
                                                        <input id="range_time" type="radio" name="broadcast_time" class="magic-radio">
                                                        <label for="range_time"></label>
                                                    </div>
                                                    <div class="mr-2">
                                                        <input type="text" name="daterange" id="daterange" class="form-control" autocomplete="off"
                                                        readonly="readonly" value="" placeholder="Select date"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-50 message_area">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex mb-3">
                                                            <div class="col">
                                                                <p class="font-weight-bold mb-0">Message Format</p>
                                                                <small class="text-black-50">Choose the type of image or video format you'd like to use in this ad.</small>
                                                            </div>
                                                            <div class="col-3 ml-auto">
                                                                <select id="" class="form-control border-primary content_type" onchange="SelectedContent(this)">
                                                                    <option value="1">Text</option>
                                                                    <option value="2">Image</option>
                                                                    <option value="3">Video</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex mb-3">
                                                            <div class="col">
                                                                <textarea class="form-control message-type" id=""></textarea>
                                                                <div class="float-right text-black-50">
                                                                    <span>0</span>
                                                                    <span>/</span>
                                                                    <span>50</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-50">
                                    <div class="form-group">        
                                        <div class="row">
                                            <div class="col-12">
                                                <button id="add_message_mor" type="button" class="btn btn-outline-primary">
                                                    <i class="zmdi zmdi-plus"></i>
                                                    Add more
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="{{ URL::to('/Line/Broadcas')}}" class="btn btn-warning mt-3">Cancel</a>
                                <button type="submit" class="btn btn-success mt-3">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript">
    //limit textarae charater
    var maxchars = 50;
    function SelectedRecipientGroup(state){
        var getID = $(state).attr("id");
        var getNameOption = $("#"+getID+" option:selected").text();
        var findItemLength = $(".recipient_group_selected_block").children().length;
        if($(".recipient_group_selected_block").length == 0){
            $(".recipient_group_area").append(
                '<div class="form-group">'+
                    '<div class="row">'+
                        '<div class="col-12">'+
                            '<div class="list-group recipient_group_selected_block">'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        }
        

        $(".recipient_group_selected_block").append(
            '<button type="button" class="list-group-item list-group-item-action select-item">'+
                '<div class="float-left">'+
                    // '<input id="recipient_'+findItemLength+'" type="checkbox" name="recipient_'+findItemLength+'" class="magic-checkbox recipient_selected" checked>'+
                    '<label class="mb-0" for="recipient_'+findItemLength+'">'+getNameOption+'</label>'+
                '</div>'+
                '<div class="float-right">'+
                    '<i class="zmdi zmdi-delete del-group text-danger" style="font-size:22px;"></i>'+
                '</div>'+
            '</button>'
        );

        $("#"+getID+" option:selected").remove();

        $("#"+getID+"").prop("selectedIndex", 0);
    }

    function SelectedContent(state){
        var getID = $(state).attr("id");
        var getNameOption = $("#"+getID+" option:selected").text();
        //remove append prevent duplicate element
        $(state).closest(".card-body").children(":last-child").remove();

        if($(state).val() == "1" || getNameOption == "Text"){
            $(state).closest(".card-body").append(
                '<div class="d-flex mb-3">'+
                    '<div class="col">'+
                        '<textarea class="form-control message-type" id=""></textarea>'+
                        '<div class="float-right text-black-50">'+
                            '<span>0</span>'+
                            '<span>/</span>'+
                            '<span>'+maxchars+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
            
        }
        else if($(state).val() == "2" || getNameOption == "Image"){
            $(state).closest(".card-body").append(
                '<div class="d-flex mb-3">'+
                    '<div class="col-12">'+
                        '<div class="form-group">'+      
                            '<div class="row">'+
                                '<div class="col-12">'+
                                    '<input type="file" accept="image/*" onchange="loadFile(event)">'+
                                '</div>'+
                                '<div class="col-12 d-none">'+
                                    '<img id="output" class="img-fluid"/>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        }
        else if($(state).val() == "3" || getNameOption == "Video"){
            $(state).closest(".card-body").append(
                '<div class="d-flex mb-3">'+
                    '<div class="col-12">'+
                        '<div class="form-group">'+      
                            '<div class="row">'+
                                '<div class="col-12">'+
                                    '<input type="file" name="file[]" class="file_multi_video" accept="video/*">'+
                                '</div>'+
                                '<div class="col-12 video-preview d-none">'+
                                    '<video width="400" controls>'+
                                      '<source src="" id="video_here">'+
                                        'Your browser does not support HTML5 video.'+
                                    '</video>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        }
    }
    //read image preview
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        $("#output").parent().removeClass("d-none");
        reader.readAsDataURL(event.target.files[0]);
    };
    //read video preview
    $(document).on("change", ".file_multi_video", function(evt) {
        var $source = $('#video_here');
        $source[0].src = URL.createObjectURL(this.files[0]);
        $source.parent()[0].load();

        $(".video-preview").removeClass("d-none");
    });
    $(document).ready(function(){
        //limit textarae charater
        $(document).on("keyup", "textarea.message-type" ,function () {
            var tlength = $(this).val().length;
            $(this).val($(this).val().substring(0, maxchars));
            var tlength = $(this).val().length;
            remain = maxchars - parseInt(tlength);

            console.log( $(this).next().find("span:first-child"));
            console.log($(this).next().find("span:last-child"));
            $(this).next().find("span:first-child").text(tlength);
            $(this).next().find("span:last-child").text(maxchars);
        });
        //daterange
        $('input[name="daterange"] , [name="daterange"]').daterangepicker({
            startDate: moment() ,
            endDate: moment() ,
            // autoUpdateInput: false,
            timePicker: true,
            dateLimit: {
                "months": 1
            },

            timePickerIncrement: 30,
            timePicker24Hour: true,
            locale: {
                format: 'DD/MM/YYYY'
            }

        }, function (start, end) {
            $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
            $('#report_list').DataTable().ajax.reload();
                // table.draw();
        });

        //change the selected date range of that picker
        $('input[name="daterange"]').data('daterangepicker').setStartDate(moment().subtract(6, 'days'));
        $('input[name="daterange"]').data('daterangepicker').setEndDate(moment());

           
            $(document).on("click" , ".del-recipient" , function(){
                var getText = $(this).parents().closest(".list-group-item-action").find("label").text();
                $(this).parents().closest(".list-group-item-action").remove();

                $("#recipient_list").append(
                    '<option value="'+getText+'">'+getText+'</option>'
                );

                //refresh
                $("#recipient_list").select2('close');
            });

            $(document).on("click" , ".del-group" , function(){
                var getText = $(this).parents().closest(".list-group-item-action").find("label").text();
                $(this).parents().closest(".list-group-item-action").remove();

                $("#recipient_group_list").append(
                    '<option value="'+getText+'">'+getText+'</option>'
                );

                //refresh
                $("#recipient_group_list").select2('close');
            });

            //add message more
            $(document).on("click" , "#add_message_mor" , function(){
                $(".message_area").append(
                    '<div class="form-group">'+        
                        '<div class="row">'+
                            '<div class="col-12">'+
                                '<div class="card">'+
                                    '<div class="card-body">'+
                                        '<div class="d-flex mb-3">'+
                                            '<div class="col">'+
                                                '<p class="font-weight-bold mb-0">Message Format</p>'+
                                                '<small class="text-black-50">'+
                                                    'Choose the type of image or video format you&lsquo;d like to use in this ad.</small>'+
                                            '</div>'+
                                            '<div class="col-3 ml-auto">'+
                                                '<select class="form-control border-primary content_type" onchange="SelectedContent(this)">'+
                                                    '<option value="text">Text</option>'+
                                                    '<option value="image">Image</option>'+
                                                    '<option value="video">Video</option>'+
                                                '</select>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="d-flex mb-3">'+
                                            '<div class="col">'+
                                                '<textarea class="form-control message-type" id=""></textarea>'+
                                                '<div class="float-right text-black-50">'+
                                                    '<span>0</span>'+
                                                    '<span>/</span>'+
                                                    '<span>'+maxchars+'</span>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                );
            });
            $(document).on("click" , ".select_type_recipient" , function(){
                var elem = $(this);
                var getDATA = $(this).data("select");
                if(getDATA == "group"){
                    if($(this).is(":checked") == false){
                        $(this).parents().closest(".flex-row").find("div.col-8").remove();
                    }
                    else{
                        $(this).parents().eq(1).append(
                            '<div class="col-8 px-3">'+
                                '<select id="recipient_group_list" class="recipient_group_list form-control" multiple="multiple">'+
                                    '<option>กลุ่ม A</option>'+
                                    '<option>กลุ่ม B</option>'+
                                    '<option>กลุ่ม C</option>'+
                                    '<option>กลุ่ม D</option>'+
                                    '<option>กลุ่ม E</option>'+
                                    '<option>กลุ่ม E1</option>'+
                                    '<option>กลุ่ม E2</option>'+
                                    '<option>กลุ่ม E3</option>'+
                                    '<option>กลุ่ม E4</option>'+
                                    '<option>กลุ่ม E5</option>'+
                                    '<option>กลุ่ม E6</option>'+
                                '</select>'+
                                '<div class="recipient_group_list-container"></div>'+
                            '</div>'
                        );
                    }
                    //generate select2 tag
                     TagSelect2MutiCustom("recipient_group_list");
                }
                else if(getDATA == "individual"){
                    if($(this).is(":checked") == false){
                        $(this).parents().closest(".flex-row").find("div.col-8").remove();
                    }
                    else{
                        $(this).parents().eq(1).append(
                            '<div class="col-8 px-3">'+
                                '<select id="recipient_list" class="recipient_list form-control" multiple="multiple">'+
                                    '<option>นาย A</option>'+
                                    '<option>นาย B</option>'+
                                    '<option>นาย 1</option>'+
                                    '<option>นาย 2</option>'+
                                    '<option>นาย 3</option>'+
                                    '<option>นาย 4</option>'+
                                    '<option>นาย 5</option>'+
                                    '<option>นาย 6</option>'+
                                    '<option>นาย 7</option>'+
                                    '<option>นาย 8</option>'+
                                    '<option>นาย 9</option>'+
                                '</select>'+
                                '<div class="recipient_list-container"></div>'+
                            '</div>'
                        );
                    }
                    //generate select2 tag
                     TagSelect2MutiCustom("recipient_list");
                   
                }
                
            });
            function TagSelect2MutiCustom(id){
                //alert(id)
                $("#"+id).select2({
                    tags: true,
                    multiple:true,
                    allowClear: true,
                  }).on('change', function() {
                    //console.log("value = " + $(this).val() );
                    var $selected = $(this).find('option:selected');
                    var $container = $(this).siblings('.'+id+'-container');

                    var $list = $('<ul class="list-inline">');
                    $selected.each(function(k, v) {
                      var $li = $('<li class="tag-selected list-inline-item text-primary" title="'+$(v).text()+'">' + $(v).text() + '<a class="destroy-tag-selected" data-target="'+id+'"><i class="zmdi zmdi-close text-primary ml-2"></i></a></li>');
                      $list.append($li);
                    });
                    $container.html('').append($list);
                  }).trigger('change');

            }
            // $(document).on('change', '#recipient_list' ,function() {
            //     var $selected = $(this).find('option:selected');
            //     var $container = $(this).parents().eq(1).find('.recipient_list-selected');

            //     var $list = $('<ul class="list-inline">');
            //     $selected.each(function(k, v) {
            //        var $li = $('<li class="list-inline-item select2-selection__choice" title="'+$(v).text()+'"><a class="destroy-tag-selected">×</a>' + $(v).text() + '</li>');
            //        $list.append($li);
            //     });
            //     $container.html('').append($list);
            // })
            // $(document).on('select2:select', '#recipient_list' , function( event ) {
            //     var data = event.params.data;
            //     //data ex ["orange", "white"];
            //     console.log($(this).val());
            //     console.log($(this));

            // });
            //remove Custom Tags
            $(document).on("click" , ".destroy-tag-selected" , function(){
                var targetData = $(this).data("target");
                //alert(targetData)
                var findText = $(this).parents().closest(".tag-selected").attr("title");
                //alert(findText)
                $('.select2-selection__choice').each(function (index) { 
                    console.log($(this).attr("title"))
                    if ($(this).attr("title") == findText) { 
                        $(this).remove(); 
                    } 
                });
                //remove custom tags
                 $(this).parents().closest(".tag-selected").remove();

                 var y = $("#"+targetData).val();
                var remove_Item = findText;

                console.log('Array before removing the element = '+y);
                y = $.grep(y, function(value) {
                  return value != remove_Item;
                });
                console.log('Array after removing the element = '+y);
                //reset select2
                $("#"+targetData).val(y).trigger("change"); 
            });
            //validate send
            $(document).on("click" , "#send_message_now" , function(){
                

                if($(".select_type_recipient:checked").length == 0){
                    $(".select_type_recipient").closest(".w-50").addClass("border border-danger");
                }
                else{
                    $(".select_type_recipient").closest(".w-50").removeClass("border border-danger");
                    console.log($("#recipient_group_list").val().length);
                    if($("#select_group").is(":checked") == true){
                        if($("#recipient_group_list").val().length == 0){
                            $("#recipient_group_list").next().find(".select2-selection--multiple").addClass("border border-danger");
                        }
                        else{
                            $("#recipient_group_list").next().find(".select2-selection--multiple").removeClass("border border-danger");
                        }
                    }
                    if($("#select_individual").is(":checked") == true){
                        if($("#recipient_list").val().length == 0){
                            $("#recipient_list").next().find(".select2-selection--multiple").addClass("border border-danger");
                        }
                        else{
                            $("#recipient_list").next().find(".select2-selection--multiple").removeClass("border border-danger");
                        }
                    }
                    
                }

                if($("input[name='broadcast_time']:checked").length == 0){
                    $("input[name='broadcast_time']").closest(".w-50").addClass("border border-danger");
                }
                else{
                    $("input[name='broadcast_time']").closest(".w-50").removeClass("border border-danger");
                }
                if($(".message_area").children().length > 0){
                    $(".message_area").children().each(function(){
                        //alert("++++ " + $(".message_area").children().length)
                        console.log($(this).find("select.content_type option:selected").eq())
                        if($(this).find(".message-type").val().length == 0){
                            //alert("++++ " + $(".message_area").children().find(".message-type").val().length)
                           $(this).find(".message-type").addClass("border border-danger");
                        }
                        else{
                            //alert("++++ " + $(".message_area").children().find(".message-type").val().length)
                            $(this).find(".message-type").removeClass("border border-danger");
                        }      
                    });
                }
                else{

                }
                
            });
    }); 
</script>
@endsection

