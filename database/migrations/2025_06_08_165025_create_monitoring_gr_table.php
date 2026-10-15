<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('monitoring_gr', function (Blueprint $table) {
            $table->id();
            $table->string('no_po')->nullable();
            $table->string('no_gr')->nullable();
            $table->string('judul')->nullable();
            $table->decimal('nilai_gr', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_gr');
    }
};
