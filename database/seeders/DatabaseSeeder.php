<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        User::factory(10)->create();

        // Create 50 products
        Product::factory(50)->create();

        // Create 20 orders with order items
        Order::factory(20)->create()->each(function ($order) {
            OrderItem::factory(rand(1, 5))->create([
                'order_id' => $order->id,
            ]);
        });
    }
}
