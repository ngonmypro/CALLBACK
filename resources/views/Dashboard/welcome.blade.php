@extends('argon_layouts.app', ['title' => __('Dashboard')])
<style>
    ul {
        position: relative;
        list-style: none;
        margin-left: 0;
        padding-left: 1.2em;
    }
    ul li:before {
        position: absolute;
        left: 0;
    }
</style>
@section('content')

    @includeIf('ShortCut.index')

    @Permission(DASHBOARD.VIEW)
        @if(Session::get('user_detail')->user_type == 'USER')
            <div class="header bg-primary pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">{{__('dashboard.dashboard')}}</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                </nav>
                            </div>
                        </div> 
                        <div class="row">
                            @if( isset($dashboard_data->total_bill_summary) && !blank($dashboard_data->total_bill_summary) )
                                @foreach($dashboard_data->total_bill_summary as $detail)
                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-stats">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="h5 mb-0">{{ $detail->bill_status ?? '' }}</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($detail->count_bill_status) ?? '' }} {{__('dashboard.bill')}}</span>
                                                </div>
                                                <div class="col-auto">
                                                    @if($detail->bill_status == "ISSUE")
                                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                            <i class="ni ni-send"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "NEW")
                                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                            <i class="ni ni-collection"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "EXPORTED")
                                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                            <i class="fa fa-envelope-open"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "PAID")
                                                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                            <i class="ni ni-check-bold"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "UNPAID")
                                                        <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                            <i class="ni ni-fat-remove"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "INACTIVE")
                                                        <div class="icon icon-shape bg-gradient-default text-white rounded-circle shadow">
                                                            <i class="ni ni-button-power"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "PENDING")
                                                        <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                            <i class="fa fa-spinner"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "CANCELLED")
                                                        <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "OVERDUE")
                                                        <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                            <i class="fa fa-calendar-times-o"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "REJECT")
                                                        <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                                            <i class="fa fa-exclamation-triangle"></i>
                                                        </div>
                                                    @elseif($detail->bill_status == "UNMATCH")
                                                        <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                                                            <i class="fa fa-exclamation"></i>
                                                        </div>
                                                    @else
                                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                            <i class="ni ni-folder-17"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2">{{ number_format($detail->sums ?? 0, 2) }} THB</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt--6">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="h3 mb-0">{{__('dashboard.overview')}} {{__('dashboard.sale_value')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    @if($userLineChart)
                                        {!! $userLineChart->container() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="h3 mb-0">{{__('dashboard.proportion')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    @if($userPieChart)
                                        {!! $userPieChart->container() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="h3 mb-0">{{__('dashboard.lastest_batch')}}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                                    @if( isset($dashboard_data->bill_batch) && !blank($dashboard_data->bill_batch))
                                        <thead>
                                        <tr>
                                            <th>{{__('dashboard.batch_name')}}</th>
                                            <th class="text-center">{{__('dashboard.total_bills')}}</th>
                                            <th class="text-center">{{__('dashboard.total_amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dashboard_data->bill_batch as $detail)
                                            <tr>
                                                <td>{{ $detail->batch_name ?? '' }}</td>
                                                <td class="text-center">{{ $detail->total_bill ?? 0 }}</td>
                                                <td class="text-center">{{ number_format($detail->total_amount ?? 0, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        @else 
                                            <thead>
                                                <tr>
                                                    <th class="text-center">{{__('dashboard.table_empty')}}</th>
                                                </tr>
                                            <thead>
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="h3 mb-0">{{__('dashboard.last_payment')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="lastest_payment" class="table table-flush dataTable">
                                    @if( isset($dashboard_data->lastest_payment) && !blank($dashboard_data->lastest_payment))
                                        <thead>
                                        <tr>
                                            <th>{{__('dashboard.recipeint_id')}}</th>
                                            <th class="text-center">{{__('dashboard.total_amount')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($dashboard_data->lastest_payment as $detail)
                                            <tr>
                                                <td>{{ $detail->recipient_id  ?? '' }}</td>
                                                <td class="text-center">{{ number_format($detail->amount ?? 0, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    @else 
                                        <thead>
                                            <tr>
                                                <th class="text-center">{{__('dashboard.table_empty')}}</th>
                                            </tr>
                                        <thead>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(Session::get('user_detail')->user_type == 'AGENT')
            <div class="header bg-primary pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 text-white d-inline-block mb-0">{{__('dashboard.dashboard')}}</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                </nav>
                            </div>
                        </div> 
                        <div class="row">
                            @if( isset($dashboard_data->div_block_1) && !blank($dashboard_data->div_block_1))
                                @foreach($dashboard_data->div_block_1 as $key_detail => $detail)
                                    @if(!blank($detail))
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-stats">
                                            <div class="card-body">
                                                @if(strtoupper($key_detail) === 'TOTAL_CORPORATE')
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.corporate_in_system')}}</h5>
                                                            <span class="h2 font-weight-bold mb-0">{{ number_format($detail->active) }} / {{ number_format($detail->total) }}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                                                <i class="ni ni-basket"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-sm">
                                                        <span class="text-success mr-2">{{__('dashboard.active')}} / {{__('dashboard.total')}}</span>
                                                    </p>
                                                @elseif(strtoupper($key_detail) === 'TOTAL_RECIPEINT')
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.total_recipient')}}</h5>
                                                            <span class="h2 font-weight-bold mb-0">{{ number_format($detail[0]->total_recipient) }}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                                                <i class="ni ni-circle-08"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-sm">
                                                        <span class="text-success mr-2">{{__('dashboard.active')}}</span>
                                                    </p>
                                                @elseif(strtoupper($key_detail) === 'TOTAL_INVOICE')
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.total_invoice')}}</h5>
                                                            <span class="h2 font-weight-bold mb-0">{{ number_format($detail[0]->total_invoice) }}</span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                                                <i class="ni ni-collection"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="mt-3 mb-0 text-sm">
                                                        <span class="text-success mr-2">{{__('dashboard.bill')}}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            @if( isset($dashboard_data->div_block_2) && !blank($dashboard_data->div_block_2) )
                                @foreach($dashboard_data->div_block_2 as $key_detail => $detail)
                                    @if(strtoupper($key_detail) === 'TOTAL_INVOICE_PAID')
                                    <div class="col-xl-4 col-md-6">
                                        <div class="card card-stats">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.invoice_paid') }}</h5>
                                                        <span class="h2 font-weight-bold mb-0 number comma">{{ number_format($detail->invoice_paid) }} / {{ number_format($detail->invoice_total) }}</span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                            <i class="ni ni-send"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-sm">
                                                    <span class="text-success mr-2">{{__('dashboard.paid')}} / {{__('dashboard.total')}} ({{__('dashboard.bill')}})</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif(strtoupper($key_detail) === 'TOTAL_AMOUNT_INVOICE_PAID')
                                    <div class="col-xl-4 col-md-8">
                                        <div class="card card-stats">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <h5 class="card-title text-uppercase text-muted mb-0">{{ __('dashboard.total_amount_paid') }}</h5>
                                                        <span class="h3 font-weight-bold mb-0">{{ number_format($detail->invoice_amount_paid ?? 0, 2) }} / {{ number_format($detail->invoice_amount_total ?? 0, 2) }}</span>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                            <i class="ni ni-money-coins"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="mt-3 mb-0 text-sm">
                                                    <span class="text-success mr-2">{{__('dashboard.paid')}} / {{__('dashboard.total')}} ({{__('dashboard.thb')}})</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif   
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt--6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="text-uppercase mb-0">{{__('dashboard.overview_bill_send')}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    @if($SendBillChart)
                                        {!! $SendBillChart->container() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card" style="height:94%">
                            <div class="card-header bg-transparent">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="text-uppercase mb-0">{{__('dashboard.proportion_paid')}}</h5>
                                    </div>
                                </div>
                            </div>
                            @if( isset($dashboard_data->table->summary_payment_channel) && !blank($dashboard_data->table->summary_payment_channel) )
                                <div class="card-body table-responsive p-3">
                                    <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                                        </thead>
                                            <tr>
                                                <th>{{__('dashboard.month')}}</th>
                                                <th class="text-center">{{__('dashboard.qr')}}</th>
                                                <th class="text-center">{{__('dashboard.credit')}}</th>
                                                <th class="text-center">{{__('dashboard.other')}}</th>
                                                <th class="text-center">{{__('dashboard.all')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $round = 0; @endphp
                                            @foreach($dashboard_data->table->summary_payment_channel as $summary)
                                                <tr>
                                                    <td>{{ $summary->month }}</td>
                                                    <td class="text-center">{{ isset($summary->PROMPT_PAY) ? $summary->PROMPT_PAY : '-' }}</td>
                                                    <td class="text-center">{{ isset($summary->CREDIT_CARD) ? $summary->CREDIT_CARD : '-' }}</td>
                                                    <td class="text-center">{{ isset($summary->OTHER) ? $summary->OTHER : '-' }}</td>
                                                    <td class="text-center">{{ isset($summary->ALL) ? $summary->ALL : '-' }}</td>
                                                </tr>
                                                @if($round >= 5)
                                                    @php break; @endphp
                                                @endif
                                                @php $round++; @endphp
                                            @endforeach
                                        <tbody>
                                    </table>
                                </div>    
                            @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="text-uppercase mb-0">{{__('dashboard.overview_payment_channel')}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                @if($SummaryPaymentBarChart)
                                    {!! $SummaryPaymentBarChart->container() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="text-uppercase mb-0">{{__('dashboard.most_value')}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                                        @if(isset($dashboard_data->table->corp_most_value))
                                            </thead>
                                                <tr>
                                                    <th class="text-center">{{__('dashboard.sequence')}}</th>
                                                    <th>{{__('dashboard.corp_name')}}</th>
                                                    <th>{{__('dashboard.value')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $round = 1; @endphp
                                                @foreach($dashboard_data->table->corp_most_value as $value)
                                                    <tr>
                                                        <td class="text-center">{{ $round }}</td>
                                                        <td>{{ isset($value->corp_name_en) ? $value->corp_name_en : '-' }}</td>
                                                        <td>{{ isset($value->total_amount) ? number_format($value->total_amount ?? 0, 2) : '-' }}</td>
                                                    </tr>
                                                    @php $round++; @endphp
                                                @endforeach
                                            </tbody>
                                        @else
                                            <tbody>
                                                <tr>
                                                </tr>
                                            </tbody>
                                        @endif
                                    </table>
                                </div>       
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h5 class="text-uppercase mb-0">{{__('dashboard.most_invoice')}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                                        @if(isset($dashboard_data->table->corp_most_invoice))
                                            </thead>
                                                <tr>
                                                    <th class="text-center">{{__('dashboard.sequence')}}</th>
                                                    <th>{{__('dashboard.corp_name')}}</th>
                                                    <th>{{__('dashboard.total_invoice')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $round = 1; @endphp
                                                @foreach($dashboard_data->table->corp_most_invoice as $corp_most_invoice)
                                                    <tr>
                                                        <td class="text-center">{{ $round }}</td>
                                                        <td>{{ isset($corp_most_invoice->corp_name_en) ? $corp_most_invoice->corp_name_en : '-' }}</td>
                                                        <td>{{ isset($corp_most_invoice->total_bill) ? number_format($corp_most_invoice->total_bill) : '-' }}</td>
                                                    </tr>
                                                    @php $round++; @endphp
                                                @endforeach
                                            </tbody>
                                        @else
                                            <tbody>
                                                <tr>
                                                </tr>
                                            </tbody>
                                        @endif
                                    </table>
                                </div>     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                        
        @endif
    @EndPermission
@endsection

@section('script')
<head>
    <meta charset="utf-8">
    @Permission(DASHBOARD.VIEW)
        @if(session('user_detail')->user_type == 'USER' && $userLineChart && $userPieChart)
            {!! $userLineChart->script() !!}
            {!! $userPieChart->script() !!}
        @elseif(session('user_detail')->user_type == 'AGENT' && $SendBillChart && $SummaryPaymentBarChart)
            {!! $SendBillChart->script() !!}
            {!! $SummaryPaymentBarChart->script() !!}
        @endif
    @EndPermission
</head>
@endsection