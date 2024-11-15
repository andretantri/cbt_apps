<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\ExamSession;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class liveController extends Controller
{
    public function index($id, $token)
    {
        return view('live', ['id' => $id, 'token' => $token]);
    }

    public function getData(Request $request)
    {
        $id_exam = $request->query('id_exam');
        $token = $request->query('token');

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
            ->where('exam_id', $id_exam)
            ->where('token', $token)
            ->groupBy('user_id', 'exam_id')
            ->with(['user', 'exam'])
            ->orderBy('total_score', 'desc')
            ->get();

        return response()->json($examAnswers);
    }
}
