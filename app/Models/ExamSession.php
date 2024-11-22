<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'exam_id', 'token', 'time_left', 'question_id', 'drop_out'];

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
