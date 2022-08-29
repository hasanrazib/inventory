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
@endsection 