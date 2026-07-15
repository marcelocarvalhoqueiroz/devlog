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
        Schema::create('experience_tech', function (Blueprint $table) {
            $table->id();

            $table->uuid('experience_id');
            $table->foreign('experience_id')->references('uuid')->on('experiences')->onDelete('cascade');

            $table->uuid('tech_id');
            $table->foreign('tech_id')->references('uuid')->on('techs')->onDelete('cascade');

            $table->unique(['experience_id', 'tech_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_tech');
    }
};
