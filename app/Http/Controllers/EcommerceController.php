<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class EcommerceController extends Controller
{
    // Fetch products with stock > 10
    public function getHighStockProducts()
    {
        $products = DB::select("
            SELECT id, name, description, price, stock
            FROM products
            WHERE stock > 10
        ");

        return response()->json($products);
    }

    // Fetch orders for a specific user
    public function getUserOrders($userId)
    {
        $orders = DB::select("
            SELECT id, total_price, status, created_at
            FROM orders
            WHERE user_id = ?
        ", [$userId]);

        return response()->json($orders);
    }

    // Place order and update stock
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($validated) {
            $totalPrice = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }
                $totalPrice += $product->price * $item['quantity'];
                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update stock
                DB::update("
                    UPDATE products
                    SET stock = stock - ?
                    WHERE id = ?
                ", [$item['quantity'], $item['product_id']]);
            }

            return response()->json([
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ], 201);
        });
    }
}
