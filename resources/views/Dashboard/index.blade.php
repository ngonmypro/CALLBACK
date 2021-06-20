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
                                            <h5 class="card-title text-uppercase text-muted mb-0">{{ $detail->bill_status ?? '' }}</h5>
                                            <span class="h2 font-weight-bold mb-0">{{ $detail->count_bill_status ?? '' }} {{__('dashboard.bill')}}</span>
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
                                            @elseif($detail->bill_status == "PAID")
                                                <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                    <i class="ni ni-check-bold"></i>
                                                </div>
                                            @elseif($detail->bill_status == "UNPAID")
                                                <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                                    <i class="ni ni-fat-remove"></i>
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
                                <h5 class="text-uppercase ls-1 mb-1">{{__('dashboard.overview')}} {{__('dashboard.sale_value')}}</h5>
                            </div>
                            <div class="col">
                                <!-- <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark">
                                    <span class="d-none d-md-block" style="color: white;"><i class="bg-gradient-info ni ni-sound-wave"></i> Prompt Pay</span>                                      
                                    </li>
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark">
                                        <span class="d-none d-md-block" style="color: white;"><i class="bg-gradient-warning ni ni-sound-wave"></i> Credit Card</span>                
                                    </li>
                                    <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark">
                                        <span class="d-none d-md-block" style="color: white;"><i class="bg-gradient-success ni ni-sound-wave"></i> Cash</span>                                  
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart" width="400" height="400"></canvas>
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
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <h4 class="text-uppercase ls-1 mb-1">{{__('dashboard.lastest_batch')}}</h4>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="broadcast" class="table table-flush dataTable" style="width:100%">
                            <thead>
                            <tr>
                                <th>{{__('dashboard.batch_name')}}</th>
                                <th class="text-center">{{__('dashboard.total_bills')}}</th>
                                <th class="text-center">{{__('dashboard.total_amount')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if( isset($dashboard_data->bill_batch) && !blank($dashboard_data->bill_batch))
                                    @foreach($dashboard_data->bill_batch as $detail)
                                    <tr>
                                        <td>{{ $detail->batch_name ?? '' }}</td>
                                        <td class="text-center">{{ $detail->total_bill ?? 0 }}</td>
                                        <td class="text-center">{{ number_format($detail->total_amount ?? 0, 2) }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
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
                            <div class="card-body table-responsive">
                                <table id="lastest_payment" class="table table-flush dataTable">
                                    <thead>
                                    <tr>
                                        <th>{{__('dashboard.recipeint_id')}}</th>
                                        <th class="text-center">{{__('dashboard.total_amount')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if( isset($dashboard_data->lastest_payment) && !blank($dashboard_data->lastest_payment))
                                            @foreach($dashboard_data->lastest_payment as $detail)
                                            <tr>
                                                <td>{{ $detail->recipient_id  ?? '' }}</td>
                                                <td class="text-center">{{ number_format($detail->amount ?? 0, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
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
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        @if(strtoupper($key_detail) === 'TOTAL_CORPORATE')
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.corporate_in_system')}}</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($detail->active ?? 0, ) }} / {{ number_format($detail->total, ) }}</span>
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
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($detail[0]->total_recipient ?? 0, ) }}</span>
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
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.total_recipient')}}</h5>
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
                        @endforeach
                    @endif
                </div>
                <div class="row">
                    @if( isset($dashboard_data->div_block_2) && !blank($dashboard_data->div_block_2) )
                        @foreach($dashboard_data->div_block_2 as $key_detail => $detail)
                            <div class="col-xl-3 col-md-6">
                                <div class="card card-stats">
                                    <div class="card-body">
                                        @if(strtoupper($key_detail) === 'TOTAL_BILL_CURRENT_MONTH')
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.total_bill_cur_month')}}</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($detail[0]->total_bill_current_month ?? 0, ) }}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                        <i class="ni ni-box-2"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2">{{__('dashboard.bill')}}</span>
                                            </p>
                                        @elseif(strtoupper($key_detail) === 'TOTAL_AMOUNT_CHARGE')
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{__('dashboard.charge_month') }}</h5>
                                                    <span class="h2 font-weight-bold mb-0 number comma">{{ number_format($detail[0]->total_amount_charge ?? 0, ) }}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                        <i class="ni ni-send"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2">{{__('dashboard.thb')}}</span>
                                            </p>
                                        @elseif(strtoupper($key_detail) === 'TOTAL_AMOUNT_PAID')
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('dashboard.total_amount_paid') }}</h5>
                                                    <span class="h2 font-weight-bold mb-0">{{ number_format($detail[0]->total_amount_paid ?? 0, 2) }}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-success text-white rounded-circle shadow">
                                                        <i class="ni ni-money-coins"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="mt-3 mb-0 text-sm">
                                                <span class="text-success mr-2">{{__('dashboard.thb')}}</span>
                                            </p>
                                        @endif
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
                                <h6 class="text-uppercase mb-0">{{__('dashboard.')}}</h6>
                                <h5 class="text-uppercase mb-0">{{__('dashboard.overview')}}</h5>
                            </div>
                            <div class="col">
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="agent-barChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase mb-0">{{__('dashboard.')}}</h6>
                                <h5 class="text-uppercase mb-0">{{__('dashboard.proportion')}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="agent-pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <h4 class="text-uppercase mb-0">{{__('dashboard.charge_on_month')}}</h4>
                        </div>
                    </div>
                    <div class="table-responsive py-4 card-body">
                        <table id="max_corporate_charge" class="table table-flush" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <h4 class="text-uppercase mb-0">{{__('dashboard.max_charge_on_month')}}</h4>
                        </div>
                    </div>
                    <div class="table-responsive py-4 card-body">
                        <table id="max_bill_paid" class="table table-flush" style="width:100%">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @EndPermission
@endsection

@section('script')
<script src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/extensions/jquery.blockUI.js') }}"></script>

<!--- Daterange picker --->
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        ////////////////////////////////////////////////////////////////
        @if(Session::get('user_detail')->user_type === 'USER')
            var summary = {!! json_encode($dashboard_data->payment_channel_summary ?? null) !!};
            var summary_month = [];
            var months = [];
            var channel = [];
            // console.log(summary)
            var label = [];
            var data = [];

            for (i = 0; i < summary.length; i++)
            {
                if(months.indexOf(summary[i].months) == -1) {
                    months.push(summary[i].months)
                }
            }

            var canvas = document.getElementById("barChart");
            var ctx = canvas.getContext('2d');

            // Global Options:
            // Chart.defaults.global.defaultFontColor = 'white';
            Chart.defaults.global.defaultFontSize = 16;

            var data = {
                labels: months,
                
            };

            var options = {
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            var yLabel = t.yLabel.toLocaleString(undefined, { minimumFractionDigits: 2 });
                            return xLabel + ': ' + yLabel;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback: function(value) {
                                return value.toLocaleString(undefined, { minimumFractionDigits: 2 });
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '{{__('dashboard.overview')}}',
                            fontSize: 20 
                        }
                    }]            
                } ,
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(0, 0, 0)',
                        fontSize: 14
                    },
                }
            };

            var myBarChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: options
            });

            var month = "";
            var chan = ""
            var sums = {};
            var color_line = "";

            @if( isset($dashboard_data->payment_channel_summary) && !blank($dashboard_data->payment_channel_summary))
                var i = 0;
                @foreach($dashboard_data->payment_channel_summary as $v)
                    if(i == 0) {
                        chan = "{!! $v->payment_channel !!}" 
                        i++
                    }

                    if(chan == "Cash") {
                        color_line = "rgb(92,206,162)";
                    }
                    else if(chan == "CREDIT_CARD") {
                        color_line = "rgb(240,115,60)";
                    }
                    else if(chan == "PROMPT_PAY") {
                        color_line = "rgb(35,132,239)";
                    }
                    else {
                        color_line = getRandomRgb();
                    }

                    if("{!! $v->payment_channel !!}" != chan ) {
                        var sum_with_month = summaryWithMonth(sums);
                        console.log(chan)
                        var _data = {
                                    label: chan,
                                    fill: false,
                                    lineTension: 0.1,
                                    backgroundColor: "rgba(167,105,0,0.4)",
                                    borderColor: color_line,
                                    borderCapStyle: 'butt',
                                    borderDash: [],
                                    borderDashOffset: 0.0,
                                    borderJoinStyle: 'miter',
                                    pointBorderColor: "white",
                                    pointBackgroundColor: color_line,
                                    pointBorderWidth: 1,
                                    pointHoverRadius: 8,
                                    pointHoverBackgroundColor: "brown",
                                    pointHoverBorderColor: "yellow",
                                    pointHoverBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHitRadius: 10,
                                    data: sum_with_month,
                                    spanGaps: false,
                                };

                        addData(myBarChart, month, _data)
                        sums = [];
                        chan = "{!! $v->payment_channel !!}";
                    }
                    month = "{!! $v->months !!}";
                    sums["{!! $v->months !!}"] = "{!! $v->sums !!}";
                @endforeach

                if(sums != []) {
                    console.log(chan)
                    var sum_with_month = summaryWithMonth(sums);
                    var _data = {
                        label: chan,
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(167,105,0,0.4)",
                        borderColor: color_line,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "white",
                        pointBackgroundColor: color_line,
                        pointBorderWidth: 1,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: "brown",
                        pointHoverBorderColor: "yellow",
                        pointHoverBorderWidth: 2,
                        pointRadius: 4,
                        pointHitRadius: 10,
                        data: sum_with_month,
                        spanGaps: false,
                    };
                    addData(myBarChart, month, _data)
                }
            @endif

            // pie chart
            var bill_status = [];
            var count_status = [];
            var color_pie = [];
            @if( isset($dashboard_data->payment_status) && !blank($dashboard_data->payment_status) )
                @foreach($dashboard_data->payment_status as $v)
                    bill_status.push("{!! $v->bill_status !!}")
                    count_status.push("{!! $v->count_status !!}")

                    @if($v->bill_status === "ISSUE")
                        color_pie.push("rgb(133,181,218)");
                    @elseif($v->bill_status === "NEW")
                        color_pie.push("rgb(26,123,238)");
                    @elseif($v->bill_status === "PAID")
                        color_pie.push("rgb(93,207,152)");
                    @elseif($v->bill_status === "UNPAID")
                        color_pie.push("rgb(242,140,60)");
                    @elseif($v->bill_status === "UNMATCH")
                        color_pie.push("rgb(255,0,60)");
                    @elseif($v->bill_status === "INACTIVE")
                        color_pie.push("rgb(134,134,134)");
                    @else
                        color_pie.push(getRandomRgb());
                    @endif
                @endforeach
            @endif

            var pie_ctx = document.getElementById("pieChart").getContext('2d');

            var chart = new Chart(pie_ctx, {
                type: 'pie',
                data: {
                    labels: bill_status,
                    datasets: [{
                        backgroundColor: color_pie,
                        data: count_status
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            fontColor: 'rgb(0, 0, 0)'
                        }
                    },
                }
            });
        @elseif(Session::get('user_detail')->user_type === 'AGENT')
        
        ///////////////////////////// graph function /////////////////////////////
            var summary = {!! json_encode($dashboard_data->total_bill_summary ?? null) !!};
            var summary_month = [];
            var months = [];
            var channel = [];
            var label = [];
            var data = [];

            for (i = 0; i < summary.length; i++)
            {
                if(months.indexOf(summary[i].month) == -1) {
                    months.push(summary[i].month)
                }
            }

            var canvas = document.getElementById("agent-barChart");
            var ctx = canvas.getContext('2d');
            var chartType = 'bar';
            var myBarChart;

            // Global Options:
            Chart.defaults.global.defaultFontColor = 'grey';
            Chart.defaults.global.defaultFontSize = 16;

            var options = {
                tooltips: {
                    callbacks: {
                        label: function(t, d) {
                            var xLabel = d.datasets[t.datasetIndex].label;
                            var yLabel = t.yLabel.toLocaleString(undefined, { minimumFractionDigits: 2 });
                            return xLabel + ': ' + yLabel;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                            callback: function(value) {
                                return value.toLocaleString(undefined, { minimumFractionDigits: 2 });
                            }
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '{{__('dashboard.count_bill')}}',
                            fontSize: 20 
                        }
                    }]            
                } ,
                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(134, 134, 134)',
                        fontSize: 14
                    },
                }
            };

            var all_bill = []
            var bill_paid = []
            @if( isset($dashboard_data->total_bill_summary) && !blank($dashboard_data->total_bill_summary) )
                @foreach($dashboard_data->total_bill_summary as $v)
                    all_bill.push("{!! $v->all_bill !!}")
                    bill_paid.push("{!! $v->bill_paid !!}")
                @endforeach
            @endif

            myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: "Bill Send",
                            backgroundColor: "#3e95cd",
                            data: all_bill
                        }, {
                            label: "Bill Paid",
                            backgroundColor: "#ef613d",
                            data: bill_paid
                        }
                    ]
                },
                options: options
            });

            // agent pie chart
            var bill_status = [];
            var count_status = [];
            var color_pie = [];
            @if( isset($dashboard_data->proportion_bill) && !blank($dashboard_data->proportion_bill) )
                @foreach($dashboard_data->proportion_bill as $v)
                    bill_status.push("{!! $v->bill_status !!}")
                    count_status.push("{!! $v->total_bill !!}")
                    @if($v->bill_status === "ISSUE")
                        color_pie.push("rgb(133,181,218)");
                    @elseif($v->bill_status === "NEW")
                        color_pie.push("rgb(26,123,238)");
                    @elseif($v->bill_status === "PAID")
                        color_pie.push("rgb(93,207,152)");
                    @elseif($v->bill_status === "UNPAID")
                        color_pie.push("rgb(242,140,60)");
                    @elseif($v->bill_status === "UNMATCH")
                        color_pie.push("rgb(200,40,40)");
                    @else
                        color_pie.push(getRandomRgb());
                    @endif
                @endforeach
            @endif

            var pie_ctx = document.getElementById("agent-pieChart").getContext('2d');

            var chart = new Chart(pie_ctx, {
                type: 'pie',
                data: {
                    labels: bill_status,
                    datasets: [{
                        backgroundColor: color_pie,
                        data: count_status
                    }]
                },
                options: {
                    legend: {
                        display: true,
                        labels: {
                            fontColor: 'rgb(0, 0, 0)'
                        }
                    },
                }
            });

            var table = $("#max_corporate_charge").DataTable({
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
                    url: '{!! URL::to("getMaxChange") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token    = "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'name_th',         title: '{{__('corp_name')}}' },
                    { data: 'total_bill',      title: '{{__('total_bill')}}'  },
                    { data: 'total_amount',    title: '{{__('total_amount')}}'  }
                ],
                aoColumnDefs: [
                    { 
                        // className: "text-center", targets: "_all" 
                        className: "text-center", 
                        targets: [1, 2] 
                    },
                    {
                        targets: [1, 2],
                        mRender: function (data, type, full) {
                            var formmatedvalue=data.replace( /\d{1,3}(?=(\d{3})+(?!\d))/g , "$&,")
                            return formmatedvalue;
                        }
                    }
                ]
            })

            var table = $("#max_bill_paid").DataTable({
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
                    url: '{!! URL::to("getMaxBillPaid") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token    = "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'name_th',         title: '{{__('corp_name')}}' },
                    { data: 'invoice_number',      title: '{{__('invoice_number')}}'  },
                    { data: 'total_amount',    title: '{{__('total_amount')}}'  }
                ],
                aoColumnDefs: [
                    { 
                        // className: "text-center", targets: "_all" 
                        className: "text-center", 
                        targets: [1, 2] 
                    },
                    {
                        targets: [1, 2],
                        mRender: function (data, type, full) {
                            var formmatedvalue=data.replace( /\d{1,3}(?=(\d{3})+(?!\d))/g , "$&,")
                            return formmatedvalue;
                        }
                    }
                ]
            })
        @endif

        ///////////////////////////// graph function /////////////////////////////
        function getRandomRgb() {
            var num = Math.round(0xffffff * Math.random());
            var r = num >> 16;
            var g = num >> 8 & 255;
            var b = num & 255;
            return 'rgb(' + r + ', ' + g + ', ' + b + ')';
        }

        function addData(chart, label, data) {
            chart.data.datasets.push(data);
            chart.update();
        }

        function summaryWithMonth(sums) {
            var sum_with_month = [];
            for (i = 0; i < months.length; i++)
            {
                if(sums.hasOwnProperty(months[i]))
                    sum_with_month.push(sums[months[i]])
                else
                sum_with_month.push(null)
            }
            return sum_with_month
        }
    })
</script>
@endsection
