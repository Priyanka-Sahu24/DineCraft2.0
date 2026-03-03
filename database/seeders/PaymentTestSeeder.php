<?php
// Quick test seeder for payments table
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PaymentTestSeeder extends Seeder
{
    public function run()
    {
        // Find a real order and user
        $order = \App\Models\Order::first();
        if (!$order) {
            $user = \App\Models\User::first();
            if (!$user) return;
            $order = \App\Models\Order::create([
                'order_number' => 'ORD-TEST',
                'user_id' => $user->id,
                'order_type' => 'dine-in',
                'order_status' => 'completed',
            ]);
        }
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'payment_method' => 'cash',
            'transaction_id' => 'TXN-TEST',
            'payment_status' => 'paid',
            'amount' => 123.45,
            'paid_at' => now(),
        ]);
    }
}
