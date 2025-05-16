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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
          
            $table->unsignedBigInteger('user_id')->nullable(); // tambahkan dulu kolomnya
            
            $table->decimal('saldo', 12, 2)->default(0);
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->string('midtrans_order_id')->unique()->nullable();
            $table->string('midtrans_payment_status')->nullable(); // atau bisa pakai enum nanti
            $table->timestamps();
        
            // Foreign key setelah definisi kolom
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
