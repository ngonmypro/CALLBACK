<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Cache;
use App\Charts\DashboardChart;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->helper               = parent::Helper();
        $this->api_client 			= parent::APIClient();
        $this->CORP_CURRENT			= isset(Session::get('CORP_CURRENT')['id']) ? Session::get('CORP_CURRENT')['id'] : '';
        $this->CORP_CODE			= isset(Session::get('CORP_CURRENT')['corp_code']) ? Session::get('CORP_CURRENT')['corp_code'] : '';
        $this->BANK_CODE			= isset(Session::get('BANK_CURRENT')['code']) ? Session::get('BANK_CURRENT')['code'] : '';
    }

    public function index()
    {
        try {
            $dashboard_data = [];
            $user_detail = Session::get('user_detail');
            if($user_detail->user_type === 'USER') {
                if (!Cache::has($this->CORP_CODE.'_dashboard_data')){
                    $data = [
                                "corp_code" => $this->CORP_CODE,
                                "corp_id"   => $this->CORP_CURRENT
                            ];
                    $data_response = $this->helper->PostRequest($this->api_client, 'api/get/dashboard', [
                        'detail'	=> $data
                    ]);

                    if ($data_response->success ?? false) {
                        $dashboard_data = $data_response->data ?? null;
                        Cache::put($this->CORP_CODE.'_dashboard_data' ,$dashboard_data, 15);

                        $months = [];
                        if( isset($dashboard_data->payment_channel_summary) && !blank($dashboard_data->payment_channel_summary) ) {
                            foreach($dashboard_data->payment_channel_summary as $pms) {
                                if(!in_array($pms->months, $months)) {
                                    array_push($months, $pms->months);
                                }
                            }

                            if(count($months) == 1) {
                                $start_month = date('M Y', strtotime($months[0])-1);
                                array_push($months, $start_month);                            
                            }
                            usort($months, function($time_1, $time_2) {
                                $time_1 = strtotime($time_1);
                                $time_2 = strtotime($time_2);
                                return $time_1 - $time_2;
                            });
                        }

                        $userLineChart = $this->LineChart($dashboard_data, $months);
                        $userPieChart = $this->userPieChart($dashboard_data, $months);

                        return view('Dashboard.welcome',
                                [ 
                                    'userLineChart' => $userLineChart,
                                    'userPieChart'  => $userPieChart
                                ],
                                compact('dashboard_data'));
                    } else {
                        Session::flash('alert-class', 'alert-danger');
                        Session::flash('message', $data_response->message);

                        return redirect('/Exception/InternalError');
                    }
                }
                else {
                    $dashboard_data = Cache::get($this->CORP_CODE.'_dashboard_data');
                    $months = [];
                    if( isset($dashboard_data->payment_channel_summary) && !blank($dashboard_data->payment_channel_summary)) {
                        foreach($dashboard_data->payment_channel_summary as $pms) {
                            if(!in_array($pms->months, $months)) {
                                array_push($months, $pms->months);
                            }
                        }
                        if(count($months) == 1) {
                            $start_month = date('M Y', strtotime($months[0])-1);
                            array_push($months, $start_month);                            
                        }
                        usort($months, function($time_1, $time_2) {
                            $time_1 = strtotime($time_1);
                            $time_2 = strtotime($time_2);
                            return $time_1 - $time_2;
                        });
                    }

                    $userLineChart = $this->LineChart($dashboard_data, $months);
                    $userPieChart = $this->userPieChart($dashboard_data, $months);
                    return view('Dashboard.welcome',
                            [ 
                                'userLineChart' => $userLineChart,
                                'userPieChart'  => $userPieChart
                            ],
                            compact('dashboard_data'));
                }
            }
            else if ($user_detail->user_type === 'AGENT') {
                if (!Cache::has($this->BANK_CODE.'_dashboard_data')) {
                    $data_response = $this->helper->PostRequest($this->api_client, 'api/get/dashboard', []);
                    if ($data_response->success ?? false) {
                        $dashboard_data = $data_response->data ?? null;
                        Cache::put($this->BANK_CODE.'_dashboard_data' ,$dashboard_data, 15);
                        $SendBillChart = $this->SendBillChart($dashboard_data);
                        $SummaryPaymentBarChart = $this->SummaryPaymentBarChart($dashboard_data);

                        return view('Dashboard.welcome', [
                                        'SendBillChart'             => $SendBillChart,
                                        'SummaryPaymentBarChart'    => $SummaryPaymentBarChart
                                    ],
                                    compact('dashboard_data'));
                    }
                    else {
                        Session::flash('alert-class', 'alert-danger');
                        Session::flash('message', $data_response->message);

                        return redirect('/Exception/InternalError');
                    }
                }
                else {
                    $dashboard_data = Cache::get($this->BANK_CODE.'_dashboard_data');
                    $SendBillChart = $this->SendBillChart($dashboard_data);
                    $SummaryPaymentBarChart = $this->SummaryPaymentBarChart($dashboard_data);

                    return view('Dashboard.welcome', [
                                    'SendBillChart'             => $SendBillChart,
                                    'SummaryPaymentBarChart'    => $SummaryPaymentBarChart
                                ],
                                compact('dashboard_data'));
                }
            }

            return view('Dashboard.welcome', compact('dashboard_data'));
        } catch (\Exception $e) {
            report($e);
            return redirect()->to('/Exception/InternalError')->with([
                'alert-class'  => 'alert-danger',
                'message'      => $e->getMessage()
            ]);
        }
    }

    public function LineChart($dashboard_data, $months)
    {
        $userLineChart = new DashboardChart;
        $userLineChart->barwidth(0.0);
        $userLineChart->displaylegend(true);

        $sums = [];
        $sum_other_ch = [];
        $firstRound = 0;
        $chan = "";
        $color_line = "";
        $arr_payment = ["CREDIT_CARD", "PROMPT_PAY", "CASH", "TRANSFER"];

        if(isset($dashboard_data->payment_channel_summary) && !blank($dashboard_data->payment_channel_summary)) {
            foreach($dashboard_data->payment_channel_summary as $v) {
                if($firstRound == 0) {
                    $chan = strtoupper($v->payment_channel);
                    $firstRound++;
                }
                $color_line = $this->setColerLineByPaymentChannel($chan);
                if(strtoupper($v->payment_channel) != $chan) {
                    if(in_array(strtoupper($v->payment_channel), $arr_payment)) {
                        if($firstRound == 1) {
                            $firstRound++;
                            $chan = strtoupper($v->payment_channel);
                        }
                        else {
                            $sum_with_month = $this->summaryWithMonth($sums, $months);
                            $userLineChart->labels($months);
                            $userLineChart->dataset(str_replace("_", " ", $chan), 'line', $sum_with_month)
                                        ->color($color_line)
                                        ->backgroundcolor($color_line)
                                        ->fill(false);
    
                            $chan = strtoupper($v->payment_channel);
                            $sums = [];
                        }
                    }
                    else {
                        $sum_other_ch[$v->months] = isset($sum_other_ch[$v->months]) ? $sum_other_ch[$v->months] + $v->sums : $v->sums;
                    }
                }
                else if(!in_array(strtoupper($v->payment_channel), $arr_payment)) {
                    $sum_other_ch[$v->months] = isset($sum_other_ch[$v->months]) ? $sum_other_ch[$v->months] + $v->sums : $v->sums;
                }
                $sums[$v->months] = $v->sums;
            }
    
            if(!blank($sums)) {
                $color_line = $this->setColerLineByPaymentChannel($chan);
                $sum_with_month = $this->summaryWithMonth($sums, $months);
                $userLineChart->labels($months);
                $userLineChart->dataset(str_replace("_", " ", $chan), 'line', $sum_with_month)
                            ->color($color_line)
                            ->backgroundcolor($color_line)
                            ->fill(false);
                $userLineChart->options([
                    'scales' => [
                        'yAxes'=> [[
                            'scaleLabel'=> [
                                'display'=> true,
                                'labelString'=> trans('dashboard.total_amount'),
                                'fontSize'=> 14
                            ]
                        ]]
                    ],
                ]);
            }

            if(!blank($sum_other_ch)) {
                $color_line = $this->setColerLineByPaymentChannel('OTHER');
                $sum_with_month = $this->summaryWithMonth($sum_other_ch, $months);
                $userLineChart->labels($months);
                $userLineChart->dataset(str_replace("_", " ", 'OTHER'), 'line', $sum_with_month)
                            ->color($color_line)
                            ->backgroundcolor($color_line)
                            ->fill(false);
                $userLineChart->options([
                    'scales' => [
                        'yAxes'=> [[
                            'scaleLabel'=> [
                                'display'=> true,
                                'labelString'=> trans('dashboard.total_amount'),
                                'fontSize'=> 14
                            ]
                        ]]
                    ],
                ]);
            }
        }
        else {
            $userLineChart->labels(['EMPTY']);
            $userLineChart->dataset('EMPTY', 'line', [0]);
        }

        return $userLineChart;
    }

    public function setColerLineByPaymentChannel($chan)
    {
        $color_line = '';
        if($chan == "CASH") {
            $color_line = "rgb(92,206,162)";
        }
        else if($chan == "CREDIT_CARD") {
            $color_line = "rgb(240,115,60)";
        }
        else if($chan == "PROMPT_PAY") {
            $color_line = "rgb(35,132,239)";
        }
        else if($chan == "TRANSFER") {
            $color_line = "rgb(167,69,185)";
        }
        else if($chan == "OTHER") {
            $color_line = "rgb(134,134,134)";
        }
        else {
            $color_line = 'rgb('.rand(0,255).', '.rand(0,255).', '.rand(0,255).')';
        }

        return $color_line;
    }

    public function userPieChart($dashboard_data ,$months)
    {
        $pieChart = new DashboardChart;
        $pieChart->minimalist(true);
        $pieChart->displaylegend(true);
        
        if(isset($dashboard_data->payment_status) && !blank($dashboard_data->payment_status)) {
            $color_pie = [];
            $bill_status = [];
            $count_status = [];
            foreach($dashboard_data->payment_status as $v) {
                array_push($bill_status, $v->bill_status);
                array_push($count_status, $v->count_status);
    
                if($v->bill_status === "ISSUE")
                    array_push($color_pie, "rgb(133,181,218)");
                elseif($v->bill_status === "NEW")
                    array_push($color_pie, "rgb(26,123,238)");
                elseif($v->bill_status === "PAID")
                    array_push($color_pie, "rgb(93,207,152)");
                elseif($v->bill_status === "UNPAID")
                    array_push($color_pie, "rgb(242,140,60)");
                elseif($v->bill_status === "UNMATCH")
                    array_push($color_pie, "rgb(255,0,60)");
                elseif($v->bill_status === "INACTIVE")
                    array_push($color_pie, "rgb(134,134,134)");
                else
                    array_push($color_pie, 'rgb('.rand(0,255).', '.rand(0,255).', '.rand(0,255).')');
            }

            $pieChart->labels($bill_status);
            $pieChart->dataset('', 'pie', $count_status)
                ->color('rgb(255,255,255)')
                ->backgroundcolor($color_pie);
        }
        else {
            $pieChart->labels(['EMPTY']);
            $pieChart->dataset('EMPTY', 'pie', [0]);
        }

        return $pieChart;
    }

    function summaryWithMonth($sums, $months) {
        $sum_with_month = [];
        for ($i = 0; $i < count($months); $i++)
        {
            if(property_exists((object) $sums, $months[$i]))
                array_push($sum_with_month, $sums[$months[$i]]);
            else
                array_push($sum_with_month, "");
        }
        return $sum_with_month;
    }

    public function SendBillChart($dashboard_data)
    {
        $SendBillChart = new DashboardChart;
        $SendBillChart->displaylegend(true);
            
        $all_bill = [];
        $bill_paid = [];
        $bill_sms = [];
        $bill_email = [];
        $months = [];
        if(!blank($dashboard_data->total_bill_summary)) {
            foreach($dashboard_data->total_bill_summary as $v) {
                array_push($all_bill ,$v->all_bill);
                array_push($bill_paid ,$v->bill_paid);
                array_push($bill_sms ,$v->bill_sms);
                array_push($bill_email ,$v->bill_email);
    
                if(!in_array($v->months, $months)) {
                    array_push($months, $v->months);
                }
            }   
            
            usort($months, function($time_1, $time_2) {
                $time_1 = strtotime($time_1);
                $time_2 = strtotime($time_2);
                return $time_1 - $time_2;
            });

            $SendBillChart->labels($months);
            $SendBillChart->dataset('All Bill', 'bar', $all_bill)
                ->color("rgb(100,150,255)")
                ->backgroundcolor("rgb(0,150,255)");
            $SendBillChart->dataset('Bill Paid', 'bar', $bill_paid)
                ->color("rgb(100,255,0)")
                ->backgroundcolor("rgb(0,255,0)");
            $SendBillChart->dataset('SMS', 'bar', $bill_sms)
                ->color("rgb(253,237,98)")
                ->backgroundcolor("rgb(253,237,98)");
            $SendBillChart->dataset('EMAIL', 'bar', $bill_email)
                ->color("rgb(239,97,61)")
                ->backgroundcolor("rgb(239,97,61)");
            $SendBillChart->options([
                'scales' => [
                    'yAxes'=> [[
                        'scaleLabel'=> [
                            'display'=> true,
                            'labelString'=> trans('dashboard.total_bills'),
                            'fontSize'=> 14
                        ]
                    ]]
                ],
            ]);
        }
        else {
            $SendBillChart->dataset('Empty', 'bar', [0])
                ->color("rgb(100,150,255)")
                ->backgroundcolor("rgb(0,150,255)");
        }
           
        return $SendBillChart;
    }

    public function SummaryPaymentBarChart($dashboard_data)
    {
        $SummaryPaymentChart = new DashboardChart;
        $SummaryPaymentChart->displaylegend(true);
            
        $prompt_pay = [];
        $credit_card = [];
        $cash = [];
        // $manual = [];
        $other = [];
        $all = [];
        $months = [];
        if(!blank($dashboard_data->summary_amount_payment)) {
            foreach($dashboard_data->summary_amount_payment as $v) {
                array_push($prompt_pay, isset($v->PROMPT_PAY) ? $v->PROMPT_PAY : 0);
                array_push($credit_card, isset($v->CREDIT_CARD) ? $v->CREDIT_CARD : 0);
                array_push($cash, isset($v->CASH) ? $v->CASH : 0);
                // array_push($manual, isset($v->MANUAL) ? $v->MANUAL : 0);
                array_push($other, isset($v->OTHER) ? $v->OTHER : 0);
                array_push($all, isset($v->ALL) ? $v->ALL : 0);
    
                if(!in_array($v->month, $months)) {
                    array_push($months, $v->month);
                }
            }
            
            usort($months, function($time_1, $time_2) {
                $time_1 = strtotime($time_1);
                $time_2 = strtotime($time_2);
                return $time_1 - $time_2;
            });
    
            $SummaryPaymentChart->labels($months);
            $SummaryPaymentChart->dataset('PROMPT PAY', 'bar', $prompt_pay)
                ->color('rgb(35,132,239)')
                ->backgroundcolor('rgb(35,132,239)');
            $SummaryPaymentChart->dataset('CREDIT CARD', 'bar', $credit_card)
                ->color('rgb(100,255,0)')
                ->backgroundcolor('rgb(0,255,0)');
            $SummaryPaymentChart->dataset('CASH', 'bar', $cash)
                ->color('rgb(253,237,98)')
                ->backgroundcolor('rgb(253,237,98)');
            // $SummaryPaymentChart->dataset('MANUAL', 'bar', $manual)
            //     ->color('rgb(255, 163, 92)')
            //     ->backgroundcolor('rgb(255, 163, 92)');
            $SummaryPaymentChart->dataset('OTHER', 'bar', $other)
                ->color('rgb(153, 157, 168)')
                ->backgroundcolor('rgb(153, 157, 168)');
            $SummaryPaymentChart->dataset('ALL', 'bar', $all)
                ->color('rgb(82, 235, 255)')
                ->backgroundcolor('rgb(82, 235, 255)');
                
            $SummaryPaymentChart->options([
                'scales' => [
                    'yAxes'=> [[
                        'scaleLabel'=> [
                            'display'=> true,
                            'labelString'=> trans('dashboard.total_amount'),
                            'fontSize'=> 14
                        ]
                    ]]
                ],
            ]);
        }
        else {
            $SummaryPaymentChart->dataset('Empty', 'bar', [0])
                ->color("rgb(100,150,255)")
                ->backgroundcolor("rgb(0,150,255)");
        }
           
        return $SummaryPaymentChart;
    }
}
