@extends('argon_layouts.app', ['title' => __('Manage Agnets')])

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Manage Agents</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        
                        @Permission(SYS_AGENT_MANAGE.CREATE)
                            <div class="col-12">
                                <div class="d-flex flex-wrap mb-3">
                                    <div class="ml-auto p-2">
                                        <button type="button" class="btn btn-neutral" onclick="window.location.href='{{ url('/Manage/Agents/Create')}}'">
                                            <i class="zmdi zmdi-plus pr-2"></i>
                                            {{__('agents.add_new')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {{-- <a href="{!! URL::to("/Manage/Agents/Create") !!}" class="btn btn-neutral">{{__('agents.add_new')}}</a> --}}
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
                                <h3 class="mb-0">Manage Agents</h3>
                                <p class="text-sm mb-0">
                                    
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="dataTables_wrapper dt-bootstrap4">
                            <table id="bank_table" class="table table-flush dataTable">
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<input type="hidden" name="breadcrumb-title" value="{{__('agents.manage_agent')}}">


<div class="col-12">
    <div class="d-flex flex-wrap flex-column">
        <div class="p-2">
            <div class="col-12 px-0 table-responsive">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#bank_table").DataTable({
                sPaginationType: "simple_numbers",
                bFilter: false,
                dataType: 'json',
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },
                ajax: {
                    url: '{!! URL::to("Manage/Agents/objectData") !!}',
                    method: 'POST',
                    data: function (d) {
                        d._token = "{{ csrf_token() }}"
                    }
                },
                columns: [
                    { data: 'app_name',     name: 'app_name'  , title: '{{__('agents.app_name')}}' },
                    { data: 'name_th',       name: 'name_th'  , title: '{{__('agents.name_th')}}' },
                    { data: 'name_en',       name: 'name_en'  , title: '{{__('agents.name_en')}}' },
                    @Permission(SYS_AGENT_MANAGE.UPDATE)
                        { data: 'code',            name: 'action'  , title: '{{__('agents.action')}}' }
                    @EndPermission
                ],
                aoColumnDefs: [
                    { className: "text-center", targets: "_all" },
                    @Permission(SYS_AGENT_MANAGE.UPDATE)
                    {
                        aTargets: [3],
                        mRender: function (data, type, full) {
                            let pattern = "{{ action('AgentManageController@detail', ['agent_code' => '%CODE%'] ) }}"
                            let link = pattern.replace('%CODE%', data)

                            let settings = "{{ action('AgentManageController@bank_setting', ['agent_code' => '%CODE%'] ) }}"
                            let link_settings = settings.replace('%CODE%', data)

                            return `<a href="${link}" class="btn btn-sm btn-default" title="View Deatil"><i class="ni ni-bold-right"></i></a>
                            <a href="${link_settings}" class="btn btn-sm btn-default" title="View Deatil"><i class="ni ni-settings"></i></a>
                            `;
                        }
                    }
                  
                    @EndPermission
                ],
                
            });
        });
    </script>
@endsection
