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
        Schema::table('smile_score_submissions', function (Blueprint $table) {
            // Simpan materi edukasi AI/rule-based sebagai JSON
            if (!Schema::hasColumn('smile_score_submissions', 'ai_education')) {
                $table->json('ai_education')->nullable()->after('completed_at');
            }
            // Catat kapan edukasi terakhir dihasilkan
            if (!Schema::hasColumn('smile_score_submissions', 'ai_education_generated_at')) {
                $table->timestamp('ai_education_generated_at')->nullable()->after('ai_education');
            }
            // Catat sumber edukasi: 'ai', 'ai_failed', atau 'rule_based'
            if (!Schema::hasColumn('smile_score_submissions', 'ai_education_source')) {
                $table->string('ai_education_source', 20)->nullable()->after('ai_education_generated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smile_score_submissions', function (Blueprint $table) {
            //
        });
    }
};
