@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">
<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Product  </h4><br><br>

    <div class="row">
        <div class="col-md-4">
            <div class="md-3">
                <label for="example-text-input" class="form-label">Date</label>
                 <input class="form-control example-date-input" name="date" type="date"  id="date">
            </div>
        </div>

        <div class="col-md-4">
            <div class="md-3">
                <label for="example-text-input" class="form-label">Purchase No</label>
                 <input class="form-control example-date-input" name="purchase_no" type="text"  id="purchase_no">
            </div>
        </div>

        <div class="col-md-4">
            <div class="md-3">
                <label for="example-text-input" class="form-label">Supplier Name </label>
                <select id="supplier_id" name="supplier_id" class="form-select" aria-label="Default select example">
                <option selected="">Open this select menu</option>
                @foreach($suppliers as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
               @endforeach
                </select>
            </div>
        </div>


       
        <div class="col-md-4">
            <div class="md-3">
                <label for="example-text-input" class="form-label" style="margin-top:43px;">  </label>
                <input type="submit" class="btn btn-secondary btn-rounded waves-effect waves-light" value="Add More">
            </div>
        </div>





    </div> <!-- // end row  -->







        </div> <!-- End card-body -->
    </div>
</div> <!-- end col -->
</div>
</div>
@endsection 