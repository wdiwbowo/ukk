<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Relasi dengan transaksi
            $table->decimal('jumlah_bayar', 15, 2); // Jumlah yang dibayarkan
            $table->decimal('kembalian', 15, 2)->default(0); // Jika pembayaran lebih besar dari total transaksi
            $table->string('status')->default('pending'); // Status: pending, sukses, gagal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
