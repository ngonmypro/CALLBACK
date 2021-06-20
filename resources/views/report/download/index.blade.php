@extends('argon_layouts.app', [
'title' => __('report.download.title') . isset($data['report']) ? ' '.ucwords(strtolower($data['report'])) : ''
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

    @if ( isset($data['report']) && $data['report'] !== 'CORPORATE' )
    <div class="row">
        <div class="col-12">

            <div class="card card-frame">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">{{ __('report.download.corporate') }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="corporate_name" type="text" value=""
                                    placeholder="{{__('report.download.search')}}">
                                <div class="text-left text-muted px-3">
                                    <small>{{__('report.download.search_help')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 offset-xs-6 col-xs-6 text-right">
                            <div class="form-group">
                                <button disabled type="button" id="search" class="btn btn-primary">{{__('common.search')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <div class="accordion" id="corporate-collapse">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#corporate-list"
                        aria-expanded="true" aria-controls="corporate-list">
                        <h5 class="mb-0">{{ __('report.download.select_corporate') }}</h5>
                    </div>
                    <div id="corporate-list" class="collapse show" aria-labelledby="headingOne"
                        data-parent="#corporate-collapse">
                        <div class="card-body">

                            {{-- START --}}

                            <div class="list-group list-group-flush corp-empty" id="corporate-wrapper"></div>

                            {{-- END --}}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">

            <div class="accordion" id="report-collapse">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#report-list"
                        aria-expanded="true" aria-controls="report-list">
                        <h5 class="mb-0">
                            {{ __('report.download.report_list') }}
                        </h5>
                        <div class="text-left text-muted">
                            <small style="font-size: 11.5px;">{{ isset($data['report']) ? ucwords(strtolower($data['report'])) : '' }}</small>
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
<script type="text/javascript">
    const obj = {
        corp: '{{ isset(Session::get("CORP_CURRENT")["corp_code"]) ? Session::get("CORP_CURRENT")["corp_code"] : null }}',
        report: '{{ $data["report"] ?? "" }}'
    }

    obj.__init = () => {
        @if ( isset($data['report']) && $data['report'] === 'CORPORATE' )
            $.blockUI()
            obj.getReport( null , (err, result) => {    
                obj.clearReport('report')
                if (err) {
                    Swal.fire(`{{ (__('common.error')) }}`, err.message, 'error')
                } else {
                    result.forEach((item) => {
                        $('#report-wrapper').append( obj.reportCard(item) )
                    })
                }
                $.unblockUI()
            })
        @endif
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

    obj.getReport = (corporate, callback) => {
        obj.ajax({
            type: 'POST',
            url: '{{ URL("/report/request/search") }}',
            data: {
                _token: '{{ csrf_token() }}',
                report: '{{ $data["report"] ?? "" }}',
                corporate
            }
        }, callback)
    }

    obj.reportCard = (data) => {
        return `
            <a href="#!" class="list-group-item list-group-item-action download" data-filename="${data.filename}">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <i class="single-copy-04 text-default"></i>
                    </div>
                    <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-sm">${data.filename}</h4>
                            </div>
                            <div class="text-right text-muted">
                                <small>${data.last_modified}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        `
    }

    obj.corporateCard = (data) => {
        return `
            <a href="#!" class="list-group-item list-group-item-action select-corporate" data-value=${data.id}>
                <div class="row align-items-center">
                    <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if ( app()->getLocale() == "th" )
                                    <h4 class="mb-0 text-sm">${data.name_th}</h4>
                                @elseif ( app()->getLocale() == "en" )
                                    <h4 class="mb-0 text-sm">${data.name_en}</h4>
                                @else
                                    <h4 class="mb-0 text-sm">${data.name_en}</h4>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm mb-0">${data.tax_id}</p>
                    </div>
                </div>

            </a>
        `
    }

    obj.getCorporate = (search, callback) => {
        obj.ajax({
            type: 'POST',
            url: '{{ URL("/report/request/search/corporate") }}',
            data: {
                _token: '{{ csrf_token() }}',
                search
            }
        }, callback)
    }
    
    $(document).ready(function() {

        obj.__init()

        $(document).on('change keyup', 'input[name=corporate_name]', function(e) {
            if ( $(this).val().length >= 3 ) {
                $(this).addClass('is-valid').removeClass('is-invalid')
                $('#search').removeAttr('disabled')
            } else {
                $(this).addClass('is-invalid').removeClass('is-valid')
                $('#search').attr('disabled', 'disabled')
            }
        })

        $(document).on('click', '.select-corporate', function(e) {
            $.blockUI()

            obj.corp = $(this).data('value')
            
            $('.select-corporate').not(this).removeClass('active')  // REMOVE ACTIVE
            $(this).addClass('active')  // THEN ADD ACTIVE TO CURRENT

            // EMPTY ELEMENT
            obj.clearReport('report')

            // CLOSE COLLAPSE
            $('#corporate-list').collapse('toggle')

            // CALL SERVICE
            obj.getReport( $(this).data('value') , (err, result) => {
                
                obj.clearReport('report')

                if (err) {
                    Swal.fire(`{{ (__('common.error')) }}`, err.message, 'error')
                } else {
                    result.forEach((item) => {
                        $('#report-wrapper').append( obj.reportCard(item) )
                    })
                }

                $.unblockUI()
            })
        })

        $(document).on('click', '#search', function() {
            $.blockUI()

            const search = $('input[name=corporate_name]').val()
            obj.getCorporate( search, (err, result) => {
                if (err) {
                    Swal.fire(`{{ (__('common.error')) }}`, err.message, 'error')
                } else {
                    obj.clearReport('corp')
                    obj.clearReport('report')

                    result.forEach((item) => {
                        $('#corporate-wrapper').append( obj.corporateCard(item) )
                    })
                }

                $.unblockUI()
            })
        })

        $(document).on('click', '.download', function() {
            const params = {
                corporate: obj.corp,
                filename: $(this).data('filename'),
                report: obj.report 
            }
            const query = $.param(params)
            window.open('{{ URL("/report/download") }}?' + query, '_blank');
        })
    
    })
</script>
@endsection