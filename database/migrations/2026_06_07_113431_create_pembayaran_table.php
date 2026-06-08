<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->foreignId('id_reservasi')->constrained('reservasi', 'id_reservasi')->cascadeOnDelete();
            $table->decimal('jumlah', 12, 2);
            $table->enum('metode_bayar', ['transfer', 'tunai', 'ewallet'])->default('transfer');
            $table->enum('status_bayar', ['belum_bayar', 'lunas', 'refund'])->default('belum_bayar');
            $table->timestamp('dibayar_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};