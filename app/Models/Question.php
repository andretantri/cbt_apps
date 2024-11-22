<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'category',
        'image',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
        'correct_option',
        'poin_a',
        'poin_b',
        'poin_c',
        'poin_d',
        'poin_e',
        'image_a',
        'image_b',
        'image_c',
        'image_d',
        'image_e',
    ];

    public function userAnswer()
    {
        return $this->hasOne(UserAnswer::class);
    }

    // Metode untuk mendapatkan opsi yang benar
    public function getCorrectOption()
    {
        switch ($this->correct_option) {
            case 'A':
                return $this->option_a;
            case 'B':
                return $this->option_b;
            case 'C':
                return $this->option_c;
            case 'D':
                return $this->option_d;
            case 'E':
                return $this->option_e;
            default:
                return null;
        }
    }

    // Metode untuk mendapatkan poin dari opsi yang dipilih
    public function getPoin($option)
    {
        switch ($option) {
            case 'A':
                return $this->poin_a;
            case 'B':
                return $this->poin_b;
            case 'C':
                return $this->poin_c;
            case 'D':
                return $this->poin_d;
            case 'E':
                return $this->poin_e;
            default:
                return 0;
        }
    }

    public function hasUse()
    {
        return $this->hasMany(ExamQuestion::class);
    }
}
