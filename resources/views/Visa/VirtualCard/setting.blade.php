@extends('argon_layouts.app', ['title' => __('Visa Virtual Card Setting')])

@section('style')
    
@endsection

@section('content')

    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Virtual Card Setting</h6>
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
                        <div class="col-12 text-right">
                            <div class="form-group">
                                <a href="{!! URL::to("Visa/VirtualCard/card_type") !!}" class="btn btn-outline-primary"></i>Add Card</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Image</td>
                                    <td>Status</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data != NULL)
                                    @foreach($data as $i => $v)
                                        <tr>
                                            <td>{{ $v->name }}</td>
                                            <td>{{ $v->description }}</td>
                                            <td><img src="{{ $v->image }}" width="400px;"></td>
                                            <td>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- MODAL CARD TYPE -->
    <div class="modal fade" id="card_type" tabindex="-1" role="dialog" aria-labelledby="cardType" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cardType">Create Card Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    
    
@endsection