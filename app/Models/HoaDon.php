<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $fillable = [
        'id_nguoi_dung',
        'id_goi',
        'so_tien',
        'ma_giao_dich',
        'phuong_thuc_thanh_toan',
        'trang_thai_thanh_toan',
    ];

    protected function casts(): array
    {
        return [
            'so_tien' => 'decimal:2',
        ];
    }
}
