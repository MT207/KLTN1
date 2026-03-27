<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhongHop extends Model
{
    protected $fillable = [
        'id_nguoi_dung',
        'id_phong_hop',
        'xac_thuc_khuon_mat',
        'is_vi_pham',
        'is_nguoi_dung',
        'is_active',
        'trang_thai',
    ];

    protected function casts(): array
    {
        return [
            'is_vi_pham' => 'boolean',
            'is_nguoi_dung' => 'boolean',
            'is_active' => 'boolean',
            'trang_thai' => 'boolean',
        ];
    }
}
