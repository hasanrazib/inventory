<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use Auth;

class ProductController extends Controller
{

      // view all category
      public function viewAllProduct (){

        $products = Product::latest()->get();
        return view('backend.product.view_all_products',compact('products'));


    }//end method

    // add product method
    public function addProduct(){

        $suppliers = Supplier::all();
        $categories = Category::all();
        $units = Unit::all();

        return view('backend.product.add_product',compact('suppliers','categories','units'));
    }

    // insert product
    public function insertProduct(Request $request){

        Product::insert([
            'name' => $request->name,
            'supplier_id' => $request->supplier_id,
            'unit_id' => $request->unit_id,
            'category_id' => $request->category_id,
            'created_by' => Auth::User()->id,
            'quantity' => '0',
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product Inserted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->route('view.products')->with($notification); 
    }



    // delete method
    public function deleteProduct($id){

        Product::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully', 
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);       
    }//end method



}
