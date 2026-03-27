<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChucNang extends Model
{
    protected $fillable = [
        'ten_chuc_nang',
        'ma_chuc_nang',
        'url',
        'mo_ta',
    ];
}
