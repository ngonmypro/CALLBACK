@extends('argon_layouts.app', ['title' => __('BAAC Product')])

@section('style')
    <link href="{{ URL::asset('assets/css/extensions/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
               <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">BAAC Product Detail</h6>
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
                                <h3 class="mb-0">BAAC Product Detail</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ url('/BAAC/Product/Update')}}" method="post" enctype="multipart/form-data" id="form_baac_product">
                            {{ csrf_field() }}
                            <input type=hidden name="code" value={{$product->code}}>
                            <div class="row mx-auto">
                                <div class="col-12">
                                    <h4 class="">Produce Detail</h4>
                                </div>
                                <div class="scedule col-12 pl-4">
                                    <div class="row mx-auto pl-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Catalogue<span class="text-danger">*</span></label>
                                                <select name="catalogue" class="form-control">
                                                    @foreach($all_catalogue as $key => $value)
                                                        @if($value->id == $product->catalogue_id)
                                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                                        @else
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endif  
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Product Type<span class="text-danger">*</span></label>
                                                <select name="product_type" class="form-control">
                                                    @foreach($all_product_type as $key => $value)
                                                        @if($value->id == $product->product_type_id)
                                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                                        @else
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endif  
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="row mx-auto pl-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" value="{{isset($product->name) ? $product->name : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Image</label>
                                                <input type="text" class="form-control" name="images" value="{{(isset($product->images) && $product->images != null) ? implode(", ", json_decode($product->images)) : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mx-auto pl-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Price<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="price" value="{{isset($product->price) ? $product->price : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Unit<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="unit" value="{{isset($product->unit) ? $product->unit : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mx-auto pl-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Description</label>
                                                <textarea rows="5" class="form-control" name="description" value="{{isset($product->description) ? $product->description : ''}}">{{isset($product->description) ? $product->description : ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Short Description</label>
                                                <input type="text" class="form-control" name="short_desc" value="{{isset($product->short_desc) ? $product->short_desc : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mx-auto pl-3">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="" class="form-control-label">Expired Date</label>
                                                <input type="text" class="form-control" name="expired_at" value="{{isset($product->expired_at) ? date('Y-m-d H:i:s', strtotime($product->expired_at)) : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="text-center py-3">
                                <a href="{{ URL::to('/BAAC/Product/')}}" class="btn btn-warning mt-3">Cancel</a>
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
<script type="text/javascript" src="{{ URL::asset('assets/js/frameworks/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\BAACProductEditRequest','#form_baac_product') !!}
<script type="text/javascript">
    $(document).ready(function() {

    })
</script>
@endsection