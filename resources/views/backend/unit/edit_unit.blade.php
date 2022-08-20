@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Unit Page </h4><br><br>



            <form method="post" action="{{route('update.unit')}}" id="myForm">
                @csrf

            <input type="hidden" name="id" value="{{ $unit->id }}">

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Unit Name </label>
                <div class="col-sm-10">
                    <input name="unit_name" class="form-control" type="text" value="{{$unit->unit_name}}">
                </div>
            </div>
            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
            </form>

        </div>
    </div>
</div> <!-- end col -->
</div>



</div>
</div>


<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                unit_name: {
                    required : true,
                }
                
            },
            messages :{
                unit_name: {
                    required : 'Please Enter Your Unit Name',
                }
            
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>
@endsection 