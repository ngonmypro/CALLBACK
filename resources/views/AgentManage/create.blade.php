@extends('argon_layouts.app', ['title' => __('Agent Management')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Agent Management</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
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
                                <h3 class="mb-0">{{__('agents.create_new_info')}}</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form_create_bank" action="{{ url('/Manage/Agents/SubmitBank')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mx-auto">
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.name_th')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="name_th" class="form-control" name="bank_info[name_th]" value="{{ old('bank_info')['name_th'] }}" onkeypress="return isThaiData(event)" data-language="isThaiData">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.name_en')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="name_en" class="form-control" name="bank_info[name_en]" value="{{ old('bank_info')['name_en'] }}" onkeypress="return isEnglishData(event)" data-language="isEnglishData" >
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-bottom bottom-devide">
                                        </div>
                                    </section>
                                </section>
                            </div>
                            <div class="row mx-auto">
                                <div class="col-12 scedule-main-block">
                                    <h4 class="mb-3 py-3 card-header-with-border">{{__('agents.bank_admin')}}</h4>
                                </div>
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.firstname_th')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="" placeholder="" class="form-control select-append" name="admin[firstname_th]" value="{{ old('admin')['firstname_th'] }}" onkeypress="return isThaiData(event)" data-language="isThaiData">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.lastname_th')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="" placeholder="" class="form-control select-append" name="admin[lastname_th]" value="{{ old('admin')['lastname_th'] }}" onkeypress="return isThaiData(event)" data-language="isThaiData">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </section>
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.firstname_en')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="" placeholder="" name="admin[firstname_en]" class="form-control select-append" value="{{ old('admin')['firstname_en'] }}" onkeypress="return isEnglishData(event)" data-language="isEnglishData">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.lastname_en')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="" placeholder="" name="admin[lastname_en]" class="form-control select-append" value="{{ old('admin')['lastname_en'] }}" onkeypress="return isEnglishData(event)" data-language="isEnglishData">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </section>
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.email')}}<span class="text-danger">*</span></label>
                                                        <input type="email" id="email" placeholder="" name="admin[email]" class="form-control select-append" value="{{ old('admin')['email'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.phone_no')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="phone_number" placeholder="" name="admin[telephone]" class="form-control select-append" value="{{ old('admin')['telephone'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </section>
                                <!-- <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-6 px-0">
                                        <div class="scedule pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.citizen_id')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="citizen_id" placeholder="" name="admin[citizen_id]" class="form-control select-append" value="{{ old('admin')['citizen_id'] }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <hr class="border-bottom bottom-devide">
                                </section> -->
                            </div>
                            <div class="text-center">
                                <a href="{{ URL::to('/Manage/Agents/')}}" class="btn btn-warning mt-3">Cancel</a>
                                <button type="button" id="btn_submit" class="btn btn-success mt-3">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AgentRequest','#form_create_bank') !!}
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '#btn_submit', function() {
            $('form').submit()
        })

        $(document).on('click', '#cancel', function() {
            window.location.href = "{{ url('/Manage/Agents/') }}"
        })
    })
</script>
@endsection