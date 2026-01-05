<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{
    public function index(){
        $invoices = Invoice::with(['customer', 'items'])->orderBy('id', 'desc')->get();
        return response()->json($invoices);
    }


    public function store(Request $request){
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Create invoice
        $invoice = Invoice::create([
            'customer_id' => $data['customer_id'],
            'invoice_date' => now(),
            'total' => 0, // will calculate below
        ]);

        $total = 0;

        // Save items
        foreach ($data['items'] as $item) {
            $invoiceItem = new InvoiceItem([
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            $invoice->items()->save($invoiceItem);

            $total += $item['quantity'] * $item['price'];
        }

        // Update total
        $invoice->total = $total;
        $invoice->save();

        return response()->json($invoice->load('items'));
    }

    public function show($id)
    {
        $invoice = \App\Models\Invoice::with(['customer', 'items'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
