@extends('layouts.master')
@section('title', 'Recipient Group')
@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<style type="text/css">
	.item--group{
		width: 10rem;
		border-radius: 10px;
		-webkit-box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
		-moz-box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
		box-shadow: 2px 2px 16px -2px rgba(133,131,133,1);
	}
	.item--group .item--inner{
		min-height:8rem;
	}

</style> 
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{ (__('recipient.group.create_title')) }}">
<div class="col-12">
    <form action="{{ url('Recipient/Group/Create/RecipientGroup')}}" method="post" enctype="multipart/form-data" id="form-create-group">
        {{ csrf_field() }}
        <div class="d-flex content-highlight">
            <hr class="vertical-line-content">
            <div class="py-2 pl-0 pr-2">
                
            </div>
            <div class="p-2 flex-shrink-1 w-100">
                
                <div class="col-lg-12 p-1">
                    <div class="card">
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3 card-header-with-border">
								{{ (__('recipient.group.recipient_group')) }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.group_name_en')) }} <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" id="group_name" name="group_name" placeholder="" class="form-control select-append"  data-spec="name" onkeypress = "return isEnglishData(event)" required> 
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.description')) }} <span class="text-danger"></span></label>
                                        </div>
                                        <div class="col-12">
  											<textarea class="form-control rounded-0" id="description" name="description" rows="5"></textarea>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.select_recipient')) }} <span class="text-danger">*</span></span></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <section class="recipient-main-block">
                                                <div class="recipient-info">
                                                    <table class="w-100 ">
                                                        <tr>
                                                            <td >
                                                                <select class="form-control select-append select_recipient"  style="width:100%;" id="select_recipient_1" name="select_recipient[1]">
                                                                </select>
                                                            </td>
                                                            
                                                            <td style="width:5%;">
                                                                <!-- <a class="cancelrecipient"><i class="zmdi zmdi-delete"></i></a> -->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                                <button id="addmore_recipient" type="button" class="addmore_recipient btn btn-link" data-type="recipient">
                                                    <div class="d-inline-block position-relative pull-left">
                                                        <div class="d-inline-block position-relative">
                                                            <i class="zmdi zmdi-plus-circle-o" style="font-size: 24px;color: #4272D7;"></i>
                                                        </div>
                                                        <div class="d-inline-block align-top">
                                                            <p class="pl-2" style="color: #4272D7;">{{ (__('recipient.group.add_more')) }}</p>
                                                        </div>
                                                    </div>
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
						</div>
					</div>
				</div>
			</div>
			<div class="p-2 flex-fill w-50">
				<div class="form-group">        
					<div class="row">
						<div class="col-12 text-right">
							<button type="button" class="btn btn-print col-4" id="create" onclick="formSubmit()"  style="width:100%;">
								{{ (__('recipient.group.create')) }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

	
                 
    </form>
@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var CountLengthrecipient =  $(".recipient-info").length; 
        $(document).on("click" , ".select_recipient",function(){
            var elem = $(this);
           $.ajax({
               type:'POST',
               url: "{!! URL::to('Recipient/Group/Select') !!}",
               data:{
                   _token : "{{ csrf_token() }}"
               },
               success: function(data)
               {
                    var opt = '';
                    for(var i=0; i< data.length;i++)
                    {
                        opt = opt + '<option value="'+data[i]['id']+'">'+data[i]['full_name']+'</option>';
                    }
                   elem.append(opt);
               }
           });
           elem.select2();
        elem.removeClass("border-danger");
        elem.addClass("border-success");
       });	
    });
    
    ////validater
    $("#group_name").on("focusout" , function(){
        var name = $("#group_name").val();
        if(name !== '')
        {
            $("#group_name").removeClass("border-danger");
            $("#group_name").addClass("border-success");
        }
        else
        {
            $("#group_name").removeClass("border-success");
            $("#group_name").addClass("border-danger");
        }
    });
    $("#description").on("focusout" , function(){
        var name = $("#description").val();
        if(name !== '')
        {
            $("#description").removeClass("border-danger");
            $("#description").addClass("border-success");
        }
        else
        {
            $("#description").removeClass("border-success");
            $("#description").addClass("border-danger");
        }
    });

	////////addmoreRecipient
    $(document).on("click" , ".addmore_recipient" ,function(){
        var elem = $(this);
        var CountRecipient =  $(".recipient-info").length+1;
            elem.parents().eq(5).find(".recipient-main-block").append(
                                            '<div class="recipient-info">'+
                                                '<table class="w-100 ">'+
                                                    '<tr>'+
                                                        '<td>'+
                                                            '<select class="form-control select-append select_recipient"  style="width:100%;" id="select_recipient_'+CountRecipient+'" name="select_recipient['+CountRecipient+']">'+
                                                            '</select>'+
                                                        '</td>'+
                                                        '<td class="text-center" style="width:5%;">'+
                                                            '<a class="cancelRecipient"><i class="zmdi zmdi-delete"></i></a>'+
                                                        '</td>'+
                                                    '</tr>'+
                                                '</table>'+
                                            '</div>'
			);
	});

	//cancelrecipient
    $(document).on("click" , ".cancelRecipient" , function(){
        var elem = $(this);
        $(this).parents().eq(4).remove();
        $(".recipient-info").each(function(index){
            $(this).find("select").attr("id" , "select_recipient_"+(index+1)+"");
        });
	});

	//Submit
	function formSubmit(){
        var name = $("#group_name").val();
        var des = $("#description").val();
        var select = $('.select_recipient').val();
        // alert(select)
        if(name == '')
        {
            $("#group_name").removeClass("border-success");
            $("#group_name").addClass("border-danger");
        }
        if(des == '')
        {
            $("#description").removeClass("border-success");
            $("#description").addClass("border-danger");
        }
        if(select === null)
        {
            $(".select_recipient").removeClass("border-success");
            $(".select_recipient").addClass("border-danger");
        }
        var $elements = $('.select_recipient');
        $elements.removeClass('border-danger').each(function () {
            var selectedValue = this.value;

            $elements.not(this).filter(function() {
                    return this.value == selectedValue;
                }).addClass('border-danger');
        });
        bootbox.confirm("ต้องการที่จะสร้างกลุ่มใหม่ใช่หรือไม่ ?", function(result){ 
            if(result == true)
            {
                if($("body").find(".border-danger").length == 0)
                {
                    $('#form-create-group').submit();
                }
                else
                {
                    OpenAlertModal('', '<h3 class="template-color text-center">{{ (__('recipient.group.message_1')) }}</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">{{ (__('recipient.group.close')) }}</button>');
                }
            }
        });
    }
    
    $('#form-create-group').submit(function() {
        $(this).ajaxSubmit({
            error: function(data) {
            },
            success:function(data){
                if (data.success == true)
                {
                    window.location.href = '{{ url("Recipient/Group")}}';
                }
                else
                {
                    if (data.data == 'name')
                    {
                        OpenAlertModal('', '<h3 class="template-color text-center">'+data.massage+'</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                        $("#group_name").removeClass("border-success");
                        $("#group_name").addClass("border-danger");
                    }
                    else
                    {
                        OpenAlertModal('', '<h3 class="template-color text-center">'+data.massage+'</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">Close</button>');
                    }
                }
            }
        });
        return false;
    });
 
</script>
@endsection
