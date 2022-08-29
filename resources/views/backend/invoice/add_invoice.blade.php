@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add Invoice  </h4><br><br>
                        <div class="row">
                                        <div class="col-md-1">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Inv No</label>
                                                <input class="form-control example-date-input" name="invoice_no" type="text" value="{{$invoice_no}}" id="invoice_no" readonly style="background-color:#ddd" >
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Date</label>
                                                <input class="form-control example-date-input" name="date" type="date"  id="date" value="{{$date}}">
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Category Name </label>
                                                <select name="category_id" id="category_id" class="form-select select2" aria-label="Default select example">
                                                <option selected="">Open this select menu</option>
                                                @foreach($categories as $item)
                                                <option value="{{ $item->id }}">{{ $item->cat_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Product Name </label>
                                                <select name="product_id" id="product_id" class="form-select select2" aria-label="Default select example">
                                                <option selected="">Open this select menu</option>

                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-1">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label">Stock(Pic/Kg)</label>
                                                <input class="form-control example-date-input" name="current_stock_qty" type="text"  id="current_stock_qty" readonly style="background-color:#ddd" >
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="md-3">
                                                <label for="example-text-input" class="form-label" style="margin-top:43px;">  </label>
                                                <i class="btn btn-secondary btn-rounded waves-effect waves-light fas fa-plus-circle addeventmore"> Add More</i>
                                            </div>
                                        </div>

                        </div><!-- row -->
                        
                    </div><!--card body --> 
                    <div class="card-body">
        <form method="post" action="{{route('insert.invoice')}}">
            @csrf
            <table class="table-sm table-bordered" width="100%" style="border-color: #ddd;">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Product Name </th>
                        <th width="10%">PSC/KG</th>
                        <th width="10%">Unit Price </th> 
                        <th width="15%">Total Price</th>
                        <th width="7%">Action</th> 

                    </tr>
                </thead>

                <tbody id="addRow" class="addRow">

                </tbody>

                <tbody>
                    <tr>
                        <td colspan="5"></td>
                        <td>
                            <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control estimated_amount" readonly style="background-color: #ddd;" >
                        </td>
                        <td></td>
                    </tr>

                </tbody>                
            </table><br>
            <div class="form-group">
                <button type="submit" class="btn btn-info" id="storeButton"> Purchase Store</button>

            </div>

        </form>






        </div> <!-- End card-body -->
                </div><!--card-->
            </div> <!-- col- 12 -->
        </div><!-- row -->                    
    </div><!-- container -->
</div> <!-- page content -->


<script type="text/javascript">
    $(function(){
        $(document).on('change','#category_id',function(){
            var category_id = $(this).val();
            $.ajax({
                url:"{{ route('get-product') }}",
                type: "GET",
                data:{category_id:category_id},
                success:function(data){
                    var html = '<option value="">Select Category</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.id+' "> '+v.name+'</option>';
                    });
                    $('#product_id').html(html);
                }
            })
        });
    });

</script>
<script type="text/javascript">
    $(function(){
        $(document).on('change','#product_id',function(){
            var product_id = $(this).val();
            $.ajax({
                url:"{{ route('get-check-stock') }}",
                type: "GET",
                data:{product_id:product_id},
                success:function(data){
                
                    $('#current_stock_qty').val(data);
                }
            })
        });
    });

</script>
<!-- handlebars template -->
<script id="document-template" type="text/x-handlebars-template">

<tr class="delete_add_more_item" id="delete_add_more_item">
        <input type="hidden" name="date" value="@{{date}}">
        <input type="hidden" name="invoice_no" value="@{{invoice_no}}">

    <td>
        <input type="hidden" name="category_id[]" value="@{{category_id}}">
        @{{ category_name }}
    </td>

     <td>
        <input type="hidden" name="product_id[]" value="@{{product_id}}">
        @{{ product_name }}
    </td>

     <td>
        <input type="number" min="1" class="form-control selling_qty text-right" name="selling_qty[]" value=""> 
    </td>

    <td>
        <input type="number" class="form-control unit_price text-right" name="unit_price[]" value=""> 
    </td>
    <td>
        <input type="number" class="form-control selling_price text-right" name="selling_price[]" value="0" readonly> 
    </td>

     <td>
        <i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i>
    </td>

</tr>

</script>
<!-- end handlebars template -->

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click",".addeventmore", function(){
            var date = $('#date').val();
            var invoice_no = $('#invoice_no').val();
            var category_id  = $('#category_id').val();
            var category_name = $('#category_id').find('option:selected').text();
            var product_id = $('#product_id').val();
            var product_name = $('#product_id').find('option:selected').text();


            if(date == '' ){
                $.notify("Date is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
                 }
                  if(category_id == ''){
                $.notify("Category is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
                 }
                  if(product_id == ''){
                $.notify("Product Field is Required" ,  {globalPosition: 'top right', className:'error' });
                return false;
                 }


                 var source = $("#document-template").html();
                 var tamplate = Handlebars.compile(source);
                 var data = {
                    date:date,
                    invoice_no:invoice_no,
                    category_id:category_id,
                    category_name:category_name,
                    product_id:product_id,
                    product_name:product_name

                 };
                 var html = tamplate(data);
                 $("#addRow").append(html); 
        });

        $(document).on("click",".removeeventmore",function(event){
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice();
        });

        $(document).on('keyup click','.unit_price,.selling_price', function(){
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.selling_qty").val();
            var total = unit_price * qty;
            $(this).closest("tr").find("input.selling_price").val(total);
            totalAmountPrice();
        });
       
        // Calculate sum of amout in invoice 

        function totalAmountPrice(){
            var sum = 0;
            $(".selling_price").each(function(){
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0){
                    sum += parseFloat(value);
                }
            });
            $('#estimated_amount').val(sum);
        }  

    });


</script>
@endsection 