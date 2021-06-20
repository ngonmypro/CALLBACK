@extends('layouts.master')
@section('title', 'Create Mapping Field')
@section('style')
    <style type="text/css">
        td:hover{
            cursor:move;
        }
    </style>
@endsection

@section('content')
<input type="hidden" name="breadcrumb-title" value="{{__('fieldmapping.create_mapping_field')}}">
 
<div class="col-12">
    <div class="row justify-content-center">
        <div class="col-10">
            <form id="form_create" action="{{ url('FieldMapping/Create') }}" method="POST" class="form" >
                
                {!! csrf_field() !!}

                <div class="form-group">        
                    <div class="row">
                        <div class="col">
                            <div class="card py-0 border-0">
                                <div class="card-body border-0">
                                    <div class="row mx-0">
                                        <div class="col px-0">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <label class="col-form-label px-3">#</label>
                                                </li>
                                                <li class="list-inline-item">        
                                                    <label class="col-form-label px-3">{{__('fieldmapping.format_name')}}</label>
                                                </li>
                                            </ul> 
                                        </div>
                                        <div class="col px-0">
                                           <input type="text" name="mapping_name" class="form-control">
                                            <input type="hidden" name="document_type" value="{{ session('document_type') }}" />
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group"> 
                          
                    <div class="row">
                        <div class="col">
                            <div class="card py-0 border-0">
                                <div class="card-body border-0">
                                    <h4 class="px-3 pt-3">{{__('fieldmapping.please_select_data_field')}}</h4>
                                    <table id="mapping_table" class="table table-striped mb-0 dragtable">
                                        <thead>
                                            <tr>
                                                <th class="draggable">#</th>
                                                <th class="draggable">{{__('fieldmapping.system_field')}}</th>
                                                <th class="draggable">{{__('fieldmapping.your_field')}}</th>
                                                <th class="draggable"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($systemField as $k => $v)
                                                <tr>
                                                    <td class="index">
                                                        <span>{{ $k+1 }}</span>
                                                        <input type="hidden" name="mapping[{{$k}}][order]" value="{{ $k+1 }}">
                                                    </td>
                                                    <td class="inputSysKey">
                                                        {{ $v->field_name }}
                                                        <input type="hidden" name="mapping[{{$k}}][system_key]" value="{{ $v->field_name }}">
                                                    </td>
                                                    <td>
                                                        <select class="user-key form-control" name="mapping[{{$k}}][user_key]">
                                                        <option disabled>{{__('fieldmapping.please_select')}}</option>
                                                            @foreach($userField as $i => $o)
                                                                <option value="{{$o}}" {{$o === $v->field_name ? 'selected' : '' }}>{{$o}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-center py-2 mt-4" style="border:3px dashed #ddd;">
                                                    <button onclick="addRows()" type="button" class="btn btn-link pt-0 text-uppercase" style="text-decoration: none;">
                                                        <i class="zmdi zmdi-plus pr-2 font21px align-top"></i><span>{{__('fieldmapping.add_new_field')}}</span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="form-group">
                    @include('layouts.footer_progress')
                    <!-- <div class="text-right">
                        <button type="button" onclick="submitForm()" class="btn btn-primary text-capitalize">{{__('common.create')}}</button>
                    </div> -->
                </div>
                
            </form>
        </div>
    </div>
    

</div>
@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
    
   
    <script type="text/javascript" src="{{ asset('assets/js/bootbox.all.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\MappingFieldRequest') !!}
    <script type="text/javascript">
    cacel_btn = CustomButton('button' , 'type="button" onclick="cancelProfile()"' , '{{__("common.cancel")}}' , 'outline-button');
    next_btn  = CustomButton('button' , 'type="button" onclick="submitForm()"' , '{{__("common.create")}}' , 'gradient-button');

    divLevel2Content = `<div class="col-12 py-3">
                            <div class="pull-left pl-4" style="padding-bottom: 10px;">
                               ${cacel_btn}
                            </div>
                            <div class="pull-right pr-4" style="padding-bottom: 10px;">
                                ${next_btn}
                            </div>
                        </div>`;
                        
    FooterProgress( divLevel2Content);
    const cancelProfile = () => {
        bootbox.confirm({
                title: '<h2 class="template-text">{{__("common.confirm_cancel")}}</h2>',
                message: '{{__("common.confirm_cancel_message")}}',
                buttons: {
                    confirm: {
                        label: '{{__("common.confirm")}}',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: '{{__("common.cancel")}}',
                        className: 'btn-outline-primary'
                    }
                },
                callback: function (result) {
                    // console.log(result)

                    $('.bootbox.modal').modal('hide')
                    // $('.modal').modal('hide')
                    
                    if (result == true) {
                        // window.history.back()
                        window.location.href= '{{ url("/FieldMapping")}}';
                    }
                }
            });   
    }
    var fixHelperModified = function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
            $(this).width($originals.eq(index).width())
        });
        return $helper;
    },
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).find('span').html(i+1);
            $(this).find('input').val(i+1);
        });
    };

    $("#mapping_table tbody").sortable({
        helper: fixHelperModified,
        stop: updateIndex
    }).disableSelection();
    
    $("tbody").sortable({
        distance: 5,
        delay: 100,
        opacity: 0.6,
        cursor: 'move',
        update: function() {}
    });

    function addRows()
    {
        var index = parseInt($('#mapping_table tbody tr').length);
        var next  = index+1;

        var html = '<tr class="ui-sortable-handle">'+
                        '<td class="index">'+
                            '<span>'+next+'</span>'+
                            '<input type="hidden" name="mapping['+index+'][order]" value="'+next+'">'+
                        '</td>'+
                        '<td class="inputSysKey">'+
                            '<input class="form-control input-system_key" type="text" name="mapping['+index+'][system_key]">'+
                        '</td>'+
                        '<td>'+
                            '<select class="user-key form-control is-invalid" name="mapping['+index+'][user_key]" onchange="select_validate(this)">'+
                            '<option disabled selected>{{__('fieldmapping.please_select')}}</option>'+
                                @foreach($userField as $i => $o)
                                    '<option value="{{ $o }}">{{ $o }}</option>'+
                                @endforeach
                            '</select>'+
                        '</td>'+
                        '<td>'+
                            '<span class="zmdi zmdi-delete pt-1 del-icon in-field" onclick="deleteField(this)"></span>'+
                        '</td>'+
                    '</tr>';

        $("#mapping_table tbody").append(html);

        $('input.input-system_key').each(function() {
            $(this).rules("add", 
                {
                    required: true
                })
        }); 

        $('#form_create').validate();
    }

    function deleteField(elem_this) {
        $(elem_this).closest("tr").remove();
    }

    function ajaxSubmit()
    {
        $('#form_create').ajaxSubmit({
            success:  function(response) {
                console.log(response)
                if(response.success == true)
                {
                    bootbox.alert("สร้าง Mapping Field สำเร็จ", function(){ 
                        console.log('This was logged in the callback!'); 
                    });
                    window.location = "{{ url('/FieldMapping') }}";
                }
                else
                {
                    bootbox.alert(response.message);
                }
            }
        });
    }

    function submitForm()
    {
        if($('#form_create').valid()) {
            bootbox.confirm("{{__('common.confirm_create_title')}}", function(result){ 
                if(result == true) {
                    ajaxSubmit(); 
                }
            });
        }
    }
    function select_validate(elem)
    {
        var data = $(elem).val();
        if(data != undefined && data != "")
        {
            $(elem).removeClass('is-invalid');
            $(elem).addClass('is-valid');
        }
    }

    </script>
@endsection