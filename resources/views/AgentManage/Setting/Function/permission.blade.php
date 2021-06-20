<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">

        <div class="card">
            <div class="card-body scb_credit pb-0" >
            <form class="item-form" id="permission_form" action="{{ action('AgentManageController@postPermissions')}}" method="post" enctype="multipart/form-data">
                <div class="row"> 
                    <div class="col-lg-6 col-sm-12" >
                        <div class=" col-12">
                     
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="" class=" form-control-label">App</label>
                                    <select id="app_id" name="app_id" class="form-control">
                                        <option></option>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 d-none" id="div-agent-permission">
                        <div class=" col-12">
                            <div class="form-group">
                                <label for="" class=" form-control-label">App</label>
                                <select id="user_type" name="user_type" class="form-control">
                                        <option></option>
                                </select>
                            </div>
                        </div>
                      
                    </div>

                    <div class="col-lg-6 col-sm-12 d-none"  id="data_permission">
                        <input id="selectAll" type="checkbox"><label for='selectAll'>Select All</label>  
                    </div>

                    <div class="col-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>


                </div> 
            </form>
            </div>
        </div>

            
    </div>
</div>


@section('script.eipp.agent-setting.permission')
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AgentSettingPayment','#permission_form') !!}
<script>

    var perm = {}
    var app_id = null

    perm.ucwords = (str) => {
        return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase()
        })
    }

    perm.getPermission = (callback = null) => {

        let data = {
            _token: '{{ csrf_token() }}'
        }
       
        if ($('input[name=agent_code]').val() !== '') {
            data.agent_code = $('input[name=agent_code]').val()
        } else if ($('input[name=corp_code]').val() !== '') {
            data.corp_code = $('input[name=corp_code]').val()
        }
        data.type = $( "#user_group option:selected" ).val();

        webRequest('POST', `{{ action('AgentManageController@Permissions') }}`, data,

            function(err, result) {
            
                if (err) {
                    console.error(err)
                } else if (result.success === true) {
                    $('#loader').addClass('d-none')
                   
                    const _data = result.data

                    _data.forEach( function(element) {
                                @if( app()->getLocale() == "th" )
                                    $('#app_id').append('<option value="'+element.id+'">'+element.app_name+'</option>')
                                @else
                                    $('#app_id').append('<option value="'+element.id+'">'+element.app_name+'</option>')
                                @endif
                            })             
                } else {
                    console.error(result.message)
                }

                if (callback) {
                    callback()
                }
            }
        )
    }

    perm.init = () => {
        $('#loader').addClass('d-none')
        
        perm.getPermission(function() {
            $('#permission_list').empty()
        })
    }

    $(document).ready(function() {

    perm.init()

$(document).on('change', '#app_id', function() {
    const id = this.value
    app_id = id
    const data = {
        _token: '{{ csrf_token() }}',
        id:   id
    }

    $('#app_permission').empty();
    $('#user_type').empty();
    


   $('#permission_list').addClass('d-none');
    $('#div-agent-permission').addClass('d-none');
    $('#data_permission').addClass('d-none');



    webRequest('POST', `{{ action('AgentManageController@list_Permissions') }}`, data,
  
        function(err, result) {
            if (err) {
                console.error(err)
            } else if (!!result.success) {

                const _data = result.data


                
                $('#user_type').append('<option value=""></option>')
                _data.forEach( function(element) {
                    $('#div-agent-permission').removeClass('d-none');
                
                        @if( app()->getLocale() == "th" )
                            $('#user_type').append('<option value="'+element.user_type+'">'+element.user_type+'</option>')
                        @else
                            $('#user_type').append('<option value="'+element.user_type+'">'+element.user_type+'</option>')
                        @endif
                    })

            } else {
                console.log('error')
            }
        })


        $(document).on('change', '#user_type', function() {
            const user = this.value
            const data = {
                _token: '{{ csrf_token() }}',
                user:   user,
                app_id:  app_id
            }
            const rand = Math.floor(Math.random() * 100)
            const _rand = Math.floor(Math.random() * 1000)
          
             webRequest('POST', `{{ action('AgentManageController@getItemPermissions') }}`, data, 
             function(err, result) {
                    if (err) {
                        console.error(err)
                    } 
                    else if (!!result.success) {   
                        if(user){
                            $("#selectAll").prop("checked", false);
                            $("div").remove(".list_data");
                            const _data = result.data
                    
                        
                            $('#data_permission').removeClass('d-none');
                
                            $('#data_permission').append('<div class="list_data" id="test"><div>');
                            $('#test').append('<div class="test_'+rand+'"> <div id="getdata_'+rand+'" class="w-100">  <div><div>');
                            _data.forEach( function(element) {
                                $('#getdata_'+rand).append('<div class="row m-0 pl-5  ch-'+rand+'"> <div class="form-group"><input type="checkbox" name="permission[]" class="form-input form-check-input magic-checkbox perm-check" id="chb-'+rand+'" value="'+element.id+'"}><label class="" for="chb-'+rand+'">'+element.name+'</label></div></div>');
                            })
                        }else{
                            $('#data_permission').addClass('d-none');
                        }

                       
                    } 
                    else {
                        console.log('error')
                    }
                })
        })
      


    })



$(document).on('click', '#btn_submit', function() {
    $('form').submit()
})

$(document).on('click', '#btn_cancel', function() {
    window.location.href = "{{ action('Agent\RoleManagementController@agent_role_page_index') }}"
})

$(document).on('change', '#agent', function() {
    $('input[name=agent_code]').val($(this).val())
    $('input[name=corp_code]').val('')

    $('#permission_list').empty()
    $('#loader').removeClass('d-none')
    perm.getPermission()
})



$(document).on('change', '#corporate', function() {
    $('input[name=corp_code]').val($(this).val())
    $('input[name=agent_code]').val('')

    $('#permission_list').empty()
    $('#loader').removeClass('d-none')
    perm.getPermission()
})
})



$("#selectAll").click(function() {
    console.log('selectAll 1')
    $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
    if (!$(this).prop("checked")) {
        console.log('selectAll 2')
        $("#selectAll").prop("checked", false);
    }
});



</script>

@endsection