<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([

            [
                'name' => 'Ali Khan',
                'email' => 'ali@gmail.com',
                'phone' => '03001234567',
                'address' => 'Lahore, Pakistan',
                'total_orders' => 1,
                'total_spent' => 80000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Sara Ahmed',
                'email' => 'sara@gmail.com',
                'phone' => '03111234567',
                'address' => 'Karachi, Pakistan',
                'total_orders' => 1,
                'total_spent' => 45000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Hamza Ali',
                'email' => 'hamza@gmail.com',
                'phone' => '03211234567',
                'address' => 'Islamabad, Pakistan',
                'total_orders' => 1,
                'total_spent' => 60000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Fatima Noor',
                'email' => 'fatima@gmail.com',
                'phone' => '03331234567',
                'address' => 'Faisalabad, Pakistan',
                'total_orders' => 1,
                'total_spent' => 70000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Ahmed Raza',
                'email' => 'ahmed@gmail.com',
                'phone' => '03451234567',
                'address' => 'Multan, Pakistan',
                'total_orders' => 1,
                'total_spent' => 50000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Ayesha Khan',
                'email' => 'ayesha@gmail.com',
                'phone' => '03099887766',
                'address' => 'Rawalpindi, Pakistan',
                'total_orders' => 1,
                'total_spent' => 35000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Usman Tariq',
                'email' => 'usman@gmail.com',
                'phone' => '03155667788',
                'address' => 'Sialkot, Pakistan',
                'total_orders' => 1,
                'total_spent' => 90000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Zain Ali',
                'email' => 'zain@gmail.com',
                'phone' => '03233445566',
                'address' => 'Peshawar, Pakistan',
                'total_orders' => 1,
                'total_spent' => 55000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Hira Malik',
                'email' => 'hira@gmail.com',
                'phone' => '03344556677',
                'address' => 'Gujranwala, Pakistan',
                'total_orders' => 1,
                'total_spent' => 42000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Bilal Ahmed',
                'email' => 'bilal@gmail.com',
                'phone' => '03466778899',
                'address' => 'Sheikhupura, Pakistan',
                'total_orders' => 1,
                'total_spent' => 65000,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}