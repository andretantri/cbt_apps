<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\User;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // $tiuScores = UserAnswer::where('score_type', 'TIU')
        //     ->selectRaw('score, COUNT(*) as count')
        //     ->groupBy('score')
        //     ->orderBy('count', 'desc')
        //     ->take(5)
        //     ->get();

        // $tkpScores = UserAnswer::where('score_type', 'TKP')
        //     ->selectRaw('score, COUNT(*) as count')
        //     ->groupBy('score')
        //     ->orderBy('count', 'desc')
        //     ->take(5)
        //     ->get();

        // $twkScores = UserAnswer::where('score_type', 'TWK')
        //     ->selectRaw('score, COUNT(*) as count')
        //     ->groupBy('score')
        //     ->orderBy('count', 'desc')
        //     ->take(5)
        //     ->get();

        return view('admin.dashboard');
    }

    public function getActiveUsersCount()
    {
        $count = User::count();
        return response()->json(['count' => $count]);
    }

    public function getParticipantsByDate()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $participants = DB::table('exams')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', $oneMonthAgo)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $dates = $participants->pluck('date');
        $counts = $participants->pluck('count');
        return response()->json(['dates' => $dates, 'counts' => $counts]);
    }

    public function getGenderDistribution()
    {
        $male = User::where('jenis_kelamin', 'L')->count();
        $female = User::where('jenis_kelamin', 'P')->count();
        return response()->json(['male' => $male, 'female' => $female]);
    }
}
