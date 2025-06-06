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
        Schema::create('promo_outlet', function (Blueprint $table) {
            $table->id();
            $table->string('nama_promo');
            $table->integer('diskon_persen');
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->date('mulai');
            $table->date('selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_outlet');
    }
};
