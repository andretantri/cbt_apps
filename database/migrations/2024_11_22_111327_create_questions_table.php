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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->string('category')->nullable();
            $table->string('image')->nullable();
            $table->string('option_a');
            $table->string('option_b');
            $table->string('option_c');
            $table->string('option_d');
            $table->string('option_e');
            $table->string('poin_a')->nullable();
            $table->string('poin_b')->nullable();
            $table->string('poin_c')->nullable();
            $table->string('poin_d')->nullable();
            $table->string('poin_e')->nullable();
            $table->string('image_a')->nullable();
            $table->string('image_b')->nullable();
            $table->string('image_c')->nullable();
            $table->string('image_d')->nullable();
            $table->string('image_e')->nullable();
            $table->char('correct_option');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
