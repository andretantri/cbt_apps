<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    // Relasi ke Exam melalui UserAnswer
    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'user_answers')
            ->withPivot('score')
            ->withTimestamps();
    }

    // Mengambil total skor untuk setiap ujian yang diikuti
    public function getTotalScore()
    {
        return $this->userAnswers()
            ->select('exam_id', DB::raw('SUM(score) as total_score'))
            ->groupBy('exam_id')
            ->get(); // Tambahkan get() untuk mengembalikan koleksi
    }
}
