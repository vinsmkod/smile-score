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
        Schema::create('smile_score_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('age');
            $table->string('gender', 20);
            $table->string('class_name', 50);
            $table->json('answers');
            $table->unsignedTinyInteger('correct_count');
            $table->unsignedTinyInteger('percentage');
            $table->string('category', 30);
            $table->string('emoji', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smile_score_submissions');
    }
};
