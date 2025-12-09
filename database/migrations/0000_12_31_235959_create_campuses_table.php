<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kampus');
            $table->string('akronim')->nullable();
            $table->string('alamat')->nullable(); // Tambah alamat
            $table->string('kota')->nullable();
            $table->string('website')->nullable();
            $table->string('akreditasi')->nullable(); 
            // $table->integer('total_program_studi')->nullable();
            $table->text('deskripsi')->nullable(); // Tambah deskripsi
            $table->json('jalur_masuk')->nullable(); // Contoh: ["SNBP", "SNBT", "Mandiri"]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
