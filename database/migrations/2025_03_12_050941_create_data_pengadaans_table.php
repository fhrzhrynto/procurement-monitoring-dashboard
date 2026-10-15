<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('data_pengadaans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pengadaan');
        $table->string('tor')->nullable();
        $table->string('rab')->nullable();
        $table->string('sph')->nullable();
        $table->string('bcr')->nullable();
        $table->string('nodin')->nullable();
        $table->string('file_path')->nullable(); // Tambahkan kolom ini
        $table->timestamps();
    });
}



    public function down()
    {
        Schema::dropIfExists('data_pengadaan');
    }
};
