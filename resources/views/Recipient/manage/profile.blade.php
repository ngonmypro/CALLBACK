@extends('argon_layouts.app', ['title' => __('Customer Profile')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-md-6">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__("recipient.profile.title")}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-md-6 text-right">
                        <div id="reqCardStoreEn" class="d-none">
                            <button id="reqCardStore" type="button" class="btn btn-secondary" data-card="{{ !empty($profile->card) ? 'has' : 'no'}}">{{ isset($profile->card) && $profile->card != null ? __('recipient.profile.resend_card_store') : __('recipient.profile.send_card_store') }}</button>
                            <input type="hidden" id="card_no" value="{{ !empty($profile->card) ? $profile->card->card_no : ''}}"/>
                            <input type="hidden" id="card_create" value="{{ !empty($profile->card) ? $profile->card->create : ''}}"/>
                        </div>
                        @Permission(VISA.VIRTUAL_CARD)
                            <a href="{{ url('/Recipient/Profile/Invitation',$profile->recipient_code)}}" class="btn btn-neutral">Send Invitation</a>
                        @EndPermission
                        <a href="{{ url('/Recipient/Profile/Update',$profile->recipient_code)}}" class="btn btn-neutral">{{ (__('recipient.profile.edit')) }}</a>
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
                            <div class="col-md-6">
                                <h3 class="mb-0">{{__("recipient.profile.title")}}</h3>
                                <p class="text-sm mb-0">
                                <input type="hidden" id="request_type" />
                                </p>
                            </div>
                            <div class="col-md-6 text-right">
                            @if ($profile->status == "ACTIVE")
                                <span class="badge badge-success">{{ (__('recipient.active')) }}</span>
                            @elseif ($profile->status == "INACTIVE")
                                <span class="badge badge-danger">{{ (__('recipient.inactive')) }}</span>
                            @endif
                            @if (!empty($profile->card))
                                <span class="badge badge-primary">{{ (__('recipient.profile.credit_score.active')) }}</span>
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.customer_code')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->recipient_code) ? $profile->recipient_code : '-' }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.invitation_code')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->recipient_reference) ? $profile->recipient_reference : '-' }} </label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.customer_name')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->full_name) ? $profile->full_name : '-' }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.first_name')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->first_name) ? $profile->first_name : '-' }} </label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.middle_name')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->middle_name) ? $profile->middle_name : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.last_name')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->last_name) ? $profile->last_name : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.email')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->email) ? $profile->email : '-' }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.optional_email')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (isset($profile->optional_emails) && $profile->optional_emails != '') ? implode(",", json_decode($profile->optional_emails)) : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.mobile_no')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->telephone) ? $profile->telephone : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.optional_mobile_no')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (isset($profile->optional_telephones) && $profile->optional_telephones != '') ? implode(",", json_decode($profile->optional_telephones)) : '-' }}</label>
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
                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.address')) }}</label>
                                    </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->address) ? $profile->address : '' }} {{ isset($profile->zipcode) ? $profile->zipcode : '' }} {{ isset($profile->state) ? $profile->state : '' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                    <div class="col-12">
                                        <label for="" class=" form-control-label">{{ (__('recipient.profile.line_id')) }}</label>
                                    </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->line_id) && !blank($profile->line_id) ? $profile->line_id : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.state')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->state) ? $profile->state : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.zipcode')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->zipcode) ? $profile->zipcode : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.contact')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->contact) ? $profile->contact : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.country')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label id="country_code" for="" class=" form-control-label">{{ isset($profile->localize) ? $profile->localize : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap">

                            @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.citizen_id')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ isset($profile->citizen_id) ? $profile->citizen_id : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="p-2 flex-fill w-50"></div>

                        </div>

                        <hr>
                        
                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3 card-header-with-border">{{ (__('recipient.profile.additional_information')) }}</h4>
                            </div>
                        </div>

                        @if(session('BANK_CURRENT')['name_en'] != 'TMB')
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.career')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->career) ? $profile->career : '-' }}</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.salary')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->salary) ? $profile->salary : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_1')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->ref_1) ? $profile->ref_1 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_2')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->ref_2) ? $profile->ref_2 : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_3')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->ref_3) ? $profile->ref_3 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_4')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->ref_4) ? $profile->ref_4 : '-' }}</label>
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
                                            <label for="" class=" form-control-label">{{ (__('recipient.profile.reference_5')) }}</label>
                                        </div>
                                        <div class="col-12">
                                            <label for="" class=" form-control-label"> {{ isset($profile->ref_5) ? $profile->ref_5 : '-' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3 card-header-with-border">{{ (__('recipient.profile.bill_transaction')) }}</h4>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
                                <div class="form-group">        
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table simple-table" style="width:100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">{{ (__('recipient.profile.date')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.reference_code')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.amount')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.due_date')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.overdue')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.transaction_date')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.payment_status')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.status')) }}</th>
                                                    <th class="text-center">{{ (__('recipient.profile.download')) }}</th>
                                                </tr>
                                                </thead>
                    
                                                {{-- {{ print_r($profile->bills) }} --}}
                                                @if (isset($profile->bills) && count($profile->bills) > 0)
                    
                                                    <?php 
                                                        $bill_status = array(
                                                            "SUCCESS"   => "success",
                                                            "OVERDUE"   => "danger",
                                                            "CANCEL"    => "warning",
                                                            "ISSUED"    => "info",
                                                            "PENDING"   => "secondary",
                                                            "NEW"       => "primary",
                                                            "PAID"      => "success"
                                                        );
                                                        $payment_status = [
                                                            'PENDING'   => 'warning',
                                                            'PAID'      => 'success',
                                                            'FAILED'    => 'danger',
                                                            'UNPAID'    => 'warning'
                                                        ];
                                                        $label_payment_status =[
                                                            "SUCCESS"   => trans('common.success'),
                                                            "OVERDUE"   => trans('common.overdue'),
                                                            "CANCEL"    => trans('common.cancel'),
                                                            "ISSUED"    => trans('common.issued'),
                                                            "PENDING"   => trans('common.pending'),
                                                            "NEW"       => trans('common.new'),
                                                            "PAID"      => trans('common.paid')
                                                        ];
                                                    ?>
                                                    <tbody>
                                                        @foreach ($profile->bills as $item)
                                                            <tr role="row">
                                                                <td class="text-center" style="width: 150px;">{{ date('Y-m-d', strtotime($item->created_at)) }}</td>
                                                                <td class="text-center" style="width: 230px;">{{ isset($item->reference_code) ? $item->reference_code : ' - ' }}</td>
                                                                <td class="text-center">{{ number_format($item->bill_total_amount, 2, '.', ',') }}</td>
                                                                <td class="text-center" style="width: 150px;">{{ strpos(strtotime($item->bill_due_date), '-') === false ? date('Y-m-d', strtotime($item->bill_due_date)) : '-' }}</td>
                                                                <td class="text-center">
                                                                    <span class="role badge badge-{{$item->bill_is_overdue == true ? 'danger' : 'secondary' }}">{{ $item->bill_is_overdue == true ? trans('common.overdue_yes') : trans('common.overdue_no') }}</span>
                                                                </td>
                                                                <td class="text-center" style="width: 150px;">{{ isset($item->payment_date_time) ? date('Y-m-d', strtotime($item->payment_date_time)) : ' - ' }}</td>
                                                                @if (!blank($item->payment_status))
                                                                <td class="text-center" style="width: 150px;">
                                                                    <span class="role badge badge-{{ isset($payment_status[$item->payment_status]) ? $payment_status[$item->payment_status]: 'secondary' }}" 
                                                                        data-toggle="popover" 
                                                                        data-placement="top" 
                                                                        data-content="">{{ isset($label_payment_status[$item->payment_status]) 
                                                                                                        ? $label_payment_status[$item->payment_status]
                                                                                                        : $item->payment_status }}</span>
                                                                </td>
                                                                @else
                                                                <td class="text-center" style="width: 150px;">
                                                                    <span class="role" data-toggle="popover" data-placement="top" data-content="">{{ $item->payment_status === null ? '-' : $item->payment_status }}</span>
                                                                </td>
                                                                @endif
                                                                <td class="text-center">
                                                                    <span class="role badge badge-{{ isset($bill_status[$item->bill_status]) 
                                                                                                        ? $bill_status[$item->bill_status]
                                                                                                        : 'secondary' }}" 
                                                                        data-toggle="popover" 
                                                                        data-placement="top" 
                                                                        data-content="">{{ isset($label_payment_status[$item->bill_status]) 
                                                                                                        ? $label_payment_status[$item->bill_status]
                                                                                                        : $item->bill_status }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($item->bill_type === 'LOAN')
                                                                    <a onclick="opendoc('{{ url('Loan/Contract') }}/{{ $item->ref_1 }}/Bill/{{ $item->reference_code }}?type=pdf')">
                                                                        <i class="zmdi zmdi-download"></i>
                                                                    </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                    
                                                @else
                                                    <tbody>
                                                        <tr role="row">
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                            <td class="text-center"> - </td>
                                                        </tr>
                                                    </tbody>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        @Permission(LOAN_MANAGEMENT.*)
                        @if ( isset($profile->recipient_type) && $profile->recipient_type === 'LOAN' )

                        <div class="d-flex flex-wrap mb-3">
                            <div class="p-2 flex-fill w-50">
                                <h4 class="mb-3 py-3">
                                    <span>{{ (__('recipient.profile.credit_score.title')) }}</span>

                                    <div class="float-right">
                                        <div class="d-inline mb-3 py-3 h4">
                                            <a id="add-credit" href="#add-credit" class="btn btn-primary pt-2 pb-2" style="margin-top: -10px;">
                                                <span>{{__('recipient.profile.credit_score.btn-add')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </h4>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap">
                            <div class="w-100 table-responsive">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <table id="credit-score-table" class="table table-flush dataTable" style="width:100%"></table>
                                </div>
                            </div>
                        </div>  
                        
                        @endif
                        @EndPermission

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
    <script type="text/javascript">
    
        $.getJSON("{{ URL::asset('assets/json/country_code.json') }}", function(data) {
            localStorage.setItem('country_code', JSON.stringify(data))
            $.each(data, function(key, value){
                if(value.Code == $('#country_code').text()) {
                    $('#country_code').text(value.Name);
                }
            });
        })

        function opendoc(url) {
            const section_header = GetModalHeader()

            SetModalAlignDefault()
            SetModalSize("modal-xl")

            const type = (new URL(url)).searchParams.get('type')
            if (type !== 'pdf') {
                modal(`<div style="height:600px;"><image src="${url}" style="max-width:100%; max-height: 100%; display: block; margin: 0 auto;" onload='setFrameLoaded();'/></div>`);
            } else {
                modal(`<iframe height="600" width="100%" src="${url}" style="border:none" onload='setFrameLoaded();'></iframe>`)
            }
        }

        function modal(html_input) {
            Swal.fire({
              html: html_input
            })
        }

        const initCardStoreReq = () => {
            @if ( !blank(@Session::get('payment_recurring')) && in_array('recurring', @Session::get('payment_recurring')) ) 
                $('#reqCardStoreEn').removeClass('d-none').addClass('d-inline')
            @else
                $('#reqCardStoreEn').remove()
            @endif
        }

        $(document).on("click",".swal2-container input[name='swal2-radio']", function() {
            $("#request_type").val($('input[name=swal2-radio]:checked').val());
        });

        $(document).ready(function() {
            initCardStoreReq()
            $('#reqCardStore').on('click', function() {
                let message
                let title
                if($(this).data('card') == 'has') {
                    title = `{{ (__('recipient.profile.resend')) }}`
                    message = `<span>{{ (__('recipient.profile.card_detail')) }}</span><br/>` + `{{ (__('recipient.profile.card_no')) }} : ` + 
                                $("#card_no").val() + `<br/>{{ (__('recipient.profile.create_at')) }} : ` + $("#card_create").val() +
                                `<br/>{{ (__('recipient.profile.remove_old')) }}`
                }
                else {
                    title = `{{ (__('recipient.profile.send_card_store')) }}`
                }

                var inputOptions = new Promise(function(resolve) {
                    resolve({
                        'WEB': '{{ (__('recipient.profile.by_web')) }}',
                        'SMS': '{{ (__('recipient.profile.by_sms')) }}'
                    });
                });
                
                Swal.fire({
                    title: title,
                    html: message,
                    icon: 'warning',
                    input: 'radio',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    inputOptions: inputOptions,
                    inputValidator: function(result) {
                        return new Promise(function(resolve, reject) {
                            if (result) {
                                resolve();
                            } else {
                                reject('You need to select something!');
                            }
                        });
                    }
                }).then((result) => {
                    if (result.value) {
                        $.blockUI()
                        $.ajax({
                            type: 'POST',
                            url: "{{ action('RecipientManageController@sendSMSCardStore') }}",
                            data: {
                                _token: "{{ csrf_token() }}",
                                recipient_code: "{{ $profile->recipient_code }}",
                                request_type: $("#request_type").val()
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                console.log(result.url)
                                if(result.url !== undefined && result.url !== null) {
                                    window.open(result.url);
                                }
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Someting wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Someting wrong.', 'error')
                        })
                    }
                })
            })
        })

        @Permission(LOAN_MANAGEMENT.*)
        $(document).ready(function(){

            var table = $("#credit-score-table").DataTable({
    			sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                 "language": {
                    "emptyTable":     "{{__('common.datatable.emptyTable')}}",
                    "info":           "{{__('common.datatable.info_1')}} _START_ {{__('common.datatable.info_2')}} _END_ {{__('common.datatable.info_3')}} _TOTAL_ ",
                    "infoEmpty":      "{{__('common.datatable.infoEmpty')}}",
                    "lengthMenu":     "{{__('common.datatable.lengthMenu_1')}} _MENU_ {{__('common.datatable.lengthMenu_2')}}",
                    "loadingRecords": "{{__('common.datatable.loadingRecords')}}",
                    "processing":     "{{__('common.datatable.processing')}}",
                    "zeroRecords":    "{{__('common.datatable.zeroRecords')}}",
                    "paginate": {
                        "next":       "<i class='fas fa-angle-right'>",
                        "previous":   "<i class='fas fa-angle-left'>"
                    },
                    "infoFiltered":   "",
                },
    			ajax: {
                    url: "{{ action('Loan\CreditScoreController@objectData', ['id' => $profile->recipient_code ?? '']) }}",
    				method: 'POST',
    				data: function (d) {
                        d._token = "{{ csrf_token() }}"
    				}
    			},
    			columns: [
                    { data: 'created_at',               name: 'created_at',                 title: '{{__("recipient.profile.credit_score.created_at")}}',           class: 'text-center' },
                    { data: 'credit_score',             name: 'credit_score',               title: '{{__("recipient.profile.credit_score.credit_score")}}',         class: 'text-center' },
                    { data: 'remark',                   name: 'remark',                     title: '{{__("recipient.profile.credit_score.remark")}}',               class: 'text-center' },
    			],
    			aoColumnDefs: [
                    {
                        aTargets: [0],
                        mData: "id",
                        mRender: function (data, type, full) {
                            return moment(data).format('YYYY-MM-DD, HH:mm')
                        }
                    },
                    {
                        aTargets: '_all',
                        mData: "id",
                        mRender: function (data, type, full) {
                            return data || '-'
                        }
                    },
    			],
            })
            
            $('#add-credit').on('click', function() {

                Swal.mixin({
                    // option
                }).queue([
                    {
                        title: "{{ (__('recipient.profile.credit_score.add-credit.title')) }}",
                        text: "{{ (__('recipient.profile.credit_score.add-credit.enter_credit_score')) }}",
                        input: 'number',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: true,
                        reverseButtons: true,
                        cancelButtonText: "{{ (__('common.cancel')) }}",
                        confirmButtonText: "{{ (__('common.confirm')) }}",
                        inputValidator: (value) => {
                            if ( !value ) {
                                return "{{ (__('recipient.profile.credit_score.add-credit.validate_score')) }}"
                            }
                        },
                    },
                    {
                        title: "{{ (__('recipient.profile.credit_score.add-credit.title')) }}",
                        text: "{{ (__('recipient.profile.credit_score.add-credit.enter_reason')) }}",
                        input: 'text',
                    }
                ]).then((result) => {
                    $.blockUI()
                    if ( result.value ) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ action('Loan\CreditScoreController@add', ['id' => $profile->recipient_code ?? '']) }}",
                            data: {
                                _token: `{{ csrf_token() }}`,
                                credit: result.value[0] || '',
                                remark: result.value[1] || '',
                            }
                        }).done(function(result) {
                            $.unblockUI()
                            if ( result.success ) {
                                $('#credit-score-table').DataTable().ajax.reload()  // datatable ajax reload
                                Swal.fire(`{{ (__('common.success')) }}`, '', 'success')
                            } else {
                                console.error('Error: ', result.message)
                                Swal.fire(result.message || 'Oops! Someting wrong.', '', 'warning')
                            }
                        }).fail(function(err) {
                            $.unblockUI()
                            console.error('Error: ', err)
                            Swal.fire(`{{ (__('common.error')) }}`, err.message || 'Oops! Someting wrong.', 'error')
                        })
                    } else {
                        $.unblockUI()
                    }
                })  
            })

        });
        @EndPermission
        
    </script>
@endsection
