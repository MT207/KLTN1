<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goi extends Model
{
    protected $fillable = [
        'ten_goi',
        'so_nguoi_toi_da',
        'so_phong_toi_da',
        'thoi_han',
        'mo_ta',
        'is_nguoi_dung',
        'is_open',
        'is_hien_thi',
        'trang_thai',
    ];

    protected function casts(): array
    {
        return [
            'is_nguoi_dung' => 'boolean',
            'is_open' => 'boolean',
            'is_hien_thi' => 'boolean',
            'trang_thai' => 'boolean',
        ];
    }
}
