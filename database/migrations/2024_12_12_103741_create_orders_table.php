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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key ke tabel Users
            $table->string('laundry_type'); // Jenis cucian (kiloan, dry cleaning, dll)
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->float('total_price', 8, 2); // Total harga
            $table->date('pickup_date'); // Tanggal pengambilan
            $table->date('delivery_date')->nullable(); // Tanggal pengiriman
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relasi ke tabel Users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
