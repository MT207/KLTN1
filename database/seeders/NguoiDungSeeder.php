<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NguoiDungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\NguoiDung::create([
            'id_chuc_vu' => 1, // Giả sử có chức vụ với id 1
            'id_doi_tac' => null,
            'ho_va_ten' => 'Nguyễn Văn A',
            'so_dien_thoai' => '0987654321',
            'email' => 'nguyenvana@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'du_lieu_khuon_mat' => null,
            'trang_thai' => true,
        ]);

        \App\Models\NguoiDung::create([
            'id_chuc_vu' => 2, // Giả sử có chức vụ với id 2
            'id_doi_tac' => 1, // Giả sử có đối tác với id 1
            'ho_va_ten' => 'Trần Thị B',
            'so_dien_thoai' => '0912345678',
            'email' => 'tranthib@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'du_lieu_khuon_mat' => null,
            'trang_thai' => true,
        ]);

        \App\Models\NguoiDung::create([
            'id_chuc_vu' => 3, // Giả sử có chức vụ với id 3
            'id_doi_tac' => null,
            'ho_va_ten' => 'Lê Văn C',
            'so_dien_thoai' => '0933445566',
            'email' => 'levanc@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'du_lieu_khuon_mat' => null,
            'trang_thai' => true,
        ]);

        \App\Models\NguoiDung::create([
            'id_chuc_vu' => 1,
            'id_doi_tac' => 2, // Giả sử có đối tác với id 2
            'ho_va_ten' => 'Phạm Thị D',
            'so_dien_thoai' => '0977889900',
            'email' => 'phamthid@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'du_lieu_khuon_mat' => null,
            'trang_thai' => true,
        ]);

        \App\Models\NguoiDung::create([
            'id_chuc_vu' => 2,
            'id_doi_tac' => null,
            'ho_va_ten' => 'Hoàng Văn E',
            'so_dien_thoai' => '0966554433',
            'email' => 'hoangvane@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'du_lieu_khuon_mat' => null,
            'trang_thai' => false, // Người dùng không hoạt động
        ]);
    }
}
