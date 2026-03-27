<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->unsignedBigInteger('id_goi');
            $table->decimal('so_tien', 15, 2)->default(0);
            $table->string('ma_giao_dich')->nullable();
            $table->string('phuong_thuc_thanh_toan')->nullable();
            $table->string('trang_thai_thanh_toan')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
