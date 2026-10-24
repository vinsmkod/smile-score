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
            $table->string('status', 20)->default('completed')->after('emoji')->index();
            $table->unsignedTinyInteger('answered_count')->default(20)->after('status');
            $table->string('test_type', 20)->default('pre_test')->after('answered_count')->index();
            $table->string('session_id', 100)->nullable()->after('test_type')->index();
            $table->timestamp('started_at')->nullable()->after('session_id');
            $table->timestamp('completed_at')->nullable()->after('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('smile_score_submissions', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'answered_count',
                'test_type',
                'session_id',
                'started_at',
                'completed_at',
            ]);
        });
    }
};
