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
    public function addPurchase(){
        $suppliers = Supplier::all();
        $categories = Category::all();
        return view('backend.purchase.add_purchase',compact('suppliers','categories'));
    }
    
    // view all purchase
    public function viewAllPurchases(){
        $purchases = Purchase::orderBy('date','desc')->orderBy('id','desc');
        return view('backend.purchase.view_all_purchases',compact('purchases'));
    }
}
