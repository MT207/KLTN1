<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhanQuyen extends Model
{
    protected $fillable = [
        'id_chuc_vu',
        'id_chuc_nang',
    ];
}
