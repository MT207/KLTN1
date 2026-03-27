<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::create([
            'id_chuc_vu' => null,
            'ho_va_ten' => 'Super Administrator',
            'so_dien_thoai' => '0987654321',
            'email' => 'admin@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_open' => true,
            'is_master' => true,
            'trang_thai' => true,
        ]);

        \App\Models\Admin::create([
            'id_chuc_vu' => 1,
            'ho_va_ten' => 'Admin Content',
            'so_dien_thoai' => '0912345678',
            'email' => 'content@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_open' => true,
            'is_master' => false,
            'trang_thai' => true,
        ]);

        \App\Models\Admin::create([
            'id_chuc_vu' => 2,
            'ho_va_ten' => 'Admin Marketing',
            'so_dien_thoai' => '0933445566',
            'email' => 'marketing@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_open' => true,
            'is_master' => false,
            'trang_thai' => true,
        ]);

        \App\Models\Admin::create([
            'id_chuc_vu' => 3,
            'ho_va_ten' => 'Admin Support',
            'so_dien_thoai' => '0977889900',
            'email' => 'support@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_open' => true,
            'is_master' => false,
            'trang_thai' => true,
        ]);
    }
}
