<div id="" class="row mx-auto mb-4">
    <div class="col-12 p-0">
        <form action="{{ url('Corporate/Setting/Function') }}" method="POST" class="form" id="function_form">
            {{ csrf_field() }}

            <input type="hidden" name="corp_code" value="{{ $corp_code }}">
            
            <div class="card-header" style="border: none;">
                <h4 class="mb-0 py-1">
                    <span class="template-text">Function Setting</span>
                </h4> 
            </div>

            <div class="card">
                <div class="card-header theme-style">
                    <h4 class="mb-0 py-3">
                        <span class="template-text">Select Function</span>
                    </h4> 
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="px-5 d-flex flex-wrap">
                            <div class="p-2 flex-fill w-50">
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
                </div>
            </div>


            <div class="row py-2">
                <div class="col-12 text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary"><i class="zmdi zmdi-spinner"></i> {{__('corpsetting.save')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@section('script.eipp.corp-setting.function')
<script type="text/javascript">
    const checkboxFunction = (data) => {
        @if (isset($function_config))
            const functions = JSON.parse('{!! json_encode($function_config) !!}')
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
            corp_code: '{{ $corp_code }}',
            type: 'USER'
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
    })
    
</script>
@endsection