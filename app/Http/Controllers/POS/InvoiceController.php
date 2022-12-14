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
use Illuminate\Support\Facades\Auth;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\location\Division;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    // all invoices
    public function viewAllInvoice(){

        $invoices = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','1')->get();
        return view('backend.invoice.view_all_invoices',compact('invoices'));
    }

    // invoice add
    public function addInvoice(){
        $date = date('Y-m-d');
        $invoice_no = Invoice::orderBy('id','desc')->first();
        if($invoice_no == null){
            $num = '0';
            $invoice_no = $num+1;
        }else{
            $invoice_no = Invoice::orderBy('id','desc')->first()->invoice_no;
            $invoice_no = $invoice_no+1 ;
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
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;

                DB::transaction(function() use($request,$invoice){
                    if ($invoice->save()) {
                       $count_category = count($request->category_id);
                       for ($i=0; $i < $count_category ; $i++) {

                          $invoice_details = new InvoiceDetail();
                          $invoice_details->date = date('Y-m-d',strtotime($request->date));
                          $invoice_details->invoice_id = $invoice->id;
                          $invoice_details->category_id = $request->category_id[$i];
                          $invoice_details->product_id = $request->product_id[$i];
                          $invoice_details->selling_qty = $request->selling_qty[$i];
                          $invoice_details->unit_price = $request->unit_price[$i];
                          $invoice_details->selling_price = $request->selling_price[$i];
                          $invoice_details->status = '0';
                          $invoice_details->save();
                       }

                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->name = $request->name;
                            $customer->mobile_no = $request->mobile_no;
                            $customer->email = $request->email;
                            $customer->save();
                            $customer_id = $customer->id;
                        } else{
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_status == 'full_due') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        }elseif ($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d',strtotime($request->date));
                        $payment_details->save();
                    }

                        });

            }// end else

            $notification = array(
                'message' => 'Invoice Data Inserted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('pending.invoice')->with($notification);
        }



    } //end method

    // pending list
    public function pendingInvoice(){

        $pendings = Invoice::orderBy('date','desc')->orderBy('id','desc')->where('status','0')->get();

        return view('backend.invoice.pending_list',compact('pendings'));
    }//end method


    //aprove invocie page
    public function editInvoice($id){

        $invoice = Invoice::findOrFail($id);

        return view('backend.invoice.approve_invoice', compact('invoice'));

    }


    //approveInvoice



    public function approveInvoice(Request $request, $id){

        foreach($request->selling_qty as $key => $val){
            $invoice_details = InvoiceDetail::where('id',$key)->first();
            $product = Product::where('id',$invoice_details->product_id)->first();
            if($product->quantity < $request->selling_qty[$key]){

        $notification = array(
        'message' => 'Sorry you approve Maximum Value',
        'alert-type' => 'error'
    );
    return redirect()->back()->with($notification);

            }
        } // End foreach

        $invoice = Invoice::findOrFail($id);
        $invoice->updated_by = Auth::user()->id;
        $invoice->status = '1';

        DB::transaction(function() use($request,$invoice,$id){
            foreach($request->selling_qty as $key => $val){
             $invoice_details = InvoiceDetail::where('id',$key)->first();

             $invoice_details->status = '1';
             $invoice_details->save();

             $product = Product::where('id',$invoice_details->product_id)->first();
             $product->quantity = ((float)$product->quantity) - ((float)$request->selling_qty[$key]);
             $product->save();
            } // end foreach

            $invoice->save();
        });

    $notification = array(
        'message' => 'Invoice Approve Successfully',
        'alert-type' => 'success'
    );
    return redirect()->route('view.invoices')->with($notification);

    } // End Method

    // delete invoice method
    public function deleteInvoice($id){

       $invoice = Invoice::findOrFail($id);
       $invoice->delete();
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();

        $notification = array(
            'message' => 'Invoice Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    // all invoices
    public function divisionList(){

        $divisions = Division::get();
        return view('backend.invoice.list',compact('divisions'));
    }
}
