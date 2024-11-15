<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Exam;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('operator.user.index');
    }

    public function getData(Request $request)
    {
        $data = User::query();

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
        return view('operator.user.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->input('password')),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        return redirect()->route('operator.user')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $data = User::find($id);

        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus!'
        ]);
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('operator.user.edit', compact('data'));
    }

    public function update($id, Request $request)
    {
        $data = User::find($id);
        $data->password = Hash::make($request->input('password'));
        $data->save();

        return redirect()->route('operator.user')->with('success', 'Data berhasil diubah!');
    }

    public function report($id)
    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'User not found');
        }

        // Mengambil total skor untuk setiap ujian yang diikuti
        $examScores = $user->getTotalScore()->map(function ($item) {
            return [
                'exam_id' => $item->exam_id,
                'total_score' => $item->total_score,
                'exam_name' => Exam::find($item->exam_id)->name,
            ];
        });

        // Kirim data ke view
        return view('operator.user.score', [
            'examScores' => $examScores,
            'user' => $user
        ]);
    }
}
