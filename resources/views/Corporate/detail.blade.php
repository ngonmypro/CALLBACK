@extends('argon_layouts.app', ['title' => __('Corporate Management')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('corporate.corporate_info')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">

                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right d-none">
                        @Permission(CORPORATE_MANAGEMENT.VIEW)
                        @if (isset($corp_code) && !blank($corp_code))
                            <a href="{{ url('Corporate')}}" class="btn btn-neutral">{{__('common.back')}}</a>
                        @else
                            <a onclick="window.history.back()" class="btn btn-neutral">{{__('common.back')}}</a>
                        @endif
                        @EndPermission
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
                            <div class="col-4 text-right">
                                @Permission(CORPORATE_MANAGEMENT.UPDATE)
                                <a href="{{ url('/Corporate/Edit',$data->corp_code) }}" class="btn btn-primary"> {{__('common.edit')}} </a>
                                @EndPermission
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="form_profile" class="pl-1">
                            <div class="d-flex flex-wrap flex-column mb-3">
                                <div class="w-100">
                                    <div class="form-group">
                                        <div class="row mx-auto">
                                            <div class="col-8 px-0">
                                                <h4 class="mb-3 py-3 card-header-with-border">
                                                    {{__('corporateManagement.corporate_group')}}  : {{ $data->group_name_th }} {{ $data->group_name_en }}

                                                </h4>
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
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_name_th')}}</label>
                                                    <p class="form-control-static">{{isset($data->corp_name_th) ? $data->corp_name_th : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.company_name_en')}}</label>
                                                    <p class="form-control-static">{{isset($data->corp_name_en) ? $data->corp_name_en : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.taxid')}}</label>
                                                    <p class="form-control-static">{{isset($data->tax_id) ? $data->tax_id : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.unitNo')}}</label>
                                                    <p class="form-control-static">{{isset($data->branch_code) ? $data->branch_code : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.short_name_en')}}</label>
                                                    <p class="form-control-static">{{isset($data->short_name_en) ? $data->short_name_en : '-' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mx-auto">
                                            <div class="col-12 px-0">
                                                <h4 class="mb-3 py-3 card-header-with-border">{{__('corporateManagement.address')}}</h4>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.building')}}</label>
                                                    <p class="form-control-static">{{isset($data->building) ? $data->building : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.house_no')}}</label>
                                                    <p class="form-control-static">{{isset($data->house_no) ? $data->house_no : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.village_no')}}</label>
                                                    <p class="form-control-static">{{isset($data->village_no) ? $data->village_no : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.village')}}</label>
                                                    <p class="form-control-static">{{isset($data->village) ? $data->village : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.lane')}}</label>
                                                    <p class="form-control-static">{{isset($data->lane) ? $data->lane : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.road')}}</label>
                                                    <p class="form-control-static">{{isset($data->road) ? $data->road : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Province')}}</label>
                                                    @if(app()->getLocale() == 'th')
                                                    <p class="form-control-static">{{isset($data->province_th) ? $data->province_th : __('corporateManagement.nodata')}}</p>
                                                    @else
                                                    <p class="form-control-static">{{isset($data->province_en) ? $data->province_en : __('corporateManagement.nodata')}}</p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.District')}}</label>
                                                    @if(app()->getLocale() == 'th')
                                                    <p class="form-control-static">{{isset($data->district_th) ? $data->district_th : __('corporateManagement.nodata')}}</p>
                                                    @else
                                                    <p class="form-control-static">{{isset($data->district_en) ? $data->district_en : __('corporateManagement.nodata')}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Sub_District')}}</label>
                                                    @if(app()->getLocale() == 'th')
                                                    <p class="form-control-static">{{isset($data->sub_district_th) ? $data->sub_district_th : __('corporateManagement.nodata')}}</p>
                                                    @else
                                                    <p class="form-control-static">{{isset($data->sub_district_en) ? $data->sub_district_en : __('corporateManagement.nodata')}}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Zipcode')}}</label>
                                                    <p class="form-control-static">{{isset($data->zipcode) ? $data->zipcode : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.Country')}}</label>
                                                    <p class="form-control-static">{{__('corporateManagement.thailand')}}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="" class=" form-control-label">{{__('corporateManagement.contact')}}</label>
                                                    <p class="form-control-static">{{isset($data->contract) ? $data->contract : __('corporateManagement.nodata')}}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 branch_section px-0">
                                    <div class="row mx-auto">
                                        <div class="col-12">
                                            <h4 class="mb-5 pb-3 pt-0 card-header-with-border">
                                                {{__('corporateManagement.branch')}}
                                            </h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="card border-0">
                                                <div class="card-header py-2" style="background-color: #4A4A4A;">
                                                    <p class="text-white font-14px">{{__('corporateManagement.branch_no')}}</p>
                                                </div>
                                                <div class="card-body px-2">
                                                    <nav class="">
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
                                                                <li class="branch-item" data-index="{{ $i }}">
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
                                                                    </div>
                                                                    <input type="hidden" data-name="corp_name_th" value="{{ $v->corp_name_th }}">
                                                                    <input type="hidden" data-name="corp_name_en" value="{{ $v->corp_name_en }}">
                                                                    <input type="hidden" data-name="branch_code" value="{{ $v->branch_code }}">
                                                                    <input type="hidden" data-name="address_th" value="{{ $v->address_th }}">
                                                                    <input type="hidden" data-name="address_en" value="{{ $v->address_en }}">
                                                                    @if(app()->getLocale() == 'th')
                                                                        <input type="hidden" data-name="sub_district_th" value="{{ $v->sub_district_th }}">
                                                                        <input type="hidden" data-name="district_th" value="{{ $v->district_th }}">
                                                                        <input type="hidden" data-name="province_th" value="{{ $v->province_th }}">
                                                                    @else
                                                                        <input type="hidden" data-name="sub_district_th" value="{{ $v->sub_district_en }}">
                                                                        <input type="hidden" data-name="district_th" value="{{ $v->district_en }}">
                                                                        <input type="hidden" data-name="province_th" value="{{ $v->province_en }}">
                                                                    @endif
                                                                    <input type="hidden" data-name="zipcode" value="{{ $v->zipcode }}">
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
                <h3 class="modal-title py-3 px-2" style="color: #4272D7;">{{__('corporateManagement.add_branch')}}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="form_branch">

                    <div class="row mx-auto">
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.branch_th')}}</label>
                                <p class="form-control-static" id="static_corp_name_th"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.branch_en')}}</label>
                                <p class="form-control-static" id="static_corp_name_en"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class=" form-control-label">{{__('corporateManagement.unitNo')}}</label>
                                <p class="form-control-static" id="static_branch_code"></p>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div class="col-12">
                            <h4 class="py-4">{{__('corporateManagement.address')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.address_th')}}</label>
                                <p class="form-control-static" id="static_address_th"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.address_en')}}</label>
                                <p class="form-control-static" id="static_address_en"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Province')}}</label>
                                <p class="form-control-static" id="static_province_th"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.District')}} </label>
                                <p class="form-control-static" id="static_district_th"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Sub_District')}}</label>
                                <p class="form-control-static" id="static_sub_district_th"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label">{{__('corporateManagement.Zipcode')}}</label>
                                <p class="form-control-static" id="static_zipcode"></p>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('corporateManagement.close')}}</button>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer_progress')
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript">
    function modalBranch(elem) {
        $(elem).find('input[type="hidden"]').each(function(){
            var name = $(this).data('name');

            $('#static_'+name).text($(this).val())
        });

        $('#AddBranchModal').modal('show')
    }

    $('#AddBranchModal').on('hidden', function () {
        $('#AddBranchModal .form-control-static').each(function(v){
            $(this).text(__('corporateManagement.nodata'))
        });
    })

</script>
@endsection
