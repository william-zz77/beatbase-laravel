<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('studio', function (Blueprint $table) {
            $table->id('id_studio');
            $table->foreignId('id_owner')->nullable()->constrained('users', 'id_user')->nullOnDelete();
            $table->string('nama_studio', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_jam', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('studio'); }
};