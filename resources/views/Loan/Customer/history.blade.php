@extends('Loan.Customer.master')

@section('content')
    <div class="align-content-center col-12 px-0"> 
        <div class="col-12 px-0 mb-3">
            <div class="media">
                <img src="{{ URL::asset('assets/images/bill_his_iccon.png') }}" class="align-self-start mr-3" alt="...">
                <div class="media-body">
                    <h1 class="mt-0 mb-0">Bill Payment History</h1>
                    <p class="font-weight-normal">Please scroll down to see more transaction</p>
                </div>
            </div>
        </div>
        <div class="col-12 px-0">
            <section>
                @if($data != null)
                    @foreach($data as $k => $v)
                        <div class="row mb-2 mx-0">
                            <div class="col-12 px-0">
                                <div class="card card-content-history">
                                    <div class="card-body">
                                        {{-- <div class="d-flex flex-wrap">
                                            <div class="flex-fill">
                                                <p class="mb-0 font-weight-bold payment-status">{{ $v->payment_status == null ? 'UNPAID' : $v->payment_status }}</p>
                                                <p class="mb-0 font-weight-bold">Pay bill </p>
                                                <p class="text-muted mb-0">Invoice Number. : {{ $v->invoice_number }}</p>
                                                <p class="text-muted mb-0">Ref 1. : {{ $v->ref_1 }}</p>
                                                <p class="text-muted mb-0">Ref 2. : {{ $v->ref_2 }}</p>
                                            </div>
                                            <div class="flex-fill"> 
                                                <p class="text-right mb-0 template-color font-weight-bold"></p>
                                                <p class="text-right mb-0 template-color font-weight-bold">{{ number_format($v->bill_total_amount) }} {{ $v->currency }}</p>
                                                <p class="text-right mb-0">Due Date : {{ date('d-m-Y',strtotime($v->bill_due_date)) }}</p>
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <p class="mb-0 font-weight-bold payment-status">{{ $v->payment_status == null ? 'UNPAID' : $v->payment_status }}</p>
                                                <p class="mb-0 font-weight-bold">Invoice Number. : {{ $v->invoice_number }}</p>
                                                <p class="text-muted mb-0">Ref 1. : {{ $v->ref_1 }}</p>
                                                <p class="text-muted mb-0">Ref 2. : {{ $v->ref_2 }}</p>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <p class="text-right mb-0 template-color font-weight-bold"></p>
                                                <p class="text-right mb-0 template-color font-weight-bold">{{ number_format($v->bill_total_amount) }} {{ $v->currency }}</p>
                                                <p class="text-right mb-0">Due Date : {{ date('d-m-Y',strtotime($v->bill_due_date)) }}</p>
                                            </div>
                                            @if($v->url != null)
                                                {{-- <button type="button" class="btn btn-info btn-lg" onclick="showPDF('{{$v->url}}')">VIEW INVOICE</button> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </section>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalPDF" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invoice</h4>
                </div>
                <div class="modal-body">

                    <embed id="pdf_area" src=""
                           frameborder="0" width="100%" height="400px">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function showPDF(url)
        {
            console.log(url)

            $('#pdf_area').attr('src',url);
            $('#modalPDF').modal('toggle');
        }
    </script>
@endsection