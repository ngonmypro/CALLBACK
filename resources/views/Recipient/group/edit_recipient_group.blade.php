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
<input type="hidden" name="breadcrumb-title" value="{{ (__('recipient.group.update_title')) }}">
<div class="col-12">
    <div class="d-flex flex-wrap mb-3">
        
		<div class="ml-auto p-2 openEdit">
            <button type="button" class="btn btn-outline-primary" id="button_delete" onclick="deleteGroup()">
                {{ (__('recipient.group.delete_group')) }}
            </button>
			<button type="button" class="btn btn-primary" id="button_openEdit" onclick="openEdit()">
                {{ (__('recipient.group.edit_group')) }}
            </button>
		</div>
    </div>
</div>
<div class="col-12">
<form action="{{ url('Recipient/Group/Delete')}}" method="post" enctype="multipart/form-data" id="form-delete-group">
{{ csrf_field() }}
    <input type="hidden" id="group_id" name="group_id" value="{{ $recipient[0]->group_id }}">
</form>
    <form action="{{ url('Recipient/Group/Edit/RecipientGroup')}}" method="post" enctype="multipart/form-data" id="form-edit-group">
        {{ csrf_field() }}
        <input type="hidden" id="total_recipient" value="{{ $count }}">
        <input type="hidden" id="group_id" name="group_id" value="{{ $recipient[0]->group_id }}">
        <div class="d-flex content-highlight">
            <hr class="vertical-line-content">
            <div class="py-2 pl-0 pr-2">
                
            </div>
            <div class="p-2 flex-shrink-1 w-100" id="show_data">
                
                <div class="col-lg-12 p-1" >
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.group_name_en')) }} <span class="text-danger"></span></label>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" disabled value="{{ $recipient[0]->group_name }}" placeholder="" class="form-control select-append"  data-spec="name" > 
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.description')) }}<span class="text-danger"></span></label>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control rounded-0" disabled rows="5" >{{$recipient[0]->description}}</textarea>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.group.select_recipient')) }} <span class="text-danger"></span></span></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <section class="">
                                            @for($n=1;$n<=$count;$n++)
                                                <div class="">
                                                    <table class="w-100 ">
                                                        <tr>
                                                            <td >
                                                                <input type="text" class="form-control" value="{{$recipient[$n-1]->full_name}}" disabled>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            @endfor
                                            </section>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>

            <div class="p-2 flex-shrink-1 w-100 d-none" id="edit_data">
                
                <div class="col-lg-12 p-1" >
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
                                            <input type="text" id="group_name" name="group_name" value="{{ $recipient[0]->group_name }}" placeholder="" class="form-control select-append"  data-spec="name" onkeypress = "return isEnglishData(event)"> 
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
                                            <textarea class="form-control rounded-0" id="description" name="description" rows="5" >{{$recipient[0]->description}}</textarea>
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
						<div class="col-12">
							<button type="button" class="btn btn-print d-none" id="update" onclick="formSubmit()"  style="width:100%;">
								{{ (__('recipient.group.update')) }}
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
        var dataEdit = {!! json_encode($recipient) !!};
        var getRecipientEdit = [];
        for(var i=0;i < dataEdit.length;i++)
        {
            getRecipientEdit.push(dataEdit[i].recipient_id);
            // alert(getRecipientEdit)
        }
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
                        // console.log(data)
                        var opt = '';
                        for(var i=0; i< data.length;i++)
                        {
                            if(jQuery.inArray(data[i]['id'], getRecipientEdit) == -1)
                            {
                                opt = opt + '<option value="'+data[i]['id']+' ">'+data[i]['full_name']+'</option>';
                                // alert(opt)
                            }
                        } 
                    elem.append(opt);
                }
            });
            elem.select2();
        }); 
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
            $(this).find("select").attr("name" , "select_recipient["+(index+1)+"]");
        });
	});

	//Submit
	function formSubmit(){
        var name = $("#group_name").val();
        var des = $("#description").val();
        var select = $('.select_recipient').val();
        if(name == '')
        {
            $("#group_name").removeClass("border-success");
            $("#group_name").addClass("border-danger");
        }
        else
        {
            $("#group_name").removeClass("border-danger");
            $("#group_name").addClass("border-success");
        }
        if(des == '')
        {
            $("#description").removeClass("border-success");
            $("#description").addClass("border-danger");
        }
        else
        {
            $("#description").removeClass("border-danger");
            $("#description").addClass("border-success");
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

			 bootbox.confirm("ต้องการแก้ไขข้อมูลกลุ่มใช่หรือไม่ ?", function(result){ 
                if(result == true)
                {
                    if($("body").find(".border-danger").length == 0)
                    {
                        $('#form-edit-group').submit();
                    }
                    else{
                        OpenAlertModal('', '<h3 class="template-color text-center">{{ (__('recipient.group.message_1')) }}</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">{{ (__('recipient.group.close')) }}</button>');
                    }
                   
                }
            });
    }
    $('#form-edit-group').submit(function() {
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
    
    function openEdit()
    {
        var elem = $(this);
        elem.addClass("d-none");
        $("#show_m_name").addClass("d-none");
        $("#show_data").addClass("d-none");
        $("#button_openEdit").addClass("d-none");
        $("#button_delete").addClass("d-none");

        $("#m_name").removeClass("d-none");
        $("#edit_data").removeClass("d-none");
        $("#update").removeClass("d-none");

        var count =  {!! $count !!};
        var dataEdit = {!! json_encode($recipient) !!};
        for(var n=0;n<count;n++)
        {
            $(".recipient-main-block").append(
                                            '<div class="recipient-info">'+
                                                '<table class="w-100 ">'+
                                                    '<tr>'+
                                                        '<td>'+
                                                            '<select class="form-control select-append select_recipient"  style="width:100%;" id="select_recipient_'+(n+1)+'" name="select_recipient['+(n+1)+']">'+
                                                            '<option value="'+dataEdit[n]["recipient_id"]+'">'+dataEdit[n]["full_name"]+'</option>'+
                                                            '</select>'+
                                                        '</td>'+
                                                        '<td class="text-center" style="width:5%;">'+
                                                            '<a class="cancelRecipient"><i class="zmdi zmdi-delete"></i></a>'+
                                                        '</td>'+
                                                    '</tr>'+
                                                '</table>'+
                                            '</div>'
			);
        }      
    }
    
    //delete group
    function deleteGroup()
    {
        bootbox.confirm("{{ (__('recipient.group.delete_confirm_title')) }}", function(result){ 
            if(result == true)
            {
                bootbox.confirm("{{ (__('recipient.group.delete_confirm_message')) }}", function(result){ 
                    if(result == true)
                    {
                        $('#form-delete-group').submit();
                    }
                });
            }
        });
    }
    ///form delete
    $('#form-delete-group').submit(function() {
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
                    OpenAlertModal('', '<h3 class="template-color text-center">{{ (__('recipient.group.error_delete')) }}</h3>' , '<button type="button" class="btn btn-primary standard-danger-btn pt-2 pb-2" data-dismiss="modal">{{ (__('recipient.group.close')) }}</button>');
                }
            }
        });
        return false;
    }); 


</script>
@endsection
