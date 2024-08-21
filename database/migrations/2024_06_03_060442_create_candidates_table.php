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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('status', ['perseorangan', 'ganda'])->default('perseorangan');
            $table->tinyInteger('no_urut_kandidat');
            $table->string('nama_ketua');
            $table->string('nama_wakil_ketua')->nullable();
            $table->string('slug')->unique();;
            $table->longText('visi');
            $table->longText('misi');
            $table->string('slogan');
            $table->string('foto')->nullable();
            $table->string('foto_wakil')->nullable();
            $table->unsignedBigInteger('periode_id');
            $table->foreign('periode_id')->references('id')->on('periode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
