<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(){
        $invoices = Invoice::with(['customer', 'items'])->orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'data' => $invoices->items(),
            'current_page' => $invoices->currentPage(),
            'last_page' => $invoices->lastPage(),
            'per_page' => $invoices->perPage(),
            'total' => $invoices->total(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $data['customer_id'],
            'invoice_date' => $data['invoice_date'],
            'total' => collect($data['items'])->sum(fn($i) => $i['quantity'] * $i['price']),
        ]);

        foreach ($data['items'] as $item) {
            $invoice->items()->create($item);
        }

        return response()->json($invoice->load('items'));
    }
}
