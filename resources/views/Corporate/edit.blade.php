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
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('corporate.corporate_edit')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right d-none">
                        <a href="{{ url('Corporate')}}" class="btn btn-neutral">{{__('common.edit')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{__('corporate.corporate_info')}}</h3>
                                <p class="text-sm mb-0">

                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Corporate/EditData') }}" method="post" enctype="multipart/form-data" id="form_profile" class="pl-1">

                            {{ csrf_field() }}


                            <input type="hidden" name="corp_code" value="{{ $data->corp_code }}">

                            <input type="hidden" name="is_new" id="is_new" value="false">

                            <div class="d-flex flex-wrap flex-column mb-3">
                                <div class="w-100">
                                    <div class="form-group">
                                        <div class="row mx-auto">
                                            <div class="col-8 px-0">
                                                <h4 class="mb-3 py-3 card-header-with-border theme-style">{{__('corporateManagement.corporate_group')}} {{session('corporate_group')['name_en']}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <div id="new_group" class="row animsition">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class=" form-control-label">{{__('corporateManagement.company_group_name_th')}} <span class="text-danger">*</span></label>
                                                        <p class="form-control-static">{{isset($data->group_name_th) ? $data->group_name_th : ''}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class=" form-control-label">{{__('corporateManagement.company_group_name_en')}} <span class="text-danger">*</span></label>
                                                        <p class="form-control-static">{{isset($data->group_name_en) ? $data->group_name_en : ''}}</p>
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
                                                <h4 class="mb-3 pb-3 pt-0 card-header-with-border theme-style">{{__('corporateManagement.corporate_invoice')}}</h4>
                                            </div>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_name_th')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="company_name_th"class="form-control" value="{{isset($data->corp_name_th) ? old('company_name_th') != null ? old('company_name_th') : $data->corp_name_th : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_name_en')}}<span class="text-danger">*</span></label>

                                                    <input type="text" name="company_name_en"class="form-control" value="{{isset($data->corp_name_en) ? old('company_name_en') != null ? old('company_name_en') : $data->corp_name_en : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.taxid')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="tax_id"class="form-control" value="{{isset($data->tax_id) ? old('tax_id') != null ? old('tax_id') : $data->tax_id : ''}}" maxlength="13">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.unitNo')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="branch_code"class="form-control" maxlength="5" value="{{isset($data->branch_code) ? old('branch_code') != null ? old('branch_code') : $data->branch_code : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.short_name_en')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="short_name_en"class="form-control" value="{{isset($data->short_name_en) ? old('short_name_en') != null ? old('short_name_en') : $data->short_name_en : ''}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-12 px-0">
                                                <h4 class="mb-3 py-3 card-header-with-border theme-style">{{__('corporateManagement.address')}}</h4>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.building')}}</label>
                                                    <input type="text" name="building"class="form-control" value="{{isset($data->building) ? old('building') != null ? old('building') : $data->building : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.house_no')}}<span class="text-danger">*</span></label>
                                                    <input type="text" name="house_no"class="form-control" value="{{isset($data->house_no) ? old('house_no') != null ? old('house_no') : $data->house_no : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.village_no')}}</label>
                                                    <input type="text" name="village_no"class="form-control" value="{{isset($data->village_no) ? old('village_no') != null ? old('village_no') : $data->village_no : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.village')}}</label>
                                                    <input type="text" name="village"class="form-control" value="{{isset($data->village) ? old('village') != null ? old('village') : $data->village : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.lane')}}</label>
                                                    <input type="text" name="lane"class="form-control" value="{{isset($data->lane) ? old('lane') != null ? old('lane') : $data->lane : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.road')}}</label>
                                                    <input type="text" name="road"class="form-control" value="{{isset($data->road) ? old('road') != null ? old('road') : $data->road : ''}}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Province')}}<span class="text-danger">*</span></label>
                                                    <select class="form-control province" name="select_province">

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.District')}}<span class="text-danger">*</span></label>
                                                    <select class="form-control district" name="select_district">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Sub_District')}}<span class="text-danger">*</span></label>
                                                    <select class="form-control sub-district" name="select_sub_district">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Zipcode')}}<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="select_zipcode" readonly="readonly" value="{{ $data->zipcode }}">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Country')}}<span class="text-danger">*</span></label>
                                                    <select class="form-control country-code" name="country_code">
                                                        <option value="TH">{{__('corporateManagement.thailand')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.contact')}}</label>
                                                    <input type="text" name="contract"class="form-control" value="{{isset($data->contract) ? old('contract') != null ? old('contract') : $data->contract : ''}}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 branch_section px-0">
                                    <div class="row mx-auto">
                                        <div class="col-12 pb-4">
                                            <h4 class="mb-5 pb-3 pt-0 card-header-with-border theme-style">
                                                {{__('corporateManagement.branch')}}
                                                <div class="float-right">
                                                    <button  type="button" class="btn btn-primary confirm-invoice normal pt-2 pb-2 theme-style" style="margin-top: -10px;" data-toggle="modal" data-target="#AddBranchModal" data-for="create" onclick="modalBranch(this)" >{{__('corporateManagement.add_branch')}}</button>
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
                                                        <ul id="branch_block_delete" class="ul-list-item-block branch_block_delete d-none">

                                                        </ul>
                                                        <ul id="branch_block" class="ul-list-item-block branch_block list-unstyled">

                                                            @if($data->branch == null)
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
                                                            @else
                                                                @foreach($data->branch as $i => $v)
                                                                <li class="branch-item theme-style" data-index="{{ $i }}">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div class="">
                                                                            <div class="rounded d-inline-block">
                                                                                <div class="d-flex justify-content-center h-100">
                                                                                    <span class="align-self-center">{{ $i+1 }}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="d-inline-block align-middle">
                                                                                <p class="pl-4 mb-0">{{ $v->corp_name_th }}</p>
                                                                                <p class="pl-4 mb-0">{{ $v->corp_name_en }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="align-self-center">
                                                                            <ul class="list-inline mb-0">
                                                                                <li class="list-inline-item">
                                                                                    <i class="fas fa-edit pb-0" data-index="{{ $i }}" onclick="modalBranch(this)" data-for="edit" title="Edit"></i>
                                                                                    <i class="fas fa-trash-alt" onclick="deleteBranch({{$i}})" title="Delete"></i>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>


                                                                    <input type="hidden" data-name="branch_info_id" name="branch[{{ $i }}][branch_info_id]" value="{{ $v->corp_info_id }}">
                                                                    <input type="hidden" data-name="branch_address_id" name="branch[{{ $i }}][branch_address_id]" value="{{ $v->corp_address_id }}">
                                                                    <input type="hidden" data-name="branch_name_th" name="branch[{{ $i }}][branch_name_th]" value="{{ $v->corp_name_th }}">
                                                                    <input type="hidden" data-name="branch_name_en" name="branch[{{ $i }}][branch_name_en]" value="{{ $v->corp_name_en }}">
                                                                    <input type="hidden" data-name="branch_code" name="branch[{{ $i }}][branch_code]" value="{{ $v->branch_code }}">
                                                                    <input type="hidden" data-name="branch_short_name_en" name="branch[{{ $i }}][branch_short_name_en]" value="{{ $v->short_name_en }}">

                                                                    <input type="hidden" data-name="branch_contract" name="branch[{{ $i }}][branch_contract]" value="{{ $v->contract }}">
                                                                    <input type="hidden" data-name="branch_building" name="branch[{{ $i }}][branch_building]" value="{{ $v->building }}">
                                                                    <input type="hidden" data-name="branch_house_no" name="branch[{{ $i }}][branch_house_no]" value="{{ $v->house_no }}">
                                                                    <input type="hidden" data-name="branch_village_no" name="branch[{{ $i }}][branch_village_no]" value="{{ $v->village_no }}">
                                                                    <input type="hidden" data-name="branch_village" name="branch[{{ $i }}][branch_village]" value="{{ $v->village }}">
                                                                    <input type="hidden" data-name="branch_lane" name="branch[{{ $i }}][branch_lane]" value="{{ $v->lane }}">
                                                                    <input type="hidden" data-name="branch_road" name="branch[{{ $i }}][branch_road]" value="{{ $v->road }}">

                                                                    @if(app()->getLocale() == 'th')
                                                                        <input type="hidden" data-name="branch_province" name="branch[{{ $i }}][branch_province]" value="{{ $v->province_th }}">
                                                                        <input type="hidden" data-name="branch_district" name="branch[{{ $i }}][branch_district]" value="{{ $v->district_th }}">
                                                                        <input type="hidden" data-name="branch_sub_district" name="branch[{{ $i }}][branch_sub_district]" value="{{ $v->sub_district_th }}">
                                                                    @else
                                                                        <input type="hidden" data-name="branch_province" name="branch[{{ $i }}][branch_province]" value="{{ $v->province_en }}">
                                                                        <input type="hidden" data-name="branch_district" name="branch[{{ $i }}][branch_district]" value="{{ $v->district_en }}">
                                                                        <input type="hidden" data-name="branch_sub_district" name="branch[{{ $i }}][branch_sub_district]" value="{{ $v->sub_district_en }}">
                                                                    @endif
                                                                    <input type="hidden" data-name="branch_zipcode" name="branch[{{ $i }}][branch_zipcode]" value="{{ $v->zipcode }}">

                                                                </li>
                                                                @endforeach
                                                            @endif

                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="{{ URL::to('/Corporate')}}" class="btn btn-warning mt-3">{{__('common.cancel')}}</a>
                                <button type="button" onclick="submitProfile()" class="btn btn-primary mt-3">{{__('common.save')}}</button>
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
                                <input type="text" class="form-control" name="modal_branch_name_th" id="input_branch_name_th">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.branch_en')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_name_en" id="input_branch_name_en">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.unitNo')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="5" name="modal_branch_code" id="input_branch_code">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.shortName')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_short_name_en" id="input_branch_short_name_en">
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
                                <input type="text" class="form-control" name="modal_branch_contract" id="input_branch_contract">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.building')}}</label>
                                <input type="text" name="modal_branch_building"class="form-control" id="input_branch_building">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.house_no')}}<span class="text-danger">*</span></label>
                                <input type="text" name="modal_branch_house_no"class="form-control" id="input_branch_house_no">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.village_no')}}</label>
                                <input type="text" name="modal_branch_village_no"class="form-control" id="input_branch_village_no">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.village')}}</label>
                                <input type="text" name="modal_branch_village"class="form-control" id="input_branch_village">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.lane')}}</label>
                                <input type="text" name="modal_branch_lane"class="form-control" id="input_branch_lane">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class=" form-control-label">{{__('corporateManagement.road')}}</label>
                                <input type="text" name="modal_branch_road"class="form-control" id="input_branch_road">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Province')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_province"  id="branch_province">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.District')}} <span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_district"  id="branch_district">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Sub_District')}}<span class="text-danger">*</span></label>
                                <select class="form-control" name="modal_branch_sub_district"  id="branch_sub_district">

                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Zipcode')}}<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="modal_branch_zipcode" readonly="readonly">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="modal_branch_zipcode">

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

