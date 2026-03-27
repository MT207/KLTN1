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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_chuc_vu')->nullable();
            $table->string('ho_va_ten');
            $table->string('so_dien_thoai')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_open')->default(true);
            $table->boolean('is_master')->default(false);
            $table->boolean('trang_thai')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
