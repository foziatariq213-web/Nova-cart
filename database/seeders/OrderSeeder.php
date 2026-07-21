<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert([

            [
                'order_number' => 'ORD-1001',
                'customer_name' => 'Ali Khan',
                'email' => 'ali@gmail.com',
                'phone' => '03001234567',
                'address' => 'Lahore, Pakistan',
                'total' => 80000,
                'payment_method' => 'Cash on Delivery',
                'payment_status' => 'Unpaid',
                'order_status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1002',
                'customer_name' => 'Sara Ahmed',
                'email' => 'sara@gmail.com',
                'phone' => '03111234567',
                'address' => 'Karachi, Pakistan',
                'total' => 45000,
                'payment_method' => 'JazzCash',
                'payment_status' => 'Paid',
                'order_status' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1003',
                'customer_name' => 'Hamza Ali',
                'email' => 'hamza@gmail.com',
                'phone' => '03211234567',
                'address' => 'Islamabad, Pakistan',
                'total' => 60000,
                'payment_method' => 'EasyPaisa',
                'payment_status' => 'Paid',
                'order_status' => 'Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1004',
                'customer_name' => 'Fatima Noor',
                'email' => 'fatima@gmail.com',
                'phone' => '03331234567',
                'address' => 'Faisalabad, Pakistan',
                'total' => 70000,
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'order_status' => 'Shipped',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1005',
                'customer_name' => 'Ahmed Raza',
                'email' => 'ahmed@gmail.com',
                'phone' => '03451234567',
                'address' => 'Multan, Pakistan',
                'total' => 50000,
                'payment_method' => 'Bank Transfer',
                'payment_status' => 'Paid',
                'order_status' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1006',
                'customer_name' => 'Ayesha Khan',
                'email' => 'ayesha@gmail.com',
                'phone' => '03099887766',
                'address' => 'Rawalpindi, Pakistan',
                'total' => 35000,
                'payment_method' => 'Cash on Delivery',
                'payment_status' => 'Unpaid',
                'order_status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1007',
                'customer_name' => 'Usman Tariq',
                'email' => 'usman@gmail.com',
                'phone' => '03155667788',
                'address' => 'Sialkot, Pakistan',
                'total' => 90000,
                'payment_method' => 'JazzCash',
                'payment_status' => 'Paid',
                'order_status' => 'Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1008',
                'customer_name' => 'Zain Ali',
                'email' => 'zain@gmail.com',
                'phone' => '03233445566',
                'address' => 'Peshawar, Pakistan',
                'total' => 55000,
                'payment_method' => 'EasyPaisa',
                'payment_status' => 'Paid',
                'order_status' => 'Delivered',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1009',
                'customer_name' => 'Hira Malik',
                'email' => 'hira@gmail.com',
                'phone' => '03344556677',
                'address' => 'Gujranwala, Pakistan',
                'total' => 42000,
                'payment_method' => 'Cash on Delivery',
                'payment_status' => 'Unpaid',
                'order_status' => 'Cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'order_number' => 'ORD-1010',
                'customer_name' => 'Bilal Ahmed',
                'email' => 'bilal@gmail.com',
                'phone' => '03466778899',
                'address' => 'Sheikhupura, Pakistan',
                'total' => 65000,
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'order_status' => 'Shipped',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}