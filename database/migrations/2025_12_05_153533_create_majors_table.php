<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->onDelete('cascade');
            $table->string('nama_jurusan');
            $table->string('fakultas')->nullable();
            $table->string('akreditasi')->nullable();
            $table->integer('kapasitas')->nullable();
            $table->integer('peminat')->nullable();  
            $table->integer('diterima')->nullable();  
            $table->string('tingkat')->nullable();    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
