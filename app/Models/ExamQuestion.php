<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_id',
        'order',
    ];

    public function questions()
    {
        return $this->belongsTo(Question::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
