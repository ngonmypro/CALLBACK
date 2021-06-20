@extends('argon_layouts.app', ['title' => __('Recipient Management')])

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">{{__('recipient.index.title')}}</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        </nav>
                    </div>
                </div> 

                <div class="row" id="count"></div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card card-stats">
                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('recipient.index.customer_code')}}</label>
                                            <input type="text" id="data_search" name="customer_code" class="form-control" placeholder="{{__('recipient.index.search_customer_code')}}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols1Input">{{__('recipient.profile.full_name')}}</label>
                                            <input type="text" name="full_name" class="form-control" placeholder="{{__('recipient.index.search_fullname')}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="example3cols2Input">{{__('recipient.profile.status')}}</label>
                                            <select class="form-control custom-form-control" name="status" id="status">
                                                <option selected disabled>{{__('recipient.profile.status')}}</option>
                                                <option value="">{{__('common.all')}}</option>
                                                <option value="ACTIVE">{{__('common.active')}}</option>
                                                <option value="INACTIVE">{{__('common.inactive')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row px-3">

                                    <div class="offset-md-10 col-md-2">
                                        <div class="form-group">
                                            <button id="search" class="btn btn-primary w-100">{{__('common.search')}}</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
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
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{__('recipient.index.title')}}</h3>
                                            <p class="text-sm mb-0"></p>
                                        </div>
                                        <div>
                                            <ul class="list-inline"> 
                                                <li class="list-inline-item">
                                                    <a href="{!! URL::to('Recipient/Create') !!}" class="btn btn-primary w-100 text-uppercase">{{__('common.create')}}</a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ url('Recipient/Upload')}}" class="btn btn-primary w-100 text-uppercase">{{__('common.import_file')}}</a>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <div class="dataTables_wrapper dt-bootstrap4">
                                <table id="users_detail" class="table simple-table" style="width:100%"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('script')
<script src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript">

    const __blockElem = (data) => {
        return `
            <div class="col-xl-3 col-md-6">
                <div class="card card-stats">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">${data.status}</h5>
                                <span class="h2 font-weight-bold mb-0">${data.count}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-${data.color} text-white rounded-circle shadow">
                                    <i class="${data.icon}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    }

	$(document).ready(function(){

        $('#search').on('click', function () {
            table.search( this.value ).draw()
        })

		var table = $("#users_detail").DataTable({
			sPaginationType: "simple_numbers",
            bFilter: false,
            dataType: 'json',
            processing: true,
            serverSide: true,
            order: [[ 1, 'asc' ], [ 2, 'asc' ]],
            dom: '<"float-left pt-2"l>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
            language: {
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
            },
			ajax: {
				url: '{!! URL::to("Recipient/objectData") !!}',
				method: 'POST',
				data: function (d) {
                    d._token = "{{ csrf_token() }}",
                    d.customer_code = $('input[name="customer_code"]').val() || null,
                    d.status = $('select[name="status"]').val() || null,
                    d.full_name = $('input[name="full_name"]').val() || null
				}
			},
			columns: [
                { data: 'recipient_code',		name: 'recipient_code',         title: '{{__("recipient.index.customer_code")}}',   class: 'text-center' },
				{ data: 'full_name',			name: 'full_name',              title: '{{__("recipient.profile.full_name")}}',     class: 'text-left' },
				{ data: 'email',          	    name: 'email',                  title: '{{__("recipient.profile.email")}}',         class: 'text-left' },
				{ data: 'telephone',            name: 'telephone',              title: '{{__("recipient.index.telephone")}}',       class: 'text-center' },
				{ data: 'status',               name: 'status',                 title: '{{__("common.status")}}',                   class: 'text-center' },
				{ data: 'recipient_code',		name: 'recipient_code',         title: '{{__("common.action")}}',                   class: 'text-center' },
			],
			aoColumnDefs: [
                { 
                    className: "text-center", 
                    targets: [0, 3, 4, 5] 
                },
                {
			        "aTargets": [0],
			        "mData": null,
			        "mRender": function (data, type, full) {
                        if (data.length > 20) {
                            return `${data.substring(0, 35)}`
                        } else {
                            return data
                        }
			        }
                },
                {
			        "aTargets": [1],
			        "mData": null,
			        "mRender": function (data, type, full) {
                        if (full.full_name) {
                            return full.full_name
                        } else if (full.first_name && full.last_name) {
                            return `${full.first_name} ${full.middle_name || ''} ${full.last_name} `
                        } else {
                            return ''
                        }
			        }
			    },
                {
			        "aTargets": [4],
			        "mData": null,
			        "mRender": function (data, type, full) {
			        	// console.log(data)
			        	if(data === "ACTIVE"){
			        		return '<span class="badge badge-success">{{__('common.active')}}</span>';
                        }
                        else if(data === "INACTIVE"){
			        		return '<span class="badge badge-danger">{{__('common.inactive')}}</span>';
			        	}
			        	else {
			        		return '<span class="badge badge-warning">'+data+'</span>';
			        	}
			        }
			    },
			    {
			        "aTargets": [5],
			        "mData": null,
			        "mRender": function (data, type, full) {
                        return '<a href="{{ url('Recipient/Profile')}}/'+data+'" class="btn btn-sm btn-default" title="View Detail">'+
                                        '<i class="ni ni-bold-right"></i>'+
                                    '</a>';
			        }
			    }
			]
		})

		table.on('xhr', function(){
            var json = table.ajax.json()
			$(".recipient-total").text(json.recordsTotal)
			$(".total").text(json.data.length)
        })

        $.ajax({
            url: `{{ url('Recipient/objectData/Count') }}`,
            method: 'POST',
            data: {
                _token: `{{ csrf_token() }}`
            },
            success: function(response) { 
                console.log('response: ', response)
                if ( response.success && response.count ) {
                    const profile = {
                        total: {
                            icon: 'ni ni-folder-17',
                            color: 'primary',
                        },
                        active: {
                            icon: 'ni ni-check-bold',
                            color: 'success',
                        },
                        inactive: {
                            icon: 'ni ni-fat-remove',
                            color: 'danger',
                        },
                    }
                    Object.keys(response.count).forEach(function (element) {
                        $('#count').append(__blockElem({
                            status: _.ucwords(element),
                            color: profile[element.toLowerCase()].color || '',
                            icon: profile[element.toLowerCase()].icon || '',
                            count: response.count[element]
                        }))
                    })
                } else {
                    console.error('error: ', response.message)
                }
            },
            error: function(err) {
                console.error('error: ', err)
            }
        })

	});
</script>
@endsection
