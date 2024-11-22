<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'has_accessed'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function questionsExam()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Mengambil total skor dari UserAnswer
    public function getTotalScore()
    {
        return $this->userAnswers()->sum('score');
    }
}
