<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Token;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index()
    {
        return view('admin.token.index');
    }

    public function getData(Request $request)
    {
        $data = Token::query()
            ->join('exams', 'tokens.exam_id', '=', 'exams.id')
            ->select('tokens.*', 'exams.name as exam_name');;

        $recordsTotal = $data->count();

        if ($request->has('search') && !empty($request->search['value'])) {
            $searchValue = $request->search['value'];
            $data->where('question', 'like', '%' . $searchValue . '%');
        }

        $recordsFiltered = $data->count();

        $data->skip($request->start ?? 0)
            ->take($request->length ?? $recordsTotal);

        $data = $data->get();

        return response()->json([
            'draw' => intval($request->draw ?? 1),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function create()
    {
        $exam = Exam::all();
        return view('admin.token.create', ['exam' => $exam]);
    }

    public function store(Request $request)
    {
        $token = Str::random(6);

        Token::create([
            'exam_id' => $request->exam_id,
            'time_limit' => $request->time_limit,
            'token' => strtoupper($token),
            'has_accessed' => $request->has_access,
        ]);

        return redirect()->route('admin.token')->with('success', 'Token Berhasil Dibuat!');
    }

    public function destroy($id)
    {
        $data = Token::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $data = Token::find($id);
        $exam = Exam::all();
        return view('admin.token.edit', compact('data', 'exam'));
    }

    public function update($id, Request $request)
    {

        $token = Token::find($id);

        $token->exam_id = $request->exam_id;
        $token->time_limit = $request->time_limit;
        $token->has_accessed = $request->has_access;
        $token->save();

        return redirect()->route('admin.token')->with('success', 'Token Berhasil Diubah!');
    }
}
