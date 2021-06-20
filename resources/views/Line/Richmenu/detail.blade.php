@extends('argon_layouts.app', ['title' => __('Rich Menu')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/dropzone.css') }}" rel="stylesheet" media="all">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Rich Menu</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Image</h4>
                        <img src="{{ isset($data->image_path) ? $data->image_path : '' }}" class="img" style="width: 100%;border: 1px dashed #ccc">
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ url('/Line/Richmenu/Update', $data->reference ) }}" method="POST" enctype="multipart/form-data" id="form-create-recipient">
                            
                            {{ csrf_field() }}
                            
                            <h4 class="card-title">{{__("common.import_file")}}</h4>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="richmenu_name" class="form-control" value="{{ isset($data->richmenu_name) ? $data->richmenu_name : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="richmenu_desc" class="form-control" value="{{ isset($data->richmenu_desc) ? $data->richmenu_desc : '' }}">
                            </div>
                            <div class="form-group">
                                <label>Config</label>
                                <textarea class="form-control" rows="20" name="config">{{ isset($data->config) ? $data->config : '' }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Default Auth</label>
                                <br/>
                                <label class="custom-toggle">
                                    <input name="richmenu_default_auth" type="checkbox" {{ isset($data->is_default_auth) && strtoupper($data->is_default_auth) == true ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="Off" data-label-on="On"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Default App</label>
                                <br/>
                                <label class="custom-toggle">
                                    <input name="richmenu_default_app" type="checkbox" {{ isset($data->is_default_app) && strtoupper($data->is_default_app) == true ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="Off" data-label-on="On"></span>
                                </label>
                            </div>
                            
                            <br>
                            <button type="submit" id="submit_btn" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>                      
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/extensions/dropzone.min.js') }}"></script>=
    <script src="{{ asset('assets/js/extensions/jquery.form.js') }}"></script>
    <script type="text/javascript">

    </script>
@endsection