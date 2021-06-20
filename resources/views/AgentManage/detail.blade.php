@extends('argon_layouts.app', ['title' => __('Agent Management')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Agent Management</h6>
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
                                <h3 class="mb-0">{{__('agents.info')}}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Manage/Agents/SubmitBank')}}" method="post" enctype="multipart/form-data" id="form_info_bank">
                            {{ csrf_field() }}
                            <div class="col-12">
                                <div class="d-flex flex-wrap">
                                    <div class="p-2">
                                        <div class="col-12 px-0">
                                            <div class="form-group">
                                                <h4 class="">{{__('agents.update_of')}} {{ app()->getLocale() == 'en' ? $bank_data->name_en : $bank_data->name_th}}</h4>
                                                <input type="hidden" id="bank_id" name="bank_info[bank_code]" value="{{ $bank_data->bank_id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col-12">
                                    <h4 class="">{{__('agents.info')}}</h4>
                                </div>
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">
                                            <div class="row mx-auto pl-3">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.name_th')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="name_th" class="form-control" name="bank_info[name_th]" onkeypress="return isThaiData(event)" data-language="isThaiData" value="{{ $bank_data->name_th }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">{{__('agents.name_en')}}<span class="text-danger">*</span></label>
                                                        <input type="text" id="name_en" class="form-control" name="bank_info[name_en]" onkeypress="return isEnglishData(event)" data-language="isEnglishData" value="{{ $bank_data->name_en }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-bottom bottom-devide">
                                        </div>
                                    </section>
                                </section>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="px-5 d-flex flex-wrap">
                                    <div class="p-2 flex-fill w-50">
                                        <div class="pt-3 col-12">
                                            Select Function
                                        </div>
                                        <div class="p-2 flex-fill w-100">
                                            <div class="form-group">
                                                <div id="loader" class="row mx-auto m-5">
                                                    <div class="col-12 text-center" style="letter-spacing: 1.2px;">
                                                        <span>{{__('common.loading')}}...</span>
                                                    </div>                              
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-check" id="checkbox_function"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center py-3">
                                <a href="{{ URL::to('/Manage/Agents/')}}" class="btn btn-warning mt-3">{{__('agents.cancel')}}</a>
                                <button type="button" id="btn_submit" class="btn btn-success mt-3">{{__('agents.save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="{{ URL::asset('assets/js/extensions/input-validation.js') }}"></script>
<script type="text/javascript">
    const checkboxFunction = (data) => {
        @if (isset($function))
            const functions = JSON.parse('{!! json_encode($function) !!}')
        @elseif (old('functions') !== null)
            const functions = JSON.parse('{!! json_encode(old("functions")) !!}')
        @else
            const functions = []
        @endif
        
        return `
            <div class="px-1 my-3">
                <input id="${data.name}-checkbox" class="form-check-input magic-checkbox" type="checkbox" name="functions[]" value="${data.id || ''}" ${functions.map(x => x.id).indexOf(data.code) !== -1 ? 'checked' : ''}>
                <label class="form-check-label" for="${data.name}-checkbox">${data.name || ''}</label>
                <span class="d-block text-muted font-10 text-overflow">${data.description || ''}</span>
            </div>
        `
    }

    const GetFunctions = (elem) => {

        const data = {
            _token: '{{ csrf_token() }}',
            bank_code: '{{ $bank_data->bank_id }}',
            type: 'AGENT'
        }
        const url = `{{ action('FunctionController@get_function') }}`

        $.ajax({
            url,
            data,
            method: 'POST',
            success: function(result) {
                console.log('response: ', result)

                if (result.success === true) {
                    $('#loader').remove();
                    result.data.forEach((item) => {
                        $(elem).append(checkboxFunction(item))
                    })
                } else {
                    console.error(result.message)
                }
            },
            error: function(err) {
                console.error(err)
            }
        })
    }

    const __init = () => {
        GetFunctions('#checkbox_function')
    }

    $(document).ready(function() {
        __init()
      
        $(document).on('click', '#btn_submit', function() {
            $('form').submit()
        })
    })
</script>
@endsection