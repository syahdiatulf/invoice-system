@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Invoice #{{ $invoice->id }}</h2>
    <p><strong>Customer:</strong> {{ $invoice->customer->name }}</p>
    <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Total:</strong> {{ $invoice->total }}</p>

    <h3 class="mt-4 font-semibold">Items</h3>
    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">Product</th>
                <th class="border p-2">Quantity</th>
                <th class="border p-2">Price</th>
                <th class="border p-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
            <tr>
                <td class="border p-2">{{ $item->product_name }}</td>
                <td class="border p-2">{{ $item->quantity }}</td>
                <td class="border p-2">{{ $item->price }}</td>
                <td class="border p-2">{{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('invoices.index') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        Back to Invoices
    </a>
</div>
@endsection