@include('layouts.footer_progress')

@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/select2.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CorporateEdit','#form_profile') !!}
{!! JsValidator::formRequest('App\Http\Requests\CorporateBranchEdit','#form_branch') !!}
<script type="text/javascript">

    function submitProfile()
    {
        $('#form_profile').submit();
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

        // console.log(len)
    }


    function switchType()
    {
        $('#existing_group, #new_group').toggle();
        $('#is_new').val($('#is_new').val() === "true" ? "false" : "true");
    }
    var getButton = "";
    function submitBranch(elem_this)
    {
        if($('#form_branch').valid()) {
            // console.log("submitBranch")
            // console.log(elem_this)
            getButton = elem_this;
            // array.include('');
            var data_check =  JSON.parse('{!! json_encode($data) !!}')
            var branch_check = data_check.branch;
            var ck_branch = false;
            if(branch_check == [])
            {
                if(data_check.branch_code != $('#input_branch_code').val())
                {
                    branch_check.forEach(check_branchcode);
                branch_check.forEach(check_branchcode);
                    branch_check.forEach(check_branchcode);
                branch_check.forEach(check_branchcode);
                    branch_check.forEach(check_branchcode);
                branch_check.forEach(check_branchcode);
                    branch_check.forEach(check_branchcode);
        
                }
                else
                {
                    $('#input_branch_code').addClass('is-invalid');
                    $('#input_branch_code').removeClass('is-valid');
                }
            }
            else
            {
                $('#no_branch').hide();
                addBranch(elem_this);
            }
        }
    }

    function check_branchcode(item, index)
    {
        if(item.branch_code == $('#input_branch_code').val())
        {
            $('#input_branch_code').addClass('is-invalid');
            $('#input_branch_code').removeClass('is-valid');
        }
        else
        {
            $('#input_branch_code').addClass('is-valid');

            if($('#form_branch').valid()){
                // console.log("check_branchcode")
                // console.log(getButton)
                addBranch(getButton);



                if($('.branch-item').length == 0) {
                    $('#no_branch').show();
                } else {
                    $('#no_branch').hide();
                }
                clearModal();

                $('#input_branch_name_th').removeClass('is-valid');
                $('#input_branch_name_en').removeClass('is-valid');
                $('#input_branch_code').removeClass('is-valid');
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
                $('#AddBranchModal').modal('hide');
            }
        }
    }

    function editBranch()
    {
        if($('#form_branch').valid()){

            var index = $('input[name="index"]').val();

            var modal_branch_info_id          = $('.branch-item[data-index="'+index+'"]').find('input[data-name="branch_info_id"]').val();
            var modal_branch_address_id       = $('.branch-item[data-index="'+index+'"]').find('input[data-name="branch_address_id"]').val();
            var modal_branch_name_th          = $('input[name="modal_branch_name_th"]').val();
            var modal_branch_name_en          = $('input[name="modal_branch_name_en"]').val();
            var modal_branch_code             = $('input[name="modal_branch_code"]').val();
            var modal_branch_short_name_en    = $('input[name="modal_branch_short_name_en"]').val();
            // var modal_address_th              = $('input[name="modal_address_th"]').val();
            // var modal_address_en              = $('input[name="modal_address_en"]').val();
            var modal_branch_province           = $('#branch_province').val();
            var modal_branch_district           = $('#branch_district').val();
            var modal_branch_sub_district       = $('#branch_sub_district').val();
            var modal_branch_country_code       = 'TH';
            var modal_branch_zipcode            = $('input[name="modal_branch_zipcode"]').val();

            var modal_branch_contract               = $('input[name="modal_branch_contract"]').val();
            var modal_branch_building               = $('input[name="modal_branch_building"]').val();
            var modal_branch_house_no               = $('input[name="modal_branch_house_no"]').val();
            var modal_branch_village_no             = $('input[name="modal_branch_village_no"]').val();
            var modal_branch_village                = $('input[name="modal_branch_village"]').val();
            var modal_branch_lane                   = $('input[name="modal_branch_lane"]').val();
            var modal_branch_road                   = $('input[name="modal_branch_road"]').val();

            $('.branch-item[data-index="'+index+'"]').remove();

            var html = '<li class="branch-item" data-index="'+(index)+'">'+
                        '<div class="d-flex justify-content-between">'+
                            '<div class="">'+
                                '<div class="d-inline-block position-relative">'+
                                    '<div class="rounded d-inline-block">'+
                                        '<div class="d-flex justify-content-center h-100">'+
                                            '<span class="align-self-center">'+(index+1)+'</span>'+
                                        '</div>'+
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
                                        '<i class="fas fa-edit pb-0" data-index="'+index+'" onclick="modalBranch(this)" data-for="edit" title="Edit"></i>'+
                                        '<i class="fas fa-trash-alt" onclick="deleteBranch('+index+')" title="Delete"></i>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<input type="hidden" name="branch['+index+'][branch_info_id]" value="'+modal_branch_info_id+'">'+
                        '<input type="hidden" name="branch['+index+'][branch_address_id]" value="'+modal_branch_address_id+'">'+
                        '<input type="hidden" name="branch['+index+'][branch_name_th]" value="'+modal_branch_name_th+'" data-name="branch_name_th">'+
                        '<input type="hidden" name="branch['+index+'][branch_name_en]" value="'+modal_branch_name_en+'" data-name="branch_name_en">'+
                        '<input type="hidden" name="branch['+index+'][branch_code]" value="'+modal_branch_code+'" data-name="branch_code">'+
                        '<input type="hidden" name="branch['+index+'][branch_short_name_en]" value="'+modal_branch_short_name_en+'" data-name="branch_short_name_en">'+
                        '<input type="hidden" name="branch['+index+'][branch_contract]" value="'+modal_branch_contract+'" data-name="branch_contract">'+
                        '<input type="hidden" name="branch['+index+'][branch_building]" value="'+modal_branch_building+'" data-name="branch_building">'+
                        '<input type="hidden" name="branch['+index+'][branch_house_no]" value="'+modal_branch_house_no+'" data-name="branch_house_no">'+
                        '<input type="hidden" name="branch['+index+'][branch_village_no]" value="'+modal_branch_village_no+'" data-name="branch_village_no">'+
                        '<input type="hidden" name="branch['+index+'][branch_village]" value="'+modal_branch_village+'" data-name="branch_village">'+
                        '<input type="hidden" name="branch['+index+'][branch_lane]" value="'+modal_branch_lane+'" data-name="branch_lane">'+
                        '<input type="hidden" name="branch['+index+'][branch_road]" value="'+modal_branch_road+'" data-name="branch_road">'+
                        '<input type="hidden" name="branch['+index+'][branch_province]" value="'+modal_branch_province+'" data-name="branch_province">'+
                        '<input type="hidden" name="branch['+index+'][branch_district]" value="'+modal_branch_district+'" data-name="branch_district">'+
                        '<input type="hidden" name="branch['+index+'][branch_sub_district]" value="'+modal_branch_sub_district+'" data-name="branch_sub_district">'+
                        '<input type="hidden" name="branch['+index+'][branch_zipcode]" value="'+modal_branch_zipcode+'" data-name="branch_zipcode">'+

                    '</li>';

                $('#branch_block').append(html)

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

    function addBranch(elem_this)
    {
        var current = $('.branch-item').length;
        var next = current;

        var modal_branch_name_th        = $(elem_this).closest(".modal-content").find('input[name="modal_branch_name_th"]').val();
        var modal_branch_name_en        = $(elem_this).closest(".modal-content").find('input[name="modal_branch_name_en"]').val();
        var modal_branch_code           = $(elem_this).closest(".modal-content").find('input[name="modal_branch_code"]').val();
        var modal_branch_short_name_en         = $(elem_this).closest(".modal-content").find('input[name="modal_branch_short_name_en"]').val();

        var modal_branch_contract              = $(elem_this).closest(".modal-content").find('input[name="modal_branch_contract"]').val();
        var modal_branch_building              = $(elem_this).closest(".modal-content").find('input[name="modal_branch_building"]').val();
        var modal_branch_house_no              = $(elem_this).closest(".modal-content").find('input[name="modal_branch_house_no"]').val();
        var modal_branch_village_no            = $(elem_this).closest(".modal-content").find('input[name="modal_branch_village_no"]').val();
        var modal_branch_village               = $(elem_this).closest(".modal-content").find('input[name="modal_branch_village"]').val();
        var modal_branch_lane                  = $(elem_this).closest(".modal-content").find('input[name="modal_branch_lane"]').val();
        var modal_branch_road                  = $(elem_this).closest(".modal-content").find('input[name="modal_branch_road"]').val();

        var modal_branch_province           = $(elem_this).closest(".modal-content").find('select[name="modal_branch_province"]').val();
        var modal_branch_district           = $(elem_this).closest(".modal-content").find('select[name="modal_branch_district"]').val();
        var modal_branch_sub_district       = $(elem_this).closest(".modal-content").find('select[name="modal_branch_sub_district"]').val();
        var modal_branch_country_code       = 'TH';


        var modal_branch_zipcode  = $(elem_this).closest(".modal-content").find('input[name="modal_branch_zipcode"]').val();

        var html = '<li class="branch-item" data-index="'+(next)+'">'+
                        '<div class="d-flex justify-content-between">'+
                            '<div class="">'+
                                '<div class="d-inline-block position-relative">'+
                                    '<div class="rounded d-inline-block">'+
                                        '<div class="d-flex justify-content-center h-100">'+
                                            '<span class="align-self-center">'+(next+1)+'</span>'+
                                        '</div>'+
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
                                        '<i class="fas fa-edit pb-0" data-index="'+next+'" onclick="modalBranch(this)" data-for="edit" title="Edit"></i>'+
                                        '<i class="fas fa-trash-alt" onclick="deleteBranch('+next+')" title="Delete"></i>'+
                                    '</li>'+
                                '</ul>'+
                            '</div>'+
                        '</div>'+
                        '<input type="hidden" name="branch['+next+'][branch_info_id]" value="">'+
                        '<input type="hidden" name="branch['+next+'][branch_address_id]" value="">'+
                        '<input type="hidden" name="branch['+next+'][branch_name_th]" value="'+modal_branch_name_th+'" data-name="branch_name_th">'+
                        '<input type="hidden" name="branch['+next+'][branch_name_en]" value="'+modal_branch_name_en+'" data-name="branch_name_en">'+
                        '<input type="hidden" name="branch['+next+'][branch_code]" value="'+modal_branch_code+'" data-name="branch_code">'+
                        '<input type="hidden" name="branch['+next+'][branch_short_name_en]" value="'+modal_branch_short_name_en+'" data-name="branch_short_name_en">'+
                        '<input type="hidden" name="branch['+next+'][branch_contract]" value="'+modal_branch_contract+'" data-name="branch_contract">'+
                        '<input type="hidden" name="branch['+next+'][branch_building]" value="'+modal_branch_building+'" data-name="branch_building">'+
                        '<input type="hidden" name="branch['+next+'][branch_house_no]" value="'+modal_branch_house_no+'" data-name="branch_house_no">'+
                        '<input type="hidden" name="branch['+next+'][branch_village_no]" value="'+modal_branch_village_no+'" data-name="branch_village_no">'+
                        '<input type="hidden" name="branch['+next+'][branch_village]" value="'+modal_branch_village+'" data-name="branch_village">'+
                        '<input type="hidden" name="branch['+next+'][branch_lane]" value="'+modal_branch_lane+'" data-name="branch_lane">'+
                        '<input type="hidden" name="branch['+next+'][branch_road]" value="'+modal_branch_road+'" data-name="branch_road">'+
                        '<input type="hidden" name="branch['+next+'][branch_province]" value="'+modal_branch_province+'" data-name="branch_province">'+
                        '<input type="hidden" name="branch['+next+'][branch_district]" value="'+modal_branch_district+'" data-name="branch_district">'+
                        '<input type="hidden" name="branch['+next+'][branch_sub_district]" value="'+modal_branch_sub_district+'" data-name="branch_sub_district">'+
                        '<input type="hidden" name="branch['+next+'][branch_zipcode]" value="'+modal_branch_zipcode+'" data-name="branch_zipcode">'+

                    '</li>';

                $('#branch_block').append(html)
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
                $('#AddBranchModal').modal('hide');
    }

    function deleteBranch(index) {

    var current = $('.branch-item-delete').length;
    var next = current;
    // console.log($('.branch-item[data-index="'+index+'"]').find('input[data-name="branch_info_id"]').val());
    var branch_info_id = $('.branch-item[data-index="'+index+'"]').find('input[data-name="branch_info_id"]').val();
    var branch_address_id = $('.branch-item[data-index="'+index+'"]').find('input[data-name="branch_address_id"]').val();

    var html = '<li class="branch-item-delete" data-index="'+(next)+'">'+
                        '<input type="hidden" name="branch_del['+next+'][branch_info_id]" value="'+branch_info_id+'" data-name="branch_del_info_id">'+
                        '<input type="hidden" name="branch_del['+next+'][branch_address_id]" value="'+branch_address_id+'" data-name="branch_del_address_id">'+
                '</li>';

        $('#branch_block_delete').append(html)

        var elem = $('.branch-item[data-index="'+index+'"]').remove();

        if($('.branch-item').length == 0) {
            $('#no_branch').show();
        } else {
            $('#no_branch').hide();
        }
        $('#AddBranchModal').modal('hide');
    }

    function select2(elem,type) {
        $(elem).select2({
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
    function modalBranch(elem) {
        var type = $(elem).data("for");
        //console.log("find type  --- " + type)
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
            // console.log("type  +++  " + type)
            $('#addBranch_submit').addClass('d-none');
            $('#saveBranch').removeClass('d-none');

            $('input[name="modal_state"]').val('edit');
            $('input[name="index"]').val($(elem).data('index'));
            // console.log("index val  --- " + $('input[name="index"]').val())
            $('input[name="modal_branch_zipcode"]').val($(elem).find('*[data-name="branch_zipcode"]').val());

            $(elem).closest("li.branch-item").find('input[type="hidden"]').each(function(){
                var name = $(this).data('name');

                $('#input_'+name).val($(this).val());
            });

            var province     = $(elem).closest("li.branch-item").find('*[data-name="branch_province"]').val();
            var district     = $(elem).closest("li.branch-item").find('*[data-name="branch_district"]').val();
            var sub_district = $(elem).closest("li.branch-item").find('*[data-name="branch_sub_district"]').val();
            var zipcode      = $(elem).closest("li.branch-item").find('*[data-name="branch_zipcode"]').val();

            // console.log($('select[name="modal_branch_province"]').val())

            // console.log(province+' '+district+' '+sub_district+' '+zipcode)

            $('select[name="modal_branch_province"]').append(new Option(province, province, true, true)).trigger('change');
            $('select[name="modal_branch_district"]').append(new Option(district, district, true, true)).trigger('change');
            $('select[name="modal_branch_sub_district"]').append(new Option(sub_district, sub_district, true, true)).trigger('change');
            $('input[name="modal_branch_zipcode"]').val(zipcode);

            // console.log($('select[name="modal_branch_province"]').val())
        }


        $('#AddBranchModal').modal('show');


    }

    $(document).ready(function(){
        select2('select[name="select_province"]','province');
        select2('select[name="select_district"]','district');
        select2('select[name="select_sub_district"]','sub_district');
        select2Branch('select[name="modal_branch_province"]','province');
        select2Branch('select[name="modal_branch_district"]','district');
        select2Branch('select[name="modal_branch_sub_district"]','sub_district');
        
        if('{{ app()->getLocale() }}' == 'th'){
            $('select[name="select_province"]').append(new Option('{{ $data->province_th }}', '{{ $data->province_th }}', false, false)).trigger('change');
            $('select[name="select_district"]').append(new Option('{{ $data->district_th }}', '{{ $data->district_th }}', false, false)).trigger('change');
            $('select[name="select_sub_district"]').append(new Option('{{ $data->sub_district_th }}', '{{ $data->sub_district_th }}', false, false)).trigger('change');
        }
        else{
            $('select[name="select_province"]').append(new Option('{{ $data->province_en }}', '{{ $data->province_th }}', false, false)).trigger('change');
            $('select[name="select_district"]').append(new Option('{{ $data->district_en }}', '{{ $data->district_th }}', false, false)).trigger('change');
            $('select[name="select_sub_district"]').append(new Option('{{ $data->sub_district_en }}', '{{ $data->sub_district_th }}', false, false)).trigger('change');
        }
    });


</script>

@endsection
