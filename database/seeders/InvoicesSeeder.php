<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;

class InvoicesSeeder extends Seeder
{
    public function run()
    {
        $customers = Customer::all(); // 3 customers

        $invoiceCount = 0;

        foreach ($customers as $customer) {
            // Each customer gets 5 invoices
            for ($i = 1; $i <= 5; $i++) {
                $invoiceCount++;
                $invoice = Invoice::create([
                    'customer_id' => $customer->id,
                    'invoice_date' => now()->subDays(15 - $invoiceCount), // spread dates
                    'total' => 0, // will calculate after adding items
                ]);

                // Each invoice has 2 items
                $items = [
                    ['product_name' => 'Product A', 'quantity' => rand(1,3), 'price' => rand(10,50)],
                    ['product_name' => 'Product B', 'quantity' => rand(1,3), 'price' => rand(10,50)],
                ];

                $total = 0;
                foreach ($items as $item) {
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_name' => $item['product_name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                    $total += $item['quantity'] * $item['price'];
                }

                // Update invoice total
                $invoice->update(['total' => $total]);
            }
        }
    }
}
