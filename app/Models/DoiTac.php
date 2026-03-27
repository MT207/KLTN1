<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DoiTac extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id_admin',
        'ho_va_ten',
        'so_dien_thoai',
        'email',
        'password',
        'dia_chi',
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
