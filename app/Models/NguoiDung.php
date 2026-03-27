<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class NguoiDung extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id_chuc_vu',
        'id_doi_tac',
        'ho_va_ten',
        'so_dien_thoai',
        'email',
        'password',
        'du_lieu_khuon_mat',
        'trang_thai',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'trang_thai' => 'boolean',
        ];
    }
}
