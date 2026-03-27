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
        Schema::create('chi_tiet_gois', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_goi');
            $table->unsignedBigInteger('id_nguoi_dung')->nullable();
            $table->unsignedBigInteger('id_doi_tac')->nullable();
            $table->date('ngay_bat_dau')->nullable();
            $table->date('ngay_ket_thuc')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_nguoi_dung')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_gois');
    }
};
