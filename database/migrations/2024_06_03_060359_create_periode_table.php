<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('periode', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('periode_nama');
            $table->string('periode_kepala_sekolah');
            $table->string('periode_no_kepala_sekolah');
            $table->tinyInteger('actif')->comment('1: active, 2: nonactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
