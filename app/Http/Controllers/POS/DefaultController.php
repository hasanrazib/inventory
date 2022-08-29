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

class DefaultController extends Controller
{
    //get categories by ajax filtering
    public function getCategory(Request $request){
        $supplier_id = $request->supplier_id;
        
        $allCategory = Product::with(['category'])->select('category_id')->where('supplier_id',$supplier_id)->groupBy('category_id')->get();
        return response()->json($allCategory);

    }//end method

    // get products by ajax filtering
    public function getProduct(Request $request){

        $category_id = $request->category_id; 
        $allProduct = Product::where('category_id',$category_id)->get();
        return response()->json($allProduct);
    } // end mehtod 

    public function getStock(Request $request){
        $product_id = $request->product_id;
        $stocks = Product::where('id',$product_id)->first()->quantity;

        return response()->json($stocks);
    }

    

}
