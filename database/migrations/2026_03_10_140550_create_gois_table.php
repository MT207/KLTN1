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
        Schema::create('gois', function (Blueprint $table) {
            $table->id();
            $table->string('ten_goi');
            $table->integer('so_nguoi_toi_da')->default(0);
            $table->integer('so_phong_toi_da')->default(0);
            $table->integer('thoi_han')->default(0);
            $table->text('mo_ta')->nullable();
            $table->boolean('is_nguoi_dung')->default(true);
            $table->boolean('is_open')->default(true);
            $table->boolean('is_hien_thi')->default(true);
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gois');
    }
};
