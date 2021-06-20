@extends('argon_layouts.app', ['title' => __('Corporate Management')])

@section('style')

    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
{{-- <style type="text/css">
    select.select2-hidden-accessible + span.invalid-feedback{
        position: absolute;
        bottom: -5px;
    }
    input[name='select_zipcode'] + span.invalid-feedback{
        position: absolute;
        bottom: -5px;
    }
    input[name='modal_branch_zipcode'] + span.invalid-feedback{
        position: absolute;
        bottom: -5px;
    }
    input[name='select_zipcode'].form-control[readonly].is-valid{
        border-color: #28a745;
        padding-right: calc(1.5em + .75rem);
        background-image:  url(/assets/images/is-valid.svg);
        background-repeat: no-repeat;
        background-position: center right calc(.375em + .1875rem);
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
</style> --}}
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('corporate.corporate_management')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right d-none">
                        @Permission(CORPORATE_MANAGEMENT.VIEW)
                        @if (isset($corp_code) && !blank($corp_code))
                            <a href="{{ url('Corporate')}}" class="btn btn-neutral" robot-test="corporate-create-back">{{__('common.back')}}</a>
                        @else
                            <a onclick="window.history.back()" class="btn btn-neutral" robot-test="corporate-create-back">{{__('common.back')}}</a>
                        @endif
                        @EndPermission
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
                                <h3 class="mb-0">{{__('corporate.corporate_management')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Corporate/Create') }}" method="post" enctype="multipart/form-data" id="form_profile">

                        {{ csrf_field() }}

                        <input type="hidden" name="is_new" id="is_new" value="true">

                        <div class="d-flex flex-wrap flex-column mb-0">
                            @if(\Session::get('user_detail')->user_type === "SYSTEM")
                                <div class="col-8 px-0">
                                    <h4 class="mb-3 py-3 card-header-with-border">{{__('corporateManagement.sponsor_bank')}}</h4>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <div id="bank_id" class="row animsition">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="bank_id" class="form-control" robot-test="corporate-create-select-agent">
                                                        <option selected="" disabled="">-- {{__('corporateManagement.sponsor_bank')}} --</option>
                                                        @if($bank_owner != null)
                                                            @foreach($bank_owner as $i => $v)
                                                                <option value="{{ $v->id }}">{{ app()->getLocale() == "th" ? $v->name_th : $v->name_en }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="w-100">
                                <div class="form-group">
                                    <div class="row mx-auto">
                                        <div class="col-8 px-0">
                                            <h4 class="mb-3 py-3 card-header-with-border">{{__('corporateManagement.corporate_group')}} {{isset(session('corporate_group')['name_en']) ? session('corporate_group')['name_en'] : ''}}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <div id="new_group" class="row animsition">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_group_name_th')}} <span class="text-danger">*</span></label>
                                                    <input type="text" id="company_th" name="group_name_th" class="form-control" value="{{ old('group_name_th') }}" robot-test="corporate-create-groupname-th">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_group_name_en')}} <span class="text-danger">*</span></label>
                                                    <input type="text" id="company_en" name="group_name_en" class="form-control" value="{{ old('group_name_en') }}" robot-test="corporate-create-groupname-en">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button onclick="switchType('EXIST')" type="button" class="btn btn-link" robot-test="corporate-create-switch-to-exisiting-select">
                                                        <h4 class="py-3 font-weight-light">{{__('corporateManagement.select_existing_group')}}</h4>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        @if(old('is_new') != null)
                                        <div id="existing_group" class="row animsition" style="display:{{ old('is_new') != null && old('is_new') == 'true' || old('is_new') == 'false' ? 'none' : '' }}">
                                        
                                        @else
                                            <div id="existing_group" class="row animsition" style="display:none">
                                        @endif
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.select_existing_group')}}</label>
                                                    <select name="corporate_group_id" class="form-control select-append" robot-test="corporate-create-select-existing">
                                                        <option selected="" disabled="">-- {{__('corporateManagement.select_existing_group')}} --</option>
                                                        @if($corporate_group_list != null)
                                                            @foreach($corporate_group_list as $i => $v)
                                                                <option value="{{ $v->id }}">{{ app()->getLocale() == "th" ? $v->name_th : $v->name_en }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button onclick="switchType('NEW')"type="button" class="btn btn-link" robot-test="corporate-create-switch-to-new-select">
                                                        <h4 class="py-3 font-weight-light">{{__('corporateManagement.create_new_group')}}</h4>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap corporateBlock">
                            <div class="col-lg-8 corp_section px-0">
                                <div class="corporateItem">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4 class="mb-3 pb-3 pt-0 card-header-with-border">{{__('corporateManagement.corporate_invoice')}}</h4>
                                        </div>
                                    </div>
                                    <div class="row mx-auto">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.company_name_th')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="company_name_th"class="form-control" value="{{ old('company_name_th') }}" robot-test="corporate-create-companyname-th">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.company_name_en')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="company_name_en"class="form-control" value="{{ old('company_name_en') }}" robot-test="corporate-create-companyname-en">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.taxid')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="tax_id"class="form-control" value="{{ old('tax_id') }}" maxlength="13" robot-test="corporate-create-taxid">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.unitNo')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="branch_code"class="form-control" maxlength="5" value="{{ old('branch_code') }}" robot-test="corporate-create-unitno">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.short_name_en')}}<span class="text-danger">*</span></label>
                                                <input type="text" name="short_name_en"class="form-control" value="{{ old('short_name_en') }}" robot-test="corporate-create-shortname-en">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mx-auto">
                                        <div class="col-12 px-0">
                                            <h4 class="mb-3 py-3 card-header-with-border">{{__('corporateManagement.address')}}</h4>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.contact')}}</label>
                                                <input type="text" name="contract"class="form-control" value="{{ old('contract') }}">
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.building')}}</label>
                                                <input type="text" name="building"class="form-control" value="{{ old('building') }}" robot-test="corporate-create-building">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.house_no')}} <span class="text-danger">*</span></label>
                                                <input type="text" name="house_no"class="form-control" value="{{ old('house_no') }}" robot-test="corporate-create-house_no">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.village_no')}}</label>
                                                <input type="text" name="village_no"class="form-control" value="{{ old('village_no') }}" robot-test="corporate-create-village_no">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.village')}}</label>
                                                <input type="text" name="village"class="form-control" value="{{ old('village') }}" robot-test="corporate-create-village">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.lane')}}</label>
                                                <input type="text" name="lane"class="form-control" value="{{ old('lane') }}" robot-test="corporate-create-lane">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.road')}}</label>
                                                <input type="text" name="road"class="form-control" value="{{ old('road') }}" robot-test="corporate-create-road">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.Province')}}<span class="text-danger">*</span></label>
                                                <select class="form-control province" name="select_province" robot-test="corporate-create-provice">
                                                    @if(old('select_province'))
                                                    <option value="{{ old('select_province') }}">{{ old('select_province') }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.District')}}<span class="text-danger">*</span></label>
                                                <select class="form-control district" name="select_district" robot-test="corporate-create-district">
                                                    @if(old('select_district'))
                                                    <option value="{{ old('select_district') }}">{{ old('select_district') }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.Sub_District')}}<span class="text-danger">*</span></label>
                                                <select class="form-control sub-district" name="select_sub_district" robot-test="corporate-create-subdistrict">
                                                    @if(old('select_sub_district'))
                                                    <option value="{{ old('select_sub_district') }}">{{ old('select_sub_district') }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.Zipcode')}}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="select_zipcode" value="{{ old('select_zipcode') }}" readonly="readonly" robot-test="corporate-create-zipcode">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.Country')}}<span class="text-danger">*</span></label>
                                                <select class="form-control country-code" name="country_code" robot-test="corporate-create-countrycode">
                                                    <option value="TH">{{__('corporateManagement.thailand')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class=" form-control-label">{{__('corporateManagement.contact')}}</label>
                                                <input type="text" name="contract"class="form-control" value="{{ old('contract') }}" robot-test="corporate-create-contact">
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" name="zipcode_address" robot-test="corporate-create-zipcodeaddress">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 branch_section px-0">
                                <div class="row mx-auto">
                                    <div class="col-12 pb-4">
                                        <h4 class="mb-5 pb-3 pt-0 card-header-with-border">
                                            {{__('corporateManagement.branch')}}
                                            <div class="float-right">
                                                <button  type="button" class="btn btn-primary confirm-invoice normal pt-2 pb-2" style="margin-top: -10px;" data-toggle="modal" data-target="#AddBranchModal" data-for="create" robot-test="corporate-create-addbranch" onclick="modalBranch(this)">{{__('corporateManagement.add_branch')}}</button>
                                                <input class="branch_number" type="hidden" value='1'>
                                            </div>
                                        </h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="card border-0">
                                            <div class="card-header py-2" style="background-color: #4A4A4A;">
                                                <p class="text-white font-14px">{{__('corporateManagement.branch_no')}}</p>
                                            </div>
                                            <div class="card-body px-2">
                                                <nav class="">
                                                <input type="hidden" id="check_branch" name="count_branch_check" value="{{ old('count_branch_check') }}" />
                                                    <ul id="branch_block" class="ul-list-item-block branch_block list-unstyled">

                                                        <li id="no_branch" class="">
                                                            <div class="d-flex flex-wrap justify-content-center">
                                                                <div>
                                                                    <img src="{{ URL::asset('assets/images/Visual.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="text-center">
                                                                <p class="pt-3" style="color:#A7A7A7;">{{__('corporateManagement.no_branch')}}</p>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ URL::to('/Corporate')}}" class="btn btn-warning mt-3" robot-test="corporate-create-cancel-corporate">{{__('common.cancel')}}</a>
                            <button type="button" onclick="submitProfile()" class="btn btn-primary mt-3" robot-test="corporate-create-submit-corporate">{{__('common.create')}}</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="AddBranchModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title py-3 px-2 theme-style">{{__('corporateManagement.add_branch')}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form_branch">
                    <input type="hidden" name="modal_state" value="">
                    <input type="hidden" name="index" value="">
                    <div class="row mx-auto">
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.branch_th')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_name_th" robot-test="corporate-create-branch_name_th" id="input_branch_name_th">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.branch_en')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_name_en" robot-test="corporate-create-branch_name_en" id="input_branch_name_en">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.unitNo')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="5" name="modal_branch_code" robot-test="corporate-create-branch_code" id="input_branch_code">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.shortName')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_short_name_en" robot-test="corporate-create-branch_short_name_en" id="input_branch_short_name_en">
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-12">
                            <h4 class="py-4">{{__('corporateManagement.address')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.contact')}}</label>
                                <input type="text" class="form-control" name="modal_contact" robot-test="corporate-create-branch_contact" id="input_branch_contract">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.building')}}</label>
                                <input type="text" name="modal_building" class="form-control" robot-test="corporate-create-branch_building" id="input_branch_building">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.house_no')}}<span class="text-danger">*</span></label>
                                <input type="text" name="modal_house_no" class="form-control" robot-test="corporate-create-branch_house_no" id="input_branch_house_no">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.village_no')}}</label>
                                <input type="text" name="modal_village_no" class="form-control" robot-test="corporate-create-branch_village_no" id="input_branch_village_no">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.village')}}</label>
                                <input type="text" name="modal_village" class="form-control" robot-test="corporate-create-branch_village" id="input_branch_village">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.lane')}}</label>
                                <input type="text" name="modal_lane" class="form-control" robot-test="corporate-create-branch_lane" id="input_branch_lane">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.road')}}</label>
                                <input type="text" name="modal_road" class="form-control" robot-test="corporate-create-branch_road" id="input_branch_road">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Province')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_province"  id="branch_province" robot-test="corporate-create-branch_province">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.District')}} <span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_district"  id="branch_district" robot-test="corporate-create-branch_district">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Sub_District')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_sub_district"  id="branch_sub_district" robot-test="corporate-create-branch_subdistrict">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Zipcode')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_zipcode" readonly="readonly" robot-test="corporate-create-branch_zipcode" id="input_branch_zipcode">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('corporateManagement.close')}}</button>

                <button type="button" onclick="submitBranch(this)" id="addBranch_submit" class="btn btn-primary d-none">{{__('corporateManagement.add_branch')}}</button>

                <button type="button" onclick="editBranch(this)" id="saveBranch" class="btn btn-primary d-none">{{__('corporateManagement.save')}}</button>
            </div>
        </div>
    </div>
    </div>

    {{--Modal 3  create success --}}
    <div id="create_success_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div id="" class="modal-body border-0">
                    <div class="row">
                        <div class="col-12 text-center pt-4">
                            <i class="zmdi zmdi-check-circle" style="font-size: 7rem;color: #1151e7;"></i>
                        </div>
                        <div class="col-12 text-center pt-4 mb-3">
                            <h3 class="text-capitalize mb-0">
                                {{__('corporateManagement.create_corp')}}
                            </h3>
                            <h3 class="text-capitalize mb-0">
                                {{__('common.success')}}
                                
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CorporateCreate','#form_profile') !!}
{!! JsValidator::formRequest('App\Http\Requests\CorporateBranchCreate','#form_branch') !!}
<script type="text/javascript">


    function submitProfile()
    {
        // $('#form_profile').submit();
        //change style validate select2 same jsvalidate
        var validator = $( "#form_profile" ).validate();
        var len =
        $.map(validator.invalid, function(n, i) {
            if (i == "select_district"){
                 $('select[name="select_district"]').parent().find("span.select2-selection.select2-selection--single").addClass("is-invalid");
                 $('select[name="select_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid");
            }
            if (i == "select_sub_district"){
                 $('select[name="select_sub_district"]').parent().find("span.select2-selection.select2-selection--single").addClass("is-invalid");
                 $('select[name="select_sub_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid");
            }
            if (i == "select_province"){
                 $('select[name="select_province"]').parent().find("span.select2-selection.select2-selection--single").addClass("is-invalid");
                 $('select[name="select_province"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid");
            }
            if(i == "country_code"){
                $('select[name="country_code"]').addClass("is-invalid");
                $('select[name="country_code"]').removeClass("is-valid");
            }
            else{
                $('select[name="country_code"]').addClass("is-valid");
                $('select[name="country_code"]').removeClass("is-invalid");
            }
            return i;
        });

        $('#form_profile').submit();
    }

    function switchType()
    {
        $('#existing_group, #new_group').toggle();
        $('#is_new').val($('#is_new').val() === "true" ? "false" : "true");
        if($('#is_new').val() === "false"){
            $('#company_th').val(null);
            $('#company_en').val(null)
        }
    }

    function submitBranch()
    {
        var validator = $( "#form_branch" ).validate();

        if($('#form_branch').valid()){
            addBranch();

            if($('.branch-item').length == 0) {
                $('#no_branch').show();
            } else {
                $('#no_branch').hide();
            }

            validator.resetForm();

            clearModal();

            $('#modal_branch_name_th').removeClass('is-valid');
            $('#modal_branch_name_en').removeClass('is-valid');
            $('#modal_branch_code').removeClass('is-valid');
            $('#modal_contact').removeClass('is-valid');
            $('#modal_building').removeClass('is-valid');
            $('#modal_house_no').removeClass('is-valid');
            $('#modal_village_no').removeClass('is-valid');
            $('#modal_village').removeClass('is-valid');
            $('#modal_lane').removeClass('is-valid');
            $('#modal_road').removeClass('is-valid');
            $('#modal_branch_zipcode').removeClass('is-valid');
            $('#form_branch').trigger('reset');
            $("#branch_province").select2("val", "");
            $("#branch_district").select2("val", "");
            $("#branch_sub_district").select2("val", "");

            $('#AddBranchModal').modal('toggle');
            $('#AddBranchModal').modal('hide');
        }
    }

    function addBranch()
    {
        var current = $('.branch-item').length;
        var next = current+1;

        var modal_branch_name_th            = $('input[name="modal_branch_name_th"]').val();
        var modal_branch_name_en            = $('input[name="modal_branch_name_en"]').val();
        var modal_branch_code               = $('input[name="modal_branch_code"]').val();
        var modal_branch_short_name_en      = $('input[name="modal_branch_short_name_en"]').val();
        var modal_contact                   = $('input[name="modal_contact"]').val();
        var modal_building                  = $('input[name="modal_building"]').val();
        var modal_house_no                  = $('input[name="modal_house_no"]').val();
        var modal_village_no                = $('input[name="modal_village_no"]').val();
        var modal_village                   = $('input[name="modal_village"]').val();
        var modal_lane                      = $('input[name="modal_lane"]').val();
        var modal_road                      = $('input[name="modal_road"]').val();


        var modal_branch_province           = $('#branch_province').val();
        var modal_branch_district           = $('#branch_district').val();
        var modal_branch_sub_district       = $('#branch_sub_district').val();
        var modal_branch_country_code       = 'TH';


        var modal_branch_zipcode            = $('input[name="modal_branch_zipcode"]').val();

        var html = '<li class="branch-item" data-index="'+(next)+'">'+
                        '<div class="d-flex justify-content-between">'+
                            '<div class="">'+
                                '<div class="rounded d-inline-block">'+
                                    '<div class="d-flex justify-content-center h-100">'+
                                        '<span class="align-self-center">'+(next)+'</span>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="d-inline-block align-middle">'+
                                    '<p class="pl-4 mb-0">'+modal_branch_name_th+'</p>'+
                                    '<p class="pl-4 mb-0">'+modal_branch_name_en+'</p>'+
                                '</div>'+
                            '</div>'+
                            '<div class="align-self-center">'+
                                '<ul class="list-inline mb-0">'+
                                    '<li class="list-inline-item">'+
                                        '<i class="fas fa-trash-alt" onclick="deleteBranch('+next+')" title="Delete"></i>'+
                                    '</li>'+
                                    '<li class="list-inline-item">'+
                                        '<i class="fas fa-edit pb-0" data-index="'+next+'" onclick="modalBranch(this)" data-for="edit" title="Edit"></i>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<input type="hidden" data-name="branch_name_th" name="branch['+next+'][branch_name_th]" value="'+modal_branch_name_th+'">'+
                        '<input type="hidden" data-name="branch_name_en" name="branch['+next+'][branch_name_en]" value="'+modal_branch_name_en+'">'+
                        '<input type="hidden" data-name="branch_code" name="branch['+next+'][branch_code]" value="'+modal_branch_code+'">'+
                        '<input type="hidden" data-name="branch_short_name_en" name="branch['+next+'][branch_short_name_en]" value="'+modal_branch_short_name_en+'">'+
                        '<input type="hidden" data-name="branch_contract" name="branch['+next+'][branch_contract]" value="'+modal_contact+'">'+
                        '<input type="hidden" data-name="branch_building" name="branch['+next+'][branch_building]" value="'+modal_building+'">'+
                        '<input type="hidden" data-name="branch_house_no" name="branch['+next+'][branch_house_no]" value="'+modal_house_no+'">'+
                        '<input type="hidden" data-name="branch_village_no" name="branch['+next+'][branch_village_no]" value="'+modal_village_no+'">'+
                        '<input type="hidden" data-name="branch_village" name="branch['+next+'][branch_village]" value="'+modal_village+'">'+
                        '<input type="hidden" data-name="branch_lane" name="branch['+next+'][branch_lane]" value="'+modal_lane+'">'+
                        '<input type="hidden" data-name="branch_road" name="branch['+next+'][branch_road]" value="'+modal_road+'">'+
                        '<input type="hidden" data-name="branch_province" name="branch['+next+'][branch_province]" value="'+modal_branch_province+'">'+
                        '<input type="hidden" data-name="branch_district" name="branch['+next+'][branch_district]" value="'+modal_branch_district+'">'+
                        '<input type="hidden" data-name="branch_sub_district" name="branch['+next+'][branch_sub_district]" value="'+modal_branch_sub_district+'">'+
                        '<input type="hidden" data-name="branch_country_code" name="branch['+next+'][branch_country_code]" value="'+modal_branch_country_code+'">'+
                        '<input type="hidden" data-name="branch_zipcode" name="branch['+next+'][branch_zipcode]" value="'+modal_branch_zipcode+'">'+
                    '</li>';

        $('#branch_block').append(html);

        $('#check_branch').val(next);

        localStorage.setItem("checkbranch["+next+"]", html);
    }

    function editBranch()
    {
        if($('#form_branch').valid()) {
            var index = $('input[name="index"]').val();

            var modal_branch_name_th            = $('input[name="modal_branch_name_th"]').val();
            var modal_branch_name_en            = $('input[name="modal_branch_name_en"]').val();
            var modal_branch_code               = $('input[name="modal_branch_code"]').val();
            var modal_branch_short_name_en      = $('input[name="modal_branch_short_name_en"]').val();
            var modal_contact                   = $('input[name="modal_contact"]').val();
            var modal_building                  = $('input[name="modal_building"]').val();
            var modal_house_no                  = $('input[name="modal_house_no"]').val();
            var modal_village_no                = $('input[name="modal_village_no"]').val();
            var modal_village                   = $('input[name="modal_village"]').val();
            var modal_lane                      = $('input[name="modal_lane"]').val();
            var modal_road                      = $('input[name="modal_road"]').val();
            var modal_branch_province           = $('#branch_province').val();
            var modal_branch_district           = $('#branch_district').val();
            var modal_branch_sub_district       = $('#branch_sub_district').val();
            var modal_branch_country_code       = 'TH';
            var modal_branch_zipcode            = $('input[name="modal_branch_zipcode"]').val();

            $('.branch-item[data-index="'+index+'"]').remove();

            var html = '<li class="branch-item" data-index="'+(index)+'">'+
                            '<div class="d-flex justify-content-between">'+
                                '<div class="">'+
                                    '<div class="rounded d-inline-block">'+
                                        '<div class="d-flex justify-content-center h-100">'+
                                            '<span class="align-self-center">'+(index)+'</span>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="d-inline-block align-middle">'+
                                        '<p class="pl-4 mb-0">'+modal_branch_name_th+'</p>'+
                                        '<p class="pl-4 mb-0">'+modal_branch_name_en+'</p>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="align-self-center">'+
                                    '<ul class="list-inline mb-0">'+
                                        '<li class="list-inline-item">'+
                                            '<i class="fas fa-trash-alt" onclick="deleteBranch('+index+')" title="Delete"></i>'+
                                        '</li>'+
                                        '<li class="list-inline-item">'+
                                            '<i class="fas fa-edit pb-0" data-index="'+index+'" onclick="modalBranch(this)" data-for="edit" title="Edit"></i>'+
                                        '</li>'+
                                    '</ul>'+
                                '</div>'+
                            '</div>'+
                            '<input type="hidden" data-name="branch_name_th" name="branch['+index+'][branch_name_th]" value="'+modal_branch_name_th+'">'+
                            '<input type="hidden" data-name="branch_name_en" name="branch['+index+'][branch_name_en]" value="'+modal_branch_name_en+'">'+
                            '<input type="hidden" data-name="branch_code" name="branch['+index+'][branch_code]" value="'+modal_branch_code+'">'+
                            '<input type="hidden" data-name="branch_short_name_en" name="branch['+index+'][branch_short_name_en]" value="'+modal_branch_short_name_en+'">'+
                            '<input type="hidden" data-name="branch_contract" name="branch['+index+'][branch_contract]" value="'+modal_contact+'">'+
                            '<input type="hidden" data-name="branch_building" name="branch['+index+'][branch_building]" value="'+modal_building+'">'+
                            '<input type="hidden" data-name="branch_house_no" name="branch['+index+'][branch_house_no]" value="'+modal_house_no+'">'+
                            '<input type="hidden" data-name="branch_village_no" name="branch['+index+'][branch_village_no]" value="'+modal_village_no+'">'+
                            '<input type="hidden" data-name="branch_village" name="branch['+index+'][branch_village]" value="'+modal_village+'">'+
                            '<input type="hidden" data-name="branch_lane" name="branch['+index+'][branch_lane]" value="'+modal_lane+'">'+
                            '<input type="hidden" data-name="branch_road" name="branch['+index+'][branch_road]" value="'+modal_road+'">'+
                            '<input type="hidden" data-name="branch_province" name="branch['+index+'][branch_province]" value="'+modal_branch_province+'">'+
                            '<input type="hidden" data-name="branch_district" name="branch['+index+'][branch_district]" value="'+modal_branch_district+'">'+
                            '<input type="hidden" data-name="branch_sub_district" name="branch['+index+'][branch_sub_district]" value="'+modal_branch_sub_district+'">'+
                            '<input type="hidden" data-name="branch_country_code" name="branch['+index+'][branch_country_code]" value="'+modal_branch_country_code+'">'+
                            '<input type="hidden" data-name="branch_zipcode" name="branch['+index+'][branch_zipcode]" value="'+modal_branch_zipcode+'">'+
                        '</li>';
            $('#branch_block').append(html);
            clearModal();

            $('#input_branch_name_th').removeClass('is-valid');
            $('#input_branch_name_en').removeClass('is-valid');
            $('#input_branch_code').removeClass('is-valid');
            $('#input_branch_short_name_en').removeClass('is-valid');
            $('#input_branch_contract').removeClass('is-valid');
            $('#input_branch_building').removeClass('is-valid');
            $('#input_branch_house_no').removeClass('is-valid');
            $('#input_branch_village_no').removeClass('is-valid');
            $('#input_branch_village').removeClass('is-valid');
            $('#input_branch_lane').removeClass('is-valid');
            $('#input_branch_road').removeClass('is-valid');
            $('#modal_branch_zipcode').removeClass('is-valid');
            $('#form_branch').trigger('reset');
            $("#branch_province").select2("val", "");
            $("#branch_district").select2("val", "");
            $("#branch_sub_district").select2("val", "");

            $('#AddBranchModal').modal('toggle');
            $('#AddBranchModal').modal('hide');
        }
    }

    function deleteBranch(index) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure to remove this branch!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                    var elem = $('.branch-item[data-index="'+index+'"]').remove();
                $('#check_branch').val($('.branch-item').length);
                if($('.branch-item').length == 0) {
                    $('#no_branch').show();
                } else {
                    $('#no_branch').hide();
                }
            }
        })
    }

    function modalBranch(elem) {
        var type = $(elem).data("for");
        if(type == 'create')
        {
            $('#saveBranch').addClass('d-none');
            $('#addBranch_submit').removeClass('d-none');
            clearModal();


            $('select[name="modal_branch_province"]').val(null).trigger('change');
            $('select[name="modal_branch_district"]').val(null).trigger('change');
            $('select[name="modal_branch_sub_district"]').val(null).trigger('change');

            $('select[name="modal_branch_province"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
            $('select[name="modal_branch_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
            $('select[name="modal_branch_sub_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
        }
        else if(type == 'edit')
        {
            console.log('edit');
            $('#addBranch_submit').addClass('d-none');
            $('#saveBranch').removeClass('d-none');

            $('input[name="modal_state"]').val('edit');
            $('input[name="index"]').val($(elem).data('index'));
            $('input[name="modal_branch_zipcode"]').val($(elem).find('*[data-name="branch_zipcode"]').val());

            $(elem).closest("li.branch-item").find('input[type="hidden"]').each(function(){
                var name = $(this).data('name');
                console.log('input_'+name+' '+$(this).val());
                $('#input_'+name).val($(this).val());
            });

            var province     = $(elem).closest("li.branch-item").find('*[data-name="branch_province"]').val();
            var district     = $(elem).closest("li.branch-item").find('*[data-name="branch_district"]').val();
            var sub_district = $(elem).closest("li.branch-item").find('*[data-name="branch_sub_district"]').val();
            var zipcode      = $(elem).closest("li.branch-item").find('*[data-name="branch_zipcode"]').val();

            $('select[name="modal_branch_province"]').append(new Option(province, province, true, true)).trigger('change');
            $('select[name="modal_branch_district"]').append(new Option(district, district, true, true)).trigger('change');
            $('select[name="modal_branch_sub_district"]').append(new Option(sub_district, sub_district, true, true)).trigger('change');
            $('input[name="modal_branch_zipcode"]').val(zipcode);
        }
        $('#AddBranchModal').modal('show');
    }

    function clearModal()
    {
        $('input[name="modal_state"]').val('');
        $('input[name="index"]').val('');
        $('input[name="modal_branch_zipcode_address"]').val('');
        $('#form_branch').trigger('reset');
        // $("#branch_province").select2("val", "");
        // $("#branch_district").select2("val", "");
        // $("#branch_sub_district").select2("val", "");

        $('select[name="modal_branch_province"]').val(null).trigger('change');
        $('select[name="modal_branch_district"]').val(null).trigger('change');
        $('select[name="modal_branch_sub_district"]').val(null).trigger('change');

        $('select[name="modal_branch_province"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
        $('select[name="modal_branch_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
        $('select[name="modal_branch_sub_district"]').parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid is-invalid")
        var validator = $( "#form_branch" ).validate();
        validator.resetForm();
    }

    function select2(elem,type) {
        $(elem).select2({
            placeholder: '{{__("common.please_select_data")}}',
            ajax: {
                type: 'POST',
                url: '{{ url('/Corporate/Create/ZipcodeAddress') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        province: $('select[name="select_province"').val(),
                        district: $('select[name="select_district"').val(),
                        locale: '{{ app()->getLocale() }}',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }

    function select2Branch(elem,type) {
        $(elem).select2({
            placeholder: '{{__("common.please_select_data")}}',
            dropdownParent: $(elem).closest("div.form-group"),
            ajax: {
                type: 'POST',
                url: '{{ url('/Corporate/Create/ZipcodeAddress') }}',
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: type,
                        province: $('select[name="modal_branch_province"').val(),
                        district: $('select[name="modal_branch_district"').val(),
                        locale: '{{ app()->getLocale() }}',
                        _token: '{{ csrf_token() }}'
                    }
                  return query;
                },
                processResults: function (data) {
                  return {
                    results: data.items
                  };
                }
            }
        });
    }
    $('select').on("change.select2", function(e) {
        if($(this).val() !== null){
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");

            // $(this).parent().find(".check").attr('value',$(this).text())

            $(this).parent().find("span.select2-selection.select2-selection--single").addClass("is-valid");
            $(this).parent().find("span.select2-selection.select2-selection--single").removeClass("is-invalid")

            if($(this).parent().find("span.invalid-feedback").length != 0){
                $(this).next().text('');
            }
        }
        else{
            $(this).parent().find("span.select2-selection.select2-selection--single").removeClass("is-valid")
            $(this).parent().find("span.select2-selection.select2-selection--single").addClass("is-invalid")
            $(this).addClass("is-invalid");
            $(this).removeClass("is-valid");
        }
    });
    $('select[name="select_sub_district"]').on("change.select2", function(e) {
        if($(this).val() !== null){
            $('input[name="select_zipcode"]').addClass("is-valid");
            $('input[name="select_zipcode"]').removeClass("is-invalid");
            if($('input[name="select_zipcode"]').parent().find("span.invalid-feedback").length != 0){
                $('input[name="select_zipcode"]').next().text('');
                $('input[name="select_zipcode"]').removeClass("is-invalid");
            }
        }
        else{
            $('input[name="select_zipcode"]').removeClass("is-valid");
            $('input[name="select_zipcode"]').addClass("is-invalid");
        }
    });

    $('select[name="select_province"]').on("select2:selecting", function(e) {
        $('select[name="select_district"]').val(null).trigger('change');
        $('select[name="select_sub_district"]').val(null).trigger('change');
        $('input[name="select_zipcode"]').val(null).trigger('change');
        $('input[name="zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="select_district"]').on("select2:selecting", function(e) {
        $('select[name="select_sub_district"]').val(null).trigger('change');
        $('input[name="select_zipcode"]').val(null).trigger('change');
        $('input[name="zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="select_sub_district"]').on("select2:selecting", function(e) {
       $('input[name="select_zipcode"]').val(e.params.args.data.zipcode)
       $('input[name="zipcode_address"]').val(e.params.args.data.id)
    });

    $('select[name="modal_branch_province"]').on("select2:selecting", function(e) {
        $('select[name="modal_branch_district"]').val(null).trigger('change');
        $('select[name="modal_branch_sub_district"]').val(null).trigger('change');
        $('input[name="modal_branch_zipcode"]').val(null).trigger('change');
        $('input[name="modal_branch_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="modal_branch_district"]').on("select2:selecting", function(e) {
        $('select[name="modal_branch_sub_district"]').val(null).trigger('change');
        $('input[name="modal_branch_zipcode"]').val(null).trigger('change');
        $('input[name="modal_branch_zipcode_address"]').val(null).trigger('change');
    });
    $('select[name="modal_branch_sub_district"]').on("select2:selecting", function(e) {
       $('input[name="modal_branch_zipcode"]').val(e.params.args.data.zipcode)
       $('input[name="modal_branch_zipcode_address"]').val(e.params.args.data.id)
    });

    $(document).ready(function(){
        select2('select[name="select_province"]','province');
        select2('select[name="select_district"]','district');
        select2('select[name="select_sub_district"]','sub_district');
        select2Branch('select[name="modal_branch_province"]','province');
        select2Branch('select[name="modal_branch_district"]','district');
        select2Branch('select[name="modal_branch_sub_district"]','sub_district');

        if($('#check_branch').val() != "" && $('#check_branch').val() != 0)
        {
            var j = 0;
            var getblock=[];
            $("#branch_block").empty();
            for(var i=0 ;i < $('#check_branch').val();i++)
            {
                j = j+1;
                getblock[i] = localStorage.getItem("checkbranch["+j+"]");
                $("#branch_block").append(getblock[i]);
            }
        }

    });
</script>

@endsection
