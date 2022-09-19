@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Inovice Approve</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @php
          $payment = App\Models\Payment::where('invoice_id',$invoice->id)->first();
        @endphp
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Invoice No: #{{ $invoice->invoice_no }} - {{ date('d-m-Y',strtotime($invoice->date)) }} </h4>
                        <table class="table table-dark" width="100%">
                            <tbody>
                                <tr>
                                    <td><p> Customer Info </p></td>
                                    <td><p> Name: <strong>{{ $payment['customer']['name']  }}</strong> </p></td>
                                    <td><p> Mobile: <strong> {{ $payment['customer']['mobile_no']  }} </strong> </p></td>
                                   <td><p> Email: <strong> {{ $payment['customer']['email']  }}</strong> </p></td>
                                </tr>

                                 <tr>
                                 <td></td>
                                  <td colspan="3"><p> Description : <strong>{{$invoice->description}}</strong> </p></td>
                                 </tr>
                            </tbody>
                         </table>

                         <table border="1" class="table table-dark" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center" style="background-color: #8B008B">Current Stock</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Price </th>
                                    <th class="text-center">Total Price</th>
                                </tr>

                            </thead>
                    <tbody>


                    </tbody>

                </table>

                <button type="submit" class="btn btn-info">Invoice Approve </button>








                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>


@endsection
