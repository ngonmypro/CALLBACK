@extends('argon_layouts.app', ['title' => __('Create User')])

@section('style')
<style>
    .font-10 {
        font-size: 10px;
    }
    .text-overflow {
        white-space: nowrap; 
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .modal-backdrop {
        background-color: rgba(0,0,0,0.6) !important;
        position: fixed;
    }
</style>
@endsection

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <div class="header bg-primary pb-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <h6 class="h2 text-white d-inline-block mb-0">Fee Setting</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
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
                                <h3 class="mb-0">Create</h3>
                            </div>
                            <div class="col-4 text-right">
                            </div>
                        </div>
                    </div>
                 

                    <div class="card-body">
                        <form id="create_settlement" action="{{ url('Settlement/Product/corporate/create_corporate')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row mx-auto">
                                <section class="col-12 scedule-main-block">
                                    <section class="scedule-content-block col-12 px-0">
                                        <div class="scedule col-12 pl-4">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th> @if($corporate != null) <input type="checkbox" id="select_all" class="checkall"> @endif</th>
                                                    <th scope="col">Corp Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($corporate as $corp)
                                                <tr>

                                                <th> <input class="control-input case" type="checkbox" id="corp_{{ $corp->id }}" name="corp[]" value="{{ $corp->id }}"></th>
                                                   
                                                    @if( app()->getLocale() == "th" )
                                                        <td> {{ $corp->name_th }} </td>
                                                    @else
                                                    <td> {{ $corp->name_en }} </td>
                                                    @endif
                                               
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                            <hr class="border-bottom bottom-devide">
                                        </div>
                                    </section>
                                </section>
                            </div>

                            <div class="modal" id="demo-modal-22">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="m-progress">
                                        
                                            <div class="modal-body " >
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">Fee</label>
                                                        <input type="number" id="fee" class="form-control" name="fee" value="" >
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">MDR</label>
                                                        <input type="number" id="mdr" class="form-control" name="mdr" value=""  >
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">field_name_date</label>
                                                        <input class="form-control" type="text" value="" name="field_name_date" id="field_name_date">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">field_name_time</label>
                                                        <input class="form-control" type="text" value="" name="field_name_time" id="field_name_time">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="" class="form-control-label">cutoff_time</label>
                                                        <input class="form-control" type="time" value="00.00" name="cutoff_time" id="example-datetime-local-input">
                                                    </div>
                                                </div>

                                                <input type="hidden" id="channel_name" class="form-control" name="channel_name" value="{{ $channel_name }}" >
                                                <input type="hidden" id="channel_type" class="form-control" name="channel_type" value="{{ $channel_type }}" >

                                                <div class="text-center">
                                                    <a  class="btn btn-warning mt-3" data-menu="Dashboard"  onclick="cancel()">Cancel</a>
                                                    <button  onclick="save()" class="btn btn-success mt-3">Save</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Settlement</h4>
                                        </div>
                                        <div class="modal-body " >
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-control-label">Fee</label>
                                                    <input type="number" id="fee" class="form-control" name="fee" value="" >
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-control-label">MDR</label>
                                                    <input type="number" id="mdr" class="form-control" name="mdr" value=""  >
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-control-label">field_name_date</label>
                                                    <input class="form-control" type="text" value="" name="field_name_date" id="field_name_date">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-control-label">field_name_time</label>
                                                    <input class="form-control" type="text" value="" name="field_name_time" id="field_name_time">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-control-label">cutoff_time</label>
                                                    <input class="form-control" type="time" value="00.00" name="cutoff_time" id="example-datetime-local-input">
                                                </div>
                                            </div>

                                            <input type="hidden" id="channel_name" class="form-control" name="channel_name" value="{{ $channel_name }}" >
                                            <input type="hidden" id="channel_type" class="form-control" name="channel_type" value="{{ $channel_type }}" >

                                            <div class="text-center">
                                                <button  onclick="save()" class="btn btn-success mt-3">Save</button>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>

                        <div class="text-center">
                            @if($corporate != null)
                                <button type="button" class="btn btn-success mt-3" data-toggle="modal" data-target="#myModal">Next</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/extensions/request.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CreateSettlement','#create_settlement') !!}

    <script type="text/javascript">
            $("#select_all").click(function () {
                $('.case').attr('checked', this.checked);
            });
          
            $(".case").click(function(){
        
                if($(".case").length == $(".case:checked").length) {
                    $("#select_all").attr("checked", "checked");
                } else {
                    $("#select_all").removeAttr("checked");
                }
        
            });
            
    </script>

@endsection
