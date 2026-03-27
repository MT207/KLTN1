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
        Schema::create('chi_tiet_phong_hops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nguoi_dung');
            $table->unsignedBigInteger('id_phong_hop');
            $table->text('xac_thuc_khuon_mat')->nullable();
            $table->boolean('is_vi_pham')->default(false);
            $table->boolean('is_nguoi_dung')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phong_hops');
    }
};
