@extends('argon_layouts.app', [
    'title' => __('report.inquiry_page.title')
])

@section('style')
<style type="text/css">
    #report-wrapper .lds-ring div{
        border-color: #007abc transparent transparent transparent;
    }
    #corporate-wrapper .lds-ring div{
        border-color: #007abc transparent transparent transparent;
    }
</style>
@endsection

@section('content')

<section class="container-fluid p-lg-5 p-3">

    <div class="row">
        <div class="col-12">

            <form id="form">

                <input type="hidden" name="criteria">

                {{ csrf_field() }}

                <div class="card card-frame">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">{{ __('report.inquiry_page.search') }}</div>
                        </div>
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('report.inquiry_page.select_report_type') }}</label>
                                    <select class="form-control" name="report_type" id="report_type" onchange="changeDatePicker(this)" >
                                        
                                        @Permission('REPORT.SUMMARY_CORPORATE_REPORT')
                                        <option value="corporate" data-criteria="daily">{{ __('report.inquiry_page.corporate_report') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.SUMMARY_BILL_PAYMENT_REPORT')
                                        <option value="bill" data-criteria="daily">{{ __('report.inquiry_page.bill_payment_report') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.SUMMARY_PAYMENT_TRANSACTION_REPORT')
                                        <option value="payment" data-criteria="daily">{{ __('report.inquiry_page.payment_transaction_report') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.SUMMARY_PAYMENT_RECONCILE_REPORT')
                                        <option value="payment-reconcile" data-criteria="daily">{{ __('report.inquiry_page.payment_reconcile_report') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.SUMMARY_AUDIT_LOG_REPORT')
                                        <option value="auditlog" data-criteria="daily">{{ __('report.inquiry_page.auditlog_report') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.MONTHLY_PAYMENT_TRANSACTION_REPORT')
                                        <option value="monthly-payment-transaction" data-criteria="monthly">{{ __('report.inquiry_page.monthly_payment_transaction') }}</option>
                                        @EndPermission

                                        @Permission('REPORT.SUMMARY_CORPORATE_USAGE_REPORT')
                                        <option value="corporate-usage" data-criteria="monthly">{{ __('report.inquiry_page.monthly_corporate_usage') }}</option>
                                        @EndPermission
        
                                        @Permission('REPORT.MONTHLY_BILL_PAYMENT_USAGE_REPORT')
                                        <option value="billpayment-usage" data-criteria="monthly">{{ __('report.inquiry_page.monthly_bill_payment_usage') }}</option>
                                        @EndPermission

                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row d-none" id="wrapper-daterange">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('report.inquiry_page.select_date_range') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control" id="date_range" name="date_range" placeholder="{{__('common.start_date_end_date')}}" type="text" value="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-none" id="wrapper-monthrange">

                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('report.inquiry_page.select_start_month') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                            <input type="text" id="start_month" name="start_month">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-control-label">{{ __('report.inquiry_page.select_end_month') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                            <input type="text" id="end_month" name="end_month">
                                    </div>
                                </div>
                            </div>
                                
                        </div>

                        <div class="row">
                            <div class="offset-lg-10 col-lg-2 offset-xs-6 col-xs-6 text-right">
                                <div class="form-group">
                                    <button type="button" id="search" class="btn btn-primary">{{__('common.search')}}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </form>

        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="accordion" id="report-collapse">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#report-list"
                        aria-expanded="true" aria-controls="report-list">
                        <div class="row pr-5">
                            <div class="col-6">
                                <h5 class="mb-0">
                                    {{ __('report.inquiry_page.report_list') }}
                                </h5>
                            </div>
                            <div class="col-6 text-right"></div>
                        </div>
                    </div>
                    <div id="report-list" class="collapse show" aria-labelledby="headingOne"
                        data-parent="#report-collapse">
                        <div class="card-body">
                            <div class="list-group list-group-flush report-empty" id="report-wrapper"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\ReportSearchRequest','#form') !!}
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('argon/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/extensions/daterangepicker.js') }}"></script>

<script type="text/javascript">

    function changeDatePicker(elem) {

        const report_type = $(elem).val()

        const criteria = $(elem).find(':selected').attr('data-criteria')

        $('input[name=criteria]').val(criteria)

        if ( criteria === 'monthly' ) {

            $('#wrapper-monthrange').removeClass('d-none')
            $('#wrapper-daterange').addClass('d-none')

        } else {

            $('#wrapper-daterange').removeClass('d-none')
            $('#wrapper-monthrange').addClass('d-none')

        }      
    }

    const obj = {}

    obj.__init = () => {
        //
        const criteria = $('#report_type').find(':selected').attr('data-criteria')
        $('input[name=criteria]').val(criteria)
    }

    obj.getLoader = () => {
        return `
            <div class="loading-wrapper text-center remove">
                <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
            </div>
        `
    }

    obj.clearReport = (elem = '') => {
        if ( elem !== '' && elem !== null ) {
            elem = `${elem}-`
        }
        $(`.${elem}remove`).each(function() {
            $(this).remove()
        })
        $(`.${elem}empty`).each(function() {
            $(this).empty()
        })
    }

    obj.ajax = (options, callback) => {
        $.ajax(options)
            .done(function(response) {
                if ( response.success ) {
                    callback(null, response.data)
                } else {
                    callback({ message: response.message }, null)
                }
            }).fail(function(err) {
                console.error('Error: ', err)
                callback({ message: err.message }, null)
            })
    }

    obj.getReport = (callback) => {
        obj.ajax({
            type: 'POST',
            url: "{{ action('Report\InquiryController@inquiry') }}",
            data: $('#form').serializeObject()
        }, callback)
    }

    obj.reportCard = (data) => {
        return `
            <a href="#!" class="list-group-item list-group-item-action download" data-filename="${data}">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="single-copy-04 text-default"></i>
                    </div>
                    <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-sm">${data}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        `
    }

    $(document).ready(function() {

        const startMonth = $('#start_month').datepicker({
            format: 'mm/yyyy',
            viewMode: 'months', 
            minViewMode: 'months'
        }).on('changeDate', function(ev) {

            if (ev.date > endMonth.viewDate) {


                var newDate = new Date(ev.date)

                newDate.setDate(newDate.getMonth() + 1)

                endMonth.update(newDate)

            }

            startMonth.hide()

            $('#end_month')[0].focus()

        }).data('datepicker')

        const endMonth = $('#end_month').datepicker({
            format: 'mm/yyyy',
            viewMode: 'months', 
            minViewMode: 'months',
        }).on('changeDate', function(ev) {

            if (ev.date < startMonth.viewDate) {

                var newDate = new Date(ev.date)

                startMonth.update(newDate)

                $('#start_month')[0].focus()

            }

            endMonth.hide()

        }).data('datepicker')

        $('input[name="date_range"]').daterangepicker({
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
            $('input[name="month"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
        })

        $('input[name="date_range"]').daterangepicker({
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
            $('input[name="date_range"]').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'))
        })

        $('input[name="date_range"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('')
        })

        obj.__init()

        $(document).on('click', '#search', function() {

            if ( !$('#form').valid() ) {
                return
            }

            $.blockUI()

            obj.clearReport('report')

            obj.getReport( (err, result) => {
                if (err) {
                    Swal.fire(`{{ (__('common.error')) }}`, err.message, 'error')
                } else {
                    result.forEach( (item) => {
                        $('#report-wrapper').append( obj.reportCard(item) )
                    })
                }

                $.unblockUI()
            })
        })

        $(document).on('click', '.download', function() {
            const params = {
                report_type: $('#report_type').val(),
                filename: $(this).data('filename')
            }
            const query = $.param(params)
            window.open("{{ action('Report\InquiryController@single_download') }}?" + query, '_blank');
        })
    
    })
</script>
@endsection