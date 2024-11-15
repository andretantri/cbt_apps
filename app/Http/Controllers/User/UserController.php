<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\Exam;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::user()->id;

        $exams = Exam::leftJoin('user_answers', function ($join) use ($userId) {
            $join->on('exams.id', '=', 'user_answers.exam_id')
                ->where('user_answers.user_id', $userId);
        })
            ->leftJoin('exam_sessions', function ($join) use ($userId) {
                $join->on('exams.id', '=', 'exam_sessions.exam_id')
                    ->where('exam_sessions.user_id', $userId);
            })
            ->where('exams.has_accessed', '1')
            ->select(
                'exams.id',
                'exams.name',
                'exams.start_date',
                'exams.end_date',
                'exams.start_time',
                'exams.end_time',
                DB::raw('SUM(CASE WHEN user_answers.score_type = "TIU" THEN user_answers.score ELSE 0 END) as total_tiu'),
                DB::raw('SUM(CASE WHEN user_answers.score_type = "TKP" THEN user_answers.score ELSE 0 END) as total_tkp'),
                DB::raw('SUM(CASE WHEN user_answers.score_type = "TWK" THEN user_answers.score ELSE 0 END) as total_twk'),
                DB::raw('CASE
                WHEN exam_sessions.id IS NOT NULL AND exam_sessions.time_left > 0 THEN "Sedang Mengerjakan"
                WHEN exam_sessions.id IS NOT NULL AND exam_sessions.time_left = 0 THEN "Sudah Mengerjakan"
                ELSE "Belum Mengerjakan"
            END as status_process'),
                'exam_sessions.id as examSessionId'
            )
            ->groupBy(
                'exams.id',
                'exams.name',
                'exams.start_date',
                'exams.end_date',
                'exams.start_time',
                'exams.end_time',
                'exam_sessions.id',
                'exam_sessions.time_left'
            )
            ->get();


        return view('user.dashboard', compact('exams'));
    }
}
