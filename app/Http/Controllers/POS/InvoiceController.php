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

    }
}
