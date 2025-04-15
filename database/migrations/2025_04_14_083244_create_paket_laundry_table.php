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
        Schema::create('paket_laundry', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->enum('jenis', ['kiloan', 'satuan']);
            $table->decimal('harga', 12, 2);
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_laundry');
    }
};
