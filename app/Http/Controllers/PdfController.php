<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Setup;
use Illuminate\Http\Request;
use PDF;
class PdfController extends Controller
{
    public function index()
    {
        $items = Product::all();
        $pdf = PDF::loadView('pdf.products', compact('items'));
        return $pdf->stream('document.pdf');

    }
    public function invoice($id)
    {
        $invoice = Invoice::find($id);
        $items = $invoice->invoiceDetails;
        $payment = Payment::where('invoice_id', $id)->first();
        $paymentDetails = PaymentDetail::where('invoice_id', $id)->get();
        $setup = Setup::first();
        $pdf = PDF::loadView('pdf.invoice-details', compact('items', 'invoice', 'payment', 'paymentDetails', 'setup'));
        return $pdf->stream('document.pdf');
//        return view('pdf.invoice-details', compact('items', 'invoice', 'payment'));

    }
    public function purchase($id)
    {
        $purchase = Purchase::find($id);
        $items = $purchase->purchaseDetails;
        $bill = Bill::where('purchase_id', $id)->first();
        $billDetails = BillDetail::where('purchase_id', $id)->get();
        $setup = Setup::first();
        $pdf = PDF::loadView('pdf.purchase-details', compact('items', 'purchase', 'bill', 'billDetails', 'setup'));
        return $pdf->stream('document.pdf');
//        return view('pdf.purchase-details', compact('items', 'purchase', 'bill'));

    }
}
