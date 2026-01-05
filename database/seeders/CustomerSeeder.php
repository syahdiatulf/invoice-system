<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder {
    public function run(): void {
        Customer::insert([
            ['name' => 'Farah', 'email' => 'farah@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Atul', 'email' => 'atul@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Syah', 'email' => 'syah@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

