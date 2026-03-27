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
        Schema::create('phong_hops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_chu_phong');
            $table->string('ma_phong')->unique();
            $table->string('ten_phong');
            $table->integer('so_nguoi_toi_da')->default(0);
            $table->timestamp('thoi_gian_bat_dau')->nullable();
            $table->timestamp('thoi_gian_ket_thuc')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phong_hops');
    }
};
