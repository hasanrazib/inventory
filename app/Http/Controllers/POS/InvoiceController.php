<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Unit;
use App\Models\Category;
use App\Models\Product;
use Auth;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;


class InvoiceController extends Controller
{
    // all invoices
    public function viewAllInvoice(){

        $invoices = Invoice::orderBy('date','desc')->orderBy('id','desc')->get();
        return view('backend.invoice.view_all_invoices',compact('invoices'));
    }

    // invoice add
    public function addInvoice(){
        $date = date('Y-m-d');
        $invoice_no = Invoice::orderBy('id','desc')->first();
        if($invoice_no == null){
            $num = '0';
            $invoice_no = $num + 1;
        }else{
            $invoice_no = Invoice::orderBy('id','desc')->first();
            $invoice_no = $invoice_no + 1;
        }
        $categories = Category::all();
        $costomers = Customer::all();
        return view ('backend.invoice.add_invoice',compact('categories','date','invoice_no','costomers'));   
    }//end method

    // invoice insert 
    public function insertInvoice(Request $request){
        $category_id = $request->category_id;
        if($category_id == null){
            
            $notification = array(
                'message' => 'Sorry You do not select any item', 
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }else{
            if($request->paid_amount > $request->estimated_amount){

                $notification = array(
                    'message' => 'Sorry Paid Amount is Maximum the total price', 
                    'alert-type' => 'error'
                    );
                return redirect()->back()->with($notification);
            }else{
                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d',strtotime($request->date));
            }

        }
        

        
    } //end method
}
