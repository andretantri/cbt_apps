<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'token',
        'time_limit',
        'has_accessed',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function isTokenValid(): bool
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now && !$this->has_accessed;
    }
}
