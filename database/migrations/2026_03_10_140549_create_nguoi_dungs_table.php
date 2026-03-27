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
        Schema::create('nguoi_dungs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_chuc_vu')->nullable();
            $table->unsignedBigInteger('id_doi_tac')->nullable();
            $table->string('ho_va_ten');
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->longText('du_lieu_khuon_mat')->nullable();
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguoi_dungs');
    }
};
