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



       <div class="col-md-3">
            <div class="md-3">
                <label for="example-text-input" class="form-label">Division Name </label>
                <select name="division_id" id="division_id" class="form-select select2" aria-label="Default select example">
                <option selected="">Open this select menu</option>
                  @foreach($divisions as $item)
                <option value="{{ $item->id }}">{{ $item->division_name }}</option>
               @endforeach
                </select>
            </div>
        </div>


         <div class="col-md-3">
            <div class="md-3">
                <label for="example-text-input" class="form-label">District Name </label>
                <select name="district_id" id="district_id" class="form-select select2" aria-label="Default select example">
                <option selected="">Open this select menu</option>

                </select>
            </div>
        </div>

    </div> <!-- // end row  -->

        </div> <!-- End card-body -->
<!--  ---------------------------------- -->


    </div>
</div> <!-- end col -->
</div>


    </div><!-- container -->
</div> <!-- page content -->






<script type="text/javascript">
    $(function(){
        $(document).on('change','#division_id',function(){
            var division_id = $(this).val();
            $.ajax({
                url:"{{ route('get-district-list') }}",
                type: "GET",
                data:{division_id:division_id},
                success:function(data){
                    var html = '<option value="">Select Category</option>';
                    $.each(data,function(key,v){
                        html += '<option value=" '+v.id+' "> '+v.district_name+'</option>';
                    });
                    $('#district_id').html(html);
                }
            })
        });
    });

</script>




@endsection
