<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'id_phong_hop',
        'id_chi_tiet',
        'id_nguoi_dung',
        'noi_dung',
    ];
}
