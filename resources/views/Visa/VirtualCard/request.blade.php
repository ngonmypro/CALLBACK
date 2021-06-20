@extends('argon_layouts.app', ['title' => __('Request Virtual Card')])

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
    <style>
        .word-wrap {
            word-break: break-all;
        }
        .no-wrap {
            white-space: nowrap;
        }
        .fixed {
            table-layout: fixed;
        }
        .accordion .card-header {
            font-size: 0.9rem;
        }
        .table-sm input[type="text"] ,
        .table-sm input[type="number"] ,
        .table-sm input[type="time"] ,
        .table-sm select{
            height: 30px;
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .accordion .card-header.no-icon:after{
            display: none !important;
        }
    </style>
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Request Virtual Card</h6>
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
                <form id="form_create_bank" action="{{ url('/Visa/VirtualCard/request')}}" method="post" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="virtual_card_reference" value="{{ isset($data->reference_code) ? $data->reference_code : '' }}"> 
                    <input type="hidden" name="corporate_id" value="{{ isset($data->reference_code) ? $data->corporate_id : '' }}">
                    <input type="hidden" name="recipient_code" value="{{ isset($data->recipient_info->recipient_code) ? $data->recipient_info->recipient_code : '' }}">
                    <input type="hidden" name="line_id" value="{{ isset($data->recipient_info->line_id) ? $data->recipient_info->line_id : '' }}">
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Request Detail</h3>
                                </div>
                                <div class="col-4 text-right">
                                    @if($data->status == 'NEW')
                                        <h1><span class="badge badge-primary"> NEW </span></h1>
                                    @elseif($data->status == "PENDING")
                                        <h1><span class="badge badge-secondary"> PENDING </span></h1>
                                    @elseif($data->status == "APPROVE")
                                        <h1><span class="badge badge-success"> APPROVE </span></h1>
                                    @elseif($data->status == "REJECT")
                                        <h1><span class="badge badge-danger"> REJECT </span></h1>
                                    @else
                                        <h1><span class="badge badge-secondary"> {{ $data->status  }} </span></h1>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12">
                                <div class="row ">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row col-12">
                                                    <div class="form-group">
                                                         <span class="col-md-4 col-xs-12">Requester :</span>
                                                         <span class="col-8 col-xs-12">{{ isset($data->recipient_info->full_name) ? $data->recipient_info->full_name : '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row col-12">
                                                    <div class="form-group">
                                                         <span class="col-md-4 col-xs-12">Credit request :</span>
                                                         <span class="col-8 col-xs-12">{{ isset($data->credit_request) ? number_format($data->credit_request,2) : '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row">
                                                     <span class="col-md-4 col-xs-12">Date use :</span>
                                                     <span class="col-8 col-xs-12">{{ isset($data->start_date) ? date('d/m/Y',strtotime($data->start_date)) : '' }} - {{ isset($data->end_date) ? date('d/m/Y',strtotime($data->end_date)) : '' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group row">
                                                     <span class="col-md-4 col-xs-12">Reason :</span>
                                                     <span class="col-8 col-xs-12">{{ isset($data->request_reason) ? $data->request_reason : '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($data->status) && $data->status == 'APPROVE')
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Card Profile</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <div class="col-md-5 col-sm-5">
                                            <div class="row">

                                                <img src="{{ isset($data->card_type->image) ? $data->card_type->image : '' }}" class="w-100">


                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-7">
                                            <div class="row mb-4">
                                                <span class="col-md-4 col-xs-12 text-right">Account Number :</span>
                                                <span class="col-6 col-xs-12">{{ isset($data->virtual_cards[0]->account_number_mask) ? $data->virtual_cards[0]->account_number_mask : '' }}</span>
                                            </div>
                                            <div class="row mb-4">
                                                <span class="col-md-4 col-xs-12 text-right">Credit Approve :</span>
                                                <span class="col-6 col-xs-12">{{ isset($data->virtual_cards[0]->card_limit) ? number_format($data->virtual_cards[0]->card_limit,2) : '' }}</span>
                                            </div>
                                            <div class="row mb-4">
                                                <span class="col-md-4 col-xs-12 text-right">Approve Period :</span>
                                                <span class="col-6 col-xs-12">{{ isset($data->start_date) ? date('d/m/Y', strtotime($data->start_date))  : '' }} - {{ isset($data->end_date) ? date('d/m/Y', strtotime($data->end_date))  : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @if(isset($data->card_setting) && $data->card_setting != null)
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <h4 class="mb-3"> Card Setting </h4>
                                            </div>
                                            <div class="col-12">
                                                <table class="table table-sm table-bordered ">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Description</th>
                                                            <th>Override Code</th>
                                                            <th>Override Value</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($data->card_setting as $i => $v)
                                                            <tr>
                                                                <td>{{ $v->rule_code }}</td>
                                                                <td style="white-space: normal !important;">{{ $v->rule_desc }}</td>
                                                                <td>{{ $v->override == true ? $v->override_code : '-' }}</td>
                                                                <td>{{ $v->override == true ? $v->override_value : '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Card Transaction</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                    <!-- <div class="col-4"></div> -->
                             
                                </div>
                                <br>
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input class="form-control daterange" name="daterange" placeholder="Start date - End date" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input class="form-control" name="txn_id" id="txn_id" type="text" value="" placeholder="Transaction ID">
                                        </div>
                                    </div>
                                    <!-- <div class="offset-md-10 col-md-2"> -->
                                    <div class="col-4">
                                        <div class="form-group">
                                            <button type="button" id="search" class="btn btn-primary ">{{__('common.search')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="bill_table" class="table table-flush dataTable"></table>
                            </div>
                        </div>
                        </div>
                    @endif


                    @if(isset($data->status) && ($data->status == 'NEW' || $data->status == 'REJECT'))
                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Setup Card Profile</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-12">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label>Credit Limit</label>
                                                            <input type="text" class="form-control" name="credit_limit" value="{{ $data->credit_request }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group col-12">
                                                            <label>Card Use Period</label>
                                                            <input type="text" class="form-control" name="card_use_period">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h3 class="mb-0">Setup Card Limit</h3>
                                    </div>
                                    <div class="col-4 text-right">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="accordion" id="accordionRule">

                                            @foreach($type as $k => $v)
                                                <div class="card mb-1">
                                                    <div class="card-header py-2 {{ !$v->override ? 'no-icon' : '' }}" id="heading_{{ $k }}">
                                                        <h2 class="mb-0">
                                                            @if($v->rule_code != 'SPV')
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="hidden" name="config[{{ $k }}][ruleCode]" value="{{ $v->rule_code }}">
                                                                        <input class="custom-control-input" type="checkbox" id="config_{{ $k }}" data-toggle="collapse" data-target="#collapse_{{ $k }}" checked="checked">
                                                                    <label class="custom-control-label" for="config_{{ $k }}">
                                                                        {{ $v->rule_code }} : {{ $v->rule_desc }}
                                                                    </label>
                                                                </div>
                                                            @else
                                                                <div class="custom-control py-2">
                                                                    <input type="hidden" name="config[{{ $k }}][ruleCode]" value="{{ $v->rule_code }}">
                                                                    <label class="control-label mb-0" for="config_{{ $k }}">
                                                                        {{ $v->rule_code }} : {{ $v->rule_desc }}
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        </h2>
                                                    </div>
                                                    @if($v->override)
                                                        @if(isset($v->override_rules))
                                                            <div id="collapse_{{ $k }}" class="collapse show">
                                                                <div class="card-body">
                                                                    <div class="col-8">
                                                                        <div class="table-responsive">
                                                                        <table class="table table-sm table-bordered">
                                                                            <thead>
                                                                                <th colspan="2">Override</th>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($v->override_rules as $i => $o)
                                                                                <tr class="{{ $v->rule_code == 'SPV' && ($o->override_code == 'startDate' || $o->override_code == 'endDate') ? 'recurring_date_range' : '' }} {{ $v->rule_code == 'SPV' && ($o->override_code == 'recurringDay') ? 'recurring_date_number' : '' }}"
                                                                                    style="display: {{ $v->rule_code == 'SPV' && ($o->override_code == 'recurringDay') ? 'none' : '' }}"
                                                                                >
                                                                                    <td class="py-1 px-3 text-left align-middle">
                                                                                        <span>{{ $o->override_code }}</span>
                                                                                    </td>
                                                                                    <td class="py-1 px-2" style="width: 30%">
                                                                                        <input type="hidden" name="config[{{ $k }}][overrides][{{ $i }}][sequence]" value="{{ $i }}"  {{ $o->override_code == 'recurringDay' ? "disabled" : "" }}>
                                                                                        @if($o->override_code == 'amountCurrencyCode')
                                                                                            <select class="form-control input-sm" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]">
                                                                                                @if($currencies != NULL)
                                                                                                    @foreach($currencies as $c)
                                                                                                        <option value="{{ $c->NumericCode }}" {{ $c->NumericCode == 764 ? 'selected' : '' }}> {{ $c->Currency }} </option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </select>
                                                                                        @elseif($o->override_code == 'recurringDay')
                                                                                            <select class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]" disabled>
                                                                                                @for ($i = 1; $i <= 28; $i++)
                                                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        @elseif($o->override_code == 'rangeType')
                                                                                            <select class="form-control recurring_type" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]">
                                                                                                <option value="1">Recurring</option>
                                                                                                <option value="2">Monthly</option>
                                                                                                <option value="3" selected>DateRange</option>
                                                                                            </select>
                                                                                        @elseif($o->override_code == 'startDate')
                                                                                            <div class="input-group input-group-alternative">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                                                                </div>
                                                                                                <input class="form-control datepicker" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]"  placeholder="Select date" type="text" value="{{ isset($data->start_date) ? date('d/m/Y',strtotime($data->start_date)) : '' }}">
                                                                                            </div>
                                                                                        @elseif($o->override_code == 'endDate')
                                                                                            <div class="input-group input-group-alternative">
                                                                                                <div class="input-group-prepend">
                                                                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                                                                </div>
                                                                                                <input class="form-control datepicker" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]"  placeholder="Select date" type="text" value="{{ isset($data->end_date) ? date('d/m/Y',strtotime($data->end_date)) : '' }}">
                                                                                            </div>
                                                                                        @elseif($o->override_code == 'amountValue' || $o->override_code == 'minValue'  || $o->override_code == 'maxValue')
                                                                                            <input type="number" class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]" min="0">
                                                                                        @elseif($o->override_code == 'spendLimitAmount')
                                                                                            <input type="number" class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]" min="0" value="{{ $data->credit_request ?? 0 }}">
                                                                                        @elseif($o->override_code == 'timeEffectiveStart' || $o->override_code == 'timeEffectiveEnd')
                                                                                            <input type="time" class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]">
                                                                                        @elseif($o->override_code == 'timezone')
                                                                                            <select class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]">
                                                                                                <option></option>
                                                                                                <option value="Etc/GMT+12">(GMT-12:00) International Date Line West</option>
                                                                                                <option value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                                                                                <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
                                                                                                <option value="US/Alaska">(GMT-09:00) Alaska</option>
                                                                                                <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                                                                                                <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
                                                                                                <option value="US/Arizona">(GMT-07:00) Arizona</option>
                                                                                                <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                                                                <option value="US/Mountain">(GMT-07:00) Mountain Time (US & Canada)</option>
                                                                                                <option value="America/Managua">(GMT-06:00) Central America</option>
                                                                                                <option value="US/Central">(GMT-06:00) Central Time (US & Canada)</option>
                                                                                                <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                                                                <option value="Canada/Saskatchewan">(GMT-06:00) Saskatchewan</option>
                                                                                                <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                                                                <option value="US/Eastern">(GMT-05:00) Eastern Time (US & Canada)</option>
                                                                                                <option value="US/East-Indiana">(GMT-05:00) Indiana (East)</option>
                                                                                                <option value="Canada/Atlantic">(GMT-04:00) Atlantic Time (Canada)</option>
                                                                                                <option value="America/Caracas">(GMT-04:00) Caracas, La Paz</option>
                                                                                                <option value="America/Manaus">(GMT-04:00) Manaus</option>
                                                                                                <option value="America/Santiago">(GMT-04:00) Santiago</option>
                                                                                                <option value="Canada/Newfoundland">(GMT-03:30) Newfoundland</option>
                                                                                                <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                                                                                <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires, Georgetown</option>
                                                                                                <option value="America/Godthab">(GMT-03:00) Greenland</option>
                                                                                                <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                                                                                                <option value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                                                                                <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                                                                                <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                                                                                <option value="Africa/Casablanca">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
                                                                                                <option value="Etc/Greenwich">(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                                                                                                <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                                                                                <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                                                                                <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                                                                <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                                                                                                <option value="Africa/Lagos">(GMT+01:00) West Central Africa</option>
                                                                                                <option value="Asia/Amman">(GMT+02:00) Amman</option>
                                                                                                <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
                                                                                                <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                                                                                <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                                                                                <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
                                                                                                <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                                                                                                <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                                                                                <option value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                                                                                <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
                                                                                                <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
                                                                                                <option value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                                                                <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
                                                                                                <option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
                                                                                                <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                                                                                <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
                                                                                                <option value="Asia/Baku">(GMT+04:00) Baku</option>
                                                                                                <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                                                                                <option value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                                                                                <option value="Asia/Yekaterinburg">(GMT+05:00) Yekaterinburg</option>
                                                                                                <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
                                                                                                <option value="Asia/Calcutta">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                                                                <option value="Asia/Calcutta">(GMT+05:30) Sri Jayawardenapura</option>
                                                                                                <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                                                                                <option value="Asia/Almaty">(GMT+06:00) Almaty, Novosibirsk</option>
                                                                                                <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                                                                                <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                                                                                <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                                                                <option value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
                                                                                                <option value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                                                                <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>
                                                                                                <option value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                                                                <option value="Australia/Perth">(GMT+08:00) Perth</option>
                                                                                                <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
                                                                                                <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                                                                <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                                                                                <option value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                                                                                <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                                                                                <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                                                                                <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                                                                                                <option value="Australia/Canberra">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                                                                                                <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                                                                                <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
                                                                                                <option value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                                                                                <option value="Asia/Magadan">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
                                                                                                <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                                                                                                <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                                                                <option value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                                                                            </select>
                                                                                        @elseif($o->override_code == 'updateFlag')
                                                                                            <input type="text" class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]" value="NOCHANGE">
                                                                                        @else
                                                                                            <input type="text" class="form-control" name="config[{{ $k }}][overrides][{{ $i }}][overrideValue]">
                                                                                        @endif
                                                                                        <input type="hidden" name="config[{{ $k }}][overrides][{{ $i }}][overrideCode]" value="{{ $o->override_code }}" {{ $o->override_code == 'recurringDay' ? "disabled" : "" }}>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="{{ URL::to('/Visa/VirtualCard/')}}" class="btn btn-warning mt-3">Cancel</a>
                            <button type="submit" id="btn_submit" class="btn btn-success mt-3">Save</button>
                        </div>
                    @endif

                </form>
            </div>
        </div>
    </div>

@endsection


@section('script')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>
    
<script type="text/javascript">

    $('input[name="card_use_period"]').daterangepicker({
        // startDate: moment().subtract(7, 'days'),
        // endDate: moment(),
        startDate: "{{ date('d/m/Y',strtotime($data->start_date))  }}",
        endDate: "{{ date('d/m/Y',strtotime($data->end_date))  }}",
        timePicker: true,
        dateLimit: {
            "months": 1
        },
        timePickerIncrement: 30,
        timePicker24Hour: true,
        locale: {
            format: 'DD/MM/YYYY'
        }

    }, function (start, end) {
        $('input[name="card_use_period"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
    });

    $('input[type="checkbox"]').change(function() {
        $(this).parents().eq(3).find('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
        $(this).parents().eq(3).find('input[type="text"]').prop('disabled', function(i, v) { return !v; });
        $(this).parents().eq(3).find('input[type="time"]').prop('disabled', function(i, v) { return !v; });
        $(this).parents().eq(3).find('input[type="number"]').prop('disabled', function(i, v) { return !v; });
        $(this).parents().eq(3).find('select').prop('disabled', function(i, v) { return !v; });
    });

    $(".datepicker").datepicker({
        format: 'dd/mm/yyyy'
    });

    $('.recurring_type').change(function() {

        $('.recurring_date_range').find('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
        $('.recurring_date_range').find('input[type="text"]').prop('disabled', function(i, v) { return !v; });
        $('.recurring_date_range').find('select').prop('disabled', function(i, v) { return !v; });

        $('.recurring_date_number').find('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
        $('.recurring_date_number').find('input[type="text"]').prop('disabled', function(i, v) { return !v; });
        $('.recurring_date_number').find('select').prop('disabled', function(i, v) { return !v; });

        $('.recurring_date_range').toggle();
        $('.recurring_date_number').toggle();

        if($(this).val() == 2) {
            $('.recurring_date_range').attr('disabled',false);
            $('.recurring_date_range').attr('disabled',false);
            $('.recurring_date_range').hide();

            $('.recurring_date_number').attr('disabled',true);
            $('.recurring_date_number').attr('disabled',true);
            $('.recurring_date_number').show();
        } else if($(this).val() == 3) {
            $('.recurring_date_range').attr('disabled',true);
            $('.recurring_date_range').attr('disabled',true);
            $('.recurring_date_range').show();

            $('.recurring_date_number').attr('disabled',false);
            $('.recurring_date_number').attr('disabled',false);
            $('.recurring_date_number').hide();
        } else {
            $('.recurring_date_range').attr('disabled',true);
            $('.recurring_date_range').attr('disabled',true);
            $('.recurring_date_range').hide();

            $('.recurring_date_number').attr('disabled',true);
            $('.recurring_date_number').attr('disabled',true);
            $('.recurring_date_number').hide();
        }

    });

 
		$(document).ready(function(){

            $('#search').on('click', function () {
                table.search( this.value ).draw()
            })

            $('input[name="daterange"]').daterangepicker({
      			startDate: moment().subtract(7, 'days'),
      			endDate: moment(),
    		    timePicker: true,
    		    dateLimit: {
    		        "months": 1
    		    },
    		    timePickerIncrement: 30,
    		    timePicker24Hour: true,
    		    locale: {
    		        format: 'DD/MM/YYYY'
    		    }

    		}, function (start, end) {
    		    $('input[name="daterange"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
    		})

			var table = $("#bill_table").DataTable({
				sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 6, "desc" ]],
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
					url: '{!! URL::to("Visa/VirtualCard/post_perform") !!}',
					method: 'POST',
						data: function (d) {
                        d._token        = "{{ csrf_token() }}"
                        d.virtual_card_reference     = $('input[name="virtual_card_reference"]').val() || '',
                        d.txn_id     = $('input[name="txn_id"]').val() || '',
                        d.daterange = $('input[name="daterange"]').val()
                        
					}
                },
				columns: [
                    { data: 'transaction_id',      name: 'transaction_id',     title: "Transaction id"  },
					{ data: 'transaction_amount',        name: 'transaction_amount',       title: "Transaction Amount"   },
                    { data: 'auth_status',          name: 'auth_status', title: "Auth Status"   },
                    { data: 'mcc',  name: 'mcc', title: "MCC"   },
                    { data: 'created_by',  name: 'created_by', title: "Created By"   },
                    { data: 'full_name',  name: 'full_name', title: "Full Name"   },
                    { data: 'created_at',  name: 'created_at', title: "Created at"   }
                ],
              
				columnDefs: [
				],
				aoColumnDefs: [
                 
				]
            })

		});


    
</script>
@endsection