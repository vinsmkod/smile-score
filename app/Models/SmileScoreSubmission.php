<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmileScoreSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'class_name',
        'answers',
        'correct_count',
        'percentage',
        'category',
        'emoji',
        'status',
        'answered_count',
        'test_type',
        'session_id',
        'started_at',
        'completed_at',
        'ai_education',
        'ai_education_generated_at',
        'ai_education_source',
    ];

    protected $casts = [
        'answers'                   => 'array',
        'ai_education'              => 'array',
        'age'                       => 'integer',
        'correct_count'             => 'integer',
        'percentage'                => 'integer',
        'answered_count'            => 'integer',
        'started_at'                => 'datetime',
        'completed_at'              => 'datetime',
        'ai_education_generated_at' => 'datetime',
    ];

    /**
     * Scope query untuk responden yang sudah menyelesaikan kuesioner.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope query untuk responden yang pengerjaannya belum selesai.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Dapatkan ID responden berformat ramah penelitian, e.g. #SS-000123
     */
    public function getFormattedIdAttribute(): string
    {
        return 'SS-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
