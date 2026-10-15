<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('proyek_pengadaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_proyek');
            $table->text('deskripsi')->nullable();  // Kolom untuk deskripsi proyek
            $table->date('start_date')->nullable(); // Tanggal mulai proyek
            $table->date('target_date')->nullable(); // Target tanggal selesai
            $table->string('progress')->nullable();  // Keterangan update terakhir/progress
            $table->timestamps();                    // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyek_pengadaan');
    }
};
