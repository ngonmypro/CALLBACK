@extends('argon_layouts.app', ['title' => __('Settlemnt')])


@section('style')
<link href="{{ URL::asset('assets/css/frameworks/datatables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/fixedHeader.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/rowReorder.dataTables.min.css') }}" rel="stylesheet" media="all">
<link href="{{ URL::asset('assets/css/extensions/responsive.bootstrap.min.css') }}" rel="stylesheet" media="all">
<link type="text/css" href="{{ asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">

<style>
.has-error .select2-selection {
    border-color: rgb(185, 74, 72) !important;
}

div:invalid {
    border: 5px solid #ffdddd !important;
}
</style>

@endsection


@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Update setting</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="table-div" class="container-fluid mt--6">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-10">
                            </div>
                        </div>
                    </div>

                    <form id="create_settlement" action="{{ url('Settlement/Product/corporate/update')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body ">
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden"  class="form-control" name="id" value="{{$data_obj->id}}"  >
                                <input type="hidden"  class="form-control" name="channel_name" value="{{$data_obj->channel_name}}"  >
                            
                                <div class="form-group">
                                    <label for="" class="form-control-label">Fee</label>
                                    <input type="number" id="fee" class="form-control" name="fee" value="{{$data_obj->fee}}"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="" class="form-control-label">MDR</label>
                                    <input type="number" id="mdr" class="form-control" name="mdr" value="{{$data_obj->mdr}}"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="form-control-label">Status</label>
                                    <div class="col-6">
                                    <input id="status"  type="radio" class="magic-radio green-check" name="status" {{ $data_obj->status == 'ACTIVE' ? 'checked' : ''}} value="ACTIVE" >
                                    <label for="status">Active</label>
                                    <input id="status"  type="radio" class="magic-radio green-check" name="status" {{ $data_obj->status == 'INACTIVE' ? 'checked' : ''}} value="INACTIVE" >
                                    <label for="status">Inactive</label>
                                </div>
                            </div>
                        </div>
                            <div class="text-center">
                                <a href="{{ url()->previous() }}"    class="btn btn-warning mt-3" >Cancel</a> 
                                <button  class="btn btn-success mt-3">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
    </div>
    
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CreateSettlement','#create_settlement') !!}
@endsection
