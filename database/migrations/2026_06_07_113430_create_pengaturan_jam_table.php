<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaturan_jam', function (Blueprint $table) {
            $table->id();
            $table->time('jam_buka')->default('09:00:00');
            $table->time('jam_tutup')->default('22:00:00');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pengaturan_jam'); }
};