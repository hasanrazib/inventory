<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Auth;

class PurchaseController extends Controller
{
    // view all purchase
    public function viewAllPurchases(){

        $purchases = Purchase::orderBy('date','desc')->orderBy('id','desc')->get();

        return view('backend.purchase.view_all_purchases',compact('purchases'));
    }


    // add purchase
    public function addPurchase(){

        $suppliers = Supplier::all();
        $categories = Category::all();

        return view('backend.purchase.add_purchase',compact('suppliers','categories'));
    }

    // inset product
    public function insertPurchase(Request $request){

        if ($request->category_id == null) {

           $notification = array(
            'message' => 'Sorry you do not select any item',
            'alert-type' => 'error'
            );
        return redirect()->back( )->with($notification);

        } else {

            $count_category = count($request->category_id);
            for ($i=0; $i < $count_category; $i++) {
                $purchase = new Purchase();
                $purchase->date = date('Y-m-d', strtotime($request->date[$i]));
                $purchase->purchase_no = $request->purchase_no[$i];
                $purchase->supplier_id = $request->supplier_id[$i];
                $purchase->category_id = $request->category_id[$i];

                $purchase->product_id = $request->product_id[$i];
                $purchase->buying_qty = $request->buying_qty[$i];
                $purchase->unit_price = $request->unit_price[$i];
                $purchase->buying_price = $request->buying_price[$i];
                $purchase->description = $request->description[$i];

                $purchase->created_by = Auth::user()->id;
                $purchase->status = '0';
                $purchase->save();
            } // end foreach

        } // end else

        $notification = array(
            'message' => 'Data Save Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('view.purchases')->with($notification);

        }// End Method



    // pending purchase
    public function pendingPurchase(){
        $pendings = Purchase::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();

        return view('backend.purchase.pending_purchase',compact('pendings'));
    }



    // approve function
    public function approvePurchase($id){

        $purchase = Purchase::findOrFail($id);
        $product = Product::where('id',$purchase->product_id)->first();
        $purchase_qty = ((float)($purchase->buying_qty))+((float)($product->quantity));
        $product->quantity = $purchase_qty;

        if($product->save()){

            Purchase::findOrFail($id)->update([
                'status' => '1',
            ]);

             $notification = array(
            'message' => 'Status Approved Successfully',
            'alert-type' => 'success'
            );
        return redirect()->route('view.purchases')->with($notification);

        }

    }// End Method


     // delete purchase method
     public function deletePurchase($id){

        Purchase::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Purchase Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
