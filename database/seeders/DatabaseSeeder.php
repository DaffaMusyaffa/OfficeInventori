<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Admin (satu-satunya akun bawaan; employee mendaftar sendiri) ---
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // --- Data Barang ---
        $items = [
            ['name' => 'Mouse Wireless',   'category' => 'Elektronik', 'stock' => 15,  'minimum_stock' => 5,  'location' => 'Gudang A'],
            ['name' => 'Keyboard Logitech', 'category' => 'Elektronik', 'stock' => 8,   'minimum_stock' => 3,  'location' => 'Gudang A'],
            ['name' => 'Kabel HDMI',        'category' => 'Elektronik', 'stock' => 12,  'minimum_stock' => 5,  'location' => 'Gudang B'],
            ['name' => 'Headset',           'category' => 'Elektronik', 'stock' => 6,   'minimum_stock' => 4,  'location' => 'Gudang B'],
            ['name' => 'Flashdisk 32GB',    'category' => 'Elektronik', 'stock' => 20,  'minimum_stock' => 8,  'location' => 'Gudang A'],
            ['name' => 'Kertas A4',         'category' => 'ATK',        'stock' => 50,  'minimum_stock' => 10, 'location' => 'Gudang C'],
            ['name' => 'Pulpen',            'category' => 'ATK',        'stock' => 100, 'minimum_stock' => 20, 'location' => 'Gudang C'],
            ['name' => 'Tinta Printer',     'category' => 'ATK',        'stock' => 4,   'minimum_stock' => 5,  'location' => 'Gudang C'],
        ];

        foreach ($items as $data) {
            Item::create($data);
        }
    }
}
