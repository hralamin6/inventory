<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
class PdfController extends Controller
{
    public function index()
    {
        $items = Product::all();
//        $pdf = PDF::loadView('pdf.products', compact('items'));
//        return $pdf->stream('itsolutionstuff.pdf');

    }
}
