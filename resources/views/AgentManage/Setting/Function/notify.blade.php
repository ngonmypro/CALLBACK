<style type="text/css">
    .note-toolbar .note-btn {
        color: #666;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/summernote/summernote-bs4.css') }}"/>

<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form id="notify_form" action="{{ url('Manage/Agents/Setting/Notify2') }}" method="POST" class="form"> 
                {{ csrf_field() }}

                <input type="hidden" name="bank_id" value="{{ $bank_data->bank_id}}">
                <div class="card">
                        <div class="card-body scb_credit pb-0" >
                            <div class="row"> 
                                <div class=" col-6">
                                    <div class="card mb-0">
                                 
                                        <div class="card-header">
                                            <h4 class="float-sm-left my-0 pt-2">NAME</h4>
                                            <div class="float-sm-right pt-1">
                                                <label class="custom-toggle custom-toggle-default"></label>
                                            </div>
                                        </div>

                                        <div class="card-body " style="display: ">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="">
                                        </div>

                                        <div class="card-body " style="display: ">
                                            <label>type <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="type" value="">
                                        </div>

                                        <div class="card-body " style="display: ">
                                            <label>provider <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="provider" value="">
                                        </div>
                                        <div class="card-body " style="display: ">
                                            <label>status <span class="text-danger">*</span></label>
                                                <select class="form-control" name="status">
                                                    <option value="">PLEASE SELECT</option>
                                                    <option value="INACTIVE">INACTIVE</option>
                                                    <option value="ACTIVE" >ACTIVE</option>
                                                </select>
                                    
                                        </div>
                                    </div>
                                </div>

                                <div class=" col-6">
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <h4 class="float-sm-left my-0 pt-2">CONFIG </h4>
                                            <div class="float-sm-right pt-1">
                                                <label class="custom-toggle custom-toggle-default">
                                                    <input type="checkbox" id="email_enable" class="enable-event" data-target="" name="" style="display: none">
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="{{__('common.off')}}" data-label-on="{{__('common.on')}}"></span>
                                                </label>
                                            </div>
                                        </div>


                                    
                                <div class="card-body">
                                  
                                  <div class="card email-provider" style="display: none">
                                        <div class="card-header">
                                            <h4 class="float-sm-left my-0 pt-2"></h4>
                                            <div class="float-sm-right pt-1"></div>
                                        </div>
                                        <div class="card-body group email-provider-config" >
                                            <label>Host</label>
                                            <input type="text" class="form-control" name="host" value="" placeholder="http://www.web.com">
                                        </div>
                                        <div class="card-body group email-provider-config">
                                            <label>User</label>
                                            <input type="text" class="form-control"  name="user" value="">
                                        </div>
                                        <div class="card-body group- email-provider-config" >
                                            <label>Pass</label>
                                            <input type="text" class="form-control" name="pass" value="">
                                        </div>
                                        <div class="card-body group- email-provider-config" >
                                            <label>sid</label>
                                            <input type="text" class="form-control" name="sid" value="">
                                        </div>
                                        <div class="card-body group- email-provider-config" >
                                            <label>fl</label>
                                            <input type="number" class="form-control" name="fl" value="">
                                        </div>
                                        <div class="card-body group- email-provider-config" >
                                            <label>dc</label>
                                            <input type="number" class="form-control" name="dc" value="">
                                        </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-right">
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                        </div>
                    </div>

                               
                </div>
            </div>
    </div>
            
  
        </form>
    </div>
</div>

@section('script.eipp.agent-setting.notify')
{!! JsValidator::formRequest('App\Http\Requests\AgentSettingPayment','#notify_form') !!}

<script type="text/javascript" src="{{ URL::asset('assets/summernote/summernote-bs4.js') }}"></script>

<script>

    $('#email_enable').change(function() {
        console.log('test');
        $('.email-provider').toggle();
        $('#email_tempalte').toggle();
    });

  

</script>
@endsection