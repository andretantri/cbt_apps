<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\ExamSession;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $exams = Exam::all(); // Fetch all exams
        return view('operator.laporan.index', compact('exams'));
    }

    // Handle the form submission and fetch exam results
    public function report(Request $request)
    {
        $request->validate([
            'exam_id' => 'required',
            'token' => 'required',
        ]);

        $examId = $request->input('exam_id');
        $token = $request->input('token');

        $examAnswers = UserAnswer::select(
            'user_id',
            'exam_id',
            DB::raw('SUM(CASE WHEN score_type = "TIU" THEN score ELSE 0 END) as total_tiu'),
            DB::raw('SUM(CASE WHEN score_type = "TKP" THEN score ELSE 0 END) as total_tkp'),
            DB::raw('SUM(CASE WHEN score_type = "TWK" THEN score ELSE 0 END) as total_twk'),
            DB::raw('SUM(CASE WHEN score_type = "TIU" THEN score ELSE 0 END) +
                     SUM(CASE WHEN score_type = "TKP" THEN score ELSE 0 END) +
                     SUM(CASE WHEN score_type = "TWK" THEN score ELSE 0 END) as total_score'),
            DB::raw('COUNT(*) as total_answer')
        )
            ->where('exam_id', $examId)
            ->where('token', $token)
            ->groupBy('user_id', 'exam_id')
            ->with(['user', 'exam'])
            ->orderBy('total_score', 'desc')
            ->get();

        return view('operator.laporan.getdata', compact('examAnswers', 'examId', 'token'));
    }

    public function stopExam(Request $r)
    {
        $ex = ExamSession::find($r->session_id);
        $ex->time_left = 0;
        $ex->drop_out = 1;
        $ex->save();

        $message = 'Ujian Pengguna ' . $ex->getUser->name . ' Berhasil Dihentikan';

        return response()->json(['message' => $message]);
    }

    public function printUserExam($id)
    {
        // Retrieve the exam session and calculate scores
        $ex = ExamSession::find($id);
        $uses = UserAnswer::select(
            DB::raw('SUM(CASE WHEN score_type = "TIU" THEN score ELSE 0 END) as total_tiu'),
            DB::raw('SUM(CASE WHEN score_type = "TKP" THEN score ELSE 0 END) as total_tkp'),
            DB::raw('SUM(CASE WHEN score_type = "TWK" THEN score ELSE 0 END) as total_twk'),
            DB::raw('SUM(CASE WHEN score_type = "TIU" THEN score ELSE 0 END) +
                 SUM(CASE WHEN score_type = "TKP" THEN score ELSE 0 END) +
                 SUM(CASE WHEN score_type = "TWK" THEN score ELSE 0 END) as total_score'),
            DB::raw('COUNT(*) as total_answer'),
        )
            ->where('user_id', $ex->user_id)
            ->where('exam_id', $ex->exam_id)
            ->first();

        $users = User::find($ex->user_id);
        $exam = Exam::find($ex->exam_id);

        $userData = [
            'tanggal' => $exam->start_date,
            'user' => $users->name,
        ];

        return view('operator.laporan.user', ['data' => $uses, 'info' => $userData]);
    }
}
