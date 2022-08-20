<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use Auth;

class CustomerController extends Controller
{
    
// view all suppliers
public function viewAllCustomer(){

    $customers = Customer::latest()->get();
    return view('backend.customer.view_all_customers',compact('customers'));

}//end method

// add supplier page
public function addCustomer(){

    return view('backend.customer.add_customer');

}

// insert supplier 
public function insertCustomer(Request $request){
    
    Customer::insert([

        'name' => $request->name,
        'mobile_no' => $request->mobile_no,
        'email' => $request->email,
        'address' => $request->address,
        'created_by' => Auth::User()->id,
        'created_at' => Carbon::now(),

    ]); 
    $notification = array(
    'message' => 'Customer Add Successfully', 
    'alert-type' => 'success'
);

return redirect()->route('view.customers')->with($notification);


}//end method


// edit supplier
public function editCustomer($id){
    $customer = Customer::findOrFail($id);
    return view('backend.customer.edit_customer',compact('customer'));

   
} // End Method

// update supplier
public function updateCustomer(Request $request){
    $id = $request->id;
    Customer::findOrFail($id)->update([
        'name' => $request->name,
        'mobile_no' => $request->mobile_no,
        'email' => $request->email,
        'address' => $request->address,
        'updated_by' => Auth::User()->id,
        'updated_at' => Carbon::now()
    ]);

    $notification = array(
        'message' => 'Customer Updated Successfully', 
        'alert-type' => 'success'
    );

    return redirect()->route('view.customers')->with($notification);

}//end method


// delete method
public function deleteCustomer($id){

    Customer::findOrFail($id)->delete();

     $notification = array(
        'message' => 'Customer Deleted Successfully', 
        'alert-type' => 'success'
    );

    return redirect()->back()->with($notification);       

} // End Method

    
}
