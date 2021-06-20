@extends('argon_layouts.app', ['title' => __('Visa Virtual Card Setting')])

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/extensions/daterangepicker.css') }}"/>
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Add Card Type</h6>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            
                        </nav>
                    </div>
                   {{-- <div class="col-lg-6 col-5 text-right">
                        @Permission(CORPORATE_MANAGEMENT.VIEW)
                        @if (isset($corp_code) && !blank($corp_code))
                            <a href="{{ url('Corporate')}}" class="btn btn-neutral">{{__('common.back')}}</a>
                        @else
                            <a onclick="window.history.back()" class="btn btn-neutral">{{__('common.back')}}</a>
                        @endif
                        @EndPermission
                    </div>--}}
                </div> 
            </div>
        </div>
    </div>

    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">


                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 py-1">
                            <span class="template-text">Card Type</span>
                        </h4> 
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/Visa/VirtualCard/card_type')}}" method="post" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="card_name">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="card_desc">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <div class="custom-file">
                                    <input type="hidden" class="card_image" name="card_image">
                                    <input type="file" class="custom-file-input" data-target="card_image" accept="image/gif, image/jpeg, image/png"  onchange="convertB64(this)">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <img id="preview_img" src="" style="width: 400px">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Setting</label>
                                <div class="d-flex justify-content-center">
                                    <div class="flex col-10">
                                        @foreach($data as $k => $v)
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="config_{{ $k }}" name="card_rule[]" value="{{ $v->reference }}">
                                                                <label class="custom-control-label" for="config_{{ $k }}">
                                                                    {{ $v->rule_desc }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="{{ URL::to('/Visa/VirtualCard/')}}" class="btn btn-warning mt-3">Cancel</a>
                                <button type="submit" id="btn_submit" class="btn btn-success mt-3">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/select2.min.js') }}"></script>
    <script type="text/javascript">
        function convertB64(img) {
            var target = $(img).data('target');

            if (img.files && img.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var base64 = e.target.result;
                    // var replaceB64 = base64.replace(/^data:image\/(png|jpg);base64,/, '');
                        var image = new Image();

                        image.src = e.target.result;

                        image.onload = function () {
                        var height = this.height;
                        var width = this.width;

                        if (width < 270 && height < 350) {
                            return true;
                        }else{
                            
                            const file = document.querySelector('.logo-file');
                            file.value = '';
                            return false;
                        }
                
                        };

                    //Edit
                        var image = new Image();

                        image.src = e.target.result;

                        image.onload = function () {
                        var height = this.height;
                        var width = this.width;

                        if (width < 270 && height < 350) {
                            return true;
                        }else{
                            
                            const file = document.querySelector('.logo-file');
                            file.value = '';
                            return false;
                        }
                
                        };
                    //Edit

                    $('.'+target).val(base64)
                    $('#preview_img').attr('src',base64)
                };
                reader.readAsDataURL(img.files[0]);
            }
        }
    </script>
@endsection