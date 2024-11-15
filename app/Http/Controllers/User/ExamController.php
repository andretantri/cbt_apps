<?php

namespace App\Http\Controllers\User;

use Auth;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamSession;
use App\Models\Question;
use App\Models\Token;
use App\Models\UserAnswer;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function verifyToken($id, Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $exam = Exam::find($id);

        if (!$exam) {
            return redirect()->back()->with(['error' => 'Ujian tidak ditemukan.']);
        }

        $currentDateTime = Carbon::now();
        $startDateTime = Carbon::parse($exam->start_date . ' ' . $exam->start_time);
        $endDateTime = Carbon::parse($exam->end_date . ' ' . $exam->end_time);

        if ($currentDateTime->lt($startDateTime) || $currentDateTime->gt($endDateTime)) {
            return redirect()->back()->with(['error' => 'Ujian belum dimulai atau sudah berakhir.']);
        }

        $validToken = Token::where('exam_id', $id)
            ->where('token', $request->token)
            ->where('has_accessed', '1')
            ->first();


        if ($validToken) {
            return redirect()->route('exam.start', ['id' => $id, 'token' => $request->token]);
        } else {
            return redirect()->back()->with(['error' => 'Token salah, silahkan coba lagi.']);
        }
    }

    public function proses($id, $token)
    {
        $cekSession = ExamSession::where('user_id', Auth::user()->id)->where('time_left', '>', '0')->where('exam_id', $id)->where('token', $token)->count();
        $tokens = Token::where('token', $token)->first();
        $examId = $id;

        if ($tokens == null) {
            return redirect()->route('dashboard')->with(['error' => 'Token salah, silahkan coba lagi']);
        }


        if ($cekSession == 0) {
            $questions = ExamQuestion::join('questions', 'exam_questions.question_id', '=', 'questions.id')
                ->where('exam_questions.exam_id', $id)
                ->select('questions.id', 'questions.scoring_type', 'questions.question', 'questions.option_a', 'questions.option_b', 'questions.option_c', 'questions.option_d', 'questions.option_e', 'exam_questions.order')
                ->orderBy('exam_questions.order')
                ->get()
                ->groupBy('order')
                ->map(function ($group) {
                    return $group->shuffle();
                })
                ->flatten(1);


            $qid = [];
            foreach ($questions as $q) {
                $qid[] = $q->id;
            }

            $limit_time_in_seconds = $tokens->time_limit * 60;

            ExamSession::create([
                'user_id' => Auth::user()->id,
                'exam_id' => $id,
                'token' => $token,
                'question_id' => json_encode($qid),
                'time_left' => $limit_time_in_seconds,
            ]);
        } else {
            $sess = ExamSession::where('user_id', Auth::user()->id)->where('time_left', '>', '0')->where('exam_id', $id)->where('token', $token)->first();
            $limit_time_in_seconds = $sess->time_left;
            $qid = json_decode($sess->question_id);
        }


        return view('user.exam.page', compact('qid', 'limit_time_in_seconds', 'token', 'examId'));
    }

    public function updateTimeLeft(Request $request, $examSessionId)
    {
        $examSession = ExamSession::where('exam_id', $examSessionId)->where('user_id', Auth::user()->id)->where('token', $request->token)->first();
        $examSession->time_left = $request->input('time_left');
        $examSession->save();

        if ($examSession->drop_out == '1') {
            return response()->json(['message' => 'DropOut']);
        } else {
            return response()->json(['message' => 'Time left updated successfully']);
        }
    }

    public function continueExam($examSessionId)
    {
        $examSession = ExamSession::find($examSessionId);
        $token = $examSession->token;
        $examId = $examSession->exam_id;

        return redirect()->route('exam.start', ['id' => $examId, 'token' => $token]);
    }

    public function getQuestion(Request $request)
    {
        $questionId = $request->input('questionId');
        $userId = Auth::user()->id;
        $examId = $request->input('examId');

        // Fetch the question and user's saved answer
        $question = Question::where('id', $questionId)
            ->select('id', 'question', 'image', 'option_a', 'option_b', 'option_c', 'option_d', 'option_e', 'image_a', 'image_b', 'image_c', 'image_d', 'image_e')
            ->with(['userAnswer' => function ($query) use ($userId, $examId) {
                $query->where('user_id', $userId)->where('exam_id', $examId);
            }])
            ->first();

        // Extract the selected option, if available
        $selectedOption = $question->userAnswer ? $question->userAnswer->selected_option : null;

        return response()->json([
            'id' => $question->id,
            'question' => $question->question,
            'image' => $question->image,
            'option_a' => $question->option_a,
            'option_b' => $question->option_b,
            'option_c' => $question->option_c,
            'option_d' => $question->option_d,
            'option_e' => $question->option_e,
            'image_a' => $question->image_a,
            'image_b' => $question->image_b,
            'image_c' => $question->image_c,
            'image_d' => $question->image_d,
            'image_e' => $question->image_e,
            'selectedOption' => $selectedOption,
        ]);
    }

    public function saveAnswer(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'questionId' => 'required|integer|exists:questions,id',
            'selectedOption' => 'required|string|max:1', // Assuming options are single characters like A, B, C, etc.
            'examId' => 'required|integer|exists:exams,id',
        ]);

        // Retrieve the current user ID
        $userId = Auth::user()->id;

        $quest = Question::find($request->questionId);

        $score = 0;

        switch ($request->selectedOption) {
            case 'A':
                $score = $quest->poin_a;
                break;
            case 'B':
                $score = $quest->poin_b;
                break;
            case 'C':
                $score = $quest->poin_c;
                break;
            case 'D':
                $score = $quest->poin_d;
                break;
            case 'E':
                $score = $quest->poin_e;
                break;
        }

        // Check if the user has already answered this question
        $userAnswer = UserAnswer::where('user_id', $userId)
            ->where('exam_id', $request->examId)
            ->where('question_id', $request->questionId)
            ->where('token', $request->token)
            ->first();

        if ($userAnswer) {
            // Update the existing answer
            $userAnswer->selected_option = $request->selectedOption;
            $userAnswer->score = $score;
            $userAnswer->save();
        } else {
            // Create a new answer record
            UserAnswer::create([
                'user_id' => $userId,
                'exam_id' => $request->examId,
                'question_id' => $request->questionId,
                'score_type' => $quest->scoring_type,
                'token' => $request->token,
                'score' => $score,
                'selected_option' => $request->selectedOption,
            ]);
        }

        return response()->json(['message' => 'Answer saved successfully']);
    }

    public function stopCat($id, $token)
    {
        $ex = ExamSession::where('exam_id', $id)->where('token', $token)->where('user_id', Auth::user()->id)->first();
        $ex->time_left = 0;
        $ex->save();
        return redirect()->route('dashboard');
    }
}
