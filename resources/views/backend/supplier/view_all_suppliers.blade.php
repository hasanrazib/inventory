@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Supplier All</h4>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Supplier All Data </h4>
                    
                    <a style="margin:15px 0;" class="btn btn-primary waves-effect waves-light" href="{{route('add.supplier')}}">Add New Supplier</a>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                            
                        </thead>


                        <tbody>
                        	@foreach($suppliers as $key => $item)
                        <tr>
                            <td> {{ $key++}} </td>
                            <td> {{ $item->name}} </td>
                            <td> {{ $item->mobile_no}} </td>
                            <td> {{ $item->email }} </td>
                            <td> {{ $item->address }} </td>
                            <td>
   <a href="{{ route('edit.supplier', $item->id) }}" class="btn btn-info sm" title="Edit Data">  <i class="fas fa-edit"></i> </a>

    <a href="{{route('delete.supplier', $item->id)}}" class="btn btn-danger sm" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

                            </td>
                           
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
        
                     
                        
                    </div> <!-- container-fluid -->
                </div>
 

@endsection