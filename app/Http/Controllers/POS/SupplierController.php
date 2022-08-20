<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Supplier;
use Auth;


class SupplierController extends Controller
{
    // view all suppliers
    public function viewAllSupplier(){

        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.view_all_suppliers',compact('suppliers'));

    }//end method

    // add supplier page
    public function addSupplier(){

        return view('backend.supplier.add_supplier');

    }

    // insert supplier 
    public function insertSuplier(Request $request){
        
        Supplier::insert([

            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'created_by' => Auth::User()->id,
            'created_at' => Carbon::now(),

        ]); 
        $notification = array(
        'message' => 'Supplier Add Successfully', 
        'alert-type' => 'success'
    );

    return redirect()->route('view.suppliers')->with($notification);


    }//end method


    // edit supplier
    public function editSupplier($id){
        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.edit_supplier',compact('supplier'));

       
    } // End Method

    // update supplier
    public function updateSupplier(Request $request){
        $id = $request->id;
        Supplier::findOrFail($id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'update_by' => Auth::User()->id,
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Supplier Updated Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('view.suppliers')->with($notification);

    }//end method


    // delete method
    public function deleteSupplier($id){

        Supplier::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Supplier Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);       

    } // End Method






}
