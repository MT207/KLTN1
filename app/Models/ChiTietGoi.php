<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietGoi extends Model
{
    protected $fillable = [
        'id_goi',
        'id_nguoi_dung',
        'id_doi_tac',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'is_active',
        'is_nguoi_dung',
    ];

    protected function casts(): array
    {
        return [
            'ngay_bat_dau' => 'date',
            'ngay_ket_thuc' => 'date',
            'trang_thai' => 'boolean',
            'is_active' => 'boolean',
            'is_nguoi_dung' => 'boolean',
        ];
    }
}
