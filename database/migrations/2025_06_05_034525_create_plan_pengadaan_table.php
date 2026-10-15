<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plan_pengadaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained('proyek_pengadaan')->onDelete('cascade');
            $table->string('id_plan')->unique(); // Seperti PLAN-001, PLAN-002
            $table->string('status')->default('Draft'); // Draft, Disetujui, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_pengadaan');
    }
};
