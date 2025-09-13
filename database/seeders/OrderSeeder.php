<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء 10 طلبات تجريبية
        for ($i = 1; $i <= 10; $i++) {
            $user = User::inRandomOrder()->first();
            
            if (!$user) {
                // إذا لم يكن هناك مستخدمين، قم بإنشاء مستخدم
                $user = User::create([
                    'name' => 'عميل تجريبي ' . $i,
                    'email' => 'customer' . $i . '@example.com',
                    'password' => bcrypt('password'),
                    'user_type' => 'customer'
                ]);
            }
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'status' => ['pending', 'processing', 'shipped', 'delivered'][rand(0, 3)],
                'subtotal' => $subtotal = rand(100, 1000),
                'tax' => $tax = $subtotal * 0.15,
                'shipping' => $shipping = 30,
                'total' => $subtotal + $tax + $shipping,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '05' . rand(10000000, 99999999),
                'shipping_address' => 'عنوان تجريبي ' . $i . '، مكة، المملكة العربية السعودية',
                'notes' => rand(0, 1) ? 'ملاحظات للطلب رقم ' . $i : null
            ]);
            
            // لا نقوم بإنشاء عناصر الطلب لأن جدول المنتجات فارغ
        }
    }
}