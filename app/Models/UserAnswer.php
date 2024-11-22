<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exam_id',
        'token',
        'score_type',
        'score',
        'question_id',
        'selected_option',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getPointsAttribute()
    {
        $question = $this->question;
        $value = 0;

        if ($question->exam->category->scoring_type === 'TIU') {
            if ($this->is_answered) {
                switch ($this->selected_option) {
                    case 'A':
                        $value = $question->poin_a;
                        break;
                    case 'B':
                        $value = $question->poin_b;
                        break;
                    case 'C':
                        $value = $question->poin_c;
                        break;
                    case 'D':
                        $value = $question->poin_d;
                        break;
                    case 'E':
                        $value = $question->poin_e;
                        break;
                }
                if ($value === null) {
                    $value = 0;
                }
            } else {
                $value = 1;
            }
        } else {
            if ($this->selected_option === $question->correct_option) {
                $value = 5;
            } else {
                $value = 0;
            }
        }

        return $value;
    }
}
